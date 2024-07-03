<?php
/**
 * BuddyPress - Members Settings (Export Data)
 *
 * @since   3.1.0
 * @version 12.0.0
 */

defined( 'ABSPATH' ) || exit;

bp_nouveau_member_hook( 'before', 'settings_template' ); ?>

	<h2 class="screen-heading data-settings-screen">
		<?php esc_html_e( 'Data Export', 'edumall' ); ?>
	</h2>

<?php $request = bp_settings_get_personal_data_request(); ?>

<?php if ( $request ) : ?>

	<?php if ( 'request-completed' === $request->status ) : ?>

		<?php if ( bp_settings_personal_data_export_exists( $request ) ) : ?>

			<p><?php esc_html_e( 'Your request for an export of personal data has been completed.', 'edumall' ); ?></p>
			<p><?php printf( esc_html__( 'You may download your personal data by clicking on the link below. For privacy and security, we will automatically delete the file on %s, so please download it before then.', 'edumall' ), bp_settings_get_personal_data_expiration_date( $request ) ); ?></p>

			<p>
				<strong><?php printf( '<a href="%1$s">%2$s</a>', bp_settings_get_personal_data_export_url( $request ), esc_html__( 'Download personal data', 'edumall' ) ); ?></strong>
			</p>

		<?php else : ?>

			<p><?php esc_html_e( 'Your previous request for an export of personal data has expired.', 'edumall' ); ?></p>
			<p><?php esc_html_e( 'Please click on the button below to make a new request.', 'edumall' ); ?></p>

			<form id="bp-data-export" method="post">
				<input type="hidden" name="bp-data-export-delete-request-nonce"
				       value="<?php echo wp_create_nonce( 'bp-data-export-delete-request' ); ?>"/>
				<button type="submit" name="bp-data-export-nonce"
				        value="<?php echo wp_create_nonce( 'bp-data-export' ); ?>"><?php esc_html_e( 'Request new data export', 'edumall' ); ?></button>
			</form>

		<?php endif; ?>

	<?php elseif ( 'request-confirmed' === $request->status ) : ?>

		<p><?php printf( esc_html__( 'You previously requested an export of your personal data on %s.', 'edumall' ), bp_settings_get_personal_data_confirmation_date( $request ) ); ?></p>
		<p><?php esc_html_e( 'You will receive a link to download your export via email once we are able to fulfill your request.', 'edumall' ); ?></p>

	<?php endif; ?>

<?php else : ?>

	<p><?php esc_html_e( 'You can request an export of your personal data, containing the following items if applicable:', 'edumall' ); ?></p>

	<div class="user-data-exporter-items"><?php bp_settings_data_exporter_items(); ?></div>

	<p><?php esc_html_e( 'If you want to make a request, please click on the button below:', 'edumall' ); ?></p>

	<form id="bp-data-export" method="post">
		<button type="submit" name="bp-data-export-nonce"
		        value="<?php echo wp_create_nonce( 'bp-data-export' ); ?>"><?php esc_html_e( 'Request personal data export', 'edumall' ); ?></button>
	</form>

<?php endif; ?>

<?php if ( ! user_can( bp_displayed_user_id(), 'delete_users' ) ) : ?>
	<h2 class="screen-heading data-settings-screen">
		<?php esc_html_e( 'Data Erase', 'edumall' ); ?>
	</h2>
	<p>
		<?php
		esc_html_e( 'To erase all data associated with your account, your user account must be completely deleted.', 'edumall' );

		if ( bp_disable_account_deletion() ) :
			esc_html_e( 'Please contact the site administrator to request account deletion.', 'edumall' );
		else :
			printf(
			/* translators: %s the link to Delete Account Settings page */
				esc_html__( 'You may delete your account by visiting the %s page.', 'edumall' ),
				sprintf(
					'<a href="%s">%s</a>',
					esc_url( bp_displayed_user_url( bp_members_get_path_chunks( array(
						bp_nouveau_get_component_slug( 'settings' ),
						'delete-account',
					) ) ) ),
					esc_html__( 'Delete Account', 'edumall' )
				)
			);
		endif; ?>
	</p>
<?php endif; ?>

<?php
bp_nouveau_member_hook( 'after', 'settings_template' );
