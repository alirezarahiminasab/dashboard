<?php

/**
 * Show all students of the instructor.
 *
 * @author  ThemeMove
 * @package Edumall/TutorLMS/Templates
 * @since   2.7.4
 * @version 2.7.4
 */

defined('ABSPATH') || exit;


require_once get_stylesheet_directory() . '\\inc\\event-module\\util.php' ; 
$fetch_results = EventUtil::callApi('shops/students', [], 'GET');

$results = [];

$decoded = json_decode($fetch_results, true);
if (json_last_error() === JSON_ERROR_NONE) {
    // error_log(print_r($decoded, true));
    
    if ($decoded['status'] === 'success') {
        $results = $decoded['data']['shops'];
        error_log(print_r($results, true));

        // Extract category values into an array
        $categories = array_column($results, 'category');
        
        // Remove duplicate values
        $event_category = array_values(array_unique($categories));
        
        // Output the unique categories
        // error_log(print_r($event_category,true));
    } else {
        error_log(print_r("Response status is not 'success'.",true));
    }

} else {
    error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
}

// Extract unique USERIDs
$userIds = array_map(function($item) {
    return $item['userDetails']['USERID'];
}, $results);
$uniqueUserIds = array_unique($userIds);

// Fetch user metadata from WordPress
function fetch_user_meta($userId) {
    // Ensure that you are within the WordPress environment
    if (function_exists('get_user_meta')) {
        return [
            'first_name' => get_user_meta($userId, 'first_name', true),
            'last_name' => get_user_meta($userId, 'last_name', true),
            '_instructor_marriage' => get_user_meta($userId, '_instructor_marriage', true),
            '_instructor_birth_date' => get_user_meta($userId, '_instructor_birth_date', true),
            '_instructor_profile_pic' => get_user_meta($userId, '_instructor_profile_pic', true)
        ];
    } else {
        // Handle error - maybe log it or return a default value
        return [];
    }
}

$my_students = [];
foreach ($uniqueUserIds as $userId) {
    $my_students[$userId] = fetch_user_meta($userId);
}

// Extract unique eventDetails based on _id
$instructor_events = [];
$eventDetailIds = [];
foreach ($results as $item) {
    $eventDetail = $item['eventDetails'];
    if (!in_array($eventDetail['_id'], $eventDetailIds)) {
        $eventDetailIds[] = $eventDetail['_id'];
        $instructor_events[] = $eventDetail;
    }
}

// Output results
// error_log(print_r("Unique USERIDs:\n",true));
// error_log(print_r($uniqueUserIds,true));
// error_log(print_r("\nUnique Titles:\n",true));
// error_log(print_r($instructor_events,true));
// error_log(print_r("\nUser Metadata:\n",true));
// error_log(print_r($my_students,true));



$profile_url  = apply_filters('edumall_user_profile_url', '');

$current_user_id = get_current_user_id();



$instructor_courses_ids = [];

foreach ($instructor_events as $event) :
    $instructor_courses_ids[] = $event['_id'];
endforeach;
$instructor_courses_ids = json_encode($instructor_courses_ids);
// Read the JSON file 
$json_cities = file_get_contents(get_stylesheet_directory_uri() . '/assets/json/cities.json');

// Decode the JSON file 
$cities_data = json_decode($json_cities, true);

$limit        = 20;
$current_page = max(1, tutils()->array_get('current_page', $_GET));
$offset       = ($current_page - 1) * $limit;

// $my_students    = Edumall_Tutor::instance()->get_students_by_instructor($current_user_id, $offset, $limit);
$total_students = Edumall_Tutor::instance()->get_total_students_by_instructor(get_current_user_id());

$total_pages = ceil($total_students / $limit);
// print_r($my_students);
$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';
?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('لیست فراگیران', 'edumall-child'); ?></h3>
</div>


