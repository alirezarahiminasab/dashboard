<?php
/**
 * Template part for displaying event location & contact info on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/location-details.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @since         1.0.0
 * @version       2.7.3
 */

defined( 'ABSPATH' ) || exit;

$place        = get_post_meta( get_the_ID(), 'tp_event_place', true );
$location     = get_post_meta( get_the_ID(), 'tp_event_location', true );
$phone_number = get_post_meta( get_the_ID(), 'tp_event_phone_number', true );
$website      = get_post_meta( get_the_ID(), 'tp_event_website', true );
?>
<div class="event-location-details">
	<?php if ( ! empty( $place ) ) : ?>
		<p class="entry-event-place heading"><?php echo esc_html( $place ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $location ) ) : ?>
		<div class="entry-event-location-address">
			<?php echo esc_html( $location ); ?>
			<p class="event-google-map-link">
				<a href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . $location ); ?>"
				   class="link-transition-01">
					<?php esc_html_e( '+ Google Map', 'edumall' ); ?><?php /*@todo fix link */ ?>
				</a>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $phone_number ) ) : ?>
		<div class="entry-event-contact-info entry-event-phone-number">
			<span class="meta-label"><?php esc_html_e( 'Phone Number', 'edumall' ); ?></span>
			<span class="meta-value"><?php echo esc_html( $phone_number ); ?></span>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $website ) ) : ?>
		<div class="entry-event-contact-info entry-event-website">
			<span class="meta-label"><?php esc_html_e( 'Website', 'edumall' ); ?></span>
			<span class="meta-value"><?php echo esc_html( $website ); ?></span>
		</div>
	<?php endif; ?>
</div>
