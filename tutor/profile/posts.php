<?php

$args = array(
    'posts_per_page' => -1, // Retrieve all posts
    'author' => $user_id
);

// Create a new instance of WP_Query
$query = new WP_Query($args);

?>
<!-- TODO -->
<!-- Implement Posts for instructor in profile public -->
<div class="instructor-posts-wrap">
    <!-- <div class="course-container">
        <div class="title">
            <p>
                <?php esc_html_e("پست‌های مربی", 'edumall-child') ?>
            </p>
        </div>
        <div class="posts">
            <?php
            // Check if there are any posts
            if ($query->have_posts()) :
                // Loop through the posts
                while ($query->have_posts()) :
                    $query->the_post();
                    $categories = get_the_category(get_the_ID()); //$post->ID
                    $categories_list = [];
                    foreach ($categories as $cd) {
                        array_push($categories_list, $cd->cat_name);
                    }
                    $categories_list = implode(' ', $categories_list);
                    $post_date = get_the_date('d M');
                    $author = get_the_author();
                    $feature_image = get_the_post_thumbnail_url(get_the_ID());
                    $comment_count = get_comments_number();
                    // Output the course information
            ?>
                    <div class="course-wrap">
                        <div class="feature-image">
                            <img src="<?php echo $feature_image ? $feature_image : get_stylesheet_directory_uri() . '/assets/images/Banner.png'; ?>" alt="">
                        </div>
                        <div class="post-meta">
                            <div class="meta-item author">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/user-square.png'; ?>" alt="">
                                <p>
                                    <?php echo $author; ?>
                                </p>
                            </div>
                            <div class="meta-item categories">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category-gray.png'; ?>" alt="">
                                <p>
                                    <?php echo $categories_list; ?>
                                </p>
                            </div>
                            <div class="meta-item date">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-gray.png'; ?>" alt="">
                                <p>
                                    <?php echo $post_date ?>
                                </p>
                            </div>
                        </div>
                        <div class="content-wrapper">
                            <div class="title">
                                <a href="<?php echo get_post_permalink(); ?>">
                                    <?php echo get_the_title(); ?>
                                </a>
                            </div>
                            <div class="caption">
                                <p>
                                    <?php echo get_the_content(); ?>
                                </p>
                            </div>
                        </div>
                        <!-- TODO -->
    <!-- Implement Like and Bookmark -->
    <div class="post-mention">
        <div class="social-item like">
            <a href="javascript:void(0);">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/heart-bio.png'; ?>" alt="">
            </a>
        </div>
        <div class="social-item comment">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/message-bio.png'; ?>" alt="">
            <p>
                <?php echo number_format_i18n($comment_count) ?>
            </p>
        </div>
        <div class="social-item bookmark">
            <a href="javascript:void(0);">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bookmark-bio.png'; ?>" alt="">
            </a>
        </div>
        <div class="social-item share">
            <a href="javascript:void(0);">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/share-bio.png'; ?>" alt="">
            </a>
        </div>
    </div>
</div>
<?php endwhile; ?>

// Restore original post data
<?php wp_reset_postdata(); ?>
<?php else : ?>
    <p>
        <?php echo esc_html__('هیچ پستی یافت نشد', 'edumall-child'); ?>
    </p>
<?php endif; ?>
</div>
</div> -->
</div>