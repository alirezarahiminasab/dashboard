<?php
/**
 * BuddyPress - Members Settings ( Group Invites )
 *
 * @since   3.0.0
 * @version 12.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<h2 class="screen-heading group-invites-screen">
	<?php esc_html_e( 'Group Invites', 'edumall' ); ?>
</h2>
<?php
if ( 1 === bp_nouveau_groups_get_group_invites_setting() ) {
	bp_nouveau_user_feedback( 'member-group-invites-friends-only' );
} else {
	bp_nouveau_user_feedback( 'member-group-invites-all' );
}
?>
<form action="<?php bp_displayed_user_link( array( bp_nouveau_get_component_slug( 'settings' ), 'invites' ) ); ?>"
      name="account-group-invites-form" id="account-group-invites-form"
      class="standard-form user-group-invites-form"
      method="post"
>
	<label for="account-group-invites-preferences" class="form-label-checkbox">
		<input type="checkbox" name="account-group-invites-preferences" id="account-group-invites-preferences"
		       value="1" <?php checked( 1, bp_nouveau_groups_get_group_invites_setting() ); ?>/>
		<?php esc_html_e( 'I want to restrict Group invites to my friends only.', 'edumall' ); ?>
	</label>
	<?php edumall_bp_nouveau_submit_button( 'member-group-invites' ); ?>
</form>
