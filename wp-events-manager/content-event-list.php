<?php
/**
 * The Template for displaying content events style list.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-event-list.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * tp_event_before_loop_event hook
 */
do_action( 'tp_event_before_loop_event' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

$extra_classes = 'grid-item';
?>

<div id="event-<?php the_ID(); ?>" <?php post_class( $extra_classes ); ?>>

	<?php
	/**
	 * tp_event_before_loop_event_summary hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_before_loop_event_item' );
	?>

	<div class="edumall-box">
		<a href="<?php the_permalink(); ?>" class="event-image edumall-image">
			<?php
			/**
			 * tp_event_single_event_thumbnail hook
			 */
			do_action( 'tp_event_single_event_thumbnail' );
			?>
		</a>
		<div class="event-caption">
			<div class="event-caption-left">
				<?php wpems_get_template( 'loop/title.php' ); ?>

				<?php wpems_get_template( 'loop/price.php' ); ?>

				<div class="event-excerpt">
					<?php Edumall_Templates::excerpt( [
						'limit' => 30,
						'type'  => 'word',
					] ); ?>
				</div>
			</div>
			<div class="event-caption-right">
				<?php wpems_get_template( 'loop/meta.php' ); ?>

				<?php wpems_get_template( 'loop/read-more-small.php' ); ?>
			</div>
		</div>
	</div>

	<?php
	/**
	 * tp_event_after_loop_event_item hook
	 *
	 * @hooked tp_event_show_event_sale_flash - 10
	 * @hooked tp_event_show_event_images - 20
	 */
	do_action( 'tp_event_after_loop_event_item' );
	?>
</div>

<?php do_action( 'tp_event_after_loop_event' ); ?>
