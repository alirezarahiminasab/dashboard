<?php
/**
 * Display single course add to cart
 *
 * @author        themeum
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.8.8
 */

defined( 'ABSPATH' ) || exit;

$isLoggedIn = is_user_logged_in();

$monetize_by              = tutils()->get_option( 'monetize_by' );
$enable_guest_course_cart = tutor_utils()->get_option( 'enable_guest_course_cart' );

$is_public      = get_post_meta( get_the_ID(), '_tutor_is_public_course', true ) == 'yes';
$is_purchasable = tutor_utils()->is_course_purchasable();

$required_loggedin_class = '';
if ( ! $isLoggedIn && ! $is_public ) {
	$required_loggedin_class = apply_filters( 'tutor_enroll_required_login_class', 'tutor-open-login-modal' );
}
if ( $is_purchasable && $monetize_by === 'wc' && $enable_guest_course_cart ) {
	$required_loggedin_class = '';
}

$tutor_form_class = apply_filters( 'tutor_enroll_form_classes', [ 'tutor-enroll-form' ] );

$tutor_course_sell_by = apply_filters( 'tutor_course_sell_by', null );

do_action( 'tutor_course/single/add-to-cart/before' );
?>

<div class="tutor-single-add-to-cart-box <?php echo $required_loggedin_class; ?>">
	<?php
	if ( $is_purchasable && $tutor_course_sell_by ) {
		tutor_load_template( 'single.course.add-to-cart-' . $tutor_course_sell_by );
	} else {
		?>
		<?php
		if ( $is_public ) {
			$first_lesson_url = tutor_utils()->get_course_first_lesson( get_the_ID(), tutor()->lesson_post_type );
			! $first_lesson_url ? $first_lesson_url = tutor_utils()->get_course_first_lesson( get_the_ID() ) : 0;
			?>
			<div class="<?php echo implode( ' ', $tutor_form_class ); ?> ">
				<div class="tutor-course-enroll-wrap">
					<?php
					Edumall_Templates::render_button( [
						'link'        => [
							'url' => esc_url( $first_lesson_url ),
						],
						'text'        => esc_html__( 'Start Learning', 'edumall' ),
						'extra_class' => 'tutor-btn-enroll tutor-btn tutor-course-purchase-btn',
					] );
					?>
				</div>
			</div>
		<?php } else { ?>
			<form class="<?php echo esc_attr( implode( ' ', $tutor_form_class ) ); ?>" method="post">
				<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
				<input type="hidden" name="tutor_course_id" value="<?php echo get_the_ID(); ?>">
				<input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">

				<div class=" tutor-course-enroll-wrap">
					<button type="submit" class="tutor-btn-enroll tutor-btn tutor-course-purchase-btn">
						<?php esc_html_e( 'Enroll Now', 'edumall' ); ?>
					</button>
				</div>
			</form>
		<?php } ?>
	<?php } ?>
</div>

<?php do_action( 'tutor_course/single/add-to-cart/after' ); ?>
