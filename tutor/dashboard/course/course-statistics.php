<?php

use CourseExtend\CourseExtend;

$profile_url  = apply_filters('edumall_user_profile_url', '');
$instructor_id = get_current_user_id();
$course_args = array(
    'post_type' => 'courses',
    'posts_per_page' => 5,
    'author' => $instructor_id
);

$course_query = new WP_Query($course_args);

$course_extend = new CourseExtend();

?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('آمار دوره‌ها', 'edumall-child'); ?></h3>
</div>

<div class="course-statistics">
    <div class="course-statistics-wrap">
        <div class="course-statistics-header">
            <a class="course-statistics-sort-btn" href="#">
                <span>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/sort.png' ?>" alt="">
                </span>
                <span>
                    <?php esc_html_e('مرتب سازی بر اساس', 'edumall-child'); ?>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </span>
            </a>
        </div>

        <div class="course-statistics-footer">
            <div class="course-statistics-footer-title">
                <span>
                    <p>
                        عنوان دوره
                    </p>
                </span>
                <span>
                    <p>
                        تعداد فراگیران
                    </p>
                </span>
                <span>
                    <p>
                        کل درآمد
                    </p>
                </span>
            </div>
            <div class="course-statistics-footer-wrap">
                <?php if ($course_query->have_posts()) : ?>
                    <?php while ($course_query->have_posts()) : $course_query->the_post();
                        $course_total_students = tutor_utils()->count_enrolled_users_by_course(get_the_ID());
                        $course_product_id = tutor_utils()->get_course_product_id(get_the_ID());

                        $course_total_sales =  $course_extend->get_total_earnings_by_product_id($course_product_id);
                        $course_total_earn = $course_extend->get_price_indicator($course_total_sales);
                    ?>
                        <div class="course-statistics-footer-item" data-students="<?php echo $course_total_students ?>" data-earn="<?php echo $course_total_sales; ?>">
                            <span>
                                <p>
                                    <?php echo get_the_title() ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $course_total_students ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $course_total_earn; ?>
                                </p>
                            </span>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="course-statistics-sort">
        <div class="course-statistics-sort-bg"></div>
        <div class="course-statistics-sort-wrap">
            <div class="course-statistics-sort-wrap-header">
                <p>مرتب سازی بر اساس</p>
                <img class="sort-header-logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
            </div>
            <div class="course-statistics-sort-wrap-radio">
                <span>
                    <input type="radio" name="course-statistics-sort-radio" class="course-statistics-sort-radio" data-sort="students" data-author-id="<?php echo $instructor_id ?>">
                    <p>
                        <?php esc_html_e('تعداد فراگیران', 'edumall-child'); ?>
                    </p>
                </span>
                <span>
                    <input type="radio" name="course-statistics-sort-radio" class="course-statistics-sort-radio" data-sort="earn" data-author-id="<?php echo $instructor_id ?>">
                    <p>
                        <?php esc_html_e('کل درآمد', 'edumall-child'); ?>
                    </p>
                </span>
            </div>
        </div>
    </div>
</div>