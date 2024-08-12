<?php

/**
 * The Template for displaying register button in single event page.
 *
 * new 
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit();

$event_more_details = get_post_meta(get_the_ID(), 'tp_events_more_details', true);

?>

<h4 class="more-details-title">
    <?php echo esc_html__('Events description', 'edumall-child') ?>
</h4>

<p class="more-details-caption">
    <?php echo $event_more_details ?>
</p>