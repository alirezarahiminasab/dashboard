<?php
/**
 * Display single login
 *
 * @since   v.1.0.0
 * @author  themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true ) ) {
	// Redirect to wp native login page.
	header( 'Location: ' . wp_login_url( tutor_utils()->get_current_url() ) );
	exit;
}

get_header();
?>

	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="page-main-content">
					<?php do_action( 'tutor/template/login/before/wrap' ); ?>

					<div class="tutor-template-segment user-form-box user-login-form">
						<div class="tutor-login-form-wrapper">
							<?php tutor_load_template( 'login-form' ); ?>
						</div>

						<?php do_action( 'tutor_after_login_form_wrapper' ); ?>
					</div>

					<?php do_action( 'tutor/template/login/after/wrap' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();
