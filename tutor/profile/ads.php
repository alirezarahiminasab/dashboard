<?php

use Detection\MobileDetect;

$detect = new MobileDetect();
$args = array(
    'post_type' => 'ads',
    'posts_per_page' => 2,
    'orderby' => 'rand' // Display a random ad
);
$ads_query = new WP_Query($args);
?>
<div class="bio-ads-wrap">
    <?php if ($detect->isMobile()) : ?>
        <div class="ads-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bio-ads.png'; ?>" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bio-ads.png'; ?>" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bio-ads.png'; ?>" alt="">
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!-- If we need navigation buttons -->
        <div class="ads-button-prev ads-button">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bio-arrow-square-left.png'; ?>" alt="">
        </div>
        <div class="ads-button-next ads-button">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bio-arrow-square-right.png'; ?>" alt="">
        </div>
    <?php else : ?>
        <?php if ($ads_query->have_posts()) {
            while ($ads_query->have_posts()) {
                $ads_query->the_post();
                $ads_link = get_post_meta(get_the_ID(), 'ads_link', true);
        ?>
                <div class="bio-ads-wrap-item">
                    <a href="<?php echo $ads_link ? esc_url($ads_link) : '#'; ?>" target="_blank">
                        <?php the_post_thumbnail(); ?>
                    </a>
                </div>
        <?php
            }
            wp_reset_postdata();
        }
        ?>
    <?php endif; ?>
</div>