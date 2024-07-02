<?php
/* 
Template Name: Landing Page
 */
get_header();
$course_tags = tutor_utils()->get_course_tags();
$course_categories = tutor_utils()->get_course_categories();
$course_counter = 0;

$popular_instructors = $landing_page_init->get_popular_instructors();

$freeCoursesArgs =
    [
        'post_type' => 'courses',
        'posts_per_page' => 7,
        'meta_query' => [
            [
                'key' => '_tutor_course_price_type',
                'value' => "free",
                'compare' => '=',
            ]
        ],
    ];

$freeCoursesQuery = new WP_Query($freeCoursesArgs);

$tutor = new Edumall_Tutor();

$courses_archive_url = get_post_type_archive_link('courses');

?>

<main class="home">

    <div class="home-slider" data-pagination="true">
        <div class="swiper-wrapper home-slider-wrapper">
            <div class="swiper-slide home-slider-wrapper-item">
                <div class="home-slider-wrapper-item-image">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Banner.png' ?>" alt="">
                </div>
            </div>
            <div class="swiper-slide home-slider-wrapper-item">
                <div class="home-slider-wrapper-item-image">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Banner1.png' ?>" alt="">
                </div>
            </div>
        </div>
        <div class="home-slider-pagination swiper-pagination"></div>
    </div>

    <div class="home-tags" data-slides="<?php echo count($course_tags) > 3 ? 3 : 1 ?>" data-space="12" data-free="true" data-speed="5000" data-loop="true" data-autoplay="5000">
        <div class="swiper-wrapper home-tags-wrapper">
            <?php foreach ($course_tags as $tag) : ?>
                <div class="swiper-slide home-tags-wrapper-item">
                    <a href="<?php echo get_term_link($tag->term_id) ?>">#<?php echo $tag->name ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="home-free">
        <div class="home-free-title">
            <h2><?php echo esc_html_e('دوره های رایگان', 'edumall-child') ?></h2>
        </div>
        <div class="home-free-categories">
            <a href="#" class="active" data-category="all"><?php echo esc_html_e('همه', 'edumall-child') ?></a>
            <?php foreach ($course_categories as $index => $category) : ?>
                <?php if ($category->count > 0) : ?>
                    <a href="#" data-category="<?php echo $category->term_id ?>"><?php echo $category->name ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="home-free-content">
            <div class="home-free-content-slider" data-nav="true">
                <?php if ($freeCoursesQuery->have_posts()) : ?>
                    <div class="swiper-wrapper home-free-content-slider-wrap">
                        <?php while ($freeCoursesQuery->have_posts()) :
                            $freeCoursesQuery->the_post();
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
                            <div class="swiper-slide home-free-content-slider-wrap-item">
                                <a href="<?php echo get_the_permalink() ?>">
                                    <div class="pics">
                                        <span class="pics-author">
                                            <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                        </span>
                                        <span class="pics-thumbnail">
                                            <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                                        </span>
                                        <span class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                            <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                            <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                                        </span>
                                    </div>
                                    <div class="captions">
                                        <div class="captions-meta">
                                            <div class="captions-meta-title">
                                                <p>
                                                    <?php echo get_the_title() ?>
                                                </p>
                                            </div>
                                            <div class="captions-meta-info">
                                                <span class="captions-meta-info-item">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.svg' ?>" alt="">
                                                    <p><?php echo $course_instructors[0]->display_name ?></p>
                                                </span>
                                                <span class="captions-meta-info-item">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                                    <?php if (!empty($course_category)) : ?>
                                                        <?php foreach ($course_category as $category) : ?>
                                                            <p class="captions-meta-info-item-category"><?php echo $category->name ?></p>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="captions-meta-info-item">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.svg' ?>" alt="">
                                                    <p>
                                                        <?php echo $course_rating->rating_avg ?>
                                                    </p>
                                                    <p class="captions-meta-info-item-reviews">
                                                        (<?php echo $course_rating->rating_count ?> نظر)
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <?php echo $landing_page_init->get_the_course_price() ?>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                        <div class="swiper-slide home-more-slides">
                            <a href="<?php echo $courses_archive_url ?>">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                            </a>
                        </div>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
            <?php if ($freeCoursesQuery->post_count > 1) : ?>
                <div class="home-free-content-nav-btn">
                    <img class="btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                    <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="home-all">
        <div class="home-all-bg"> </div>
        <div class="home-all-title">
            <h2><?php echo esc_html_e('دوره‌ها', 'edumall-child') ?></h2>
        </div>
        <?php foreach ($course_categories as $index => $category) : ?>
            <?php
            if ($category->count > 0) :
                $paidCoursesArgs =
                    [
                        'post_type' => 'courses',
                        'posts_per_page' => 7,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'course-category',
                                'field' => 'term_id',
                                'terms' => $category->term_id,
                            )
                        ),
                    ];

                $paidCoursesQuery = new WP_Query($paidCoursesArgs);
            ?>
                <div class="home-all-category <?php echo $course_counter === 0 ? 'active' : '' ?>">
                    <div class="home-all-category-meta" data-category="<?php echo $category->term_id ?>">
                        <div class="home-all-category-meta-title">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $category->slug . '.png' ?>" alt="">
                            <p><?php echo $category->name ?></p>
                        </div>
                        <div class="home-all-category-meta-link">
                            <a href="#"><?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?></a>
                            <img class="home-all-category-meta-link-add" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/add-circle.svg' ?>" alt="">
                            <img class="home-all-category-meta-link-minus" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/minus-cirlce.svg' ?>" alt="">
                        </div>
                    </div>
                    <?php if ($course_counter === 0) : ?>
                        <div class="home-all-content">
                            <div class="home-all-content-slider" data-nav="true">
                                <?php if ($paidCoursesQuery->have_posts()) : ?>
                                    <div class="swiper-wrapper home-all-content-slider-wrap">
                                        <?php while ($paidCoursesQuery->have_posts()) :
                                            $paidCoursesQuery->the_post();
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
                                            <div class="swiper-slide home-all-content-slider-wrap-item">
                                                <a href="<?php echo get_the_permalink() ?>">
                                                    <div class="pics">
                                                        <span class="pics-author">
                                                            <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                                        </span>
                                                        <span class="pics-thumbnail">
                                                            <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                                                        </span>
                                                        <span class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                                            <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                                            <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="captions">
                                                        <div class="captions-meta">
                                                            <div class="captions-meta-title">
                                                                <p>
                                                                    <?php echo get_the_title() ?>
                                                                </p>
                                                            </div>
                                                            <div class="captions-meta-info">
                                                                <span class="captions-meta-info-item">
                                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.svg' ?>" alt="">
                                                                    <p><?php echo $course_instructors[0]->display_name ?></p>
                                                                </span>
                                                                <span class="captions-meta-info-item">
                                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
                                                                    <?php foreach ($course_category as $category) : ?>
                                                                        <p class="captions-meta-info-item-category"><?php echo $category->name ?></p>
                                                                    <?php endforeach; ?>
                                                                </span>
                                                                <span class="captions-meta-info-item">
                                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.svg' ?>" alt="">
                                                                    <p><?php echo $course_rating->rating_avg ?></p>
                                                                    <p class="captions-meta-info-item-reviews">
                                                                        (<?php echo $course_rating->rating_count ?> نظر)
                                                                    </p>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?php echo $landing_page_init->get_the_course_price() ?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endwhile; ?>
                                        <div class="swiper-slide home-more-slides">
                                            <a href="<?php echo $courses_archive_url ?>">
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                                <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($paidCoursesQuery->post_count > 1) : ?>
                                <div class="home-all-content-nav-btn">
                                    <img class="btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                                    <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif; ?>
                </div>
        <?php endif;
            $course_counter++;
        endforeach; ?>
    </div>

    <div class="home-instructors">
        <div class="home-instructors-bg"> </div>
        <div class="home-instructors-title">
            <h2><?php echo esc_html_e('محبوب‌ترین مدرس‌های هانیل', 'edumall-child') ?></h2>
        </div>
        <div class="home-instructors-content">
            <div class="home-instructors-content-slider" data-slides="2" data-space="16" data-nav="true">
                <div class="swiper-wrapper">
                    <?php foreach ($popular_instructors as $instructor) : ?>
                        <?php
                        $total_students    = (int) $instructor->tutor_profile_total_students;
                        $total_courses     = Edumall_Tutor::instance()->get_total_courses_by_instructor($instructor->ID);
                        $profile_url       = tutor_utils()->profile_url($instructor->ID);
                        $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                        $profile_placeholder = Edumall_Helper::placeholder_avatar_src();
                        $profile_photo_id    = get_user_meta($instructor->ID, '_instructor_profile_pic', true);
                        ?>
                        <div class="swiper-slide home-instructors-content-slider-item">
                            <a href="<?php echo esc_url($profile_url); ?>" class="home-instructors-content-slider-item-wrap">
                                <div class="home-instructors-content-slider-item-header">
                                    <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                </div>
                                <div class="home-instructors-content-slider-item-footer">
                                    <div class="home-instructors-content-slider-item-footer-specs">
                                        <h6 class="info-meta-name">
                                            <?php echo esc_html($instructor->display_name); ?>
                                        </h6>

                                        <?php if (!empty($instructor->tutor_profile_job_title)) : ?>
                                            <p class="info-meta-job">
                                                <?php echo esc_html($instructor->tutor_profile_job_title); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="home-instructors-content-slider-item-footer-review">
                                        <div class="info-meta-rating">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.svg' ?>" alt="">
                                            <?php if ($instructor_rating->rating_count > 0) : ?>
                                                <p>
                                                    <?php echo Edumall_Helper::number_format_nice_float($instructor_rating->rating_avg); ?>
                                                </p>
                                            <?php else : ?>
                                                <p>
                                                    <?php echo Edumall_Helper::number_format_nice_float(0); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <span class="info-meta-separator"></span>
                                        <div class="info-meta-students">
                                            <p>
                                                <?php
                                                echo esc_html(sprintf(
                                                    _n('%s student', '%s students', $total_students, 'edumall-child'),
                                                    number_format_i18n($total_students)
                                                ));
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (count($popular_instructors) > 2) : ?>
                <div class="home-instructors-content-nav-btn">
                    <img class="btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                    <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="home-become-instructor">
        <div class="home-become-instructor-bg"> </div>

        <div class="home-become-instructor-banner">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/become-instructor.png' ?>" alt="">
            <p>
                <?php echo esc_html_e('بنر تبلیغ مدرس شو!', 'edumall-child') ?>
            </p>
        </div>
    </div>

    <!-- TODO -->
    <!-- Implement Events -->
    <div class="home-events"></div>

    <div class="home-banner"></div>

    <!-- TODO -->
    <!-- Implement Special Offer -->
    <div class="home-special"></div>
</main>

<?php get_footer(); ?>