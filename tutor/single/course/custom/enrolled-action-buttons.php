<?php
/**
 * Display action buttons
 *
 * @since   v.1.0.0
 * @author  thememove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

$is_enrolled         = apply_filters( 'tutor_alter_enroll_status', tutor_utils()->is_enrolled() );
$retake_course       = tutor_utils()->can_user_retake_course();
$completed_percent   = tutor_utils()->get_course_completed_percent();
$is_completed_course = tutor_utils()->is_completed_course();
$lesson_url          = tutor_utils()->get_course_first_lesson();
$start_content       = '';

if ( $lesson_url ) {
	$button_class = 'tutor-btn ' .
	                ( $retake_course ? 'tutor-btn-outline-primary' : 'tutor-btn-primary' ) .
	                ' tutor-btn-block' .
	                ( $retake_course ? ' tutor-course-retake-button' : '' );

	// Button identifier class.
	$button_identifier = 'start-continue-retake-button';
	$button_tag        = $retake_course ? 'button' : 'a';

	if ( $retake_course ) {
		$button_text = __( 'Retake This Course', 'edumall' );
	} elseif ( $completed_percent <= 0 ) {
		$button_text = __( 'Start Learning', 'edumall' );
	} else {
		$button_text = __( 'Continue Learning', 'edumall' );
	}

	$attributes = '';
	$attributes .= 'a' === $button_tag ? ' href="' . esc_url( $lesson_url ) . '"' : '';
	$attributes .= $retake_course ? ' disabled="disabled"' : '';

	$start_content = sprintf(
		'<%1$s %2$s class="%3$s" data-course_id="%4$s">%5$s</%1$s>',
		$button_tag,
		$attributes,
		esc_attr( $button_class . ' ' . $button_identifier ),
		esc_attr( get_the_ID() ),
		$button_text
	);
}
echo apply_filters( 'tutor_course/single/start/button', $start_content, get_the_ID() );

// Show Course Completion Button.
if ( ! $is_completed_course ) {
	ob_start();
	?>
	<form method="post" class="tutor-mt-20">
		<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
		<input type="hidden" value="<?php echo esc_attr( get_the_ID() ); ?>" name="course_id"/>
		<input type="hidden" value="tutor_complete_course" name="tutor_action"/>
		<button type="submit" class="tutor-btn tutor-btn-outline-primary tutor-btn-block" name="complete_course_btn" value="complete_course">
			<?php esc_html_e( 'Complete Course', 'edumall' ); ?>
		</button>
	</form>
	<?php
	echo apply_filters( 'tutor_course/single/complete_form', ob_get_clean() );
}

// Check if has enrolled date.
$post_date = is_object( $is_enrolled ) && isset( $is_enrolled->post_date ) ? $is_enrolled->post_date : '';
if ( '' !== $post_date ) :
	?>
	<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-d-flex">
		<div class="tutor-fs-6 tutor-color-success tutor-icon-purchase-mark tutor-mr-8"></div>
		<div class="tutor-enrolled-info-text">
			<?php esc_html_e( 'You enrolled in this course on', 'edumall' ); ?>
			<span class="tutor-fs-7 tutor-fw-bold tutor-color-success tutor-ml-4 tutor-enrolled-info-date">
				<?php echo esc_html( tutor_i18n_get_formated_date( $post_date, get_option( 'date_format' ) ) ); ?>
			</span>
		</div>
	</div>
<?php endif; ?>
