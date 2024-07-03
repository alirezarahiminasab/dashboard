<?php
/**
 * Login page shortcode
 *
 * @author        themeum
 * @link          https://themeum.com
 * @since         2.1.0
 *
 * @package       Tutor Pro
 * @theme-since   3.9.0
 * @theme-version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_user_logged_in() && ! is_admin() ) {
	tutor_load_template( 'dashboard.logged-in' );

	return;
}

add_filter( 'tutor_after_login_redirect_url', function() {
	return tutor_utils()->tutor_dashboard_url();
} );
?>

<?php do_action( 'tutor/template/login/before/wrap' ); ?>
<div <?php tutor_post_class( 'tutor-page-wrap' ); ?>>
	<div class="tutor-template-segment user-form-box user-login-form">
		<?php tutor_load_template( 'login-form' ); ?>
		<?php do_action( 'tutor_after_login_form_wrapper' ); ?>
	</div>
</div>
<?php do_action( 'tutor/template/login/after/wrap' ); ?>
