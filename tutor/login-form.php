<?php
/**
 * Tutor login form template
 *
 * @package       Tutor\Templates
 * @author        Themeum <support@themeum.com>
 * @link          https://themeum.com
 * @since         2.0.1
 *
 * @theme-since   3.9.0
 * @theme-version 3.9.0
 */

use TUTOR\Ajax;

$lost_pass = apply_filters( 'tutor_lostpassword_url', wp_lostpassword_url() );
/**
 * Get login validation errors & print
 *
 * @since 2.1.3
 */
$login_errors = get_transient( Ajax::LOGIN_ERRORS_TRANSIENT_KEY ) ? get_transient( Ajax::LOGIN_ERRORS_TRANSIENT_KEY ) : array();
?>
<div class="user-form-wrap">
	<?php
	foreach ( $login_errors as $login_error ) {
		?>
		<div class="tutor-alert tutor-warning tutor-mb-12" style="display:block; grid-gap: 0px 10px;">
			<?php
			echo wp_kses(
				$login_error,
				array(
					'strong' => true,
					'a'      => array(
						'href'  => true,
						'class' => true,
						'id'    => true,
					),
					'p'      => array(
						'class' => true,
						'id'    => true,
					),
					'div'    => array(
						'class' => true,
						'id'    => true,
					),
				)
			);
			?>
		</div>
		<?php
	}

	do_action( 'tutor_before_login_form' );
	?>
	<form id="tutor-login-form" method="post">
		<div class="form-header">
			<h4 class="form-title login-title"><?php esc_html_e( 'Login', 'edumall' ); ?></h4>
			<?php if ( get_option( 'users_can_register', false ) ) : ?>
				<p class="form-description">
					<?php
					printf(
						esc_html__( 'Don\'t have an account yet? %sSign up for free%s', 'edumall' ),
						'<a href="' . esc_url( edumall_registration_url() ) . '" class="link-transition-02">',
						'</a>' );
					?>
				</p>
			<?php endif; ?>
		</div>
		<?php if ( is_single_course() ) : ?>
			<input type="hidden" name="tutor_course_enroll_attempt" value="<?php echo esc_attr( get_the_ID() ); ?>">
		<?php endif; ?>
		<?php tutor_nonce_field(); ?>
		<input type="hidden" name="tutor_action" value="tutor_user_login"/>
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( apply_filters( 'tutor_after_login_redirect_url', tutor()->current_url ) ); ?>"/>

		<div class="form-row">
			<label for="input_login_username"><?php esc_html_e( 'Username or email', 'edumall' ); ?></label>
			<input type="text" class="tutor-form-control" placeholder="<?php esc_html_e( 'Your username or email', 'edumall' ); ?>" name="log" value="" size="20" required id="input_login_username"/>
		</div>

		<div class="form-row form-input-password">
			<label for="input_login_password"><?php esc_html_e( 'Password', 'edumall' ); ?></label>
			<input type="password" class="tutor-form-control" placeholder="<?php esc_html_e( 'Password', 'edumall' ); ?>" name="pwd" value="" size="20" required id="input_login_password"/>
			<button type="button" class="btn-pw-toggle" data-toggle="0"
			        aria-label="<?php esc_attr_e( 'Show password', 'edumall' ); ?>">
			</button>
		</div>

		<div class="tutor-login-error"></div>
		<?php
		do_action( 'tutor_login_form_middle' );
		do_action( 'login_form' );
		apply_filters( 'login_form_middle', '', '' );
		?>
		<div class="tutor-d-flex tutor-justify-between tutor-align-center form-row">
			<div class="tutor-form-check">
				<label for="tutor-login-agmnt-1" class="form-label-checkbox">
					<input id="tutor-login-agmnt-1" type="checkbox" name="rememberme" value="forever"/>
					<?php esc_html_e( 'Remember me', 'edumall' ); ?>
				</label>
			</div>
			<a href="<?php echo esc_url( $lost_pass ); ?>" class="forgot-password-link link-transition-02">
				<?php esc_html_e( 'Forgot your password?', 'edumall' ); ?>
			</a>
		</div>

		<?php do_action( 'tutor_login_form_end' ); ?>
		<div class="form-row">
			<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-block">
				<?php esc_html_e( 'Log In', 'edumall' ); ?>
			</button>
		</div>
		<?php do_action( 'tutor_after_sign_in_button' ); ?>
	</form>
	<?php
	do_action( 'tutor_after_login_form' );
	if ( ! tutor_utils()->is_tutor_frontend_dashboard() ) : ?>
		<script>
			document.addEventListener( 'DOMContentLoaded', function() {
				var { __ } = wp.i18n;
				var loginModal = document.querySelector( '.tutor-modal.tutor-login-modal' );
				var errors = <?php echo wp_json_encode( $login_errors ); ?>;
				if ( loginModal && errors.length ) {
					loginModal.classList.add( 'tutor-is-active' );
				}
			} );
		</script>
	<?php endif; ?>
	<?php delete_transient( Ajax::LOGIN_ERRORS_TRANSIENT_KEY ); ?>
</div>
