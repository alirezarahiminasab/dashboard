<?php
/**
 * The template for displaying all single portfolio posts.
 *
 * @package Edumall
 * @since   1.0
 */
$style = Edumall_Helper::get_post_meta( 'portfolio_layout_style', '' );
if ( '' === $style ) {
	$style = Edumall::setting( 'single_portfolio_style' );
}

if ( 'blank' === $style ) {
	edumall_load_template( 'portfolio/content-single', 'blank' );
} else {
	edumall_load_template( 'portfolio/content-single' );
}
