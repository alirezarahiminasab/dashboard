<?php
/**
 * The Template for displaying content single event.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="tp_event-<?php the_ID(); ?>" <?php post_class( 'tp_single_event' ); ?>>
	<?php
	/**
	 * tp_event_before_single_event hook
	 */
	do_action( 'tp_event_before_single_event' );
	?>

	<div class="summary entry-summary">

		<div class="entry-header">
			<h3 class="entry-event-heading entry-event-heading-about"><?php esc_html_e( 'About The Event', 'edumall' ); ?></h3>

			<div class="entry-meta">
				<?php
				$date_start = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
				$date_start = ! empty( $date_start ) ? strtotime( $date_start ) : time();

				$date_end = get_post_meta( get_the_ID(), 'tp_event_date_end', true );
				$date_end = ! empty( $date_end ) ? strtotime( $date_end ) : time();

				$time_start = wpems_event_start( get_option( 'time_format' ) );
				$time_end   = wpems_event_end( get_option( 'time_format' ) );
				$location   = get_post_meta( get_the_ID(), Edumall_Event::POST_META_SHORT_LOCATION, true );

				$date_string = '';
				if ( $date_start === $date_end ) {
					$date_string = wp_date( get_option( 'date_format' ), $date_start );
				} else {
					$date_string = wp_date( get_option( 'date_format' ), $date_start ) . ' - ' . wp_date( get_option( 'date_format' ), $date_end );
				}
				?>
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
		</div>

		<div class="entry-details">
			<div class="row">
				<div class="col-md-8">
					<?php
					/**
					 * tp_event_single_event_content hook
					 */
					do_action( 'tp_event_single_event_content' );
					?>
				</div>
				<div class="col-md-4">
					<div class="entry-booking-form-bar">
						<?php
						/**
						 * tp_event_after_single_event hook
						 *
						 * @hooked tp_event_after_single_event - 10
						 */
						do_action( 'tp_event_after_single_event' );
						?>

						<?php wpems_get_template( 'single/share.php' ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="entry-event-location border-section">
			<h3 class="entry-event-heading entry-event-heading-location"><?php esc_html_e( 'Location', 'edumall' ); ?></h3>

			<div class="row">
				<div class="col-md-8">
					<?php wpems_get_template( 'single/location.php' ); ?>
				</div>
				<div class="col-md-4">
					<?php wpems_get_template( 'single/location-details.php' ); ?>
				</div>
			</div>
		</div>

		<?php wpems_get_template( 'single/speakers.php' ); ?>

		<?php if ( '1' === Edumall::setting( 'single_event_comment_enable' ) && ( comments_open() || get_comments_number() ) ) : ?>
			<div class="comments-section border-section">
				<?php comments_template(); ?>
			</div>
		<?php endif; ?>
	</div>
</article>
