<?php
/**
 * BuddyPress - Groups Admin
 *
 * @since         3.0.0
 * @version       3.0.0
 *
 * @theme-since   1.0.0
 * @theme-version 2.7.4
 */

defined( 'ABSPATH' ) || exit;

bp_get_template_part( 'groups/single/parts/admin-subnav' );

$group_manage_screen = bp_action_variable( 0 );

?>
<?php if ( 'membership-requests' !== $group_manage_screen ): ?>
<div class="edumall-bp-box edumall-bp-form-box">
	<?php endif; ?>
	<form action="<?php bp_group_admin_form_action(); ?>" name="group-settings-form" id="group-settings-form"
	      class="standard-form" method="post" enctype="multipart/form-data">

		<?php bp_nouveau_group_manage_screen(); ?>

	</form><!-- #group-settings-form -->
	<?php if ( 'membership-requests' !== $group_manage_screen ): ?>
</div>
<?php endif; ?>
