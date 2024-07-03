<?php
$section  = 'header_category_menu';
$priority = 1;
$prefix   = 'header_category_menu_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'number',
	'settings' => 'header_category_menu_cat_number',
	'label'    => esc_html__( 'Number categories', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'number',
	'settings' => 'header_category_menu_number_posts',
	'label'    => esc_html__( 'Number posts', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 6,
) );
