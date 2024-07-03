<?php
/**
 * User links box on header
 *
 * @package Edumall
 * @since   1.3.1
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="header-user-links-box">
	<div class="user-icon">
		<span class="fa-light fa-user"></span>
	</div>
	<div class="user-links">
		<?php
		if ( ! is_user_logged_in() ) {
			?>
			<a class="header-login-link" href="<?php echo esc_url( edumall_login_url() ); ?>"><?php esc_html_e( 'Log In', 'edumall' ); ?></a>
			<?php if ( get_option( 'users_can_register', false ) ) : ?>
				<a class="header-register-link" href="<?php echo esc_url( edumall_registration_url() ); ?>"><?php esc_html_e( 'Register', 'edumall' ); ?></a>
			<?php endif; ?>
			<?php
		} else {
			$profile_url  = edumall_user_profile_url();
			$profile_text = apply_filters( 'edumall_user_profile_text', esc_html__( 'Profile', 'edumall' ) );
			?>
			<a class="header-profile-link"
			   href="<?php echo esc_url( $profile_url ); ?>"><?php echo esc_html( $profile_text ); ?></a>
			<a class="header-logout-link"
			   href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e( 'Log out', 'edumall' ); ?></a>
		<?php } ?>
	</div>
</div>
