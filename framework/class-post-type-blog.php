<?php
defined('ABSPATH') || exit;

if (!class_exists('Edumall_Post')) {
	class Edumall_Post extends Edumall_Post_Type
	{

		protected static $instance = null;

		public static function instance()
		{
			if (null === self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize()
		{
			add_action('wp_ajax_post_infinite_load', [$this, 'infinite_load']);
			add_action('wp_ajax_nopriv_post_infinite_load', [$this, 'infinite_load']);

			add_filter('post_class', [$this, 'post_class']);

			add_filter('body_class', [$this, 'body_class']);

			add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));

			/**
			 * Special layout for home posts page.
			 */
			add_action('pre_get_posts', [$this, 'change_post_query'], 999);

			add_filter('edumall_sidebar_1', [$this, 'hide_sidebar_home_page'], 99);
			add_filter('edumall_title_bar_type', [$this, 'change_title_bar_home_page'], 99);
		}

		public function frontend_scripts()
		{
			if ($this->is_archive()) {
				wp_enqueue_script('edumall-grid-layout');
			}
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 *
		 * @return array
		 */
		public function body_class($classes)
		{
			$blog_archive_style = Edumall::setting('blog_archive_style');
			$special_layout_on  = Edumall::setting('blog_archive_special_layout');

			if (Edumall_Post::instance()->is_archive()) {
				if ('1' !== $special_layout_on || ('1' === $special_layout_on && !is_home())) {
					$classes[] = "blog-archive-style-{$blog_archive_style}";
				}
			}

			if (is_home() && '1' === $special_layout_on) {
				$classes[] = 'home-blog-special-layout';
			}

			return $classes;
		}

		/**
		 * @param WP_Query $query
		 */
		public function change_post_query($query)
		{
			if (!$query->is_main_query() || is_admin()) {
				return;
			}

			if (isset($query->query_vars) && isset($query->query_vars['post_type']) && 'post' !== $query->query_vars['post_type']) {
				return;
			}

			$layout_preset = isset($_GET['blog_archive_preset']) ? Edumall_Helper::data_clean($_GET['blog_archive_preset']) : false;

			// Change post per page.
			if ($query->is_home() || $query->is_archive()) {

				// Numbers per page.
				$numbers = Edumall::setting('blog_archive_posts_per_page', 12);

				// Hard set post per page. because override preset settings run after init hook.
				if (
					$layout_preset && in_array($layout_preset, [
						'grid-sidebar',
					], true)
				) {
					$numbers = 6;
				} elseif (
					$layout_preset && in_array($layout_preset, [
						'list-01',
						'list-02',
					], true)
				) {
					$numbers = 6;
				}

				// Work out how many products to query.
				$query->set('posts_per_page', apply_filters('edumall_loop_blog_per_page', $numbers));
			}

			$special_layout_on = Edumall::setting('blog_archive_special_layout');

			if (
				$layout_preset && in_array($layout_preset, [
					'special',
				], true)
			) {
				// Hard set. because override preset settings run after init hook.
				$special_layout_on = '1';
			}

			if ($query->is_main_query() && !is_admin() && $query->is_home() && '1' === $special_layout_on) {
				// Popular articles.

				$query->set('meta_key', 'views');
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'DESC');
			}
		}

		public function hide_sidebar_home_page($type)
		{
			$special_layout_on = Edumall::setting('blog_archive_special_layout');

			if (is_home() && '1' === $special_layout_on) {
				return 'none';
			}

			return $type;
		}

		public function change_title_bar_home_page($type)
		{
			$special_layout_on = Edumall::setting('blog_archive_special_layout');

			if (is_home() && '1' === $special_layout_on) {
				return '06';
			}

			return $type;
		}

		public function post_class($classes)
		{
			if (!has_post_thumbnail()) {
				$classes[] = 'post-no-thumbnail';
			}

			return $classes;
		}

		public function infinite_load()
		{
			$source     = isset($_POST['source']) ? $_POST['source'] : '';
			$query_vars = $_POST['query_vars'];

			if ('custom_query' === $source) {
				$query_vars = $this->build_extra_terms_query($query_vars, $query_vars['extra_tax_query']);
			}

			$edumall_query = new WP_Query($query_vars);

			$settings = isset($_POST['settings']) ? $_POST['settings'] : array();

			$response = array(
				'max_num_pages' => $edumall_query->max_num_pages,
				'found_posts'   => $edumall_query->found_posts,
				'count'         => $edumall_query->post_count,
			);

			ob_start();

			if ($edumall_query->have_posts()) :
				set_query_var('edumall_query', $edumall_query);
				set_query_var('settings', $settings);

				get_template_part('loop/widgets/blog/style', $settings['layout']);

				wp_reset_postdata();
			endif;

			$template = ob_get_contents();
			ob_clean();

			$response['template'] = $template;

			echo json_encode($response);

			wp_die();
		}

		public function get_post_type()
		{
			return 'post';
		}

		/**
		 * Check if current page is category or tag pages
		 */
		function is_taxonomy()
		{
			return is_category() || is_tag();
		}

		public function is_archive()
		{
			return $this->is_taxonomy() || is_home() || is_author() || is_date() || is_post_type_archive($this->get_post_type());
		}

		function get_related_posts($args)
		{
			$defaults = array(
				'post_id'      => '',
				'number_posts' => 3,
			);
			$args     = wp_parse_args($args, $defaults);
			if ($args['number_posts'] <= 0 || $args['post_id'] === '') {
				return false;
			}

			$categories = get_the_category($args['post_id']);

			if (!$categories) {
				return false;
			}

			foreach ($categories as $category) {
				if ($category->parent === 0) {
					$term_ids[] = $category->term_id;
				} else {
					$term_ids[] = $category->parent;
					$term_ids[] = $category->term_id;
				}
			}

			// Remove duplicate values from the array.
			$unique_array = array_unique($term_ids);

			$query_args = array(
				'post_type'      => $this->get_post_type(),
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $args['number_posts'],
				'post__not_in'   => array($args['post_id']),
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy'         => 'category',
						'terms'            => $unique_array,
						'include_children' => false,
					),
				),
			);

			$query = new WP_Query($query_args);

			wp_reset_postdata();

			return $query;
		}

		function get_the_post_meta($name = '', $default = '')
		{
			$post_meta = get_post_meta(get_the_ID(), 'insight_post_options', true);

			if (!empty($post_meta)) {
				$post_options = maybe_unserialize($post_meta);

				if ($post_options !== false && isset($post_options[$name])) {
					return $post_options[$name];
				}
			}

			return $default;
		}

		function get_the_post_format()
		{
			$format = '';
			if (get_post_format() !== false) {
				$format = get_post_format();
			}

			return $format;
		}

		function the_categories($args = array())
		{
			if (!has_category()) {
				return;
			}

			$defaults = array(
				'classes'    => 'post-categories',
				'separator'  => ', ',
				'show_links' => true,
				'single'     => true,
			);
			$args     = wp_parse_args($args, $defaults);
?>
			<div class="<?php echo esc_attr($args['classes']); ?>">
				<?php
				$categories = get_the_category();
				$loop_count = 0;
				foreach ($categories as $category) {
					if ($loop_count > 0) {
						echo "{$args['separator']}";
					}

					if (true === $args['show_links']) {
						printf(
							'<a href="%1$s"><span>%2$s</span></a>',
							esc_url(get_category_link($category->term_id)),
							$category->name
						);
					} else {
						echo "<span>{$category->name}</span>";
					}

					$loop_count++;

					if (true === $args['single']) {
						break;
					}
				}
				?>
			</div>
		<?php
		}

		/**
		 * @param array $args
		 *
		 * Render first category template of the post.
		 */
		function the_category($args = array())
		{
			if (!has_category()) {
				return;
			}

			$defaults = array(
				'classes'    => 'post-categories',
				'show_links' => true,
			);
			$args     = wp_parse_args($args, $defaults);
		?>
			<div class="<?php echo esc_attr($args['classes']); ?>">
				<?php
				$categories = get_the_category();
				$category   = $categories[0];

				if ($args['show_links']) {
					$link = get_term_link($category);
					printf('<a href="%1$s" rel="category tag"><span>%2$s</span></a>', $link, $category->name);
				} else {
					echo "<span>{$category->name}</span>";
				}
				?>
			</div>
		<?php
		}

		function nav_page_links()
		{
			$thumbnail_size = '370x120';
		?>
			<div class="blog-nav-links">
				<div class="nav-list">
					<div class="nav-item prev">
						<div class="inner">
							<?php
							$prev_post      = get_previous_post();
							$prev_thumbnail = '';
							$class          = 'hover-bg';

							if (!empty($prev_post)) {
								$prev_thumbnail = Edumall_Image::get_the_post_thumbnail_url([
									'post_id' => $prev_post->ID,
									'size'    => $thumbnail_size,
								]);

								if (!empty($prev_thumbnail)) {
									$class          .= ' has-thumbnail';
									$prev_thumbnail = 'style="background-image: url(' . $prev_thumbnail . ');"';
								}
							}

							previous_post_link('%link', '<div class="' . esc_attr($class) . '" ' . $prev_thumbnail . '></div><h6>%title</h6>');
							?>
						</div>
					</div>

					<div class="nav-item next">
						<div class="inner">
							<?php
							$next_post      = get_next_post();
							$next_thumbnail = '';
							$class          = 'hover-bg';

							if (!empty($next_post)) {
								$next_thumbnail = Edumall_Image::get_the_post_thumbnail_url(array(
									'post_id' => $next_post->ID,
									'size'    => $thumbnail_size,
								));

								if (!empty($next_thumbnail)) {
									$class          .= ' has-thumbnail';
									$next_thumbnail = 'style="background-image: url(' . $next_thumbnail . ');"';
								}
							}

							next_post_link('%link', '<div class="' . esc_attr($class) . '" ' . $next_thumbnail . '></div><h6>%title</h6>');
							?>
						</div>
					</div>
				</div>
			</div>

		<?php
		}

		function meta_author_template()
		{
		?>
			<div class="post-meta-author">
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>">
					<?php echo edumall_get_avatar(get_the_author_meta('ID'), 150); ?>
					<span class="meta-value"><?php the_author(); ?></span>
				</a>
			</div>
		<?php
		}

		function meta_date_template()
		{
		?>
			<div class="post-date">
				<span class="meta-icon"><i class="far fa-calendar"></i></span>
				<span class="meta-value"><?php echo get_the_date(); ?></span>
			</div>
			<?php
		}

		function meta_view_count_template()
		{
			if (function_exists('the_views')) : ?>
				<div class="post-view">
					<span class="meta-icon"><i class="far fa-eye"></i></span>
					<span class="meta-value"><?php the_views(); ?></span>
				</div>
			<?php
			endif;
		}

		function meta_comment_count_template()
		{
			$comment_count = get_comments_number();
			?>
			<div class="post-comments">
				<span class="meta-icon"><i class="far fa-comment-alt-lines"></i></span>
				<span class="meta-value">
					<?php printf(
						_n('%s comment', '%s comments', $comment_count, 'edumall-child'),
						number_format_i18n($comment_count)
					);
					?>
				</span>
			</div>
		<?php
		}

		function entry_meta_comment_count_template()
		{
		?>
			<div class="post-comments">
				<a href="#comments" class="smooth-scroll-link">
					<span class="meta-icon">
						<i class="far fa-comment-alt-lines"></i>
					</span>
					<?php
					$comment_count = get_comments_number();
					printf(esc_html(_n('%s comment', '%s comments', $comment_count, 'edumall-child')), number_format_i18n($comment_count));
					?>
				</a>
			</div>
		<?php
		}

		function entry_categories()
		{
			if ('1' !== Edumall::setting('single_post_categories_enable') || !has_category()) {
				return;
			}
		?>
			<div class="entry-post-categories">
				<?php the_category(' '); ?>
			</div>
		<?php
		}

		function entry_tags()
		{
			if ('1' !== Edumall::setting('single_post_tags_enable') || !has_tag()) {
				return;
			}
		?>
			<div class="entry-post-tags">
				<div class="tag-label">
					<span class="tag-icon fal fa-tags"></span>
				</div>
				<div class="tagcloud">
					<?php the_tags('', ', ', ''); ?>
				</div>
			</div>
		<?php
		}

		function entry_feature()
		{
			if ('1' !== Edumall::setting('single_post_feature_enable')) {
				return;
			}

			$post_format    = $this->get_the_post_format();
			$thumbnail_size = '770x400';

			$sidebar_status = Edumall_Global::instance()->get_sidebar_status();

			if ('none' === $sidebar_status) {
				$thumbnail_size = '1170x600';
			}

			switch ($post_format) {
				case 'gallery':
					$this->entry_feature_gallery($thumbnail_size);
					break;
				case 'audio':
					$this->entry_feature_audio();
					break;
				case 'video':
					$this->entry_feature_video($thumbnail_size);
					break;
				case 'quote':
					$this->entry_feature_quote();
					break;
				case 'link':
					$this->entry_feature_link();
					break;
				default:
					$this->entry_feature_standard($thumbnail_size);
					break;
			}
		}

		private function entry_feature_standard($size)
		{
			if (!has_post_thumbnail()) {
				return;
			}
		?>
			<div class="entry-post-feature post-thumbnail">
				<?php Edumall_Image::the_post_thumbnail(['size' => $size,]); ?>
			</div>
		<?php
		}

		private function entry_feature_gallery($size)
		{
			$gallery = $this->get_the_post_meta('post_gallery');
			if (empty($gallery)) {
				return;
			}
		?>
			<div class="entry-post-feature post-gallery tm-swiper tm-slider" data-nav="1" data-loop="1" data-lg-gutter="30">
				<div class="swiper-inner">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php foreach ($gallery as $image) { ?>
								<div class="swiper-slide">
									<?php Edumall_Image::the_attachment_by_id(array(
										'id'   => $image['id'],
										'size' => $size,
									)); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		private function entry_feature_audio()
		{
			$audio = Edumall_Post::instance()->get_the_post_meta('post_audio');
			if (empty($audio)) {
				return;
			}

			if (strrpos($audio, '.mp3') !== false) {
				echo do_shortcode('[audio mp3="' . $audio . '"][/audio]');
			} else {
			?>
				<div class="entry-post-feature post-audio">
					<?php if (wp_oembed_get($audio)) { ?>
						<?php echo Edumall_Helper::w3c_iframe(wp_oembed_get($audio)); ?>
					<?php } ?>
				</div>
			<?php
			}
		}

		private function entry_feature_video($size)
		{
			$video = $this->get_the_post_meta('post_video');
			if (empty($video)) {
				return;
			}
			?>
			<div class="entry-post-feature post-video tm-popup-video type-poster edumall-animation-zoom-in">
				<a href="<?php echo esc_url($video); ?>" class="video-link edumall-box link-secret">
					<div class="video-poster">
						<div class="edumall-image">
							<?php if (has_post_thumbnail()) { ?>
								<?php Edumall_Image::the_post_thumbnail(['size' => $size,]); ?>
							<?php } ?>
						</div>
						<div class="video-overlay"></div>

						<div class="video-button">
							<div class="video-play video-play-icon">
								<span class="icon"></span>
							</div>
						</div>
					</div>
				</a>
			</div>
		<?php
		}

		private function entry_feature_quote()
		{
			$text = $this->get_the_post_meta('post_quote_text');
			if (empty($text)) {
				return;
			}
			$name = $this->get_the_post_meta('post_quote_name');
			$url  = $this->get_the_post_meta('post_quote_url');
		?>
			<div class="entry-post-feature post-quote">
				<div class="post-quote-content">
					<span class="quote-icon fas fa-quote-right"></span>
					<h3 class="post-quote-text"><?php echo esc_html('&ldquo;' . $text . '&rdquo;'); ?></h3>
					<?php if (!empty($name)) { ?>
						<?php $name = "- $name"; ?>
						<h6 class="post-quote-name">
							<?php if (!empty($url)) { ?>
								<a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($name); ?></a>
							<?php } else { ?>
								<?php echo esc_html($name); ?>
							<?php } ?>
						</h6>
					<?php } ?>
				</div>
			</div>
		<?php
		}

		private function entry_feature_link()
		{
			$link = $this->get_the_post_meta('post_link');
			if (empty($link)) {
				return;
			}
		?>
			<div class="entry-post-feature post-link">
				<a href="<?php echo esc_url($link); ?>" target="_blank"><?php echo esc_html($link); ?></a>
			</div>
		<?php
		}

		function entry_share($args = array())
		{
			if ('1' !== Edumall::setting('single_post_share_enable') || !class_exists('InsightCore')) {
				return;
			}

			$social_sharing = Edumall::setting('social_sharing_item_enable');
			if (empty($social_sharing)) {
				return;
			}
		?>
			<div class="entry-post-share">
				<div class="post-share style-01">
					<div class="share-label heading">
						<?php esc_html_e('Share this post', 'edumall-child'); ?>
					</div>
					<div class="share-media">
						<span class="share-icon fas fa-share-alt"></span>

						<div class="share-list">
							<?php Edumall_Templates::get_sharing_list($args); ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}

		function loop_share($args = array())
		{
			if (!class_exists('InsightCore')) {
				return;
			}

			$social_sharing = Edumall::setting('social_sharing_item_enable');
			if (empty($social_sharing)) {
				return;
			}
		?>
			<div class="post-share style-01">
				<div class="share-label">
					<?php esc_html_e('Share this post', 'edumall-child'); ?>
				</div>
				<div class="share-media">
					<span class="share-icon fas fa-share-alt"></span>

					<div class="share-list">
						<?php Edumall_Templates::get_sharing_list($args); ?>
					</div>
				</div>
			</div>
<?php
		}
	}

	Edumall_Post::instance()->initialize();
}
