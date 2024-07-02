<?php

/**
 * Template for displaying single lesson
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         v.1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.0.0
 */


defined('ABSPATH') || exit;

use TUTOR\User;
use TUTOR\Input;

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;

get_tutor_header();

global $post;
global $previous_id;
global $next_id;
global $edumall_course;

$currentPost = $post;
$course_content_id = get_the_ID();
$content_id  = tutor_utils()->get_post_id($course_content_id);
$course_id         = tutor_utils()->get_course_id_by_subcontent($course_content_id);
$contents          = tutor_utils()->get_course_prev_next_contents_by_id($content_id);
$previous_id       = $contents->previous_id;
$next_id           = $contents->next_id;
$course_likes		= get_post_meta($course_id, '_course_like', true);
$course_reviews = tutor_utils()->get_course_reviews($course_id, 0, 0, true);
$user_id = get_current_user_id();
$instructors = tutor_utils()->get_instructors_by_course($course_id);
$instructor = $instructors[0];
$profile_photo_id    = get_user_meta($instructor->ID, '_instructor_profile_pic', true);

$prev_is_preview = get_post_meta($previous_id, '_is_preview', true);
$next_is_preview = get_post_meta($next_id, '_is_preview', true);
$is_enrolled     = tutor_utils()->is_enrolled($course_id);
$is_public       = get_post_meta($course_id, '_tutor_is_public_course', true);
$prev_is_locked  = !($is_enrolled || $prev_is_preview || $is_public);
$next_is_locked  = !($is_enrolled || $next_is_preview || $is_public);
$prev_link       = $prev_is_locked || !$previous_id ? '#' : get_the_permalink($previous_id);
$next_link       = $next_is_locked || !$next_id ? '#' : get_the_permalink($next_id);

$like_btn_empty = get_stylesheet_directory_uri() . '/assets/images/heart-black.svg';
$like_btn_filled = get_stylesheet_directory_uri() . '/assets/images/heart-filled.svg';

$like_src            = tutor_utils()->is_wishlisted($course_id) ? $like_btn_filled : $like_btn_empty;

$course_permalink = get_permalink($course_id);
$course_name = get_the_title($course_id);
$course_categories = wp_get_post_terms($course_id, 'course-category');
$course_tags = wp_get_post_terms($course_id, 'course-tag');
$course_categories_arr = [];

foreach ($course_categories as $category) :
	$course_categories_arr[] = $category->term_id;
endforeach;

$related_arg = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'course-category',
			'field' => 'term_id',
			'terms' => $course_categories_arr,
		),
	),
);
$related_query = new WP_Query($related_arg);

$post_type = get_post_type($course_id);
$post_type_archive_link = get_post_type_archive_link($post_type);

$total_lessons     = tutor_utils()->get_lesson_count_by_course($course_id);
$completed_lessons = tutor_utils()->get_completed_lesson_count_by_course($course_id, $user_id);
$lesson_progress_percent = ($completed_lessons / $total_lessons) * 100;

$is_completed_lesson = tutor_utils()->is_completed_lesson();

$video = tutor_utils()->get_video_info();

// Build the formatted time string
$timeString = '';

$play_time = false;
if (isset($video->url)) {

	$play_time = $video->playtime;

	// Split the duration string into an array using ":" as the delimiter
	$timeArray = explode(":", $play_time);

	// Extract minutes and seconds from the array
	$minutes = isset($timeArray[0]) ? $timeArray[0] : 0;
	$seconds = isset($timeArray[1]) ? $timeArray[1] : 0;


	if ($minutes > 0) {
		$timeString .= $minutes . ' ' . esc_html__('دقیقه', 'edumall-child');
	}

	if ($seconds > 0) {
		$timeString .= ($timeString != '' ? ' ' . esc_html__('و', 'edumall-child') . ' ' : '') . $seconds . ' ' . esc_html__('ثانیه', 'edumall-child');
	}
}

// Reviews
$per_page     = tutor_utils()->get_option('pagination_per_page', 4);
$current_page = max(1, Input::post('current_page', 0, Input::TYPE_INT));
$offset       = ($current_page - 1) * $per_page;


