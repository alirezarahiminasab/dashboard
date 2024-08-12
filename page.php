<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */
get_header();

if (is_page('cart')) {
    // Do something.
    include(dirname(__FILE__) . "/woocommerce/cart/cart.php");
    return;
}

edumall_load_template('page/content-single');

get_footer();
