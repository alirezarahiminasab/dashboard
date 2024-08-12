<?php

global $edumall_course;

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend();
$thumbnail_size = '327x210';
$bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
$course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
    'post_id' => get_the_ID(),
    'size'    => $thumbnail_size,
));
$course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';

$user_id = get_current_user_id();
$is_administrator      = current_user_can('administrator');
$is_instructor         = tutor_utils()->is_instructor_of_this_course();
$is_enrolled         = apply_filters('tutor_alter_enroll_status', tutor_utils()->is_enrolled());

global $wp_query;

$is_enrolled         = apply_filters('tutor_alter_enroll_status', tutor_utils()->is_enrolled());
$retake_course       = tutor_utils()->can_user_retake_course();
$completed_percent   = tutor_utils()->get_course_completed_percent();
$is_completed_course = tutor_utils()->is_completed_course();
$lesson_url          = tutor_utils()->get_course_first_lesson();
$start_content       = '';

if ($lesson_url) {

    // Button identifier class.
    $button_identifier = 'start-continue-retake-button';
    $button_tag        = $retake_course ? 'button' : 'a';

    if ($retake_course) {
        $button_text = __('Retake This Course', 'edumall-child');
    } elseif ($completed_percent <= 0) {
        $button_text = __('Start Learning', 'edumall-child');
    } else {
        $button_text = __('Continue Learning', 'edumall-child');
    }

    $attributes = '';
    $attributes .= 'a' === $button_tag ? ' href="' . esc_url($lesson_url) . '"' : '';
    $attributes .= $retake_course ? ' disabled="disabled"' : '';

    $start_content = sprintf(
        '<div class="single-course-action-continue single-course-action-btn course-action-btn"><%1$s %2$s data-course_id="%3$s">%4$s</%1$s></div>',
        $button_tag,
        $attributes,
        esc_attr(get_the_ID()),
        $button_text
    );
}
$isLoggedIn = is_user_logged_in();

$monetize_by              = tutils()->get_option('monetize_by');
$enable_guest_course_cart = tutor_utils()->get_option('enable_guest_course_cart');

$is_public      = get_post_meta(get_the_ID(), '_tutor_is_public_course', true) == 'yes';
$is_purchasable = tutor_utils()->is_course_purchasable();

$required_loggedin_class = '';
if (!$isLoggedIn && !$is_public) {
    $required_loggedin_class = apply_filters('tutor_enroll_required_login_class', 'open-popup-login');
}
if ($is_purchasable && $monetize_by === 'wc' && $enable_guest_course_cart) {
    $required_loggedin_class = '';
}

$tutor_form_class = apply_filters('tutor_enroll_form_classes', ['tutor-enroll-form']);

$tutor_course_sell_by = apply_filters('tutor_course_sell_by', null);


?>
<div class="single-course-action">
    <div class="single-course-action-cover-image">
        <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
        <div class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
            <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
            <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
        </div>
    </div>

    <div class="single-course-action-includes">
        <div class="content-box video-duration">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-square.png' ?>" alt="">
            <p>
                <?php
                echo !empty($duration) ? $duration["hours"] : '';
                ?>
                <?php echo esc_html__('hours video course', 'edumall-child')  ?>
            </p>
        </div>

        <div class="content-box text-duration">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/document-text.png' ?>" alt="">
            <p>
                <?php echo esc_html__('hours text course', 'edumall-child')  ?>
            </p>
        </div>

        <div class="content-box access">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/timer.png' ?>" alt="">
            <p>
                <?php echo esc_html__('Always access to course', 'edumall-child')  ?>
            </p>
        </div>
    </div>

    <?php if (boolval($is_enrolled) || $is_administrator || $is_instructor) :

        echo apply_filters('tutor_course/single/start/button', $start_content, get_the_ID());
    else : ?>
        <div class="single-course-action-cart <?php echo esc_attr($required_loggedin_class); ?> ">
            <?php
            if ($is_purchasable && $tutor_course_sell_by) {
                tutor_load_template('single.course.add-to-cart-' . $tutor_course_sell_by);
            } else {
            ?>
                <form class="<?php echo esc_attr(implode(' ', $tutor_form_class)); ?>" method="post">
                    <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
                    <input type="hidden" name="tutor_course_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">

                    <div class=" tutor-course-enroll-wrap">
                        <button type="submit" class="tutor-btn-enroll tutor-btn tutor-course-purchase-btn">
                            <?php $isLoggedIn ? esc_html_e('شروع یاد گیری', 'edumall-child') : esc_html_e('برای یادگیری وارد سایت شوید', 'edumall-child') ?>
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    <?php
    endif;

    ?>
</div>