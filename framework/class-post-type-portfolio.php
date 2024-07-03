<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Portfolio' ) ) {
	class Edumall_Portfolio extends Edumall_Post_Type {

		protected static $instance  = null;
		protected static $post_type = 'portfolio';
		protected static $tag       = 'portfolio_tags';
		protected static $category  = 'portfolio_category';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_ajax_portfolio_infinite_load', array( $this, 'infinite_load' ) );
			add_action( 'wp_ajax_nopriv_portfolio_infinite_load', array( $this, 'infinite_load' ) );

			add_action( 'pre_get_posts', array( $this, 'change_post_per_page' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		}

		public function frontend_scripts() {
			if ( $this->is_archive() ) {
				wp_enqueue_script( 'edumall-grid-layout' );
			}
		}

		/**
		 * Change number post per page of main query.
		 *
		 * @param WP_Query $query Query instance.
		 */
		public function change_post_per_page( $query ) {
			if ( $query->is_main_query() && $this->is_archive() && ! is_admin() ) {
				$number = Edumall::setting( 'archive_portfolio_posts_per_page', 12 );

				$query->set( 'posts_per_page', $number );
			}
		}

		function get_categories( $args = array() ) {
			$defaults = array(
				'all' => true,
			);
			$args     = wp_parse_args( $args, $defaults );
			$terms    = get_terms( [
				'taxonomy' => self::$category,
			] );
			$results  = array();

			if ( $args['all'] === true ) {
				$results['-1'] = esc_html__( 'All', 'edumall' );
			}

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$results[ $term->slug ] = $term->name;
				}
			}

			return $results;
		}

		function get_tags( $args = array() ) {
			$defaults = array(
				'all' => true,
			);
			$args     = wp_parse_args( $args, $defaults );
			$terms    = get_terms( [
				'taxonomy' => self::$tag,
			] );
			$results  = array();

			if ( $args['all'] === true ) {
				$results['-1'] = esc_html__( 'All', 'edumall' );
			}

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$results[ $term->slug ] = $term->name;
				}
			}

			return $results;
		}

		function get_related_items( $args ) {
			$defaults = array(
				'post_id'      => '',
				'number_posts' => 3,
			);
			$args     = wp_parse_args( $args, $defaults );
			if ( $args['number_posts'] <= 0 || $args['post_id'] === '' ) {
				return false;
			}
			$query_args              = array(
				'post_type'      => self::$post_type,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $args['number_posts'],
				'post__not_in'   => array( $args['post_id'] ),
				'no_found_rows'  => true,
			);
			$related_by              = Edumall::setting( 'portfolio_related_by' );
			$query_args['tax_query'] = array();
			if ( ! empty( $related_by ) ) {
				foreach ( $related_by as $tax ) {
					$terms = get_the_terms( $args['post_id'], $tax );
					if ( $terms && ! is_wp_error( $terms ) ) {
						$term_ids = array();
						foreach ( $terms as $term ) {
							$term_ids[] = $term->term_id;
						}
						$query_args['tax_query'][] = array(
							'terms'    => $term_ids,
							'taxonomy' => $tax,
						);
					}
				}
				if ( count( $query_args['tax_query'] ) > 1 ) {
					$query_args['tax_query']['relation'] = 'OR';
				}
			}

			$query = new WP_Query( $query_args );

			wp_reset_postdata();

			return $query;
		}

		public function infinite_load() {
			$source     = isset( $_POST['source'] ) ? $_POST['source'] : '';
			$query_vars = $_POST['query_vars'];

			if ( 'custom_query' === $source ) {
				$query_vars = $this->build_extra_terms_query( $query_vars, $query_vars['extra_tax_query'] );
			}

			$edumall_query = new WP_Query( $query_vars );

			$settings = isset( $_POST['settings'] ) ? $_POST['settings'] : array();

			$response = array(
				'max_num_pages' => $edumall_query->max_num_pages,
				'found_posts'   => $edumall_query->found_posts,
				'count'         => $edumall_query->post_count,
			);

			$post_number = 0;
			if ( $query_vars['paged'] > 1 ) {
				$post_number = ( $query_vars['paged'] - 1 ) * $query_vars['posts_per_page'];
			}

			ob_start();

			if ( $edumall_query->have_posts() ) :
				set_query_var( 'edumall_query', $edumall_query );
				set_query_var( 'settings', $settings );
				set_query_var( 'post_number', $post_number );

				get_template_part( 'loop/widgets/portfolio/style', $settings['layout'] );

				wp_reset_postdata();
			endif;

			$template = ob_get_contents();
			ob_clean();

			$template = preg_replace( '~>\s+<~', '><', $template );

			$response['template'] = $template;

			echo json_encode( $response );

			wp_die();
		}

		/**
		 * Check if current page is category or tag pages
		 */
		function is_taxonomy() {
			$taxonomies = get_object_taxonomies( self::$post_type );

			return empty( $taxonomies ) ? false : is_tax( $taxonomies );
		}

		/**
		 * Check if current page is tag pages
		 */
		function is_tag() {
			return is_tax( self::$tag );
		}

		/**
		 * Check if current page is category pages
		 */
		function is_category() {
			return is_tax( self::$category );
		}

		/**
		 * Check if current page is archive pages
		 */
		function is_archive() {
			return $this->is_taxonomy() || is_post_type_archive( self::$post_type );
		}

		function has_tag() {
			if ( has_term( '', self::$tag ) ) {
				return true;
			}

			return false;
		}

		function has_category() {
			if ( has_term( '', self::$category ) ) {
				return true;
			}

			return false;
		}

		function get_the_post_meta( $name = '', $default = '' ) {
			$post_meta = get_post_meta( get_the_ID(), 'insight_portfolio_options', true );

			if ( ! empty( $post_meta ) ) {
				//$post_options = unserialize( $post_meta );
				$post_options = maybe_unserialize( $post_meta );

				if ( $post_options !== false && isset( $post_options[ $name ] ) ) {
					return $post_options[ $name ];
				}
			}

			return $default;
		}

		function get_the_permalink() {
			$url = get_the_permalink();

			if ( Edumall::setting( 'archive_portfolio_external_url' ) === '1' ) {
				$_url = $this->get_the_post_meta( 'portfolio_url', '' );

				if ( $_url !== '' ) {
					$url = $_url;
				}
			}

			return $url;
		}

		function the_permalink() {
			$url = $this->get_the_permalink();

			echo esc_url( $url );
		}

		function the_categories() {
			?>
			<div class="post-categories">
				<?php echo get_the_term_list( get_the_ID(), self::$category, '', ', ', '' ); ?>
			</div>
			<?php
		}

		function the_categories_no_link( $args = array() ) {
			$defaults = array(
				'classes' => 'post-categories',
			);
			$args     = wp_parse_args( $args, $defaults );

			$terms = get_the_terms( get_the_ID(), self::$category );

			if ( is_array( $terms ) ) { ?>
				<div class="<?php echo esc_attr( $args['classes'] ); ?>">
					<?php
					$separator = ', ';
					$count     = 0;
					$temp      = '';
					foreach ( $terms as $term ) {
						if ( $count > 0 ) {
							$temp .= $separator;
						}

						$temp .= $term->name;

						$count++;
					}

					echo esc_html( $temp );
					?>
				</div>
				<?php
			}
		}

		function entry_video( $args = array() ) {
			$defaults = array(
				'position' => 'above',
			);
			$args     = wp_parse_args( $args, $defaults );

			$show_video = Edumall::setting( 'single_portfolio_video_enable' );

			if ( $show_video === 'none' || $show_video !== $args['position'] ) {
				return;
			}

			$url = Edumall_Helper::get_post_meta( 'portfolio_video_url', '' );
			if ( $url === '' ) {
				return;
			}

			$embed = wp_oembed_get( $url );

			if ( $embed === false ) {
				return;
			}

			$wrap_classes = 'entry-portfolio-video';
			$wrap_classes .= " {$args['position']}";
			?>
			<div class="<?php echo esc_attr( $wrap_classes ); ?>">
				<?php echo '<div class="embed-responsive-16by9 embed-responsive">' . $embed . '</div>'; ?>
			</div>
			<?php
		}

		function entry_categories() {
			?>
			<div class="entry-portfolio-categories">
				<?php echo get_the_term_list( get_the_ID(), self::$category, '<div>', '</div><div>', '</div>' ); ?>
			</div>
			<?php
		}

		function entry_details() {
			$client      = $this->get_the_post_meta( 'portfolio_client', '' );
			$date        = $this->get_the_post_meta( 'portfolio_date', '' );
			$cats_enable = Edumall::setting( 'single_portfolio_categories_enable' );
			$tags_enable = Edumall::setting( 'single_portfolio_tags_enable' );
			?>
			<div class="entry-portfolio-details">
				<?php if ( $date !== '' ) : ?>
					<div class="entry-portfolio-date">
						<h5 class="label"><?php esc_html_e( 'Date', 'edumall' ); ?></h5>
						<div class="value"><?php echo esc_html( $date ); ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $client !== '' ) : ?>
					<div class="entry-portfolio-client">
						<h5 class="label"><?php esc_html_e( 'Client', 'edumall' ); ?></h5>
						<div class="value"><?php echo esc_html( $client ); ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $cats_enable === '1' && $this->has_category() ) : ?>
					<div class="entry-portfolio-categories">
						<h5 class="label"><?php esc_html_e( 'Category', 'edumall' ); ?></h5>
						<div class="value">
							<?php echo get_the_term_list( get_the_ID(), self::$category, '<div>', '</div><div>', '</div>' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $tags_enable === '1' && $this->has_tag() ) : ?>
					<div class="entry-portfolio-tags">
						<h5 class="label"><?php esc_html_e( 'Tags', 'edumall' ); ?></h5>
						<div class="value">
							<?php echo get_the_term_list( get_the_ID(), self::$tag, '', ', ', '' ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}

		function entry_share( $args = array() ) {
			if ( ! class_exists( 'InsightCore' ) ) {
				return;
			}

			$social_sharing = Edumall::setting( 'social_sharing_item_enable' );
			if ( empty( $social_sharing ) ) {
				return;
			}
			?>
			<div class="entry-portfolio-share post-share">
				<h6 class="share-label label">
					<?php esc_html_e( 'Share:', 'edumall' ); ?>
				</h6>
				<div class="share-list">
					<div class="inner">
						<?php Edumall_Templates::get_sharing_list( $args ); ?>
					</div>
				</div>
			</div>
			<?php
		}

		function entry_project_link() {
			$url = Edumall_Helper::get_post_meta( 'portfolio_url', '' );

			if ( $url !== '' ) : ?>
				<div class="entry-portfolio-link">
					<?php
					Edumall_Templates::render_button( [
						'text'  => esc_html__( 'Visit Website', 'edumall' ),
						'link'  => [
							'url'         => $url,
							'is_external' => true,
							'nofollow'    => true,
						],
						'icon'  => 'fa-solid fa-arrow-right',
						'class' => 'tm-button-view-project',
						'style' => 'border',
					] );
					?>
				</div>
			<?php endif;
		}

		function entry_navigation_links() {
			$style = $this->get_the_post_meta( 'portfolio_pagination_style' );

			if ( '' === $style ) {
				$style = Edumall::setting( 'single_portfolio_pagination' );
			}

			if ( 'none' === $style ) {
				return;
			}

			$wrapper_classes = "portfolio-nav-links style-{$style}";
			?>
			<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php edumall_load_template( 'portfolio/single/navigation-links/style', $style ); ?>
			</div>
			<?php
		}
	}

	Edumall_Portfolio::instance()->initialize();
}
