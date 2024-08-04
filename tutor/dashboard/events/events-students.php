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
require_once get_stylesheet_directory() . '\\inc\\date-conversion.php' ; 

$PAGE = 'data';

function fetch_user_meta($userId) {
    return [
        'full_name' => get_user_meta($userId, 'first_name', true) . " " .  get_user_meta($userId, 'last_name', true),
        'marriage' => get_user_meta($userId, '_instructor_marriage', true),
        'birth_date' => get_user_meta($userId, '_instructor_birth_date', true),
        'profile_pic' => get_user_meta($userId, '_instructor_profile_pic', true),
        'city' => get_user_meta($userId, '_instructor_city', true)
    ];
}


function getMyEvents() {
    $fetchResult = EventUtil::callApi('events/me?fields=title,startDate&sort=-startDate', [], 'GET');
 
    $decoded = json_decode($fetchResult, true);
    if (json_last_error() !== JSON_ERROR_NONE) {    
        error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
        return false;
    }
    
    if ($decoded['status'] !== 'success') {
        error_log(print_r("Response status is not 'success'.",true));
        return false;
    }

    $results = $decoded['data']['events'];
    return $results;
}

function getStudents($eventID) {
    $fetchResult = EventUtil::callApi('shops/students?eventID=' . $eventID, [], 'GET');
    
    $decoded = json_decode($fetchResult, true);
    if (json_last_error() !== JSON_ERROR_NONE) {    
        error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
        return false;
    }

    if ($decoded['status'] !== 'success') {
        error_log(print_r("Response status is not 'success'.",true));
        return false;
    }

    $results = $decoded['data']['shops'];
    return $results;
}

$studentList = [];

$myEvents = getMyEvents();
if ($myEvents === false) {
    $PAGE = 'error';
} elseif (empty($myEvents)) {    
    error_log(print_r("there is no events!",true));
    $PAGE = 'no-event';
} else {
    
    $studentList = getStudents($myEvents[1]['_id']);
    if ($studentList === false) {
        $PAGE = 'error';
    } elseif (empty($studentList)) {    
        $PAGE = 'no-student';
    } else {    
        // Fetch user metadata from WordPress
        foreach ($studentList as &$student) {
            // $student['meta'] = 'dcdc';
            $student['meta'] = fetch_user_meta($student['USERID']);
        }
        unset($student); 

        // error_log(print_r($studentList,true));
    }
}


$profile_url  = apply_filters('edumall_user_profile_url', '');
$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';
?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('لیست فراگیران', 'edumall-child'); ?></h3>
</div>

<div id="event-students">
<?php if ($PAGE === 'data' || $PAGE === 'no-student') : ?>
    <div class="instructor-students">

        <div class="instructor-students-wrap">

            <div class="instructor-students-wrap-setting <?php echo ($PAGE !== 'data') ? 'hidden' : ''; ?>"  >
                <a class="instructor-students-wrap-setting-button instructor-students-filter-btn" href="#">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter-search.png' ?>" alt="">
                    <?php esc_html_e('فیلتر ها', 'edumall-child'); ?>
                </a>
            </div>

            <div class="instructor-students-list">
                <p>
                    <?php esc_html_e('انتخاب رویداد', 'edumall-child'); ?>
                </p>
                <div class="instructor-students-list-wrap">
                    <img class="instructor-students-list-wrap-arrow" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                    <select>
                        <?php foreach ($myEvents as $event) : ?>
                            <option class="instructor-students-list-course" value="<?php echo $event['_id'] ?>" data-type='selected'>
                                <?php echo $event['title']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($PAGE === 'data') : ?>

                <div class="instructor-students-wrap-table">
                    <p class="instructor-students-wrap-table-count">
                        <?php esc_html_e('لیست فراگیران', 'edumall-child'); ?>
                        <?php echo "(" . count($studentList) .")" ?>
                    </p>
                    <div class="all-student-wrap">

                        <?php foreach ($studentList as $student) : ?>
                            <?php
                            // $profile_url             = tutor_utils()->profile_url($USERID);
                            // $enrolled_courses_action = tutor_utils()->get_tutor_dashboard_page_permalink('my-students/enrolled-courses/?student_id=' . $USERID);
                            // $student_registered_date = strtotime($student['user_registered']);
                            // $registered_date = parsidate("Y/m/j",  $student_registered_date);

                            // get_user_meta($userId, 'first_name', true),
                            // get_user_meta($userId, 'last_name', true),

                            // full_name, marriage, birth_date, profile_pic, city
                            // $student_location = get_user_meta($USERID, "_instructor_city", true);
                            // $student_refer = get_user_meta($USERID, "_student_refer", true);
                            // $student_marriage = get_user_meta($USERID, "_instructor_marriage", true);
                            // $student_age = get_user_meta($USERID, "_instructor_birth_date", true);
                            // $profile_photo_id = get_user_meta($USERID, '_instructor_profile_pic', true);
                            // $profile_fullName = get_user_meta($USERID, 'first_name', true) . " " .get_user_meta($USERID, 'last_name', true);
                            ?>
                            <div class="student-box" data-date="$student_registered_date">
                                <div class="student-box-info">
                                    <div class="student-box-info-avatar">
                                        <img src="<?php echo !empty($student['meta']['profile_pic']) ? $student['meta']['profile_pic'] : $default_thumbnail_src ?>" alt="">
                                    </div>
                                    <h6 class="student-box-info-name"><?php echo $student['meta']['full_name'] ?></h6>
                                </div>
                                <div class="student-box-meta">
                                    <div class="student-box-meta-top">

                                        <div class="student-box-meta-item">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                                            <p> <?php echo jdate('Y/m/d', $student['createDateTime']) ?> </p>
                                        </div>
                                        <div class="student-box-meta-item">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                                            <p> <?php echo $student['meta']['city'] ?> </p>
                                        </div>
                                        <div class="student-box-meta-item">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                                            <?php echo array_key_exists('discountID', $student)?'کد تخفیف':'' ?>
                                        </div>

                                        
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                                    </div>

                                    <div class="student-box-meta-bottom">
                                        <div class="student-box-meta-item">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/heart-tick.svg' ?>" alt="">
                                            <?php echo $student['meta']['marriage'] ?>
                                        </div>
                                        <div class="student-box-meta-item">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-circle.svg' ?>" alt="">
                                            <?php echo $student['meta']['birth_date'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else : ?>

                <div class="dashboard-no-content-found">
                    <?php esc_html_e('You do not have any students on this event.', 'edumall-child'); ?>
                </div>

            <?php endif; ?>
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
            <a class="instructor-students-filter-buttons-show" href="#" >
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
<?php elseif($PAGE === 'no-event' ): ?>
    <div class="dashboard-no-content-found">
        <?php esc_html_e('no event!.', 'edumall-child'); ?>
    </div>

<?php elseif($PAGE === 'error' ): ?>
    <div class="dashboard-no-content-found">
        <?php esc_html_e('error occured.', 'edumall-child'); ?>
    </div>
<?php endif; ?>
</div>