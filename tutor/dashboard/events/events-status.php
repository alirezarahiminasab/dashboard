<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.0
 */

defined('ABSPATH') || exit;

require_once get_stylesheet_directory() . '\\inc\\event-module\\util.php' ; 
require_once get_stylesheet_directory() . '\\inc\\date-conversion.php' ; 

$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

$profile_url  = apply_filters('edumall_user_profile_url', '');

///////////////////////////////////////////

$fetch_results = EventUtil::callApi('events/me', [], 'GET');

$results = [];

$decoded = json_decode($fetch_results, true);
if (json_last_error() === JSON_ERROR_NONE) {
    error_log(print_r($decoded, true));
    
    if ($decoded['status'] === 'success') {
        $results = $decoded['data']['events'];
        // <script id="event-status-temp-data" type="application/json">
        // <?php echo $fetch_results 
        // </script>
        $categories = array_column($results, 'category');
        $event_category = array_values(array_unique($categories));
    } else {
        error_log(print_r("Response status is not 'success'.",true));
    }

} else {
    error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
}

?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('رویداد های ایجاد شده', 'edumall-child'); ?></h3>
</div>

<div class="event-status">
    <div class="event-status-wrap">
        <?php if (is_array($results) && count($results)) : ?>

            <div class="event-status-wrap-setting">
                <a class="event-status-wrap-setting-button event-status-filter-btn" href="#">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-search.png' ?>" alt="">
                    <?php esc_html_e('فیلتر', 'edumall-child'); ?>
                </a>
            </div>

            <div class="event-status-wrap-boxes">
                <?php foreach ($results as $event) : ?>

                    <!-- TODO -->
                    <div class="event-status-wrap-boxes-event">
                        <div class="event-status-wrap-boxes-event-header">
                            <img alt="<?php echo $event['title']?>" src="<?php echo $event['imageURL']?>"/>
                            <h3 class="event-status-event-title"><?php echo $event['title'] ?></h3>
                            
                            <div class="event-status-dropdown-parent">
                                <img class="event-status-dropdown-parent-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more.svg' ?>" alt="">
                                <div id="table-dashboard-event-list-<?php echo esc_attr($event['_id']); ?>" class="event-status-dropdown-parent-menu">

                                    <!-- # Move to Draft Action -->

                                    <!-- Edit Action -->
                                    <div class="event-status-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/edit.svg' ?>" alt="">
                                        <a href="<?php echo esc_url(site_url('/dashboard/events/events-create-online?event_id=' . $event['_id'])); ?>">
                                            <?php esc_html_e('ویرایش', 'edumall-child'); ?>
                                        </a>
                                    </div>
                                    <!-- # Edit Action -->

                                    <!-- Delete Action -->
                                    <div class="event-status-dropdown-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.svg' ?>" alt="">
                                        <a id='event-status-dropdown-item-delete' class="event-status-dropdown-item-delete" href="#" data-event-action='delete-event' data-event-id='<?php echo $event['_id'] ?>'>
                                            <?php esc_html_e('Delete', 'edumall-child'); ?>
                                        </a>
                                    </div>
                                    <!-- # Delete Action -->

                                </div>
                            </div>
                        </div>
                        <?php if ($event['status'] === 'reject') : ?>
                            <div class="event-status-wrap-boxes-event-declined">
                                <div class="event-status-declined-message">
                                    <p>
                                        این رویداد به دلیل نقض قوانین هانیل تایید نشده است.
                                    </p>
                                </div>
                                <div class="event-status-declined-contact">
                                    <div class="event-status-declined-contact-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/policy.svg' ?>" alt="">
                                        <a href="#">
                                            مشاهده قوانین
                                        </a>
                                    </div>
                                    <div class="event-status-declined-contact-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/call.svg' ?>" alt="">
                                        <a href="">
                                            تماس با پشتیبانی
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="event-status-wrap-boxes-event-meta">
                            <div class="event-status-metadata">

                                <div class="event-status-metadata-status">
                                    <?php
                                    if ($event['status'] === 'pending') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/pending.svg' ?>" alt="">
                                        <p class="event-status-pending">در انتظار تایید</p>
                                    <?php endif;
                                    if ($event['status'] === 'approve') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/verified.svg' ?>" alt="">
                                        <p class="event-status-approve">تایید شده</p>
                                    <?php endif;
                                    if ($event['status'] === 'reject') : ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/denied.svg' ?>" alt="">
                                        <p class="event-status-reject">تایید نشده</p>
                                    <?php endif;
                                    ?>
                                </div>

                                <div class="event-status-metadata-category">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                    <p class="event-status-meta-value"><?php echo esc_html($event['category']); ?></p>
                                </div>

                                <div class="event-status-metadata-startDate">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar.svg' ?>" alt="">
                                    <p class="event-status-meta-value"><?php echo esc_html(jdate('Y/m/d', $event['startDate']), 'none', 'Asia/Tehran', 'en') ?></p>
                                </div>


                            </div>

                            <!-- Delete prompt modal -->
                             <!-- <div id="<?php echo $id_string_delete; ?>" class="tutor-modal modal-delete-my-event">
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

                                            <div class="tutor-fs-3 tutor-fw-medium tutor-color-black tutor-mb-12"><?php esc_html_e('Delete This Event?', 'edumall-child'); ?></div>
                                            <div class="tutor-fs-6 tutor-color-muted"><?php esc_html_e('Are you sure you want to delete this event permanently from the site? Please confirm your choice.', 'edumall-child'); ?></div>

                                            <div class="tutor-d-flex tutor-justify-center tutor-my-48">
                                                <button data-tutor-modal-close class="tutor-btn tutor-btn-outline-primary">
                                                    <?php esc_html_e('Cancel', 'edumall-child'); ?>
                                                </button>
                                                <button class="tutor-btn tutor-btn-primary tutor-list-ajax-action tutor-ml-20" data-request_data='{"event_id":<?php echo $event['_id']; ?>,"action":"tutor_delete_dashboard_event"}' data-delete_element_id="<?php echo $row_id; ?>">
                                                    <?php esc_html_e('Yes, Delete This', 'edumall-child'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="event-status-wrap-create-btn">
                <a href="<?php echo site_url('/dashboard/events/events-create-online/') ?>" target="_blank">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/add-course.png' ?>" alt="">
                </a>
            </div>

        <?php else : ?>
            <div class="event-status-wrap-empty">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoItemsCourse.png' ?>" alt="">
                <p>
                    <?php esc_html_e('هنوز رویدادی ایجاد نکرده‌اید.', 'edumall-child'); ?>
                </p>
                <a href="<?php echo site_url('/dashboard/events/events-create-online/') ?>" target="_blank">
                    <?php esc_html_e('ایجاد رویداد', 'edumall-child'); ?>
                </a>
            </div>
        <?php endif; ?>


    </div>


    <div class="event-status-filter">
        <div class="event-status-filter-header">
            <p>فیلترها</p>
            <span class="event-status-sort-header-logo">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-type.svg' ?>" alt="">
            </span>
            <img class="event-status-sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
        </div>
        <div class="event-status-filter-wrap">
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
                        <input type="checkbox" name="approve" id="" value="approve" class="filter-wrap-setting-content-status">
                        <p>
                            <?php esc_html_e('تایید شده', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="reject" id="" value="reject" class="filter-wrap-setting-content-status">
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
                    <?php if (!empty($event_category)) : ?>
                        <?php foreach ($event_category as $category) : ?>
                            <span>
                                <input type="checkbox" data-id="<?php echo $category ?>" name="" id="" class="filter-wrap-setting-content-category">
                                <p>
                                    <?php echo esc_html($category) ?>
                                </p>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- <div class="filter-wrap-setting">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('محل برگزاری رویداد', 'edumall-child'); ?>
                        </p>
                    </span>
                    <img class="filter-wrap-setting-header-open" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </div>
                <div class="filter-wrap-setting-content">
                    <?php if (!empty($event_category)) : ?>
                        <?php foreach ($event_category as $category) : ?>
                            <span>
                                <input type="checkbox" data-id="<?php echo $category ?>" name="" id="" class="filter-wrap-setting-content-category">
                                <p>
                                    <?php echo esc_html($category) ?>
                                </p>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div> -->
        </div>
        <div class="event-status-filter-buttons">
            <a class="event-status-filter-buttons-show" >
                <?php esc_html_e('مشاهده نتایج', 'edumall-child'); ?>
            </a>
            <a class="event-status-filter-buttons-reset" >
                <?php esc_html_e('بازنشانی', 'edumall-child'); ?>
            </a>
        </div>
    </div>
</div>