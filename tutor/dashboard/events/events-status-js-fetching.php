<?php


/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.0
 */


require_once get_stylesheet_directory() . '\\inc\\event-module\\services\\EventService.php' ; 

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

// $results = tutor_utils()->get_courses_by_instructor($current_user_id, $status, $offset, $per_page);


// /////////////////////////////////////////
$result = EventUtil::callApi('events/me', [], 'GET');
error_log(print_r($result, true));

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
        </div>




            <div class="instructor-courses-wrap-boxes">

                <!-- SECTION -->
                <div id="event-card-template"  style="display: none;">
                    <div class="edumall-box instructor-courses-wrap-boxes-course">                       
                        <div class="instructor-courses-wrap-boxes-course-header">
                            <a href="#" class="event-link"><img src="#" alt="" class="event-image"></a>
                            <h3 class="course-title"><a href="#" class="link-in-title event-title"></a></h3>

                            <div class="instructor-dropdown-parent">
                                <img class="instructor-dropdown-parent-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more.svg' ?>" alt="">
                                <div class="instructor-dropdown-parent-menu">
                                    <!-- Edit Action -->
                                    <div class="instructor-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/edit.svg' ?>" alt="">
                                        <a href="#" class="event-edit"><?php esc_html_e('ویرایش', 'edumall-child'); ?></a>
                                    </div>
                                    <!-- # Edit Action -->
                                    <!-- discount Action -->
                                    <div class="instructor-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/edit.svg' ?>" alt="">
                                        <a href="#" class="event-discount"><?php esc_html_e('کد تخفیف', 'edumall-child'); ?></a>
                                    </div>
                                    <!-- # discount Action -->
                                    <!-- Delete Action -->
                                    <div class="instructor-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.svg' ?>" alt="">
                                        <a href="#" class="event-delete"><?php esc_html_e('Delete', 'edumall-child'); ?></a>
                                    </div>
                                    <!-- # Delete Action -->
                                </div>
                            </div>
                        </div>
                        <div class="instructor-courses-wrap-boxes-course-meta">
                            <div class="instructor-course-metadata">
                                <div class="instructor-course-metadata-status event-status-container">
                                    <img src="#" alt="" class="event-status-icon">
                                    <p class="event-status-text"></p>
                                </div>
                                <div class="instructor-course-metadata-category">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                    <p class="meta-value event-category"></p>
                                </div>
                                <div class="instructor-course-metadata-reviews">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/reviews.svg' ?>" alt="">
                                    <p class="meta-value event-start-date"></p>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- SECTION -->
                <!-- Hidden elements to store dynamic PHP values -->
                <div class="hidden-elements">
                    <input type="hidden" class="pending-icon" value="<?php echo get_stylesheet_directory_uri() . '/assets/images/pending.svg' ?>">
                    <input type="hidden" class="approve-icon" value="<?php echo get_stylesheet_directory_uri() . '/assets/images/verified.svg' ?>">
                    <input type="hidden" class="reject-icon" value="<?php echo get_stylesheet_directory_uri() . '/assets/images/denied.svg' ?>">
                    <input type="hidden" class="edit-url-template" value="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('course/edit-courses/?course_ID=')); ?>">
                    <input type="hidden" class="discount-url-template" value="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('event/discount-page/?course_ID=')); ?>">
                </div>

            </div>
            <div class="instructor-courses-wrap-empty">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoItemsCourse.png' ?>" alt="">
                <p>
                    <?php esc_html_e('هنوز دوره‌ای ایجاد نکرده‌اید.', 'edumall-child'); ?>
                </p>
                <a href="<?php echo site_url('/dashboard/course/course-create/') ?>">
                    <?php esc_html_e('ایجاد دوره', 'edumall-child'); ?>
                </a>
            </div>


        <div class="instructor-courses-wrap-create-btn">
            <a href="<?php echo site_url('/dashboard/course/course-create/') ?>" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/add-course.png' ?>" alt="">
            </a>
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
            <div class="filter-wrap-setting filter-wrap-setting-status">
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
            <div class="filter-wrap-setting filter-wrap-setting-category">
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
                </div>
            </div>


            <div class="filter-wrap-setting filter-wrap-setting-category">
                <input type="checkbox" class="checkbox-slider" >
                <input type="checkbox" class="custom-checkbox-slider" >
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