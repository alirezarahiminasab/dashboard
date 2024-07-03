<?php
/**
 * Template for displaying single course
 *
 * @since   v.1.0.0
 *
 * @author  Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

$course_id                         = get_the_ID();
$is_public                         = \TUTOR\Course_List::is_public( $course_id );
$student_must_login_to_view_course = tutor_utils()->get_option( 'student_must_login_to_view_course' );

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
	tutor_load_template( 'login' );

	return;
}

get_header();

$layout = Edumall::setting( 'single_course_layout' );

tutor_load_template( "content-single-course-{$layout}" );

$jsonData                                 = array();
$jsonData['post_id']                      = get_the_ID();
$jsonData['best_watch_time']              = 0;
$jsonData['autoload_next_course_content'] = (bool) get_tutor_option( 'autoload_next_course_content' );
?>
	<input type="hidden" id="tutor_video_tracking_information"
	       value="<?php echo esc_attr( json_encode( $jsonData ) ); ?>">
<?php
get_footer();
