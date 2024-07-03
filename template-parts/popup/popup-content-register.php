<?php
/**
 * Template part for display register form on popup.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0.0
 * @version 2.8.4
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="popup-content-header">
	<h3 class="popup-title"><?php esc_html_e( 'Sign Up', 'edumall' ); ?></h3>
	<p class="popup-description">
		<?php printf( esc_html__( 'Already have an account? %sLog in%s', 'edumall' ), '<a href="#" class="open-popup-login link-transition-02">', '</a>' ); ?>
	</p>
</div>

<div class="popup-content-body">
	<form id="edumall-register-form" class="edumall-register-form" method="post">

		<?php do_action( 'edumall_popup_register_before_form_fields' ); ?>

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_firstname"
					       class="form-label"><?php esc_html_e( 'First Name', 'edumall' ); ?></label>
					<input type="text" id="ip_reg_firstname" class="form-control form-input"
					       name="firstname" placeholder="<?php esc_attr_e( 'First Name', 'edumall' ); ?>">
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_lastname"
					       class="form-label"><?php esc_html_e( 'Last Name', 'edumall' ); ?></label>
					<input type="text" id="ip_reg_lastname" class="form-control form-input"
					       name="lastname" placeholder="<?php esc_attr_e( 'Last Name', 'edumall' ); ?>">
				</div>
			</div>
		</div>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action( 'edumall_popup_register_after_form_field_name' );
		?>

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_username"
					       class="form-label"><?php esc_html_e( 'Username', 'edumall' ); ?></label>
					<input type="text" id="ip_reg_username" class="form-control form-input"
					       name="username" placeholder="<?php esc_attr_e( 'Username', 'edumall' ); ?>"/>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_email"
					       class="form-label"><?php esc_html_e( 'Email', 'edumall' ); ?></label>
					<input type="email" id="ip_reg_email" class="form-control form-input"
					       name="email" placeholder="<?php esc_attr_e( 'Your Email', 'edumall' ); ?>"/>
				</div>
			</div>
		</div>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action( 'edumall_popup_register_after_form_field_login' );
		?>

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_password"
					       class="form-label"><?php esc_html_e( 'Password', 'edumall' ); ?></label>
					<div class="form-input-group form-input-password">
						<input type="password" id="ip_reg_password" class="form-control form-input"
						       name="password" placeholder="<?php esc_attr_e( 'Password', 'edumall' ); ?>">
						<button type="button" class="btn-pw-toggle" data-toggle="0"
						        aria-label="<?php esc_attr_e( 'Show password', 'edumall' ); ?>">
						</button>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="ip_reg_password2"
					       class="form-label"><?php esc_html_e( 'Re-Enter Password', 'edumall' ); ?></label>
					<div class="form-input-group form-input-password">
						<input type="password" id="ip_reg_password2" class="form-control form-input"
						       name="password2"
						       placeholder="<?php esc_attr_e( 'Re-Enter Password', 'edumall' ); ?>">
						<button type="button" class="btn-pw-toggle" data-toggle="0"
						        aria-label="<?php esc_attr_e( 'Show password', 'edumall' ); ?>">
						</button>
					</div>
				</div>
			</div>
		</div>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action( 'edumall_popup_register_after_form_field_password' );
		?>

		<?php
		/**
		 * @since 2.8.1
		 */
		$privacy_page_id   = get_option( 'wp_page_for_privacy_policy', 0 );
		$privacy_link_html = esc_html__( 'Privacy Policy', 'edumall' );
		if ( $privacy_page_id ) {
			$privacy_link_html = sprintf( '<a href="%1$s" class="edumall-privacy-policy-link" target="_blank">%2$s</a>',
				esc_url( get_permalink( $privacy_page_id ) ),
				$privacy_link_html
			);
		}

		$terms_conditions_page_id   = Edumall::setting( 'page_for_terms_and_conditions', 0 );
		$terms_conditions_link_html = esc_html__( 'Terms', 'edumall' );
		if ( $terms_conditions_page_id ) {
			$terms_conditions_link_html = sprintf( '<a href="%1$s" class="edumall-terms-conditions-link" target="_blank">%2$s</a>',
				esc_url( get_permalink( $terms_conditions_page_id ) ),
				$terms_conditions_link_html
			);
		}
		?>
		<div class="form-group accept-account">
			<label class="form-label form-label-checkbox" for="ip_accept_account">
				<input type="checkbox" id="ip_accept_account" class="form-control"
				       name="accept_account" required value="1">
				<?php printf( esc_html__( 'Accept the %1$s and %2$s', 'edumall' ), $terms_conditions_link_html, $privacy_link_html ); ?>
			</label>
		</div>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action( 'edumall_popup_register_after_form_field_accept' );
		?>

		<?php do_action( 'edumall_popup_register_after_form_fields' ); ?>

		<div class="form-response-messages"></div>

		<div class="form-group">
			<?php wp_nonce_field( 'user_register', 'user_register_nonce' ); ?>
			<input type="hidden" name="action" value="edumall_user_register">
			<button type="submit" class="button form-submit"><?php esc_html_e( 'Register', 'edumall' ); ?></button>
		</div>
	</form>
</div>
