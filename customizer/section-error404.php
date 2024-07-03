<?php
$section  = 'error404_page';
$priority = 1;
$prefix   = 'error404_page_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'background',
	'settings'    => 'error404_page_background_body',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls outer background area in boxed mode.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array(
		'background-color'      => '',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
		'background-position'   => 'center center',
	),
	'output'      => array(
		array(
			'element' => '.error404',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'image',
	'settings' => 'error404_page_image',
	'label'    => esc_html__( 'Image', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => EDUMALL_THEME_IMAGE_URI . '/page-404-image.png',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'error404_page_title',
	'label'       => esc_html__( 'Title', 'edumall' ),
	'description' => esc_html__( 'Controls the title that display on error 404 page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Oops! That page can\'t be found.', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'textarea',
	'settings'    => 'error404_page_text',
	'label'       => esc_html__( 'Text', 'edumall' ),
	'description' => esc_html__( 'Controls the text that display below title', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'edumall' ),
) );
