<?php
/**
 * Template part for displaying event meta on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/content-hero-02.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

$time = wpems_get_time( 'Y-m-d H:i', null, false );
?>
<div class="entry-hero-section">
	<div class="entry-thumbnail-bg">
		<?php Edumall_Image::the_post_thumbnail( [
			'size' => '1920x450',
		] ); ?>
	</div>
	<div class="entry-hero-content">
		<div class="entry-date">
			<?php echo wp_date( 'F d', strtotime( $time ) ); ?>
		</div>

		<?php wpems_get_template( 'single/title.php' ); ?>

		<?php
		/**
		 * tp_event_loop_event_countdown hook
		 */
		do_action( 'tp_event_loop_event_countdown' );
		?>
	</div>
</div>
