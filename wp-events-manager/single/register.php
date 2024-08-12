<?php

/**
 * The Template for displaying register button in single event page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/register.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit();

if (wpems_get_option('allow_register_event') == 'no') {
    return;
}

$event           = new WPEMS_Event(get_the_ID());
$user_reg        = $event->booked_quantity(get_current_user_id());
$date_start      = $event->__get('date_start') ? date('Ymd', strtotime($event->__get('date_start'))) : '';
$time_start      = $event->__get('time_start') ? date('Hi', strtotime($event->__get('time_start'))) : '';
$date_end        = $event->__get('date_end') ? date('Ymd', strtotime($event->__get('date_end'))) : '';
$time_end        = $event->__get('time_end') ? date('Hi', strtotime($event->__get('time_end'))) : '';
$g_calendar_link = 'http://www.google.com/calendar/event?action=TEMPLATE&text=' . urlencode($event->get_title());
$g_calendar_link .= '&dates=' . $date_start . ($time_start ? 'T' . $time_start : '') . '/' . $date_end . ($time_end ? 'T' . $time_end : '');
$g_calendar_link .= '&details=' . urlencode($event->post->post_content);
$g_calendar_link .= '&location=' . urlencode($event->__get('location'));
$g_calendar_link .= '&trp=false&sprop=' . urlencode(get_permalink($event->ID));
$g_calendar_link .= '&sprop=name:' . urlencode(get_option('blogname'));
$time_zone       = get_option('timezone_string') ? get_option('timezone_string') : 'UTC';
$g_calendar_link .= '&ctz=' . urlencode($time_zone);

if (absint($event->qty) == 0 || get_post_meta(get_the_ID(), 'tp_event_status', true) === 'expired') {
    return;
}
?>

<div class="entry-register">

    <h4 class="title">
        <?php echo esc_html__('Events Tickets', 'edumall-child') ?>
    </h4>

    <!-- TODO -->
    <!-- Implement individual ticket -->
    <div class="individual-ticket">
        <div class="individual-ticket-title">
            <p>عنوان</p>
        </div>
        <div class="individual-ticket-duration">
            <p class="description">
                <?php _e('active from:', 'edumall-child') ?>
            </p>
            <p class="info">

            </p>
        </div>
        <div class="individual-ticket-video">
            <p class="description">
                <?php _e('Downloadable video:', 'edumall-child') ?>
            </p>
            <p class="info">

            </p>
        </div>
        <div class="individual-ticket-price">
            <a href="#">
                <?php _e('Choose ticket', 'edumall-child')  ?>
            </a>
            <p>
                <?php printf('%s', $event->is_free() ? __('Free', 'edumall-child') : wpems_format_price($event->get_price())) ?>
            </p>
        </div>
    </div>

    <!-- TODO -->
    <!-- Implement group ticket -->
    <div class="group-ticket">
        <div class="group-ticket-title">
            <p>عنوان</p>
        </div>
        <div class="group-ticket-duration">
            <p class="description">
                <?php _e('active from:', 'edumall-child') ?>
            </p>
            <p class="info">

            </p>
        </div>
        <div class="group-ticket-video">
            <p class="description">
                <?php _e('Downloadable video:', 'edumall-child') ?>
            </p>
            <p class="info">

            </p>
        </div>
        <div class="group-ticket-price">
            <div class="price-button-wrapper">
                <div class="ticket-counter">
                    <span class="add">
                        <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/add.png" ?>>
                    </span>
                    <input type="text" value="3" placeholder="<?php _e('Choose number of ticket', 'edumall-child')  ?>">
                    <span class="minus">
                        <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/minus.png" ?>>
                    </span>
                </div>
                <p>
                    <?php _e('Each person share', 'edumall-child')  ?>
                </p>
                <a href="#">
                    <?php _e('Choose ticket', 'edumall-child')  ?>
                </a>
            </div>
            <div class="price-wrapper">
                <p class="price">
                    <?php printf('%s', $event->is_free() ? __('Free', 'edumall-child') : wpems_format_price($event->get_price())) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- TODO -->
    <!-- Implement coupon code -->
    <div class="coupon-code">
        <input type="text" placeholder="<?php _e('Enter your coupon code', 'edumall-child')  ?>">
        <a href="#">
            <?php _e('Apply', 'edumall-child')  ?>
        </a>
    </div>
</div>