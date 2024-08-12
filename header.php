<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Hanil
 */

use Detection\MobileDetect;

$detect = new MobileDetect();

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
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DVWHCM8ZEX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-DVWHCM8ZEX');
    </script>
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
    $profile_url  = tutor_utils()->get_tutor_dashboard_page_permalink();
    $profile_text = apply_filters('edumall_user_profile_text', esc_html__('Profile', 'edumall-child'));
    $profile_photo_id    = get_user_meta($user_id, '_instructor_profile_pic', true);
    $default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

    if (isset($args) && isset($args['reverse_scheme'])) {
        $reverse_scheme = $args['reverse_scheme'];
    }

    if ($detect->isMobile()) :
    ?>
        <header class="mobile-header">
            <div class="mobile-header-instructor">
                <?php if (!($is_instructor ||  $instructor_status) && is_user_logged_in()) : ?>
                    <a href="<?php echo $instructor_url ?>">
                        <?php esc_html_e('مربی شو', 'edumall-child'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="mobile-header-logo">
                <?php
                echo Edumall::branding_logo($reverse_scheme);
                ?>
            </div>

            <div class="mobile-header-components">
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
    <?php else : ?>
        <header class="desktop-header">
            <div class="desktop-header-logo">
                <?php
                echo Edumall::branding_logo($reverse_scheme);
                ?>
            </div>
            <nav class="desktop-header-menus">
                <ul>
                    <li>
                        <a href="<?php echo site_url() . '/courses' ?>">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/courses-desktop.svg' ?>" alt="">
                            دوره‌ها
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/events-desktop.svg' ?>" alt="">
                            رویدادها
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/magazine-desktop.svg' ?>" alt="">
                            مجله‌ها
                        </a>
                    </li> -->
                </ul>
            </nav>
            <div class="desktop-header-quest">
                <div class="desktop-header-quest-search">
                    <input type="text" placeholder="دنبال چه دوره/رویدادی میگردی؟">
                </div>
                <?php if (!($is_instructor ||  $instructor_status) && is_user_logged_in()) : ?>
                    <a href="<?php echo $instructor_url ?>">
                        <?php esc_html_e('مربی شو', 'edumall-child'); ?>
                    </a>
                <?php endif ?>
            </div>
            <div class="desktop-header-components">
                <!-- <div class="desktop-header-components-item">
                    <a href="javascript:void(0);">
                        <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/notification-desktop.svg" ?> alt="">
                        <p>
                            <?php esc_html_e('اعلان‌ها', 'edumall-child'); ?>
                        </p>
                    </a>
                </div> -->

                <div class="desktop-header-components-item">
                    <a class="desktop-header-components-item-link <?php echo !is_user_logged_in() ? 'open-login-popup' : 'desktop-header-profile' ?>" href="<?php echo !is_user_logged_in() ? 'javascript:void(0);' : esc_url($profile_url); ?>">
                        <?php if (!is_user_logged_in()) : ?>
                            <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/user-desktop.svg" ?> alt="">
                        <?php else : ?>
                            <img class="profile-picture" src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $default_thumbnail_src ?>" alt="">
                        <?php endif; ?>
                        <p>
                            <?php echo !is_user_logged_in() ? 'ورود/ثبت‌نام' : 'هانیل من' ?>
                        </p>
                    </a>
                    <?php if (is_user_logged_in()) : ?>
                        <div class="desktop-header-profile-menu">
                            <ul>
                                <?php if (($is_instructor ||  $instructor_status)) : ?>
                                    <li class="desktop-header-profile-menu-teaching">
                                        <a target="_blank" href="<?php echo $profile_url ?>">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/profile-icon-desktop.svg' ?>" alt="">
                                            <p>
                                                <?php esc_html_e('پروفایل تدریس', 'edumall-child'); ?>
                                            </p>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="desktop-header-profile-menu-learning">
                                    <a target="_blank" href="<?php echo $profile_url . '?menu=tutor' ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/profile-learning-icon-desktop.svg' ?>" alt="">
                                        <p>
                                            <?php esc_html_e('پروفایل یادگیری', 'edumall-child'); ?>
                                        </p>
                                    </a>
                                </li>
                                <?php if (($is_instructor ||  $instructor_status)) : ?>
                                    <li>
                                        <a target="_blank" href="<?php echo $profile_url . 'edit-instructor-info' ?>">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/user-edit.svg' ?>" alt="">
                                            <p>
                                                <?php esc_html_e('ویرایش اطلاعات کاربری', 'edumall-child'); ?>
                                            </p>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a target="_blank" href="<?php echo $profile_url . 'enrolled-courses' ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/my-courses-desktop.svg' ?>" alt="">
                                        <p>
                                            <?php esc_html_e('دوره‌های من', 'edumall-child'); ?>
                                        </p>
                                    </a>
                                </li>

                                <li>
                                    <a target="_blank" href="<?php echo $profile_url . 'bookmarks' ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bookmarks-desktop.svg' ?>" alt="">
                                        <p>
                                            <?php esc_html_e('نشان شده‌ها', 'edumall-child'); ?>
                                        </p>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo wp_logout_url(home_url()) ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logout-desktop.svg' ?>" alt="">
                                        <p>
                                            <?php esc_html_e('خروج از حساب کاربری', 'edumall-child'); ?>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="desktop-header-components-item">
                    <a class="desktop-header-components-item-link" href="<?php echo site_url('/cart') ?>">
                        <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/cart-desktop.svg" ?> alt="">
                        <p>
                            <?php esc_html_e('سبد خرید', 'edumall-child'); ?>
                        </p>
                    </a>
                </div>
            </div>
        </header>
    <?php endif; ?>

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