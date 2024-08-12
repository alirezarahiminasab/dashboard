<?php
/* 
Template Name: Landing Page
 */
defined('ABSPATH') || exit;
get_header();

use Detection\MobileDetect;

$detect = new MobileDetect();
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

$specialCoursesArgs =
    [
        'post_type' => 'courses',
        'posts_per_page' => 7,
        'tax_query' => [
            [
                'taxonomy' => 'course-category',
                'field' => 'slug',
                'terms' => 'special',
            ]
        ]
    ];

$specialCoursesQuery = new WP_Query($specialCoursesArgs);

$tutor = new Edumall_Tutor();

$courses_archive_url = get_post_type_archive_link('courses');

?>

<main class="home">
    <?php if ($detect->isMobile()) : ?>
        <div class="home-slider" data-pagination="true">
            <div class="swiper-wrapper home-slider-wrapper">
                <div class="swiper-slide home-slider-wrapper-item">
                    <div class="home-slider-wrapper-item-image">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/kartoshe mobile.jpg' ?>" alt="">
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
    <?php else : ?>
        <div class="home-desktop-slider">
            <div class="home-slider" data-pagination="true">
                <div class="swiper-wrapper home-slider-wrapper">
                    <div class="swiper-slide home-slider-wrapper-item">
                        <div class="home-slider-wrapper-item-image">
                            <a href="<?php echo site_url('/courses/%d8%af%d9%88%d8%b1%d9%87-%d8%a2%d9%85%d9%88%d8%b2%d8%b4%db%8c-%da%a9%d9%88%d9%84%d9%87-%d9%be%d8%b4%d8%aa%db%8c/') ?>">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/kartoshe mobile.jpg' ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide home-slider-wrapper-item">
                        <div class="home-slider-wrapper-item-image">
                            <a href="<?php echo site_url('') ?>">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Banner1.png' ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="home-slider-pagination swiper-pagination"></div>
            </div>
            <div class="home-desktop-slider-ads">
                <?php
                $thumbnail_size = '408x230';
                $course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
                    'post_id' => 1926,
                    'size'    => $thumbnail_size,
                ));
                ?>
                <a href="<?php echo get_the_permalink(1926) ?>">
                    <img src="<?php echo $course_thumb ?>" alt="">
                </a>
            </div>
            <div class="home-desktop-slider-ads">
                <?php
                $thumbnail_size = '408x230';
                $course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
                    'post_id' => 161,
                    'size'    => $thumbnail_size,
                ));
                ?>
                <a href="<?php echo get_the_permalink(161) ?>">
                    <img src="<?php echo $course_thumb ?>" alt="">
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="home-tags" data-slides="<?php echo count($course_tags) > 3 ? $detect->isMobile() ? 3 : 10 : 1 ?>" data-space="12" data-free="true" data-speed="5000" data-loop="true" data-autoplay="5000">
        <div class="swiper-wrapper home-tags-wrapper">
            <?php foreach ($course_tags as $tag) : ?>
                <div class="swiper-slide home-tags-wrapper-item">
                    <a href="<?php echo get_term_link($tag->term_id) ?>">#<?php echo $tag->name ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="home-events">
        <div class="home-events-bg"> </div>
        <div class="home-events-title">
            <h2><?php echo esc_html_e('رویدادها', 'edumall-child') ?></h2>
        </div>
        <div class="home-events-categories">
            <p><?php echo esc_html_e('ویژه نوجوانان', 'edumall-child') ?></ح>
        </div>
        <div class="home-events-content">
            <div class="home-events-content-slider" data-nav="true" <?php echo !$detect->isMobile() ? "data-slides='4' data-space='24'" : '' ?>>
                <?php if ($specialCoursesQuery->have_posts()) : ?>
                    <div class="swiper-wrapper home-events-content-slider-wrap">
                        <?php while ($specialCoursesQuery->have_posts()) :
                            $specialCoursesQuery->the_post();
                            $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
                            $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
                            $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
                            $full_name = trim($first_name . ' ' . $last_name);

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
                            <div class="swiper-slide home-events-content-slider-wrap-item">
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
                                                    <p><?php echo esc_html($full_name) ?></p>
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
                        <?php if ($specialCoursesQuery->post_count > 4) : ?>
                            <div class="swiper-slide home-more-slides">
                                <a href="<?php echo $courses_archive_url ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                    <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
            <?php if ($specialCoursesQuery->post_count > 1 && $detect->isMobile()) : ?>
                <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
            <?php elseif ($specialCoursesQuery->post_count > 4) : ?>
                <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
            <?php endif ?>
        </div>
    </div>

    <div class="home-all">
        <div class="home-all-bg"> </div>
        <div class="home-all-title">
            <h2><?php echo esc_html_e('دوره‌ها', 'edumall-child') ?></h2>
        </div>
        <?php
        $paidCoursesArgs =
            [
                'post_type' => 'courses',
                'posts_per_page' => 7,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'course-category',
                        'field' => 'term_id',
                        'terms' => current($course_categories)->term_id,
                    )
                ),
            ];
        $paidCoursesQuery = new WP_Query($paidCoursesArgs);
        ?>
        <?php if (!$detect->isMobile()) : ?>
            <div class="home-all-desktop">
            <?php endif; ?>
            <?php foreach ($course_categories as $index => $category) :
                if ($category->count > 0) :

                    $category_link = get_term_link($category);
            ?>
                    <div class="home-all-category <?php echo $course_counter === 0 ? 'active' : '' ?>">
                        <div class="home-all-category-meta" data-category="<?php echo $category->term_id ?>" data-mobile="<?php echo $detect->isMobile() ? 'true' : 'false' ?>">
                            <div class="home-all-category-meta-title">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $category->slug . '.png' ?>" alt="">
                                <p><?php echo $category->name ?></p>
                            </div>
                            <?php if ($detect->isMobile()) : ?>
                                <div class="home-all-category-meta-link">
                                    <a href="<?php echo $category_link ?>" target="_blank"><?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?></a>
                                    <img class="home-all-category-meta-link-add" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/add-circle.svg' ?>" alt="">
                                    <img class="home-all-category-meta-link-minus" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/minus-cirlce.svg' ?>" alt="">
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if ($course_counter === 0 && $detect->isMobile()) : ?>
                            <div class="home-all-content">
                                <div class="home-all-content-slider" data-nav="true" <?php echo !$detect->isMobile() ? "data-slides='4' data-space='24'" : '' ?>>
                                    <?php if ($paidCoursesQuery->have_posts()) : ?>
                                        <div class="swiper-wrapper home-all-content-slider-wrap">
                                            <?php while ($paidCoursesQuery->have_posts()) :
                                                $paidCoursesQuery->the_post();
                                                $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
                                                $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
                                                $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
                                                $full_name = trim($first_name . ' ' . $last_name);

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
                                                                        <p><?php echo esc_html($full_name) ?></p>
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
                                <?php if ($paidCoursesQuery->post_count > 1 && $detect->isMobile()) : ?>
                                    <div class="home-all-content-nav-btn">
                                        <img class="btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                                        <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                                    </div>
                                <?php elseif ($paidCoursesQuery->post_count > 4) : ?>
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
            <?php if (!$detect->isMobile()) : ?>
            </div>
        <?php endif; ?>

        <?php if (!$detect->isMobile()) : ?>
            <div class="home-all-content">
                <div class="home-all-content-slider" data-nav="true" <?php echo !$detect->isMobile() ? "data-slides='4' data-space='24'" : '' ?>>
                    <?php if ($paidCoursesQuery->have_posts()) : ?>
                        <div class="swiper-wrapper home-all-content-slider-wrap">
                            <?php while ($paidCoursesQuery->have_posts()) :
                                $paidCoursesQuery->the_post();
                                $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
                                $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
                                $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
                                $full_name = trim($first_name . ' ' . $last_name);

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
                                                        <p><?php echo esc_html($full_name) ?></p>
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
                            <?php if ($paidCoursesQuery->post_count > 4) : ?>
                                <div class="swiper-slide home-more-slides">
                                    <a href="<?php echo $courses_archive_url ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                        <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($paidCoursesQuery->post_count > 1 && $detect->isMobile()) : ?>
                    <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                    <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                <?php elseif ($paidCoursesQuery->post_count > 4) : ?>
                    <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                    <img class="btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>

    <div class="home-free">
        <div class="home-free-bg"> </div>
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
            <div class="home-free-content-slider" data-nav="true" <?php echo !$detect->isMobile() ? "data-slides='4' data-space='24'" : '' ?>>
                <?php if ($freeCoursesQuery->have_posts()) : ?>
                    <div class="swiper-wrapper home-free-content-slider-wrap">
                        <?php while ($freeCoursesQuery->have_posts()) :
                            $freeCoursesQuery->the_post();
                            $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
                            $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
                            $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
                            $full_name = trim($first_name . ' ' . $last_name);

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
                                                    <p><?php echo esc_html($full_name) ?></p>
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
                        <?php if ($freeCoursesQuery->post_count > 4 && !$detect->isMobile()) : ?>
                            <div class="swiper-slide home-more-slides">
                                <a href="<?php echo $courses_archive_url ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                    <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="swiper-slide home-more-slides">
                                <a href="<?php echo $courses_archive_url ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/more-slides.svg' ?>" alt="">
                                    <?php echo esc_html_e('مشاهده بیشتر', 'edumall-child') ?>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
            <?php if ($freeCoursesQuery->post_count > 1 && $detect->isMobile()) : ?>
                <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
            <?php elseif ($freeCoursesQuery->post_count > 4) : ?>
                <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
            <?php endif ?>
        </div>
    </div>

    <div class="home-instructors">
        <div class="home-instructors-bg"> </div>
        <div class="home-instructors-title">
            <h2><?php echo esc_html_e('محبوب‌ترین مدرس‌های هانیل', 'edumall-child') ?></h2>
        </div>
        <div class="home-instructors-content">
            <div class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>" data-slides="2" data-space="16" data-nav="true">
                <?php if ($detect->isMobile()) : ?>
                    <div class="swiper-wrapper">
                    <?php endif; ?>
                    <?php foreach ($popular_instructors as $index => $instructor) :
                        if ($index > 5) :
                            continue;
                        endif;
                        $total_students    = (int) $instructor->tutor_profile_total_students;
                        $total_courses     = Edumall_Tutor::instance()->get_total_courses_by_instructor($instructor->ID);
                        $profile_url       = tutor_utils()->profile_url($instructor->ID);
                        $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                        $profile_placeholder = Edumall_Helper::placeholder_avatar_src();
                        $profile_photo_id    = get_user_meta($instructor->ID, '_instructor_profile_pic', true);
                        $first_name = get_user_meta($instructor->ID, 'first_name', true);
                        $last_name = get_user_meta($instructor->ID, 'last_name', true);
                        $full_name = trim($first_name . ' ' . $last_name);
                    ?>
                        <div class="<?php echo $detect->isMobile() ? 'swiper-slide' : '' ?> home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item">
                            <a href="<?php echo esc_url($profile_url); ?>" class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item-wrap">
                                <div class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item-header">
                                    <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                </div>
                                <div class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item-footer">
                                    <div class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item-footer-specs">
                                        <h6 class="info-meta-name">
                                            <?php echo esc_html($full_name); ?>
                                        </h6>

                                        <?php if (!empty($instructor->tutor_profile_job_title)) : ?>
                                            <p class="info-meta-job">
                                                <?php echo esc_html($instructor->tutor_profile_job_title); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="home-instructors-content-<?php echo !$detect->isMobile() ? 'desktop' : 'slider' ?>-item-footer-review">
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
                    <?php if ($detect->isMobile()) : ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (count($popular_instructors) > 2 && $detect->isMobile()) : ?>
                <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
            <?php endif; ?>
        </div>
    </div>


</main>

<?php get_footer(); ?>