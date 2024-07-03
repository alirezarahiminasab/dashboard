<?php
/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.9.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\Input;

?>
<div class="page-content">
	<div class="container">
		<div class="row">
			<div class="page-main-content">
				<?php tutor_alert( null, 'any' ); ?>
				<div class="user-form-box user-lost-pass-form">
					<div class="user-form-wrap">
						<?php if ( Input::get( 'reset_key' ) && Input::get( 'user_id' ) ) : ?>
							<?php tutor_load_template( 'template-part.form-retrieve-password' ); ?>
						<?php else: ?>
							<?php do_action( 'tutor_before_retrieve_password_form' ); ?>

							<div class="form-header">
								<h4 class="form-title"><?php esc_html_e( 'Lost your password?', 'edumall' ); ?></h4>
								<p class="form-description">
									<?php echo esc_html( apply_filters( 'tutor_lost_password_message', __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'edumall' ) ) ) ?>
									<?php printf( esc_html__( 'Remember now? %1$sBack to login%2$s', 'edumall' ), '<a href="' . esc_url( edumall_login_url() ) . '" class="link-transition-02">', '</a>' ); ?>
								</p>
							</div>

							<form method="post" class="tutor-forgot-password-form tutor-ResetPassword lost_reset_password">
								<?php
								tutor_alert( null, 'any' );
								tutor_nonce_field();
								?>
								<input type="hidden" name="tutor_action" value="tutor_retrieve_password">

								<div class="form-row">
									<label for="user_login"><?php esc_html_e( 'Username or email', 'edumall' ); ?></label>
									<input type="text" name="user_login" id="user_login" autocomplete="username">
								</div>

								<div class="clear"></div>

								<?php do_action( 'tutor_lostpassword_form' ); ?>

								<div class="form-row">
									<button type="submit" class="tutor-button tutor-button-primary form-submit" value="<?php esc_attr_e( 'Reset password', 'edumall' ); ?>"><?php esc_html_e( 'Reset password', 'edumall' ); ?></button>
								</div>
							</form>

							<?php do_action( 'tutor_after_retrieve_password_form' ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
