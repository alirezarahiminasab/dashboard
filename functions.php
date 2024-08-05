<?php
defined('ABSPATH') || exit;
require __DIR__  . '/vendor/autoload.php';

/**
 * Enqueue child scripts
 */
if (!function_exists('edumall_child_enqueue_scripts')) {
	function edumall_child_enqueue_scripts()
	{


		wp_enqueue_style('edumall-child-style', get_stylesheet_directory_uri() . '/style.css');
		wp_enqueue_style('edumall-child-main-style', get_stylesheet_directory_uri() . '/build/main/index.css');
		wp_enqueue_script('edumall-child-main-script', get_stylesheet_directory_uri() . "/build/main/index.js", ['jquery'], time(), true);
		wp_localize_script('edumall-child-main-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'),));

		if (is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$args = array(
				'post_type' => 'ticket',
				'author'    => $current_user->ID,
				'meta_query' => array(
					array(
						'key' => '_new_admin_comment',
						'value' => true,
					),
				),
			);

			$tickets = new WP_Query($args);
			if ($tickets->have_posts()) {
				wp_localize_script('edumall-child-main-script', 'newCommentParams', array(
					'hasNewComment' => true
				));
			} else {
				wp_localize_script('edumall-child-main-script', 'newCommentParams', array(
					'hasNewComment' => false
				));
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'edumall_child_enqueue_scripts', 15);

function redirect_non_admin_users()
{
	if (!is_front_page() && !current_user_can('administrator')) {
		wp_redirect(home_url());
		exit;
	}
}

add_filter('woocommerce_template_path', 'woocommerce_child_theme_template_path');
function woocommerce_child_theme_template_path($template_path)
{
	$template_path = get_stylesheet_directory_uri() . '/woocommerce/';
	return $template_path;
}

/**
 * Enqueue Editor assets.
 */
function hanil_blocks()
{
	$blocks = [
		'name' => 'slider',
		'name' => 'tags'
	];

	foreach ($blocks as $block) :
		register_block_type(__DIR__ . "/build/hanil-{$block}");
	endforeach;
}
add_action('init', 'hanil_blocks');
// add_action('template_redirect', 'redirect_non_admin_users');

add_action('after_setup_theme', 'edumall_lang_setup');

function edumall_lang_setup()
{
	$lang = apply_filters('edumall', get_template_directory()  . '/languages');
	load_theme_textdomain('edumall', $lang);
	load_child_theme_textdomain('edumall-child', get_stylesheet_directory() . '/languages');
}

// Disable admin bar for non-admin users
function disable_admin_bar_for_non_admins()
{
	// Check if the current user is not an administrator and is not in the admin area
	if (!current_user_can('administrator') && !is_admin()) {
		// Hide the admin bar for non-admin users
		show_admin_bar(false);
	}
}

function dartcreations_remove_version()
{
	return '';
}
add_filter('the_generator', 'dartcreations_remove_version');

remove_action('wp_head', 'wp_generator');

function cart_discount_box($coupon_html, $coupon, $discount_amount_html)
{
	$coupon_html          =  ' <a href="' . esc_url(add_query_arg('remove_coupon', rawurlencode($coupon->get_code()),  wc_get_cart_url())) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr($coupon->get_code()) . '">' . __('Remove', 'woocommerce') . '</a>';
	$coupon_data = $coupon_html;
	return $coupon_data;
}

add_filter('woocommerce_cart_totals_coupon_html', 'cart_discount_box', 10, 3);
// Hook the function to run on theme activation
add_action('after_setup_theme', 'disable_admin_bar_for_non_admins');

include(dirname(__FILE__) . "/inc/roles.php");
include(dirname(__FILE__) . "/inc/custom-menu.php");
include(dirname(__FILE__) . "/inc/custom-endpoint.php");
include(dirname(__FILE__) . "/inc/custom-taxonomies.php");
// include(dirname(__FILE__) . "/inc/course-custom-fields.php");
include(dirname(__FILE__) . "/inc/custom-filters.php");
include(dirname(__FILE__) . "/inc/custom-search.php");
include(dirname(__FILE__) . "/inc/course-extend.php");
include(dirname(__FILE__) . "/inc/event-class.php");
include(dirname(__FILE__) . "/inc/dequeue-scripts.php");
include(dirname(__FILE__) . "/inc/user-custom-query.php");
include(dirname(__FILE__) . "/inc/instructor-dashboard.php");
include(dirname(__FILE__) . "/inc/landing-page-function.php");

// add_action('init', 'load_event_class');

// function load_event_class() {
//     include(get_stylesheet_directory() . '/inc/event-class.php');
// }