$is_enrolled     = tutor_utils()->is_enrolled($course_id, $user_id);

$reviews       = tutor_utils()->get_course_reviews($course_id, $offset, $per_page, false, array('approved'), $user_id);
$rating        = tutor_utils()->get_course_rating($course_id);

if (Input::has('course_id')) {
	// It's load more.
	tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews));

	return;
}

$like_count = $course_extend->get_course_likes_number($course_id);
?>
<div class="single-lesson">
	<?php do_action('tutor_lesson/single/before/wrap'); ?>

	<?php
	$enable_spotlight_mode = tutor_utils()->get_option('enable_spotlight_mode');
	$wrapper_class         = 'single-lesson-wrap';

	if ($enable_spotlight_mode) {
		$wrapper_class .= ' tutor-spotlight-mode';
	}
	?>
	<div class="single-lesson-breadcrumb">
		<a href="<?php echo get_home_url() ?>"><?php echo esc_html__('home', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<a class="archive" href="<?php echo $post_type_archive_link; ?>"><?php echo esc_html__('دوره‌ها', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<a href="<?php echo $course_permalink ?>"><?php echo $course_name ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<p class="title"><?php echo get_the_title(); ?></p>
	</div>

	<div class="<?php echo esc_attr($wrapper_class); ?>">
		<div class="single-lesson-wrap-header">
			<div class="header-title">
				<p>
					<?php echo get_the_title(); ?>
				</p>
			</div>
			<div class="header-info">
				<div class="header-info-category">
					<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
					<?php
					if (!empty($course_categories)) :
						foreach ($course_categories as $category) :
					?>
							<p><?php echo $category->name; ?></p>
					<?php
						endforeach;
					endif;
					?>
				</div>

				<div class="header-info-date">
					<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar.svg' ?>" alt="">
					<p>
						<?php echo $course_extend->time_ago(get_the_time('Y-m-d H:i:s')); ?>
					</p>
				</div>

				<div class="header-info-duration">
					<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/clock-transparent.svg' ?>" alt="">
					<p>
						<?php echo $timeString ?>
					</p>
				</div>
			</div>
		</div>

		<div class="single-lesson-wrap-progress">
			<div class="user-progress-percent">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/progress.svg' ?>" alt="">
				<p>
					<?php echo $lesson_progress_percent ?>%
				</p>
				<span class="user-progress-percent-num" style="width: <?php echo $lesson_progress_percent ?>%;"></span>
			</div>
			<div class="user-progress-count">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/completed-lessons.svg' ?>" alt="">
				<p>
					<?php echo $total_lessons ?>/<?php echo $completed_lessons ?>
				</p>
			</div>
		</div>

		<div class="single-lesson-wrap-video">
			<?php
			$video_info = tutor_utils()->get_video_info();
			$source_key = is_object($video_info) && 'html5' !== $video_info->source ? 'source_' . $video_info->source : null;
			$has_source = (is_object($video_info) && $video_info->source_video_id) || (isset($source_key) ? $video_info->$source_key : null);
			if ($has_source) :
				$completion_mode                              = tutor_utils()->get_option('course_completion_process');
				$json_data['strict_mode']                     = ('strict' === $completion_mode);
				$json_data['control_video_lesson_completion'] = (bool) tutor_utils()->get_option('control_video_lesson_completion', false);
				$json_data['required_percentage']             = (int) tutor_utils()->get_option('required_percentage_to_complete_video_lesson', 80);
				$json_data['video_duration']                  = $video_info->duration_sec ?? 0;
				$json_data['lesson_completed']                = tutor_utils()->is_completed_lesson($content_id, $user_id) !== false;
				$json_data['is_enrolled']                     = tutor_utils()->is_enrolled($course_id, $user_id) !== false;
			?>
				<input type="hidden" id="tutor_video_tracking_information" value="<?php echo esc_attr(json_encode($json_data)); ?>">
			<?php endif; ?>
			<div class="tutor-video-player-wrapper">
				<?php echo apply_filters('tutor_single_lesson_video', tutor_lesson_video(false), $video_info, $source_key); //phpcs:ignore 
				?>
			</div>
		</div>

		<div class="single-lesson-wrap-content">
			<?php
			$referer_url        = wp_get_referer();
			$referer_comment_id = explode('#', filter_input(INPUT_SERVER, 'REQUEST_URI') ?? '');
			$url_components     = parse_url($referer_url);
			$page_tab           = \TUTOR\Input::get('page_tab', 'overview');

			isset($url_components['query']) ? parse_str($url_components['query'], $output) : null;

			/**
			 * If lesson has no content, lesson tab will be hidden.
			 * To enable elementor and SCORM, only admin can see lesson tab.
			 *
			 * @since 2.2.2
			 */
			$has_lesson_content = apply_filters(
				'tutor_has_lesson_content',
				User::is_admin() || !in_array(trim(get_the_content()), array(null, '', '&nbsp;'), true),
				$course_content_id
			);

			$has_lesson_attachment = count(tutor_utils()->get_attachments()) > 0;
			$has_lesson_comment    = (int) get_comments_number($course_content_id);
			?>

			<?php if ($has_lesson_content) : ?>
				<p>
					<?php the_content(); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="single-lesson-wrap-completed">
			<form method="post">
				<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce, false); ?>
				<input type="hidden" value="<?php echo esc_attr(get_the_ID()); ?>" name="lesson_id" />
				<input type="hidden" value="tutor_complete_lesson" name="tutor_action" />
				<button type="submit" class="tutor-topbar-mark-btn tutor-btn tutor-btn-primary tutor-ws-nowrap <?php echo $is_completed_lesson ? "lesson-completed" : '' ?>" name="complete_lesson_btn" value="complete_lesson">
					<input type="checkbox" name="" id="completeLessonCheckbox" <?php echo $is_completed_lesson ? "checked" : '' ?>>
					<p><?php esc_html_e('مطالعه کردم', 'edumall-child'); ?></p>
				</button>
			</form>
		</div>

		<div class="single-lesson-wrap-navigation">
			<?php if ($next_id || $previous_id) : ?>
				<?php if ($previous_id) : ?>
					<a href="<?php echo esc_url($prev_link); ?>">
						<?php esc_html_e('قسمت قبلی', 'edumall-child'); ?>
					</a>
				<?php endif; ?>

				<?php if ($next_id) : ?>
					<a class="<?php echo $previous_id ? 'has_previous' : '' ?>" href="<?php echo esc_url($next_link); ?>">
						<?php esc_html_e('قسمت بعدی', 'edumall-child'); ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="single-lesson-course">
		<div class="single-lesson-course-tags">
			<?php
			if (!empty($course_tags)) :
				foreach ($course_tags as $tag) :
			?>
					<a href="<?php echo get_term_link($tag->term_id) ?>"><?php echo $tag->name; ?></a>
			<?php
				endforeach;
			endif;
			?>
		</div>

		<div class="single-lesson-course-meta">
			<div class="single-lesson-course-meta-box">
				<img class="edumall-course-like-btn" src="<?php echo $like_src ?>" data-filled="<?php echo $like_btn_filled ?>" data-empty="<?php echo $like_btn_empty ?>" data-course-id="<?php echo $course_id ?>" alt="">
				<p>
					<?php echo $like_count ?>
				</p>
			</div>
			<div class="single-lesson-course-meta-box">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/message-lesson.svg' ?>" alt="">
				<p>
					<?php echo $course_reviews ?>
				</p>
			</div>
		</div>
	</div>

	<?php if ($related_query->have_posts()) : ?>
		<div class="single-lesson-related">
			<div class="single-lesson-related-title">
				<h3>
					<?php echo esc_html__('مطالب مرتبط', 'edumall-child') ?>
				</h3>
			</div>
			<div class="single-lesson-related-wrap">
				<div class="single-lesson-related-slider">
					<div class="swiper-wrapper">
						<?php while ($related_query->have_posts()) : $related_query->the_post();
							$author_id = get_the_author_meta('ID');
							$profile_url       = tutor_utils()->profile_url($author_id);
						?>
							<div class="swiper-slide">
								<div class="related-thumb">
									<?php Edumall_Image::the_post_thumbnail(array('size' => '80x80')); ?>
								</div>
								<div class="related-content">
									<div class="related-content-title">
										<a href="<?php echo get_the_permalink() ?>">
											<?php echo get_the_title(); ?>
										</a>
									</div>
									<div class="related-content-author">
										<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/user-lesson.svg' ?>" alt="">
										<a href="<?php echo $profile_url ?>">
											<?php echo get_the_author_meta('display_name'); ?>
										</a>
									</div>
									<div class="related-content-category">
										<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category-lesson.svg' ?>" alt="">
										<?php
										if (!empty($course_categories)) :
											foreach ($course_categories as $category) :
										?>
												<p><?php echo $category->name; ?></p>
										<?php
											endforeach;
										endif;
										?>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>

				<div class="single-lesson-related-navigation">
					<img class="btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
					<img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
				</div>
			</div>
		</div>
	<?php endif;
	wp_reset_postdata(); ?>


	<div class="single-lesson-instructor">
		<div class="single-lesson-instructor-wrap">
			<h4 class="tutor-segment-title"><?php esc_html_e('Your Instructors', 'edumall-child'); ?></h4>
			<?php
			$profile_url = tutor_utils()->profile_url($instructor->ID);
			$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
			$instructor_story_text    = get_user_meta($instructor->ID, '_instructor_story_text', true);
			?>
			<div class="single-instructor-wrap">
				<div class="instructor-avatar-meta">
					<div class="instructor-avatar">
						<img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
					</div>
					<div class="instructor-meta">
						<h3 class="instructor-name">
							<?php echo esc_html($instructor->display_name); ?>
						</h3>

						<?php if (!empty($instructor->tutor_profile_job_title)) : ?>
							<p class="instructor-job"><?php echo esc_html($instructor->tutor_profile_job_title); ?></p>
						<?php endif; ?>

						<?php
						$total_courses = tutor_utils()->get_course_count_by_instructor($instructor->ID);
						$total_students = tutor_utils()->get_total_students_by_instructor($instructor->ID);
						?>
						<div class="instructor-meta-item instructor-students-courses">
							<p class="meta-value">
								<?php echo esc_html(sprintf(_n('%s Course', '%s Courses', $total_courses, 'edumall-child'), $total_courses)); ?>
							</p>
							<p>
								|
							</p>
							<p class="meta-value">
								<?php echo esc_html(sprintf(_n('%s Student', '%s Students', $total_students, 'edumall-child'), $total_students)); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="instructor-bio">
					<p>
						<?php echo wp_kses_post($instructor_story_text); ?>
					</p>
				</div>

				<a href="<?php echo esc_url($profile_url); ?>" class="instructor-profile-url primary-color">
					<?php esc_html_e('See instructor profile and courses', 'edumall-child'); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="single-lesson-reviews tutor-pagination-wrapper-replaceable">
		<div class="single-lesson-reviews-wrap">
			<h4 class="tutor-segment-title">
				<?php echo esc_html__('Reviews', 'edumall-child'); ?>
			</h4>

			<div class="reviews-rating">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
				<p>
					<?php
					echo $rating->rating_avg . " | " . $rating->rating_count . " " . esc_html__('نظر', 'edumall-child') ?>
				</p>
			</div>

			<?php tutor_load_template('single.course.review-form'); ?>

			<?php if (!empty($reviews)) : ?>
				<div class="tutor-course-reviews-list tutor-pagination-content-appendable">
					<?php tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews)); ?>
				</div>
				<?php
				$pagination_data              = array(
					'total_items' => $rating->rating_count,
					'per_page'    => $per_page,
					'paged'       => $current_page,
					'layout'      => array(
						'type'           => 'load_more',
						'load_more_text' => __('مشاهده بیشتر', 'edumall-child'),
					),
					'ajax'        => array(
						'action'    => 'tutor_single_course_reviews_load_more',
						'course_id' => $course_id,
					),
				);
				$pagination_template_frontend = tutor()->path . 'templates/dashboard/elements/pagination.php';
				tutor_load_template_from_custom_path($pagination_template_frontend, $pagination_data);
				?>
			<?php endif; ?>
		</div>

	</div>
</div>



<?php do_action('tutor_lesson/single/after/wrap'); ?>

<?php
get_tutor_footer();
