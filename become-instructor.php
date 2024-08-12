<?php

$loggedIn = is_user_logged_in();

if (!$loggedIn) {
    wp_redirect(home_url());
    exit;
}
/*
Template Name: Become Instructor
*/

/**
 * Template part for display instructor register form on popup.
 * 
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0.0
 * @version 2.8.4
 */
defined('ABSPATH') || exit;

get_header();

tutor_load_template('dashboard.apply_for_instructor');

get_footer();
