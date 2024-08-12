<?php

/**
 * User links on top bar
 *
 * @package Edumall
 * @since   1.3.1
 * @version 2.4.0
 */

defined('ABSPATH') || exit;
?>
<div class="top-bar-user-links">
	<div class="link-wrap">
		<?php if (!is_user_logged_in()) { ?>
			<a href="javascript:void(0);" title="<?php esc_attr_e('Log in', 'edumall-child'); ?>" class="open-popup-login top-bar-login-link"><?php esc_html_e('Log in', 'edumall-child'); ?></a>
			<a href="javascript:void(0);" title="<?php esc_attr_e('Register', 'edumall-child'); ?>" class="open-popup-register top-bar-register-link"><?php esc_html_e('Register', 'edumall-child'); ?></a>
		<?php } else { ?>
			<?php
			$profile_url  = apply_filters('edumall_user_profile_url', '');
			$profile_text = apply_filters('edumall_user_profile_text', esc_html__('Profile', 'edumall-child'));
			?>
			<?php if ('' !== $profile_url && '' !== $profile_text) : ?>
				<a href="<?php echo esc_url($profile_url); ?>"><?php echo esc_html($profile_text); ?></a>
			<?php endif; ?>
			<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log out', 'edumall-child'); ?></a>
		<?php } ?>
	</div>
</div>