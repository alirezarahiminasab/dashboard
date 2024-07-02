<?php
?>
<!-- TODO -->
<!-- Implement Bio Ads -->
<!-- Slider main container -->
<div class="bio-ads-wrap">
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
</div>