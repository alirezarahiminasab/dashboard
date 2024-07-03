<?php
/**
 * Course loop meta with icon
 *
 * @author  ThemeMove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @since   1.0.0
 * @version 2.7.0
 *
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

$duration = Edumall_Tutor::instance()->get_course_duration_context();

$lesson_count = $edumall_course->get_lesson_count();
?>
<div class="course-loop-meta style-02">
	<div class="course-loop-meta-list">
		<?php if ( ! empty( $lesson_count ) ) : ?>
			<div class="course-loop-meta-item course-loop-meta-lesson">
				<div class="meta-label">
					<span class="meta-label-icon fa-regular fa-play-circle"></span>
				</div>
				<div class="meta-value">
					<?php echo esc_html( sprintf( _n( '%s Lesson', '%s Lessons', $lesson_count, 'edumall' ), $lesson_count ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $duration ) ) : ?>
			<div class="course-loop-meta-item course-loop-meta-duration">
				<div class="meta-label">
					<span class="meta-label-icon fa-regular fa-clock"></span>
				</div>
				<div class="meta-value">
					<?php echo esc_html( $duration ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="course-loop-meta-item course-loop-meta-level">
			<div class="meta-label">
				<span class="meta-label-icon fa-regular fa-sliders-h"></span>
			</div>
			<div class="meta-value">
				<?php echo get_tutor_course_level(); ?>
			</div>
		</div>
	</div>
</div>
