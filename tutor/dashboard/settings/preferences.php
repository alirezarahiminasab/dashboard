<?php
/**
 * @package       Edumall/TutorLMS/Templates
 *
 * @theme-since   2.4.0
 * @theme-version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

if ( '1' !== Edumall::setting( 'allows_user_custom_site_skin' ) ) {
	return;
}

$user_id   = get_current_user_id();
$site_skin = get_user_meta( $user_id, 'site_skin', true );

$site_skin_options = [
	''      => __( 'Default', 'edumall' ),
	'light' => __( 'Light', 'edumall' ),
	'dark'  => __( 'Dark', 'edumall' ),
];
?>
<h3><?php esc_html_e( 'Preferences', 'edumall' ); ?></h3>

<div class="tutor-dashboard-content-inner">
	<?php tutor_load_template( 'dashboard.settings.nav-bar', [ 'active_setting_nav' => 'preferences' ] ); ?>

	<div class="tutor-preferences-form-wrap">
		<form action="" method="post" enctype="multipart/form-data"
		      class="dashboard-settings-form dashboard-settings-preferences-form">
			<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
			<input type="hidden" value="edumall_user_preferences" name="edumall_action"/>

			<?php do_action( 'edumall_user_preferences_input_before' ) ?>

			<div class="row">
				<div class="col-md-12 col-lg-6">
					<div class="dashboard-content-box">
						<h4 class="dashboard-content-box-title"><?php esc_html_e( 'User Preferences', 'edumall' ); ?></h4>

						<div class="tutor-form-group">
							<label for="field-site-skin"><?php esc_html_e( 'Site Skin', 'edumall' ); ?></label>
							<select name="site_skin" id="field-site-skin">
								<?php foreach ( $site_skin_options as $option_val => $option_label ) : ?>
									<option
										value="<?php echo esc_attr( $option_val ); ?>" <?php selected( $site_skin, $option_val ); ?>>
										<?php echo esc_html( $option_label ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="tutor-form-group form-submit-wrap">
				<button type="submit" class="tutor-button"
				        name="edumall_user_preferences_btn"><?php esc_html_e( 'Update', 'edumall' ); ?></button>
			</div>

			<?php do_action( 'edumall_user_preferences_input_after' ) ?>

		</form>
	</div>
</div>




