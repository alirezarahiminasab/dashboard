<?php

$author_id = get_post_field('post_author', get_the_ID());
$type      = get_post_meta(get_the_ID(), 'tp_event_type', true);
$location = get_post_meta(get_the_ID(), Edumall_Event::POST_META_SHORT_LOCATION, true);

$event_terms = get_the_terms(get_the_ID(), 'tp_event_category');
$categories = '';
foreach ($event_terms as $index => $term) {
    $categories .= $index == 0 ? $term->name :  "، " . $term->name;
}

$fc_args = array(
    'post_type' => 'tp_event', // Change 'events' to the actual post type slug
    'posts_per_page' => -1, // Retrieve all posts
    'author' => $author_id
);
// Create a new instance of WP_Query
$fc_query = new WP_Query($fc_args);

$date_format = "l d F Y";
$date_start  = get_post_meta(get_the_ID(), 'tp_event_date_start', true);
$date_start  = !empty($date_start) ? strtotime($date_start) : time();

$date_end = get_post_meta(get_the_ID(), 'tp_event_date_end', true);
$date_end = !empty($date_end) ? strtotime($date_end) : time();

$time_format = "H:i";
$time_start  = wpems_event_start($time_format);
$time_end    = wpems_event_end($time_format);
$date_string = wp_date($date_format, $date_start);
?>
<div class="instructor-events">
    <div class="title">
        <p>
            <?php esc_html_e("Other instructor events", 'edumall-child') ?>
        </p>
    </div>
    <div class="instructor-slider-wrapper">
        <div class="instructor-events-slider">
            <div class="swiper-wrapper">
                <?php
                // Check if there are any posts
                if ($fc_query->have_posts()) {
                    // Loop through the posts
                    while ($fc_query->have_posts()) {
                        $fc_query->the_post();
                        $author_id = get_post_field('post_author', get_the_ID());
                        $event           = new WPEMS_Event(get_the_ID());
                        $author = get_userdata($author_id);
                        $terms = wp_get_post_terms(get_the_ID(), 'tp-event-category');
                        $regularPrice = number_format($event->get_price(), 0);
                        $salePrice = '';
                        $feature_image = get_the_post_thumbnail_url(get_the_ID());

                        $author_img = edumall_get_avatar($author_id, 32);

                        if (empty($author_img)) {
                            ob_start();
                            edumall_get_avatar($author_id, 32); // Assuming this function prints the avatar
                            $author_img = ob_get_clean();
                        }

                        $bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
                        // Output the events information
                ?>
                        <div class="swiper-slide">
                            <div class="image-wrapper">
                                <div class="profile">
                                    <?php echo $author_img ?>
                                </div>
                                <div class="background">
                                    <?php
                                    if ($feature_image) :
                                        Edumall_Image::the_post_thumbnail();
                                    else :
                                    ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/event-Banner.png' ?>" alt="">
                                    <?php
                                    endif;
                                    ?>
                                </div>
                                <div class="bookmark" data-type="event" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('رویداد', 'edumall-child'); ?>">
                                    <img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
                                    <img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
                                </div>
                                <?php if ($type === "live") : ?>
                                    <div class="online">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/status-online.png' ?>" alt="">
                                        <p><?php esc_html_e('Online', 'edumall-child') ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="content-wrapper">
                                <div class="date">
                                    <p><?php echo  esc_html($date_string) . " " . __('time', 'edumall-child') . " " . esc_html($time_start); ?></p>
                                </div>
                                <div class="title">
                                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>
                                <div class="meta-item">
                                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/teacher.png' ?>" alt="">
                                    <p><?php echo $author->display_name ?></p>
                                </div>
                                <div class="meta-item">
                                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.png' ?>" alt="">
                                    <p><?php echo $categories ?></p>
                                </div>
                                <div class="meta-item">
                                    <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/location-black.png" ?>>
                                    <?php if ($type === "live") : ?>
                                        <p><?php echo esc_html__('Online', 'edumall-child'); ?></p>
                                    <?php else : ?>
                                        <p><?php echo esc_html($location); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="price">
                                    <?php if ($salePrice) : ?>
                                        <div class="price-sale">
                                            <p class="value"><?php echo $salePrice;  ?></p>
                                            <p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
                                        </div>
                                        <div class="price-regular sale">
                                            <p class="rate"><?php echo $ratePrice . '%' ?></p>
                                            <p class="value"><?php echo $regularPrice  ?></p>
                                            <p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
                                        </div>
                                    <?php else : ?>
                                        <div class="price-regular">
                                            <p class="value"><?php echo $regularPrice;  ?></p>
                                            <p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                <?php
                        // Additional information can be retrieved as needed

                    }

                    // Restore original post data
                    wp_reset_postdata();
                } else {
                    // No posts found
                    echo 'No free events found.';
                }
                ?>
            </div>
        </div>

        <!-- If we need navigation buttons -->
        <div class="slider-button slider-button-prev">
            <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
        </div>
        <div class="slider-button slider-button-next">
            <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
        </div>
    </div>
</div>