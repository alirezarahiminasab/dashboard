<?php
/**
 * Notification on header
 *
 * @package Edumall
 * @since   1.3.1
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

$menu_link                 = bp_loggedin_user_url( bp_members_get_path_chunks( array( bp_get_notifications_slug() ) ) );
$notifications             = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() );
$unread_notification_count = ! empty( $notifications ) ? $notifications : 0;
?>
	<div id="header-notifications" class="header-notifications notification-wrap menu-item-has-children">
		<a href="javascript:void(0);" class="header-notifications-open">
			<div class="header-icon">
				<i class="fa-regular fa-bell"></i>
				<span class="badge"><?php echo esc_html( $unread_notification_count ); ?></span>
			</div>
		</a>
		<div id="header-notification-list" class="header-notification-list">
			<?php do_action( 'edumall_header_notification_content_before' ); ?>

			<h4 class="notification-list-heading"><?php esc_html_e( 'Notifications', 'edumall' ); ?></h4>

			<ul class="notification-list bb-nouveau-list"></ul>

			<footer class="notification-footer">
				<a href="<?php echo esc_url( $menu_link ); ?>" class="delete-all">
					<?php esc_html_e( 'More', 'edumall' ); ?>
					<i class="fa-regular fa-angle-right"></i>
				</a>
			</footer>

			<?php do_action( 'edumall_header_notification_content_after' ); ?>
		</div>
	</div>

<?php
