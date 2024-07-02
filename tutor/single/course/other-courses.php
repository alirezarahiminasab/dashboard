<?php

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;

$author_id = get_post_field('post_author', get_the_ID());
$fc_args = array(
    'post_type' => 'courses', // Change 'course' to the actual post type slug
    'posts_per_page' => -1, // Retrieve all posts
    'author' => $author_id,
    'post__not_in' => array(get_the_ID()), // Exclude the current post
);
$landing_page_init = new LandingPage();
// Create a new instance of WP_Query
$fc_query = new WP_Query($fc_args);

?>
<?php if ($fc_query->have_posts()) : ?>
    <div class="instructor-courses">
        <div class="title">
            <p>
                <?php esc_html_e("Other instructor courses", 'edumall-child') ?>
            </p>
        </div>
        <div class="instructor-slider-wrapper">
            <div class="instructor-courses-slider">
                <div class="swiper-wrapper">
                    <?php
                    // Check if there are any posts
                    // Loop through the posts
                    while ($fc_query->have_posts()) :
                        $fc_query->the_post();
                        $author_id = get_post_field('post_author', get_the_ID());
                        $author = get_userdata($author_id);
                        $rating = tutor_utils()->get_course_rating(get_the_ID());
                        $rating_count = $rating->rating_count;
                        $rating_avg = Edumall_Helper::number_format_nice_float($rating->rating_avg);
                        $price_type = tutor_utils()->price_type(get_the_ID()); // Get course price type
                        $price = tutor_utils()->get_raw_course_price(get_the_ID());
                        $regularPrice = (int)$price->regular_price;
                        $salePrice = (int)$price->sale_price;
                        $ratePrice = $salePrice > 0 ? number_format((($regularPrice - $salePrice) / $regularPrice) * 100, 0) : 0;
                        $terms = wp_get_post_terms(get_the_ID(), 'course-category');
                        $feature_image = get_the_post_thumbnail_url(get_the_ID());
                        $profile_photo_id    = get_user_meta($author_id, '_instructor_profile_pic', true);
                        $profile_placeholder = Edumall_Helper::placeholder_avatar_src();

                        $bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
                        // Output the course information
                    ?>
                        <div class="swiper-slide">
                            <div class="image-wrapper">
                                <div class="profile">
                                    <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                </div>
                                <div class="background">
                                    <img src="<?php echo $feature_image ? $feature_image : get_stylesheet_directory_uri() . '/assets/images/Banner.png'; ?>" alt="">
                                </div>
                                <div class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                    <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                    <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                                </div>
                            </div>
                            <div class="content-wrapper">
                                <div class="title">
                                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>
                                <div class="tutor">
                                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.png' ?>" alt="">
                                    <p><?php echo $author->display_name ?></p>
                                </div>
                                <div class="category">
                                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.png' ?>" alt="">
                                    <p><?php echo $terms ? $terms[0]->name : ''; ?></p>
                                </div>
                                <div class="rating-wrapper">
                                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
                                    <div class="rating">
                                        <p class="rating-avg"><?php echo $rating_avg ?></p>
                                        <p class="rating-count"><?php echo "(" . $rating_count . " " . esc_html__('person', 'edumall-child') . ")" ?> </p>
                                    </div>
                                </div>
                                <?php echo $landing_page_init->get_the_course_price() ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>

            <?php if ($fc_query->found_posts > 1) : ?>
                <!-- If we need navigation buttons -->
                <div class="slider-button slider-button-prev">
                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                </div>
                <div class="slider-button slider-button-next">
                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>