<?php if (!empty($my_students)) : ?>
    <div class="instructor-students">

        <div class="instructor-students-wrap">

            <div class="instructor-students-wrap-setting">
                <a class="instructor-students-wrap-setting-button instructor-students-filter-btn" href="#">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-search.png' ?>" alt="">
                    <?php esc_html_e('فیلتر ها', 'edumall-child'); ?>
                </a>
                <a class="instructor-students-wrap-setting-button instructor-students-sort-btn" href="#">
                    <span>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/sort.png' ?>" alt="">
                    </span>
                    <span>
                        <?php esc_html_e('مرتب سازی بر اساس', 'edumall-child'); ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                    </span>
                </a>
            </div>

            <div class="instructor-students-list">
                <p>
                    <?php esc_html_e('انتخاب رویداد', 'edumall-child'); ?>
                </p>
                <div class="instructor-students-list-wrap">
                    <img class="instructor-students-list-wrap-arrow" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                    <select>
                        <option value='<?php print_r($instructor_courses_ids) ?>' data-current="all" class="instructor-students-list-course" data-author-id="<?php echo $current_user_id ?>" data-type='all'>
                            <?php esc_html_e('همه', 'edumall-child'); ?>
                        </option>
                        <?php foreach ($instructor_events as $event) : ?>
                            <option class="instructor-students-list-course" value="<?php echo $event['_id'] ?>" data-current="<?php echo $event['title'] ?>" data-author-id="<?php echo $current_user_id ?>" data-type='selected'>
                                <?php echo $event['title']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="instructor-students-wrap-table">
                <p class="instructor-students-wrap-table-count">
                    <?php esc_html_e('لیست فراگیران', 'edumall-child'); ?>
                    <?php echo "(" . $total_students . ")" ?>
                </p>
                <div class="all-student-wrap">

                    <?php foreach ($uniqueUserIds as $USERID) : ?>
                        <?php
                        $profile_url             = tutor_utils()->profile_url($USERID);
                        $enrolled_courses_action = tutor_utils()->get_tutor_dashboard_page_permalink('my-students/enrolled-courses/?student_id=' . $USERID);
                        // $student_registered_date = strtotime($student['user_registered']);
                        // $registered_date = parsidate("Y/m/j",  $student_registered_date);

                        // get_user_meta($userId, 'first_name', true),
                        // get_user_meta($userId, 'last_name', true),

                        $student_location = get_user_meta($USERID, "_instructor_city", true);
                        $student_refer = get_user_meta($USERID, "_student_refer", true);
                        $student_marriage = get_user_meta($USERID, "_instructor_marriage", true);
                        $student_age = get_user_meta($USERID, "_instructor_birth_date", true);
                        $profile_photo_id = get_user_meta($USERID, '_instructor_profile_pic', true);
                        $profile_fullName = get_user_meta($USERID, 'first_name', true) . " " .get_user_meta($USERID, 'last_name', true);
                        ?>
                        <div class="student-box" data-date="$student_registered_date">
                            <div class="student-box-info">
                                <div class="student-box-info-avatar">
                                    <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $default_thumbnail_src ?>" alt="">
                                </div>
                                <h6 class="student-box-info-name"><?php echo $profile_fullName ?></h6>
                            </div>
                            <div class="student-box-meta">
                                <div class="student-box-meta-top">

                                    <div class="student-box-meta-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                                        <p> <?php echo $registered_date; ?> </p>
                                    </div>
                                    <div class="student-box-meta-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                                        <p> <?php echo $student_location; ?> </p>
                                    </div>
                                    <div class="student-box-meta-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                                        <?php echo $student_refer ?>
                                    </div>

                                    
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                                </div>

                                <div class="student-box-meta-bottom">
                                    <div class="student-box-meta-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/heart-tick.svg' ?>" alt="">
                                        <?php echo $student_marriage ?>
                                    </div>
                                    <div class="student-box-meta-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-circle.svg' ?>" alt="">
                                        <?php echo $student_age ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="instructor-students-sort">
        <div class="instructor-students-sort-bg"></div>
        <div class="instructor-students-sort-wrap">
            <div class="instructor-students-sort-wrap-header">
                <p>مرتب سازی بر اساس</p>
                <img class="sort-header-logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
            </div>
            <div class="instructor-students-sort-wrap-radio">
                <span data-sort="progress" id="sort_by_progress">
                    <input type="radio" name="instructor-students-sort-radio" class="instructor-students-sort-radio" data-author-id="<?php echo $current_user_id ?>">
                    <p>
                        <?php esc_html_e('درصد پیشرفت', 'edumall-child'); ?>
                    </p>
                </span>
                <span data-sort="date" id="sort_by_date">
                    <input type="radio" name="instructor-students-sort-radio" class="instructor-students-sort-radio" data-author-id="<?php echo $current_user_id ?>">
                    <p>
                        <?php esc_html_e('تاریخ ثبت‌نام', 'edumall-child'); ?>
                    </p>
                </span>
            </div>
        </div>
    </div>

    <div class="instructor-students-filter">
        <div class="instructor-students-filter-header">
            <p>فیلترها</p>
            <span class="sort-header-logo">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-type.svg' ?>" alt="">
            </span>
            <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
        </div>

        <div class="instructor-students-filter-wrap">
            <div class="filter-wrap-setting students-filter-date-picker">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('محدوده زمانی جستجو', 'edumall-child'); ?>
                        </p>
                    </span>
                    <img class="filter-wrap-setting-header-open" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </div>
                <div class="filter-wrap-setting-content">
                    <span>
                        <input class="filter-wrap-setting-content-start-date" type="text" name="" id="" placeholder="از تاریخ">
                    </span>
                    <span>
                        <input class="filter-wrap-setting-content-end-date" type="text" name="" id="" placeholder="تا تاریخ">
                    </span>
                </div>
            </div>
            <!-- TODO -->
            <!-- Implement student progress -->
            <!-- <div class="filter-wrap-setting">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-status.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('درصد پیشرفت', 'edumall-child'); ?>
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
                        <input type="checkbox" name="pending" id="" value="pending">
                        <p>
                            <?php esc_html_e('تا 20٪', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="publish" id="" value="publish">
                        <p>
                            <?php esc_html_e('20٪ تا 40٪', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="trash" id="" value="trash">
                        <p>
                            <?php esc_html_e('۴0٪ تا ۶0٪', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="trash" id="" value="trash">
                        <p>
                            <?php esc_html_e('۶0٪ تا ۸0٪', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span>
                        <input type="checkbox" name="trash" id="" value="trash">
                        <p>
                            <?php esc_html_e('۸0٪ تا ۱۰0٪', 'edumall-child'); ?>
                        </p>
                    </span>
                </div>
            </div> -->
            <div class="filter-wrap-setting">
                <div class="filter-wrap-setting-header">
                    <span class="filter-wrap-setting-header-title">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                        <p>
                            <?php esc_html_e('محل سکونت', 'edumall-child'); ?>
                        </p>
                    </span>
                    <img class="filter-wrap-setting-header-open" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </div>
                <div class="filter-wrap-setting-content">
                    <span class="filter-wrap-setting-content-search">
                        <input type="text" name="all-status" id="" placeholder="شهر موردنظر خود را جستجو کنید">
                    </span>
                    <span class="main-city filter-wrap-setting-content-city">
                        <input type="checkbox" name="" id="" value="تهران">
                        <p>
                            <?php esc_html_e('تهران', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span class="main-city filter-wrap-setting-content-city">
                        <input type="checkbox" name="" id="" value="اصفهان">
                        <p>
                            <?php esc_html_e('اصفهان', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span class="main-city filter-wrap-setting-content-city">
                        <input type="checkbox" name="" id="" value="مشهد">
                        <p>
                            <?php esc_html_e('مشهد', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span class="main-city filter-wrap-setting-content-city">
                        <input type="checkbox" name="" id="" value="کرج">
                        <p>
                            <?php esc_html_e('کرج', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span class="main-city filter-wrap-setting-content-city">
                        <input type="checkbox" name="" id="" value="یزد">
                        <p>
                            <?php esc_html_e('یزد', 'edumall-child'); ?>
                        </p>
                    </span>
                    <span class="filter-wrap-setting-content-show-all">
                        <a href="#">
                            <?php esc_html_e('نمایش شهرهای بیشتر', 'edumall-child'); ?>
                        </a>
                    </span>
                    <?php foreach ($cities_data as $city) : ?>
                        <span class="other-city filter-wrap-setting-content-city">
                            <input type="checkbox" name="" id="" value="<?php echo $city['name']; ?>">
                            <p>
                                <?php echo $city['name']; ?>
                            </p>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="instructor-students-filter-buttons">
            <a class="instructor-students-filter-buttons-show" href="#" data-id="<?php echo $current_user_id ?>">
                <?php esc_html_e('مشاهده نتایج', 'edumall-child'); ?>
            </a>
            <a class="instructor-students-filter-buttons-reset" href="#">
                <?php esc_html_e('بازنشانی', 'edumall-child'); ?>
            </a>
        </div>
    </div>

    <?php if ($total_pages > 1) : ?>
        <div class="edumall-grid-pagination">
            <?php
            Edumall_Templates::render_paginate_links([
                'format'  => '?current_page=%#%',
                'current' => $current_page,
                'total'   => $total_pages,
            ]);
            ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="dashboard-no-content-found">
        <?php esc_html_e('You do not have any students yet.', 'edumall-child'); ?>
    </div>
<?php endif; ?>