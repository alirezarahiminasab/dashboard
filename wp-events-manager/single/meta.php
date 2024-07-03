<?php
/**
 * Template part for displaying event meta on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/meta.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

$date_format = get_option( 'date_format' );
$date_start  = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
$date_start  = ! empty( $date_start ) ? strtotime( $date_start ) : time();

$date_end = get_post_meta( get_the_ID(), 'tp_event_date_end', true );
$date_end = ! empty( $date_end ) ? strtotime( $date_end ) : time();

$time_format = get_option( 'time_format' );
$time_start  = wpems_event_start( $time_format );
$time_end    = wpems_event_end( $time_format );

$location = get_post_meta( get_the_ID(), Edumall_Event::POST_META_SHORT_LOCATION, true );

if ( $date_start === $date_end ) {
	$date_string = wp_date( $date_format, $date_start );
} else {
	$date_string = wp_date( $date_format, $date_start ) . ' - ' . wp_date( $date_format, $date_end );
}
?>
<div class="entry-meta">
	<?php if ( $location ) : ?>
		<div class="meta-item">
			<i class="meta-icon fa-light fa-map-marker-alt"></i>
			<span><?php echo esc_html( $location ); ?></span>
		</div>
	<?php endif; ?>

	<div class="meta-item">
		<i class="meta-icon fa-light fa-calendar"></i>
		<span><?php echo esc_html( $date_string ); ?></span>
	</div>

	<div class="meta-item">
		<i class="meta-icon fa-light fa-clock"></i>
		<span><?php echo esc_html( $time_start . ' - ' . $time_end ); ?></span>
	</div>
</div>
