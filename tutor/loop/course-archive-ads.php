<?php

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;
$landing_page_init = new LandingPage;
$tutor = new Edumall_Tutor();
// Set up the arguments for the query
$args = array(
    'post_type' => 'courses',
    'posts_per_page' => 6,
);
// Execute the query
$courses_query = new WP_Query($args);
?>

<div class="course-archive-ads">
    <div class="course-archive-ads-header">
        <h3>
            <?php esc_html_e('به صرفه‌ها', 'edumall-child'); ?>
        </h3>
    </div>

    <div class="course-archive-slider">
        <div class="swiper-wrapper">
            <?php
            $post_count = 0;

            // Start the Loop
            while ($courses_query->have_posts()) : $courses_query->the_post();
                $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());

                $profile_placeholder = Edumall_Helper::placeholder_avatar_src();
                $profile_photo_id    = get_user_meta($course_instructors[0]->ID, '_instructor_profile_pic', true);
                $course_rating = $tutor->get_course_rating(get_the_ID());
                $course_category = $tutor->get_the_categories();
                $bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');

                $course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';
                $thumbnail_size = '327x210';
                $course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
                    'post_id' => get_the_ID(),
                    'size'    => $thumbnail_size,
                ));
            ?>
                <div class="course-archive-slider-item swiper-slide">
                    <a href="<?php echo get_the_permalink() ?>">
                        <div class="item-pics">
                            <span class="item-pics-author">
                                <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                            </span>
                            <span class="item-pics-thumbnail">
                                <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                            </span>
                            <span class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                            </span>
                        </div>
                        <div class="item-captions">
                            <div class="item-captions-meta">
                                <div class="item-captions-meta-title">
                                    <p>
                                        <?php echo get_the_title() ?>
                                    </p>
                                </div>
                                <div class="item-captions-meta-info">
                                    <span class="item-captions-meta-info-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.svg' ?>" alt="">
                                        <p><?php echo $course_instructors[0]->display_name ?></p>
                                    </span>
                                    <span class="item-captions-meta-info-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                        <?php if (!empty($course_category)) : ?>
                                            <?php foreach ($course_category as $category) : ?>
                                                <p class="item-captions-meta-info-item-category"><?php echo $category->name ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </span>
                                    <span class="item-captions-meta-info-item">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.svg' ?>" alt="">
                                        <p><?php echo $course_rating->rating_avg ?></p>
                                        <p class="item-captions-meta-info-item-reviews">
                                            (<?php echo $course_rating->rating_count ?> نظر)
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <?php echo $landing_page_init->get_the_course_price() ?>
                        </div>
                    </a>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>