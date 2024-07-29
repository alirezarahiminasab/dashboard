<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.0
 */

defined('ABSPATH') || exit;

use TUTOR\Input;
use Tutor\Models\CourseModel;

$tutor = new Edumall_Tutor();

$profile_url  = apply_filters('edumall_user_profile_url', '');

$current_user_id = get_current_user_id();
!isset($active_tab) ? $active_tab = 'course' : 0;

// Map required course status according to page.
$status_map = array(
    'course'                 => CourseModel::STATUS_PUBLISH,
    'course/draft-courses'   => CourseModel::STATUS_DRAFT,
    'course/pending-courses' => CourseModel::STATUS_PENDING,
);

$course_category = get_terms(array(
    'taxonomy' => 'course-category',
    'hide_empty' => false,
));

// Set currently required course status fo current tab.
$status = array('publish', 'pending', 'draft', 'trash');

// Get counts for course tabs.
$count_map = array(
    'publish' => tutor_utils()->get_courses_by_instructor($current_user_id, 'publish', 0, 0, true),
    'pending' => tutor_utils()->get_courses_by_instructor($current_user_id, 'pending', 0, 0, true),
    'draft'   => tutor_utils()->get_courses_by_instructor($current_user_id, 'draft', 0, 0, true),
    'trash'   => tutor_utils()->get_courses_by_instructor($current_user_id, 'trash', 0, 0, true),
);

$course_archive_arg = isset($GLOBALS['tutor_course_archive_arg']) ? $GLOBALS['tutor_course_archive_arg']['column_per_row'] : null;
$courseCols         = $course_archive_arg === null ? tutor_utils()->get_option('courses_col_per_row', 4) : $course_archive_arg;
$per_page           = tutor_utils()->get_option('courses_per_page', 10);
$paged              = Input::get('current_page', 1, Input::TYPE_INT);
$offset             = $per_page * ($paged - 1);

$results = tutor_utils()->get_courses_by_instructor($current_user_id, $status, $offset, $per_page);
?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('دوره‌های ایجاد شده', 'edumall-child'); ?></h3>
</div>

