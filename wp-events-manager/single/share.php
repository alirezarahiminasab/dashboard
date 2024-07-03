<?php
/**
 * Template part for displaying event share on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/share.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

$social_sharing = Edumall::setting( 'social_sharing_item_enable' );

if ( empty( $social_sharing ) ) {
	return;
}
?>
<div class="entry-event-share">
	<div class="share-list">
		<?php Edumall_Templates::get_sharing_list(); ?>
	</div>
</div>
