<?php

/**
 * Template for displaying course reviews
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.5
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.3
 */

defined('ABSPATH') || exit;

use TUTOR\Input;

global $edumall_course;

use Detection\MobileDetect;

$detect = new MobileDetect();

$per_page     = tutor_utils()->get_option('pagination_per_page', 4);
$current_page = max(1, Input::post('current_page', 0, Input::TYPE_INT));
$offset       = ($current_page - 1) * $per_page;

$current_user_id = get_current_user_id();
$course_id       = Input::post('course_id', get_the_ID(), Input::TYPE_INT);
$is_enrolled     = tutor_utils()->is_enrolled($course_id, $current_user_id);

$reviews       = tutor_utils()->get_course_reviews($course_id, $offset, $per_page, false, array('approved'), $current_user_id);
$reviews_total = tutor_utils()->get_course_reviews($course_id, null, null, true, array('approved'), $current_user_id);
$rating        = tutor_utils()->get_course_rating($course_id);


if (Input::has('course_id')) {
	// It's load more.
	tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews));

	return;
}
?>
<?php do_action('tutor_course/single/enrolled/before/reviews'); ?>

<div class="single-course-reviews single-course-item">
	<?php if (!$detect->isMobile()) : ?>
		<div class="single-course-desktop">
		<?php endif; ?>
		<div class="single-course-reviews-wrap">
			<h4 class="tutor-segment-title">
				<?php echo esc_html__('نظرات فراگیران دوره', 'edumall-child'); ?>
			</h4>

			<div class="reviews-rating">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
				<p>
					<?php
					echo number_format($rating->rating_avg, 1);
					?>
				</p>
				<p>
					|
				</p>
				<p>
					<?php echo $rating->rating_count . " " . esc_html__('reviews', 'edumall-child') ?>
				</p>
			</div>

			<?php tutor_load_template('single.course.review-form'); ?>

			<?php if (!empty($reviews)) : ?>
				<div class="tutor-course-reviews-list tutor-pagination-content-appendable">
					<?php tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews)); ?>
				</div>
				<?php
				$pagination_data              = array(
					'total_items' => $reviews_total,
					'per_page'    => $per_page,
					'paged'       => $current_page,
					'layout'      => array(
						'type'           => 'load_more',
						'load_more_text' => __('Load More', 'edumall-child'),
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
		<?php if (!$detect->isMobile()) : ?>
		</div>
	<?php endif; ?>
</div>

<?php do_action('tutor_course/single/enrolled/after/reviews'); ?>