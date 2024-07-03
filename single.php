<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since   1.0
 */
get_header();

if ( is_singular( 'post' ) ):
	edumall_load_template( 'blog/content-single' );
else:
	edumall_load_template( 'global/content-single' );
endif;

get_footer();
