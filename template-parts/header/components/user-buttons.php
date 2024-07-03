<?php
/**
 * User buttons on header
 *
 * @package Edumall
 * @since   1.3.1
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;

$header_skin      = Edumall_Global::instance()->get_header_skin();
$button_2_classes = 'button-thin';

if ( 'light' === $header_skin ) {
	$button_2_classes .= ' button-secondary-white';
} else {
	$button_2_classes .= ' button-light-primary';
}
?>
<div class="header-user-buttons">
	<div class="inner">
		<?php
		if ( ! is_user_logged_in() ) {
			Edumall_Templates::render_button( [
				'link'  => [
					'url' => edumall_login_url(),
				],
				'text'  => esc_html__( 'Log In', 'edumall' ),
				'size'  => 'sm',
				'style' => 'bottom-line-alt button-thin',
			] );

			if ( get_option( 'users_can_register', false ) ) :
				Edumall_Templates::render_button( [
					'link'        => [
						'url' => edumall_registration_url(),
					],
					'text'        => esc_html__( 'Sign Up', 'edumall' ),
					'extra_class' => $button_2_classes,
					'size'        => 'sm',
				] );
			endif;
		} else {
			$profile_url  = edumall_user_profile_url();
			$profile_text = apply_filters( 'edumall_user_profile_text', esc_html__( 'Profile', 'edumall' ) );

			if ( '' !== $profile_url && '' !== $profile_text ) {
				Edumall_Templates::render_button( [
					'link'  => [
						'url' => $profile_url,
					],
					'text'  => $profile_text,
					'size'  => 'sm',
					'style' => 'bottom-line-alt',
				] );
			}

			Edumall_Templates::render_button( [
				'link'        => [
					'url' => esc_url( wp_logout_url( home_url() ) ),
				],
				'text'        => esc_html__( 'Log out', 'edumall' ),
				'extra_class' => $button_2_classes,
				'size'        => 'sm',
			] );
		}
		?>
	</div>
</div>
