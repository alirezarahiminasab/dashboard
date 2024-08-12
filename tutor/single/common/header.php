<?php

/**
 * @plugin-since  2.1.2
 * @theme-since   3.4.0
 * @theme-version 3.4.0
 */

defined('ABSPATH') || exit;

$course_id    = isset($course_id) ? (int) $course_id : 0;
$is_enrolled  = tutor_utils()->is_enrolled($course_id);
$course_stats = tutor_utils()->get_course_completed_percent($course_id, 0, true);

// options
$show_mark_complete = isset($mark_as_complete) ? $mark_as_complete : false;

/**
 * Auto course complete on all lesson, quiz, assignment complete
 *
 * @since 2.0.7
 */
$auto_course_complete_option = tutor_utils()->get_option('auto_course_complete_on_all_lesson_completion');
$is_course_completed         = tutor_utils()->is_completed_course($course_id, get_current_user_id());
if (true === $auto_course_complete_option && false === $is_course_completed) {
	if ($course_stats['completed_count'] === $course_stats['total_count']) {
		// complete the course
		\Tutor\Models\CourseModel::mark_course_as_completed($course_id, get_current_user_id());
	}
}

?>
<div class="tutor-course-topic-single-header tutor-single-page-top-bar">
	<div class="tutor-topbar-item tutor-top-bar-course-link">
		<?php $course_id = Edumall_Tutor::instance()->get_course_id_by_lessons_id(get_the_ID()); ?>
		<a href="<?php echo get_the_permalink($course_id); ?>" class="tutor-topbar-home-btn">
			<i class="far fa-home"></i><?php esc_html_e('Go to course home', 'edumall-child'); ?>
		</a>
	</div>

	<div class="tutor-topbar-item tutor-topbar-content-title-wrap">
		<?php
		$video = tutor_utils()->get_video_info(get_the_ID());

		$play_time = false;
		if ($video) {
			$play_time = $video->playtime;
		}

		$lesson_type      = $play_time ? 'video' : 'document';
		$lesson_type_icon = 'video' === $lesson_type ? 'far fa-play-circle' : 'far fa-file-alt';
		?>
		<span class="lesson-type-icon">
			<i class="<?php echo esc_attr($lesson_type_icon); ?>"></i>
		</span>
		<?php the_title(); ?>
	</div>

	<div class="tutor-topbar-mark-to-done">
		<?php if ($is_enrolled) : ?>
			<?php if ($show_mark_complete) : ?>
				<?php tutor_lesson_mark_complete_html(); ?>
			<?php else : ?>
				<div style="width: 150px;"></div>
			<?php endif ?>
		<?php endif; ?>
	</div>
</div>