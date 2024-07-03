<?php
/**
 * @plugin-since  2.1.2
 * @theme-since   3.4.0
 * @theme-version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\Course;
use Tutor\Models\CourseModel;

$user_id      = get_current_user_id();
$course_id    = isset( $course_id ) ? (int) $course_id : 0;
$is_enrolled  = tutor_utils()->is_enrolled( $course_id );
$course_stats = tutor_utils()->get_course_completed_percent( $course_id, 0, true );

// options
$show_mark_complete = isset( $mark_as_complete ) ? $mark_as_complete : false;

$is_course_completed = tutor_utils()->is_completed_course( $course_id, $user_id );

/**
 * Auto course complete on all lesson, quiz, assignment complete
 *
 * @since 2.0.7
 * @since 2.4.0 update and refactor.
 */
if ( CourseModel::can_autocomplete_course( $course_id, $user_id ) ) {
	CourseModel::mark_course_as_completed( $course_id, $user_id );

	/**
	 * After auto complete the course.
	 * Set review popup data and redirect to course details page.
	 * Review popup will be shown on course details page.
	 *
	 * @since 2.4.0
	 */
	Course::set_review_popup_data( $user_id, $course_id );
	$course_link = get_permalink( $course_id );
	if ( $course_link ) {
		tutils()->redirect_to( $course_link );
		exit;
	}
}

?>
<div class="tutor-course-topic-single-header tutor-single-page-top-bar">
	<div class="tutor-topbar-item tutor-top-bar-course-link">
		<?php $course_id = Edumall_Tutor::instance()->get_course_id_by_lessons_id( get_the_ID() ); ?>
		<a href="<?php echo get_the_permalink( $course_id ); ?>" class="tutor-topbar-home-btn">
			<i class="fa-regular fa-home"></i><?php esc_html_e( 'Go to course home', 'edumall' ); ?>
		</a>
	</div>

	<div class="tutor-topbar-item tutor-topbar-content-title-wrap">
		<?php
		$video = tutor_utils()->get_video_info( get_the_ID() );

		$play_time = false;
		if ( $video ) {
			$play_time = $video->playtime;
		}

		$lesson_type      = $play_time ? 'video' : 'document';
		$lesson_type_icon = 'video' === $lesson_type ? 'fa-regular fa-play-circle' : 'fa-regular fa-file-alt';
		?>
		<span class="lesson-type-icon">
			<i class="<?php echo esc_attr( $lesson_type_icon ); ?>"></i>
		</span>
		<?php the_title(); ?>
	</div>

	<div class="tutor-topbar-mark-to-done">
		<?php if ( $is_enrolled ) : ?>
			<?php if ( $show_mark_complete ) : ?>
				<?php tutor_lesson_mark_complete_html(); ?>
				<?php do_action( 'tutor_after_lesson_completion_button', $course_id, $user_id, $is_course_completed, $course_stats ); ?>
			<?php else : ?>
				<div style="width: 150px;"></div>
			<?php endif ?>
		<?php endif; ?>
	</div>
</div>
