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

defined('ABSPATH') || exit;

$event_terms = get_the_terms(get_the_ID(), 'tp_event_category');
$categories = '';
foreach ($event_terms as $index => $term) {
	$categories .= $index == 0 ? $term->name :  "، " . $term->name;
}
$event           = new WPEMS_Event(get_the_ID());
$type      = get_post_meta(get_the_ID(), 'tp_event_type', true);
$date_format = "l d F Y";
$date_start  = get_post_meta(get_the_ID(), 'tp_event_date_start', true);
$date_start  = !empty($date_start) ? strtotime($date_start) : time();

$date_end = get_post_meta(get_the_ID(), 'tp_event_date_end', true);
$date_end = !empty($date_end) ? strtotime($date_end) : time();

$time_format = "H:i";
$time_start  = wpems_event_start($time_format);
$time_end    = wpems_event_end($time_format);

$location = get_post_meta(get_the_ID(), Edumall_Event::POST_META_SHORT_LOCATION, true);

$date_string = wp_date($date_format, $date_start);
?>
<div class="meta-item">
	<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/calendar.png" ?>>
	<p><?php echo __('Event start: ', 'edumall-child') . esc_html($date_string) . " " . __('time', 'edumall-child') . " " . esc_html($time_start); ?></p>
</div>

<div class="meta-item">
	<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/ticket.png" ?>>
	<p><?php printf('%s', $event->is_free() ? __('Free', 'edumall-child') : __('from', 'edumall-child') . " " . wpems_format_price($event->get_price())) ?></p>
</div>

<?php if ($type === "live") : ?>
	<div class="meta-item">
		<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/location.png" ?>>
		<p><?php echo esc_html__('Online', 'edumall-child'); ?></p>
	</div>
<?php else : ?>
	<div class="meta-item">
		<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/location.png" ?>>
		<p><?php echo esc_html($location); ?></p>
	</div>
<?php endif; ?>

<!-- TODO: -->
<!-- Implement duration -->
<div class="meta-item">
	<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/clock-transparent.png" ?>>
	<p><?php echo esc_html__('Event duration:', 'edumall-child') . " "; ?></p>
</div>

<div class="meta-item">
	<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/category-transparent.png" ?>>
	<p><?php echo esc_html__('Categories:', 'edumall-child') . " " . $categories; ?></p>
</div>