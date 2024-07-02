<?php

/**
 * Template part for displaying instructor meta on single page.
 *
 * 
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Instructors-Manager/Template
 * @version       1.0.0
 */

defined('ABSPATH') || exit;

use TUTOR\Input;

$author_reviews_info = tutor_utils()->get_instructor_ratings($user_id);
$author_total_reviews = $author_reviews_info->rating_count;
$author_rating_avg = $author_reviews_info->rating_avg;
$author_reviews       = tutor_utils()->get_reviews_by_instructor($user_id);
?>
<div class="instructor-reviews tutor-pagination-wrapper-replaceable">

    <div class="instructor-reviews-wrap">
        <div class="bio-reviews-title">
            <h4 class="bio-title">
                <?php echo esc_html__('نظرات فراگیران', 'edumall-child'); ?>
            </h4>

            <div class="bio-rating">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
                <p>
                    <?php
                    echo number_format($author_rating_avg, 1);
                    ?>
                </p>
                <p>
                    |
                </p>
                <p>
                    <?php echo $author_total_reviews . " " . esc_html__('reviews', 'edumall-child') ?>
                </p>
            </div>
        </div>

        <?php if ($author_reviews->count > 0) : ?>

            <div class="bio-reviews-slider-wrap">
                <div class="tutor-instructor-reviews-list">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php tutor_load_template('profile.reviews-loop', array('reviews' => $author_reviews->results)); ?>
                        </div>
                    </div>
                </div>

                <div class="slider-button slider-button-prev">
                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-left.png' ?>" alt="">
                </div>
                <div class="slider-button slider-button-next">
                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-square-right.png' ?>" alt="">
                </div>
            </div>
        <?php endif; ?>
    </div>


</div>