<?php

/**
 * Template for displaying course benefits
 *
 * @since   v.1.0.0
 *
 * @author  Themeum
 * @url https://themeum.com
 *
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined('ABSPATH') || exit;

global $edumall_course;

if ($edumall_course instanceof Edumall_Course) {
	$benefits = $edumall_course->get_benefits();
} else {
	$benefits = tutor_course_benefits(); // Course bundle.
}

if (empty($benefits)) {
	return;
}

do_action('tutor_course/single/before/benefits');
?>

<div class="tutor-course-benefits-wrap">
	<h4 class="tutor-segment-title">
		<?php echo esc_html__('Learning Objectives:', 'edumall-child'); ?>
	</h4>
	<div class="tutor-course-benefits-content">
		<?php foreach ($benefits as $benefit) : ?>
			<div class="tutor-course-benefits-item">
				<div class="benefits-content">
					<span class="benefits-icon" area-hidden="true">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/tick.png' ?>" alt="">
					</span>
					<span class="benefits-text">
						<p>
							<?php Edumall_Helper::e($benefit); ?>
						</p>
					</span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php do_action('tutor_course/single/after/benefits'); ?>