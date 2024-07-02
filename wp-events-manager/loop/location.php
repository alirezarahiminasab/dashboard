<?php
/**
 * The Template for displaying location in loop.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/location.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

defined( 'ABSPATH' ) || exit;

$location = get_post_meta( get_the_ID(), Edumall_Event::POST_META_SHORT_LOCATION, true );
?>
<?php if ( $location ): ?>
	<div class="event-location">
		<span class="far fa-map-marker-alt"></span>
		<?php echo esc_html( $location ); ?>
	</div>
<?php endif;
