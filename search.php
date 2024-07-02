<?php

/**
 * The template for displaying search results pages.
 *
 * @link     https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package  Edumall
 * @since    1.0
 */
get_header();
$tutor = new Edumall_Tutor();
global $wp;
$search_value = sanitize_text_field($_GET['s']);
$current_page  = !empty($_GET['current_page']) ? sanitize_text_field($_GET['current_page']) : 1;
$courses_args = array(
	'post_type' => 'courses',
	'posts_per_page' => 3,
	's' 		=> $search_value,
	'order' 	=> 'DESC',
	'paged'		=> $current_page
);
$courses_query = new WP_Query($courses_args);

// could be almost anything but I don't recommend to use 'page' or 'paged'
$query_arg = 'current_page';
// URL of your search page

$user_args = array('role' => 'tutor_instructor');
$user_query = new WP_User_Query($user_args);

$page_url = add_query_arg($wp->query_vars, home_url());
?>
<div id="search-page" class="search-page">
	<div class="search-page-courses">
		<?php if ($courses_query->have_posts()) : ?>
			<?php while ($courses_query->have_posts()) :
				$courses_query->the_post();
				$course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());

				$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
				$profile_photo_id    = get_user_meta($course_instructors[0]->ID, '_instructor_profile_pic', true);
				$course_rating = $tutor->get_course_rating(get_the_ID());
				$course_category = $tutor->get_the_categories();
				$bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
			?>
				<div class="search-page-courses-item">
					<div class="pics">
						<span class="pics-author">
							<img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
						</span>
						<span class="pics-thumbnail">
							<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
						</span>
						<span class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
							<img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
							<img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
						</span>
					</div>
					<div class="captions">
						<div class="captions-meta">
							<div class="captions-meta-title">
								<a href="<?php echo get_the_permalink(); ?>">
									<?php echo get_the_title() ?>
								</a>
							</div>
							<div class="captions-meta-info">
								<span class="captions-meta-info-item">
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.svg' ?>" alt="">
									<p><?php echo $course_instructors[0]->display_name ?></p>
								</span>
								<span class="captions-meta-info-item">
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
									<?php if (!empty($course_category)) : ?>
										<?php foreach ($course_category as $category) : ?>
											<p class="captions-meta-info-item-category"><?php echo $category->name ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</span>
								<span class="captions-meta-info-item">
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.svg' ?>" alt="">
									<p><?php echo $course_rating->rating_avg ?></p>
									<p class="captions-meta-info-item-reviews">
										(<?php echo $course_rating->rating_count ?> نظر)
									</p>
								</span>
							</div>
						</div>
						<?php echo $landing_page_init->get_the_course_price() ?>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		<?php if ($courses_query->max_num_pages > 1) : ?>
			<div class="search-page-pagination">
				<?php echo paginate_links(
					array(
						'total' => $courses_query->max_num_pages,
						'current' => $current_page,
						'before_page_number' => "<p>",
						'after_page_number' => "</p>",
						'prev_text' => "",
						'next_text' => "",
						'base' => $page_url . '%_%',
						'format' => '&' . $query_arg . '=%#%'
					)
				); ?>
			</div>
		<?php endif; ?>
	</div>

</div>
<?php
get_footer();
