<?php

/**
 * User links box on header
 *
 * @package Edumall
 * @since   1.3.1
 * @version 2.4.0
 */

defined('ABSPATH') || exit;
?>
<div class="header-user-links-box">
	<div class="user-icon">
		<span class="fal fa-user"></span>
	</div>
	<div class="user-links">
		<?php
		if (!is_user_logged_in()) {
		?>
			<a class="header-login-link open-popup-login" href="javascript:void(0);"><?php esc_html_e('Log In', 'edumall-child'); ?></a>
			<a class="header-register-link open-popup-register" href="javascript:void(0);"><?php esc_html_e('Register', 'edumall-child'); ?></a>
		<?php
		} else {
			$profile_url  = apply_filters('edumall_user_profile_url', '');
			$profile_text = apply_filters('edumall_user_profile_text', esc_html__('Profile', 'edumall-child'));
		?>
			<a class="header-profile-link" href="<?php echo esc_url($profile_url); ?>"><?php echo esc_html($profile_text); ?></a>
			<a class="header-logout-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log out', 'edumall-child'); ?></a>
		<?php } ?>
	</div>
</div>