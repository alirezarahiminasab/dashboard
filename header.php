<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Hanil
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php html_class(); ?>>

<head>
    <?php Edumall_THA::instance()->head_top(); ?>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset', 'display')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url', 'display')); ?>">
    <?php endif; ?>
    <?php Edumall_THA::instance()->head_bottom(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php Edumall::body_attributes(); ?>>

    <?php wp_body_open(); ?>

    <?php Edumall_Templates::pre_loader(); ?>

    <?php
    $user_id = get_current_user_id();
    $is_instructor = boolval(tutor_utils()->is_instructor($user_id, true));
    $instructor_status = boolval(get_user_meta($user_id, '_tutor_instructor_status', true));
    $instructor_url = tutor_utils()->instructor_register_url();
    $reverse_scheme = null;

    if (isset($args) && isset($args['reverse_scheme'])) {
        $reverse_scheme = $args['reverse_scheme'];
    }
    ?>
    <header class="main-header">
        <div class="main-header-instructor">
            <?php if (!($is_instructor ||  $instructor_status)) : ?>
                <a href="<?php echo $instructor_url ?>">
                    <?php esc_html_e('مربی شو', 'edumall-child'); ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="main-header-logo">
            <?php
            echo Edumall::branding_logo($reverse_scheme);
            ?>
        </div>

        <div class="main-header-components">
            <div class="notification">
                <a href="javascript:void(0);">
                    <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/notification-bing.png" ?> alt="">
                </a>
            </div>
            <div class="search-icon">
                <a href="javascript:void(0);">
                    <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/search-normal.png" ?> alt="">
                </a>

            </div>
            <div class="basket">
                <a href="<?php echo site_url('/cart') ?>">
                    <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/bag-2.png" ?> alt="">
                </a>
            </div>
        </div>

        <div class="menu-wrapper">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'walker' => new Icon_Walker_Nav_Menu()
            ));
            ?>
        </div>
    </header>

    <div class="search-wrap">
        <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>" class="search-wrap-input">
            <img class="search-wrap-input-back" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.svg' ?>" alt="">
            <input type="text" name="s" id="search-wrap-input-value" placeholder="<?php esc_html_e('جستجو', 'edumall-child'); ?>">
            <img class="search-wrap-input-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
        </form>
        <!-- <div class="search-wrap-result">
            <div class="search-wrap-result-item result-courses">
                <header class="search-wrap-result-item-header">
                    <h5 class="search-wrap-result-item-header-title">
                        <?php esc_html_e('دوره‌های پربازدید', 'edumall-child'); ?>
                    </h5>
                </header>
                <footer class="search-wrap-result-item-footer"> </footer>
            </div>

            <div class="search-wrap-result-item result-events">
                <header class="search-wrap-result-item-header">
                    <h5 class="search-wrap-result-item-header-title">
                        <?php esc_html_e('رویداد‌های پربازدید', 'edumall-child'); ?>
                    </h5>
                </header>
                <footer class="search-wrap-result-item-footer">

                </footer>
            </div>

            <div class="search-wrap-result-item result-posts">
                <header class="search-wrap-result-item-header">
                    <h5 class="search-wrap-result-item-header-title">
                        <?php esc_html_e('محتواهای پربازدید', 'edumall-child'); ?>
                    </h5>
                </header>
                <footer class="search-wrap-result-item-footer">

                </footer>
            </div>

            <div class="search-wrap-result-item result-users">
                <header class="search-wrap-result-item-header">
                    <h5 class="search-wrap-result-item-header-title">
                        <?php esc_html_e('مربیان محبوب', 'edumall-child'); ?>
                    </h5>
                </header>
                <footer class="search-wrap-result-item-footer">

                </footer>
            </div>
        </div> -->
    </div>

    <div id="page" class="site">
        <div class="content-wrapper">