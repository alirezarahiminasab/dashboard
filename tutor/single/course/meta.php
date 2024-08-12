<?php

defined('ABSPATH') || exit;

global $edumall_course;

use Detection\MobileDetect;
use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;
$detect = new MobileDetect();
$author_id = get_post_field('post_author', get_the_ID());
$author = get_userdata($author_id);
$thumbnail_size = '327x210';
$bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
$course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
    'post_id' => get_the_ID(),
    'size'    => $thumbnail_size,
));
$rating = $edumall_course->get_rating();
$rating_count = $rating->rating_count;
$rating_avg = Edumall_Helper::number_format_nice_float($rating->rating_avg);
$course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';
$first_name = get_user_meta($author_id, 'first_name', true);
$last_name = get_user_meta($author_id, 'last_name', true);
$full_name = trim($first_name . ' ' . $last_name);
$profile_photo_id    = get_user_meta($author_id, '_instructor_profile_pic', true);
$instructor_story_text    = get_user_meta($author_id, '_instructor_story_text', true);
$profile_url = tutor_utils()->profile_url($author_id);


?>
<div class="single-course-meta single-course-item">
    <?php if (!$detect->isMobile()) : ?>
        <div class="single-course-desktop">
        <?php endif; ?>
        <?php if ($detect->isMobile()) : ?>
            <div class="single-course-meta-cover-image single-course-item">
                <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                <div class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                    <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                    <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                </div>
            </div>
        <?php endif ?>

        <?php do_action('tutor_course/single/title/before'); ?>

        <div class="single-course-meta-title">
            <p>
                <?php the_title() ?>
            </p>
        </div>

        <?php do_action('tutor_course/single/title/after'); ?>

        <div class="single-course-meta-content">
            <?php the_content() ?>
        </div>

        <div class="single-course-meta-instructor">
            <div class="single-course-meta-instructor-title">
                <p>
                    <?php echo esc_html__('مدرس دوره:', 'edumall-child') ?>
                </p>
            </div>
            <div class="single-course-meta-instructor-image">
                <?php if (!empty($profile_photo_id)) : ?>
                    <img src="<?php echo esc_html($profile_photo_id) ?>" alt="">
                <?php else : ?>
                    <img src="<?php echo esc_html($profile_placeholder) ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="single-course-meta-instructor-name">
                <a href="<?php echo $profile_url ?>">
                    <p>
                        <?php echo esc_html($full_name); ?>
                    </p>
                </a>
            </div>
        </div>

        <div class="single-course-meta-rating">
            <div class="single-course-meta-rating-value">
                <div class="single-course-meta-rating-value-star">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
                </div>
                <div class="single-course-meta-rating-value-number">
                    <p>
                        <?php echo $rating_avg; ?>
                    </p>
                </div>
                <div class="single-course-rating-value-count">
                    <p>
                        (<?php echo $rating_count . " " . esc_html__('votes', 'edumall-child') ?>)
                    </p>
                </div>
            </div>

            <div class="single-course-meta-rating-students">
                <p>
                    <?php echo sprintf(esc_html__('%s students', 'edumall-child'), $edumall_course->get_enrolled_users_count()); ?>
                </p>
            </div>
        </div>
        <?php if (!$detect->isMobile()) : ?>
        </div>
    <?php endif; ?>
</div>