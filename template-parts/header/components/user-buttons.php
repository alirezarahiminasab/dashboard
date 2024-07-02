<?php

/**
 * User buttons on header
 *
 * @package Edumall
 * @since   1.3.1
 * @version 2.4.0
 */

defined('ABSPATH') || exit;

$header_skin      = Edumall_Global::instance()->get_header_skin();
$button_2_classes = 'button-thin';

if ('light' === $header_skin) {
	$button_2_classes .= ' button-secondary-white';
} else {
	$button_2_classes .= ' button-light-primary';
}
?>
<div class="header-user-buttons">
	<div class="inner">
		<?php
		if (!is_user_logged_in()) {
			Edumall_Templates::render_button([
				'link'        => [
					'url' => 'javascript:void(0)',
				],
				'text'        => esc_html__('Log In', 'edumall-child'),
				'extra_class' => 'open-popup-login',
				'size'        => 'sm',
				'style'       => 'bottom-line-alt button-thin',
			]);

			Edumall_Templates::render_button([
				'link'        => [
					'url' => 'javascript:void(0)',
				],
				'text'        => esc_html__('Sign Up', 'edumall-child'),
				'extra_class' => 'open-popup-register ' . $button_2_classes,
				'size'        => 'sm',
			]);
		} else {
			$profile_url  = apply_filters('edumall_user_profile_url', '');
			$profile_text = apply_filters('edumall_user_profile_text', esc_html__('Profile', 'edumall-child'));

			if ('' !== $profile_url && '' !== $profile_text) {
				Edumall_Templates::render_button([
					'link'  => [
						'url' => $profile_url,
					],
					'text'  => $profile_text,
					'size'  => 'sm',
					'style' => 'bottom-line-alt',
				]);
			}

			Edumall_Templates::render_button([
				'link'        => [
					'url' => esc_url(wp_logout_url(home_url())),
				],
				'text'        => esc_html__('Log out', 'edumall-child'),
				'extra_class' => $button_2_classes,
				'size'        => 'sm',
			]);
		}
		?>
	</div>
</div>