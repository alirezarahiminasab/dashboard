<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined('ABSPATH') || exit;

global $post;

use CourseExtend\CourseExtend;
use Detection\MobileDetect;

$detect = new MobileDetect();
$course_extend = new CourseExtend();

$profile_url  = apply_filters('edumall_user_profile_url', '');
$menu_type = !$detect->isMobile() ? '/?menu=tutor' : '';
?>
<?php if ($detect->isMobile()) : ?>
    <div class="edit-profile-title">
        <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3><?php esc_html_e('نشان‌شده‌ها', 'edumall-child'); ?></h3>
    </div>
<?php endif; ?>

<div class="bookmarks">
    <div class="bookmarks-wrap">
        <div class="bookmarks-links">
            <ul>
                <li>
                    <a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('bookmarks') . $menu_type; ?>">
                        <?php esc_html_e('دوره', 'edumall-child'); ?>
                    </a>
                </li>
                <li>
                    <a class="active" href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('bookmarks/instructors') . $menu_type; ?>">
                        <?php esc_html_e('مدرس', 'edumall-child'); ?>
                    </a>
                </li>
            </ul>

            <?php if (!$detect->isMobile()) : ?>
                <div class="bookmarks-links-search">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/search-normal.svg' ?>" alt="">
                    <input type="text" name="" id="" placeholder="<?php esc_html_e('جستجو مدرس', 'edumall-child'); ?>">
                </div>
            <?php endif ?>
        </div>

        <div class="bookmarks-instructors">
            <?php
            $bookmarks = $course_extend->get_bookmarks('instructor');

            if (is_array($bookmarks) && count($bookmarks)) : ?>
                <?php foreach ($bookmarks as $post) :
                    setup_postdata($post);
                    $instructor_id = $post->meta_value;

                    $instructor_url = tutor_utils()->profile_url($instructor_id, true);

                    $instructor_name = get_user_by('id', $instructor_id)->display_name;

                    $instructor_pic    = get_user_meta($instructor_id, '_instructor_profile_pic', true);
                    $profile_placeholder = Edumall_Helper::placeholder_avatar_src();

                    $instructor_profession = get_user_meta($instructor_id, '_instructor_profession', true);

                    $bookmark = $course_extend->is_bookmarked($instructor_id, get_current_user_id(), 'instructor');
                ?>
                    <a class="bookmarks-instructors-item" href="<?php echo esc_url($instructor_url); ?>">
                        <figure class="bookmarks-instructors-item-pic">
                            <?php if (!empty($instructor_pic)) : ?>
                                <img src="<?php echo esc_html($instructor_pic) ?>" alt="">
                            <?php else : ?>
                                <img src="<?php echo esc_html($profile_placeholder) ?>" alt="">
                            <?php endif; ?>
                        </figure>
                        <div class="bookmarks-instructors-item-info">
                            <h4>
                                <?php echo esc_html($instructor_name); ?>
                            </h4>
                            <p>
                                <?php echo esc_html($instructor_profession); ?>
                            </p>
                        </div>
                        <div class="bookmark" data-type="instructor" data-id="<?php echo $instructor_id ?>" data-callback="<?php esc_html_e('', 'edumall-child'); ?>">
                            <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                            <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                        </div>
                    </a>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="bookmarks-empty">
                    <div class="bookmarks-empty-header">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoBookmark.png' ?>" alt="">
                        <p>
                            <?php esc_html_e('هنوز هیچ نشان‌شده‌ای ندارید.', 'edumall-child'); ?>
                        </p>
                    </div>
                    <a href="<?php echo esc_url(site_url('/')); ?>">
                        <?php esc_html_e('صفحه اصلی', 'edumall-child'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>