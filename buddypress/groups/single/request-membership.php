<?php
/**
 * BuddyPress - Groups Request Membership
 *
 * @since         3.0.0
 * @version       3.1.0
 *
 * @theme-since   2.7.4
 * @theme-version 2.7.4
 */

bp_nouveau_group_hook( 'before', 'request_membership_content' ); ?>

<?php if ( ! bp_group_has_requested_membership() ) : ?>
	<div id="message" class="info">
		<p>
			<?php
			echo esc_html(
				sprintf(
				/* translators: %s: group name */
					__( 'You are requesting to become a member of the group "%s".', 'edumall' ),
					bp_get_group_name()
				)
			);
			?>
		</p>
	</div>

	<div class="edumall-bp-box">
		<form action="<?php bp_group_form_action( 'request-membership' ); ?>" method="post"
		      name="request-membership-form"
		      id="request-membership-form" class="standard-form">

			<div class="form-group">
				<label
					for="group-request-membership-comments"><?php esc_html_e( 'Comments (optional)', 'edumall' ); ?></label>
				<textarea name="group-request-membership-comments" id="group-request-membership-comments"></textarea>
			</div>

			<?php bp_nouveau_group_hook( '', 'request_membership_content' ); ?>

			<p class="form-submit"><input type="submit" name="group-request-send" id="group-request-send"
			          value="<?php echo esc_attr_x( 'Send Request', 'button', 'edumall' ); ?>"/>

				<?php wp_nonce_field( 'groups_request_membership' ); ?>
		</form><!-- #request-membership-form -->
	</div>
<?php endif; ?>

<?php
bp_nouveau_group_hook( 'after', 'request_membership_content' );
