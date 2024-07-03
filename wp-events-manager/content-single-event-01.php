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

	<div class="entry-header">
		<div class="entry-header-left">
			<?php wpems_get_template( 'single/title.php' ); ?>

			<?php wpems_get_template( 'single/meta.php' ); ?>
		</div>
		<div class="entry-header-right">
			<?php
			/**
			 * tp_event_loop_event_countdown hook
			 */
			do_action( 'tp_event_loop_event_countdown' );
			?>
		</div>
	</div>

	<div class="entry-thumbnail">
		<?php Edumall_Image::the_post_thumbnail( [
			'size' => '1170x350',
		] ); ?>
	</div>

	<div class="summary entry-summary">
		<div class="entry-details">
			<div class="row">
				<div class="col-md-8">
					<h3 class="entry-event-heading entry-event-heading-about"><?php esc_html_e( 'About The Event', 'edumall' ); ?></h3>
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
	</div>

	<?php if ( '1' === Edumall::setting( 'single_event_comment_enable' ) && ( comments_open() || get_comments_number() ) ) : ?>
		<div class="comments-section border-section">
			<div class="row">
				<div class="col-md-8"><?php comments_template(); ?></div>
				<div class="col-md-4 comment-help-col">
					<?php wpems_get_template( 'single/comment-help.php' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</article>
