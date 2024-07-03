<?php
/**
 * @package Edumall
 * @since   1.0.0
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( bp_has_notifications( bp_ajax_querystring( 'notifications' ) . '&user_id=' . get_current_user_id() . '&is_new=0' ) ) : ?>
	<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
		<li class="read-item <?php echo isset( buddypress()->notifications->query_loop->notification->is_new ) && buddypress()->notifications->query_loop->notification->is_new ? 'unread' : ''; ?>">
			<span class="edumall-bp-full-link">
				<?php bp_the_notification_description(); ?>
			</span>
			<div class="notification-avatar">
				<?php edumall_bp_notification_avatar(); ?>
			</div>
			<div class="notification-content">
				<span class="edumall-bp-full-link">
					<?php bp_the_notification_description(); ?>
				</span>
				<span><?php bp_the_notification_description(); ?></span>
				<span class="posted"><?php bp_the_notification_time_since(); ?></span>
			</div>
			<div class="notification-status"></div>
		</li>
	<?php endwhile; ?>
<?php endif; ?>
