<?php
/**
 * Template for displaying add to wishlist button.
 *
 * @since   v.1.0.0
 *
 * @author  ThemeMove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$button_classes = 'edumall-course-wishlist-btn wishlist-button-01';

if ( ! is_user_logged_in() ) {
	$button_classes .= ' open-popup-login';
}

$course_id     = get_the_ID();
$is_wishlisted = tutor_utils()->is_wishlisted( $course_id );

$button_wrapper_classes = '';
$button_text            = __( 'Add to wishlist', 'edumall' );

if ( $is_wishlisted ) {
	$button_wrapper_classes = 'added';
	$button_classes         .= ' has-wish-listed';
	$button_text            = __( 'Remove from wishlist', 'edumall' );
}

Edumall_Templates::render_button( [
	'link'          => [
		'url' => 'javascript:void(0);',
	],
	'text'          => $button_text,
	'style'         => 'flat',
	'extra_class'   => $button_classes,
	'attributes'    => [
		'data-course-id' => $course_id,
	],
	'wrapper_class' => $button_wrapper_classes,
] );
