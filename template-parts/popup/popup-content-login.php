<?php

/**
 * Template part for display login form on popup.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

defined('ABSPATH') || exit;
?>
<div class="popup-content-header">
	<div class="popup-title">
		<div class="popup-title__text">
			<h3><?php esc_html_e('ورود با کلمه عبور', 'edumall-child'); ?></h3>
		</div>
	</div>
</div>

<div class="popup-content-body">

	<?php do_action('edumall_before_popup_login_form'); ?>

	<form id="edumall-login-form" class="edumall-login-form" method="post">

		<?php do_action('edumall_before_popup_login_form_fields'); ?>

		<div class="login-phone">
			<label for="ip_user_login" class="form-label"><?php esc_html_e('لطفا شماره موبایل خود را وارد کنید', 'edumall-child'); ?></label>
			<input type="text" id="ip_user_login" class="form-control form-input" name="user_login" placeholder="<?php esc_attr_e('Example: ** ** *** **09', 'edumall-child'); ?>">
		</div>

		<div class="login-password">
			<label for="ip_password" class="form-label"><?php esc_html_e('لطفا رمز عبور خود را وارد کنید', 'edumall-child'); ?></label>
			<div class="form-input-group form-input-password">
				<input type="password" id="ip_password" class="form-control form-input" name="password" placeholder="<?php esc_attr_e('رمز عبور', 'edumall-child'); ?>">
				<a href="javascript:void(0);" class="btn-toggle-pw" data-toggle="0" aria-label="<?php esc_attr_e('Show password', 'edumall-child'); ?>">
					<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/eye.svg" ?> alt="">
				</a>
			</div>
		</div>

		<div class="login-features">
			<div class="login-forget">
				<div class="forgot-password">
					<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="open-popup-lost-password forgot-password-link link-transition-02"><?php esc_html_e('رمز عبورم را فراموش کردم', 'edumall-child'); ?></a>
				</div>
			</div>
		</div>

		<?php do_action('edumall_after_popup_login_form_fields'); ?>

		<div class="form-response-messages"></div>

		<div class="login-button">
			<?php wp_nonce_field('user_login', 'user_login_nonce'); ?>
			<input type="hidden" name="action" value="edumall_user_login">
			<button type="submit" class="button form-submit"><?php esc_html_e('ورود', 'edumall-child'); ?></button>
		</div>
	</form>

	<div class="login-verify-code">
		<a class="open-login-popup" href="javascript:void(0);"><?php esc_html_e('Login with one time password', 'edumall-child'); ?></a>
	</div>

</div>