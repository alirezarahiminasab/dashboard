<?php

use CourseExtend\CourseExtend;
use Detection\MobileDetect;

$detect = new MobileDetect();

class LandingPage
{
    // Initialize the class
    function __construct()
    {
        add_action('wp_ajax_get_courses', array($this, 'get_courses'));
        add_action('wp_ajax_nopriv_get_courses', array($this, 'get_courses'));

        add_filter('tutor_get_course_categories_args', array(
            $this,
            'course_categories'
        ));
    }

    public function get_popular_instructors()
    {
        $args = [
            'post_type'      => Edumall_Tutor::instance()->get_course_type(),
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'no_found_rows'  => true,
            'fields'         => 'ids',
        ];

        $ids = get_posts($args);

        $popular_instructors = [];

        if ($ids) {
            $popular_instructors = Edumall_Tutor::instance()->get_popular_instructors_by_course_ids($ids);
        }


        return $popular_instructors;
    }

    public function get_the_course_price($course_id = null, $format = '-%s')
    {
        if (!$course_id) {
            $course_id = get_the_ID();
        }

        $is_purchasable = tutor_utils()->is_course_purchasable($course_id);
        $price          = apply_filters('get_tutor_course_price', null, $course_id);
        $product_id = tutor_utils()->get_course_product_id($course_id);

        if (!empty($product_id) && $price) {
            if (tutor_utils()->has_wc()) {
                $product    = wc_get_product($product_id);
                $_regular_price = $product->get_regular_price();

                if ($product && $product->is_on_sale()) :
                    $_sale_price    = $product->get_sale_price();
                    $percentage = number_format(($_sale_price / $_regular_price) * 100, 2);
?>
                    <div class="price">
                        <div class="price-regular on-sale">
                            <p class="price-regular-num">
                                <?php echo number_format($_regular_price) ?>
                            </p>
                            <p class="price-regular-percent">
                                <?php echo $percentage ?>٪
                            </p>
                        </div>
                        <div class="price-sale">
                            <p class="price-sale-num">
                                <?php echo number_format($_sale_price) ?>
                            </p>
                            <p class="price-sale-sign">
                                تومان
                            </p>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="price">
                        <div class="price-regular">
                            <p class="price-regular-num">
                                <?php echo number_format($_regular_price) ?>
                            </p>
                            <p class="price-regular-sign">
                                تومان
                            </p>
                        </div>
                    </div>
            <?php
                endif;
            }
        } else {
            ?>
            <div class="price">
                <div class="price-free">
                    <p>
                        رایگان!
                    </p>
                </div>
            </div>
        <?php
        }
    }

    public function course_categories($args)
    {
        $args['hide_empty'] = true;
        return $args;
    }

    public function get_courses()
    {
        global $detect;
        $category = sanitize_text_field($_POST['category']);
        $type = sanitize_text_field($_POST['type']);

        $courses_archive_url = get_post_type_archive_link('courses');

        $CoursesArgs =
            [
                'post_type' => 'courses',
                'post_status'    => 'publish',
                'posts_per_page' => 5,
                'tax_query' => array(
                    $category !== "all" ?
                        array(
                            'taxonomy' => 'course-category',
                            'field' => 'term_id',
                            'terms' => $category,
                        ) : ''
                ),
                'meta_query' => [
                    $type !== "all" ?    [
                        'key' => '_tutor_course_price_type',
                        'value' => $type,
                        'compare' => '=',
                    ] : ''
                ]
            ];


        $CoursesQuery = new WP_Query($CoursesArgs);
        $tutor = new Edumall_Tutor();
        $course_extend = new CourseExtend();

        ob_start(); ?>

        <div class="home-<?php echo $type ?>-content-slider" data-nav="true" <?php echo !$detect->isMobile() ?  "data-slides='4' data-space='24'" : '' ?>>
            <?php if ($CoursesQuery->have_posts()) : ?>
                <div class="swiper-wrapper home-<?php echo $type ?>-content-slider-wrap">

                    <?php while ($CoursesQuery->have_posts()) :
                        $CoursesQuery->the_post();
                        $course_instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
                        $course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';
                        $thumbnail_size = '327x210';
                        $course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
                            'post_id' => get_the_ID(),
                            'size'    => $thumbnail_size,
                        ));

                        $profile_placeholder = Edumall_Helper::placeholder_avatar_src();
                        $profile_photo_id    = get_user_meta($course_instructors[0]->ID, '_instructor_profile_pic', true);
                        $course_rating = $tutor->get_course_rating(get_the_ID());
                        $course_category = $tutor->get_the_categories();
                        $bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
                        $first_name = get_user_meta($course_instructors[0]->ID, 'first_name', true);
                        $last_name = get_user_meta($course_instructors[0]->ID, 'last_name', true);
                        $full_name = trim($first_name . ' ' . $last_name);
                    ?>
                        <div class="swiper-slide home-<?php echo $type ?>-content-slider-wrap-item">
                            <a href="<?php echo get_the_permalink() ?>">
                                <div class="pics">
                                    <span class="pics-author">
                                        <img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
                                    </span>
                                    <span class="pics-thumbnail">
                                        <img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
                                    </span>
                                    <span class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
                                        <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                                        <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
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
                                    <?php $this->get_the_course_price() ?>
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
        <?php if ($CoursesQuery->post_count > 1 && $detect->isMobile()) : ?>
            <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
            <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
        <?php elseif ($CoursesQuery->post_count > 4) : ?>
            <img class="home-slider-nav-btn btn-right" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
            <img class="home-slider-nav-btn btn-left" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
        <?php endif; ?>
<?php
        $result = ob_get_clean();

        wp_send_json(array('result' => $result));
    }
}

// Initialize the class
$landing_page_init = new LandingPage();
