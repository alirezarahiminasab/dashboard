<?php
/**
 * The Template for displaying register button in single event page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/register.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

defined( 'ABSPATH' ) || exit;

if ( wpems_get_option( 'allow_register_event' ) == 'no' ) {
	return;
}

$event           = new WPEMS_Event( get_the_ID() );
$user_reg        = $event->booked_quantity( get_current_user_id() );
$date_start      = $event->__get( 'date_start' ) ? date( 'Ymd', strtotime( $event->__get( 'date_start' ) ) ) : '';
$time_start      = $event->__get( 'time_start' ) ? date( 'Hi', strtotime( $event->__get( 'time_start' ) ) ) : '';
$date_end        = $event->__get( 'date_end' ) ? date( 'Ymd', strtotime( $event->__get( 'date_end' ) ) ) : '';
$time_end        = $event->__get( 'time_end' ) ? date( 'Hi', strtotime( $event->__get( 'time_end' ) ) ) : '';
$g_calendar_link = 'https://www.google.com/calendar/event?action=TEMPLATE&text=' . urlencode( $event->get_title() );
$g_calendar_link .= '&dates=' . $date_start . ( $time_start ? 'T' . $time_start : '' ) . '/' . $date_end . ( $time_end ? 'T' . $time_end : '' );
$g_calendar_link .= '&details=' . urlencode( $event->post->post_content );
$g_calendar_link .= '&location=' . urlencode( $event->__get( 'location' ) );
$g_calendar_link .= '&trp=false&sprop=' . urlencode( get_permalink( $event->ID ) );
$g_calendar_link .= '&sprop=name:' . urlencode( get_option( 'blogname' ) );
$time_zone       = get_option( 'timezone_string' ) ? get_option( 'timezone_string' ) : 'UTC';
$g_calendar_link .= '&ctz=' . urlencode( $time_zone );

$can_register = true;
if ( absint( $event->qty ) == 0 || get_post_meta( get_the_ID(), 'tp_event_status', true ) === 'expired' ) {
	$can_register = false;
}
?>

<div class="entry-register">

	<ul class="entry-event-info">
		<li class="meta-price">
			<span class="meta-label">
				<i class="meta-icon fa-regular fa-money-bill-wave"></i>
				<?php esc_html_e( 'Cost:', 'edumall' ); ?>
			</span>
			<span
				class="meta-value">
				<span
					class="event-price"><?php printf( '%s', $event->is_free() ? esc_html__( 'Free', 'edumall' ) : wpems_format_price( $event->get_price() ) ) ?></span>
			</span>
		</li>
		<li class="total">
			<span class="meta-label">
				<i class="meta-icon fa-regular fa-user-friends"></i>
				<?php esc_html_e( 'Total Slot:', 'edumall' ); ?>
			</span>
			<span class="meta-value"><?php echo esc_html( absint( $event->qty ) ); ?></span>
		</li>
		<li class="booking_slot">
			<span class="meta-label">
				<i class="meta-icon fa-regular fa-lock-alt"></i>
				<?php esc_html_e( 'Booked Slot:', 'edumall' ); ?>
			</span>
			<span class="meta-value"><?php echo esc_html( absint( $event->booked_quantity() ) ); ?></span>
		</li>
	</ul>

	<?php if ( $can_register ) : ?>
		<?php if ( is_user_logged_in() ) { ?>
			<?php
			$registered_time = $event->booked_quantity( get_current_user_id() );
			if ( $registered_time && 'once' === wpems_get_option( 'email_register_times' ) && $event->is_free() ) { ?>
				<p class="event-register-message"><?php esc_html_e( 'You have registered this event before.', 'edumall' ); ?></p>
			<?php } else { ?>
				<a class="event_register_submit event_auth_button event-load-booking-form button"
				   data-event="<?php echo esc_attr( get_the_ID() ) ?>"><?php esc_html_e( 'Book Now', 'edumall' ); ?></a>
			<?php } ?>
		<?php } else { ?>
			<?php
			Edumall_Templates::render_button( [
				'link'        => [
					'url' => 'javascript:void(0)',
				],
				'text'        => esc_html__( 'Book Now', 'edumall' ),
				'extra_class' => 'open-popup-login',
				'full_wide'   => true,
			] )
			?>
			<p class="event-register-message">
				<?php echo sprintf(
					esc_html__( 'You must %1$slogin%2$s before register event.', 'edumall' ),
					'<a href="javascript:void(0);" class="open-popup-login link-transition-01">',
					'</a>'
				); ?>
			</p>
		<?php } ?>
	<?php else: ?>
		<p class="tp-event-notice error"><?php echo esc_html__( 'This event has expired', 'edumall' ); ?></p>
	<?php endif; ?>

</div>
