<?php
/**
 * The Template for displaying event start date
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/start-date.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0
 */

defined( 'ABSPATH' ) || exit;

$date_start = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
$time_from  = $date_start ? strtotime( $date_start ) : time();
?>
<div class="event-start-date">
	<?php echo wp_date( get_option( 'date_format' ), $time_from ); ?>
</div>