<div class="instructor-courses">
    <div class="instructor-courses-wrap">
        <div class="instructor-courses-wrap-setting">
            <a class="instructor-courses-wrap-setting-button instructor-courses-filter-btn" href="#">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-search.png' ?>" alt="">
                <?php esc_html_e('فیلتر', 'edumall-child'); ?>
            </a>
            <a class="instructor-courses-wrap-setting-button instructor-courses-sort-btn" href="#">
                <span>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/sort.png' ?>" alt="">
                </span>
                <span>
                    <?php esc_html_e('مرتب سازی بر اساس', 'edumall-child'); ?>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </span>
            </a>
        </div>
        <?php if (is_array($results) && count($results)) : ?>
            <?php
            global $post;
            $tutor_nonce_value     = wp_create_nonce(tutor()->nonce_action);
            $default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

            ?>
            <div class="instructor-courses-wrap-boxes">
                <?php foreach ($results as $post) : ?>
                    <?php
                    setup_postdata($post);

                    $course_rating    = tutor_utils()->get_course_rating();
                    $course_reviews    = tutor_utils()->get_course_reviews($post->ID);
                    $terms = get_the_terms($post->ID, 'course-category');
                    $reviews_count = sizeof($course_reviews);
                    $avg_rating       = $course_rating->rating_avg;
                    $rating_count     = $course_rating->rating_count;
                    $id_string_delete = 'tutor_my_courses_delete_' . $post->ID;
                    $row_id           = 'instructor-course-' . $post->ID;
                    ?>
                    <div id="<?php echo $row_id ?>" class="edumall-box instructor-courses-wrap-boxes-course instructor-course-<?php the_ID(); ?>">
                        <div class="instructor-courses-wrap-boxes-course-header">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php Edumall_Image::the_post_thumbnail([
                                        'alt'  => get_the_title(),
                                    ]); ?>
                                <?php else : ?>
                                    <?php echo Edumall_Image::build_img_tag([
                                        'src' => $default_thumbnail_src,
                                        'alt' => get_the_title(),
                                    ]) ?>
                                <?php endif; ?>
                            </a>
                            <h3 class="course-title"><a href="<?php the_permalink(); ?>" class="link-in-title"><?php the_title(); ?></a></h3>



                            
                            <div class="instructor-dropdown-parent">
                                <img class="instructor-dropdown-parent-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more.svg' ?>" alt="">
                                <div id="table-dashboard-course-list-<?php echo esc_attr($post->ID); ?>" class="instructor-dropdown-parent-menu">

                                    <!-- Move to Draf Action -->
                                    <div class="instructor-dropdown-item">
                                        <input type="checkbox" name="" <?php echo in_array($post->post_status, array(CourseModel::STATUS_PUBLISH)) ? '' : 'checked' ?>>

                                        <a class="instructor-dropdown-item-status" href="#" data-course-action='hide-course' data-course-id='<?php echo $post->ID ?>'>
                                            <?php esc_html_e('پنهان کردن', 'edumall-child'); ?>
                                        </a>
                                    </div>

                                    <!-- # Move to Draft Action -->

                                    <!-- Edit Action -->
                                    <div class="instructor-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/edit.svg' ?>" alt="">
                                        <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('course/edit-courses/?course_ID=' . $post->ID)); ?>">
                                            <?php esc_html_e('ویرایش', 'edumall-child'); ?>
                                        </a>
                                    </div>
                                    <!-- # Edit Action -->

                                    <!-- Delete Action -->
                                    <div class="instructor-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.svg' ?>" alt="">
                                        <a id='instructor-dropdown-item-delete' class="instructor-dropdown-item-status" href="#" data-course-action='delete-course' data-course-id='<?php echo $post->ID ?>'>
                                            <?php esc_html_e('Delete', 'edumall-child'); ?>
                                        </a>
                                    </div>
                                    <!-- # Delete Action -->

                                </div>
                            </div>
                        </div>
                        <?php if ($post->post_status === 'trash') : ?>
                            <div class="instructor-courses-wrap-boxes-course-declined">
                                <div class="declined-message">
                                    <p>
                                        این دوره به دلیل نقض قوانین هانیل تایید نشده است.
                                    </p>
                                </div>
                                <div class="declined-contact">
                                    <div class="declined-contact-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/policy.svg' ?>" alt="">
                                        <a href="#">
                                            مشاهده قوانین
                                        </a>
                                    </div>
                                    <div class="declined-contact-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/call.svg' ?>" alt="">
                                        <a href="">
                                            تماس با پشتیبانی
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="instructor-courses-wrap-boxes-course-meta">
                            <div class="instructor-course-metadata">
                                <?php
                                $course_students = tutor_utils()->count_enrolled_users_by_course();
                                ?>

                                <div class="instructor-course-metadata-status">
                                    <?php
                                    if ($post->post_status === 'pending') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/pending.svg' ?>" alt="">
                                        <p class="pending">در انتظار تایید</p>
                                    <?php endif;
                                    if ($post->post_status === 'publish') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/verified.svg' ?>" alt="">
                                        <p class="published">تایید شده</p>
                                    <?php endif;
                                    if ($post->post_status === 'trash') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/denied.svg' ?>" alt="">
                                        <p class="declined">تایید نشده</p>
                                    <?php endif;
                                    ?>
                                </div>

                                <div class="instructor-course-metadata-category">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                    <?php if (!empty($terms)) : ?>
                                        <?php foreach ($terms as $term) : ?>
                                            <p class="meta-value"><?php echo esc_html($term->name); ?></p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="instructor-course-metadata-enrolled">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/profile-students.svg' ?>" alt="">
                                    <p class="meta-value"><?php echo esc_html($course_students); ?></p>
                                </div>

                                <div class="instructor-course-metadata-reviews">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/reviews.svg' ?>" alt="">
                                    <p class="meta-value"><?php echo esc_html($reviews_count); ?></p>
                                </div>
                            </div>

                            <!-- Delete prompt modal -->
                            <div id="<?php echo $id_string_delete; ?>" class="tutor-modal modal-delete-my-course">
                                <div class="tutor-modal-overlay"></div>
                                <div class="tutor-modal-window">
                                    <div class="tutor-modal-content tutor-modal-content-white">
                                        <button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close>
                                            <span class="tutor-icon-times" area-hidden="true"></span>
                                        </button>

                                        <div class="tutor-modal-body tutor-text-center">
                                            <div class="tutor-mt-48">
                                                <img class="tutor-d-inline-block" src="<?php echo tutor()->url; ?>assets/images/icon-trash.svg" />
                                            </div>

                                            <div class="tutor-fs-3 tutor-fw-medium tutor-color-black tutor-mb-12"><?php esc_html_e('Delete This Course?', 'edumall-child'); ?></div>
                                            <div class="tutor-fs-6 tutor-color-muted"><?php esc_html_e('Are you sure you want to delete this course permanently from the site? Please confirm your choice.', 'edumall-child'); ?></div>

                                            <div class="tutor-d-flex tutor-justify-center tutor-my-48">
                                                <button data-tutor-modal-close class="tutor-btn tutor-btn-outline-primary">
                                                    <?php esc_html_e('Cancel', 'edumall-child'); ?>
                                                </button>
                                                <button class="tutor-btn tutor-btn-primary tutor-list-ajax-action tutor-ml-20" data-request_data='{"course_id":<?php echo $post->ID; ?>,"action":"tutor_delete_dashboard_course"}' data-delete_element_id="<?php echo $row_id; ?>">
                                                    <?php esc_html_e('Yes, Delete This', 'edumall-child'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="instructor-courses-wrap-empty">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoItemsCourse.png' ?>" alt="">
                <p>
                    <?php esc_html_e('هنوز دوره‌ای ایجاد نکرده‌اید.', 'edumall-child'); ?>
                </p>
                <a href="<?php echo site_url('/dashboard/course/course-create/') ?>">
                    <?php esc_html_e('ایجاد دوره', 'edumall-child'); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php
        if (count($count_map) > $per_page) {
            $pagination_data = array(
                'total_items' => count($count_map),
                'per_page'    => $per_page,
                'paged'       => $paged,
            );

            tutor_load_template_from_custom_path(
                tutor()->path . 'templates/dashboard/elements/pagination.php',
                $pagination_data
            );
        }
        ?>
        <div class="instructor-courses-wrap-create-btn">
            <a href="<?php echo site_url('/dashboard/course/course-create/') ?>" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/add-course.png' ?>" alt="">
            </a>
        </div>

    </div>
    <div class="instructor-courses-sort">
        <div class="instructor-courses-sort-bg"></div>
        <div class="instructor-courses-sort-wrap">
            <div class="instructor-courses-sort-wrap-header">
                <p>مرتب سازی بر اساس</p>
                <img class="sort-header-logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
            </div>
            <div class="instructor-courses-sort-wrap-radio">
                <span>
                    <input type="radio" name="instructor-courses-sort-radio" class="instructor-courses-sort-radio" data-sort="latest" data-author-id="<?php echo $current_user_id ?>" checked>
                    <p>
                        <?php esc_html_e('جدیدترین', 'edumall-child'); ?>
                    </p>
                </span>
                <span>
                    <input type="radio" name="instructor-courses-sort-radio" class="instructor-courses-sort-radio" data-sort="enroll" data-author-id="<?php echo $current_user_id ?>">
                    <p>
                        <?php esc_html_e('تعداد دانشجویان', 'edumall-child'); ?>
                    </p>
                </span>
                <span>
                    <input type="radio" name="instructor-courses-sort-radio" class="instructor-courses-sort-radio" data-sort="comment" data-author-id="<?php echo $current_user_id ?>">
                    <p>
                        <?php esc_html_e('تعداد نظرات', 'edumall-child'); ?>
                    </p>
                </span>
            </div>
        </div>
    </div>

    <div class="instructor-courses-filter">
        <div class="instructor-courses-filter-header">
            <p>فیلترها</p>
            <span class="sort-header-logo">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-type.svg' ?>" alt="">
            </span>
            <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
        </div>
        <div class="instructor-courses-filter-wrap">
            <div class="filter-wrap-setting">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-status.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('وضعیت', 'edumall-child'); ?>
                        </p>
                    </span>
                    <img class="filter-wrap-setting-header-open" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </div>
                <div class="filter-wrap-setting-content">
                    <span>
                        <input type="checkbox" name="all-status" id="" class="filter-wrap-setting-content-all" value="all">
                        <p>
                            <?php esc_html_e('همه', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="pending" id="" value="pending" class="filter-wrap-setting-content-status">
                        <p>
                            <?php esc_html_e('در انتظار تایید', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="publish" id="" value="publish" class="filter-wrap-setting-content-status">
                        <p>
                            <?php esc_html_e('تایید شده', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="trash" id="" value="trash" class="filter-wrap-setting-content-status">
                        <p>
                            <?php esc_html_e('تایید نشده', 'edumall-child'); ?>
                        </p>
                    </span>
                </div>
            </div>
            <div class="filter-wrap-setting">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('دسته‌بندی', 'edumall-child'); ?>
                        </p>
                    </span>
                    <img class="filter-wrap-setting-header-open" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </div>
                <div class="filter-wrap-setting-content">
                    <span>
                        <input type="checkbox" name="all-status" id="" class="filter-wrap-setting-content-all">
                        <p>
                            <?php esc_html_e('همه', 'edumall-child'); ?>
                        </p>
                    </span>
                    <?php if (!empty($course_category)) : ?>
                        <?php foreach ($course_category as $category) : ?>
                            <span>
                                <input type="checkbox" data-id="<?php echo $category->term_id ?>" name="" id="" class="filter-wrap-setting-content-category">
                                <p>
                                    <?php echo esc_html($category->name) ?>
                                </p>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="instructor-courses-filter-buttons">
            <a class="instructor-courses-filter-buttons-show" href="#" data-instructor="<?php echo $current_user_id ?>">
                <?php esc_html_e('مشاهده نتایج', 'edumall-child'); ?>
            </a>
            <a class="instructor-courses-filter-buttons-reset" href="#" data-instructor="<?php echo $current_user_id ?>">
                <?php esc_html_e('بازنشانی', 'edumall-child'); ?>
            </a>
        </div>
    </div>
</div>