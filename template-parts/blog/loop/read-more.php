<?php
/**
 * The template for displaying loop read more.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;

Edumall_Templates::render_button( [
	'link'          => [
		'url' => get_the_permalink(),
	],
	'text'          => esc_html__( 'Read more', 'edumall' ),
	'icon'          => 'fa-light fa-long-arrow-right',
	'icon_align'    => 'right',
	'wrapper_class' => 'post-read-more',
	'extra_class'   => 'button-grey-white',
] );
