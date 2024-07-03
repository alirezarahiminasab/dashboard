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

<div class="header-user-links-icon">
	<div class="user-links">
		<?php
		if ( ! is_user_logged_in() ) {
			?>
			<a class="hint--bounce hint--bottom header-login-link"
			   href="<?php echo esc_url( edumall_login_url() ) ?>"
			   aria-label="<?php esc_attr_e( 'Log In', 'edumall' ); ?>">
				<div class="user-icon">
					<span class="fa-light fa-user"></span>
				</div>
			</a>
			<?php
		} else {
			$profile_url = edumall_user_profile_url();
			?>
			<a class="hint--bounce hint--bottom header-profile-link"
			   aria-label="<?php esc_attr_e( 'My Account', 'edumall' ); ?>"
			   href="<?php echo esc_url( $profile_url ); ?>">
				<div class="user-icon">
					<span class="fa-light fa-user"></span>
				</div>
			</a>
		<?php } ?>
	</div>
</div>
