<?php

use Detection\MobileDetect;

$detect = new MobileDetect();
$duration        = get_post_meta(get_the_ID(), '_course_duration', true);
?>
<div class="single-course-includes single-course-item">
    <?php if (!$detect->isMobile()) : ?>
        <div class="single-course-desktop">
        <?php endif; ?>
        <h4 class="single-course-includes-title">
            <?php echo esc_html(apply_filters('tutor_course_include_title', __('This course includes:', 'edumall-child'))); ?>
        </h4>

        <div class="single-course-includes-content">
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
        <?php if (!$detect->isMobile()) : ?>
        </div>
    <?php endif; ?>
</div>