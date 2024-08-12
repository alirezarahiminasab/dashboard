<?php

/**
 * Template for displaying single course
 *
 * @package         Edumall/TutorLMS/Templates
 * @theme-since     1.0.0
 * @theme-version   2.9.3
 */

defined('ABSPATH') || exit;

global $edumall_course;

$title_bar_type   = Edumall_Global::instance()->get_title_bar_type();
$top_info_classes = 'tutor-full-width-course-top';

if ('04' === $title_bar_type) {
	$top_info_classes .= ' course-top-info-light';
}
?>

<div class="page-content tm-sticky-parent">

	<?php do_action('tutor_course/single/before/wrap'); ?>

	<div <?php tutor_post_class(); ?>>
		<div class="<?php echo esc_attr($top_info_classes); ?>">
			<?php tutor_course_lead_info(); ?>
		</div>

		<!-- <div class="tutor-full-width-course-body">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<div class="tutor-single-course-main-content tm-sticky-column">

							<?php do_action('tutor_course/single/before/inner-wrap'); ?>

							<?php if ($edumall_course->is_enrolled()) : ?>
								<?php tutor_course_completing_progress_bar(); ?>
							<?php endif; ?>

							<?php if ($edumall_course->is_viewable()) : ?>
								<?php Edumall_Tutor::instance()->single_course_attachment_html(); ?>
								<?php tutor_course_question_and_answer(); ?>
							<?php endif; ?>

							<?php if ($edumall_course->is_viewable()) : ?>
								<?php tutor_course_announcements(); ?>
							<?php endif; ?>

							<?php if ($edumall_course->is_viewable() && $edumall_course->has_classroom_stream()) : ?>
								<?php do_action('tutor_course/single/enrolled/google-classroom-stream', get_the_ID()); ?>
							<?php endif; ?>

							<?php if ($edumall_course->is_enrolled()) : ?>
								<?php do_action('tutor_course/single/enrolled/gradebook', get_the_ID()); ?>
							<?php endif; ?>



							<?php do_action('tutor_course/single/after/inner-wrap'); ?>

						</div>
					</div>
				</div>
			</div>
		</div> -->
	</div>

	<?php do_action('tutor_course/single/after/wrap'); ?>

</div>