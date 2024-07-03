<?php
/**
 * Template part for displaying read more button on loop.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/read-more.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

Edumall_Templates::render_button( [
	'link'          => [
		'url' => get_the_permalink(),
	],
	'text'          => esc_html__( 'Get ticket', 'edumall' ),
	'size'          => 'xs',
	'wrapper_class' => 'event-read-more',
] );
