<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined('ABSPATH') || exit;

global $post;

use Detection\MobileDetect;
use CourseExtend\CourseExtend;

$detect = new MobileDetect();
$course_extend = new CourseExtend();

$profile_url  = apply_filters('edumall_user_profile_url', '');
$menu_type = !$detect->isMobile() ? '/?menu=tutor' : '';
?>
<div class="edit-profile-title">
    <?php if ($detect->isMobile()) : ?>
        <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
    <?php endif; ?>
    <h3><?php esc_html_e('نشان‌شده‌ها', 'edumall-child'); ?></h3>
</div>

<div class="bookmarks">
    <div class="bookmarks-wrap">
        <div class="bookmarks-links">
            <ul>
                <li>
                    <a class="active" href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('bookmarks') . $menu_type; ?>">
                        <?php esc_html_e('دوره', 'edumall-child'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('bookmarks/instructors') . $menu_type; ?>">
                        <?php esc_html_e('مدرس', 'edumall-child'); ?>
                    </a>
                </li>
            </ul>

            <?php if (!$detect->isMobile()) : ?>
                <div class="bookmarks-links-search">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/search-normal.svg' ?>" alt="">
                    <input type="text" name="" id="" placeholder="<?php esc_html_e('جستجو دوره', 'edumall-child'); ?>">
                </div>
            <?php endif ?>
        </div>

        <div class="bookmarks-posts">
            <?php
            $bookmarks = $course_extend->get_bookmarks('course');

            if (is_array($bookmarks) && count($bookmarks)) : ?>
                <?php
                global $edumall_course;
                $edumall_course_clone = $edumall_course;
                ?>

                <?php foreach ($bookmarks as $post) :
                    setup_postdata($post);
                    $course_id = $post->meta_value;
                    $edumall_course = new Edumall_Course();
                    $thumbnail_size = '327x210';
                    $course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
                        'post_id' => $course_id,
                        'size'    => $thumbnail_size,
                    ));
                    $course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';

                    $authors = tutor_utils()->get_instructors_by_course($course_id);

                    $author_pic    = get_user_meta($authors[0]->ID, '_instructor_profile_pic', true);
                    $profile_placeholder = Edumall_Helper::placeholder_avatar_src();

                    $course_category = get_the_terms($course_id, 'course-category');

                    $bookmark = $course_extend->is_bookmarked($course_id, get_current_user_id(), 'course');
                ?>
                    <a class="bookmarks-posts-item" href="<?php echo get_the_permalink($course_id); ?>">
                        <figure class="bookmarks-posts-item-thumb">
                            <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                            <div class="bookmark" data-type="course" data-id="<?php echo $course_id ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                            </div>
                        </figure>
                        <div class="bookmarks-posts-item-info">
                            <div class="bookmarks-posts-item-title">
                                <h4><?php echo get_the_title($course_id); ?></h4>
                            </div>
                            <div class="bookmarks-posts-item-author">
                                <?php if (!empty($instructor_pic)) : ?>
                                    <img src="<?php echo esc_html($author_pic) ?>" alt="">
                                <?php else : ?>
                                    <img src="<?php echo esc_html($profile_placeholder) ?>" alt="">
                                <?php endif; ?>
                                <p>
                                    <?php echo $authors[0]->display_name; ?>
                                </p>
                            </div>
                            <div class="bookmarks-posts-item-categories">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                <div class="bookmarks-posts-item-category">
                                    <?php if (!empty($course_category)) : ?>
                                        <?php foreach ($course_category as $category) : ?>
                                            <p class="captions-meta-info-item-category"><?php echo $category->name ?></p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>

                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>

                <?
                /**
                 * Reset course object.
                 */
                $edumall_course = $edumall_course_clone;
                ?>
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