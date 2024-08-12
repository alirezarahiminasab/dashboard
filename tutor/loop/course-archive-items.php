<?php

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;
$landing_page_init = new LandingPage;
$tutor = new Edumall_Tutor();

global $wp;

// Set up the arguments for the query
$course_category_id = isset($_GET['tutor-course-filter-category']) ? $_GET['tutor-course-filter-category'] : NUll;
$current_page = !empty($_GET['current_page']) ? $_GET['current_page'] : 1;
$args = array(
    'post_type' => 'courses',
    'posts_per_page' => 6,
    'paged' => $current_page,
);

if (isset($course_category_id)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'course-category',
            'field' => 'term_id',
            'terms' => $course_category_id,
        ),
    );
}

// Execute the query
$courses_query = new WP_Query($args);

$query_arg = 'current_page';
$page_url = add_query_arg($wp->query_vars, home_url());


// Check if there are posts
if ($courses_query->have_posts()) :
?>
    <div class="course-archive-wrap">
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
            $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
            $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
            $full_name = trim($first_name . ' ' . $last_name);
        ?>
            <div class="course-archive-wrap-item">
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
                                    <p><?php echo esc_html($full_name) ?></p>
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
            // Insert the slider after the third post
            if (($courses_query->current_post + 1) === 3 || ($courses_query->post_count) < 3) :
                // Assuming you have a function or shortcode for the slider
                tutor_load_template('loop/course-archive-ads');
            endif;

        endwhile;
        ?>

        <div class="pagination">
            <?php echo paginate_links(
                array(
                    'format'  => '?current_page=%#%',
                    'before_page_number' => "<p>",
                    'after_page_number' => "</p>",
                    'prev_text' => "",
                    'next_text' => "",
                    'current' => $current_page,
                    'total'   => $courses_query->max_num_pages,
                )
            ); ?>
        </div>
    </div>

<?php
    // Reset post data
    wp_reset_postdata();
else :
    echo '<p>No courses found.</p>';
endif;
?>