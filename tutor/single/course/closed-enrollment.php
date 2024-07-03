<?php
/**
 * Closed for Enrollment
 *
 * @since         v.1.6.4
 * @author        themeum
 * @url https://themeum.com
 *
 * @package       TutorLMS/Templates
 *
 * @theme-since   3.0.1
 * @theme-version 3.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'tutor_course/single/closed-enrollment/before' );
?>

<div class="tutor-single-add-to-cart-box">
	<div class="tutor-course-enroll-wrap">
		<button type="button" class="tutor-button tutor-button-block" disabled="disabled">
			<span><?php esc_html_e( '100% Booked', 'edumall' ); ?></span>
			<?php esc_html_e( 'Closed for Enrollment', 'edumall' ); ?>
		</button>
	</div>
</div>

<?php do_action( 'tutor_course/single/closed-enrollment/after' ); ?>
