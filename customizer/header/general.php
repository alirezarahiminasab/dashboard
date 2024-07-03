<?php
$section  = 'header';
$priority = 1;
$prefix   = 'header_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'global_header',
	'label'       => esc_html__( 'Global Header Style', 'edumall' ),
	'description' => esc_html__( 'Select default header style for your site.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => Edumall_Header::instance()->get_list(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_header_overlay',
	'label'    => esc_html__( 'Global Header Overlay', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
	'choices'  => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_header_skin',
	'label'    => esc_html__( 'Header Skin', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'dark',
	'choices'  => array(
		'dark'  => esc_html__( 'Dark', 'edumall' ),
		'light' => esc_html__( 'Light', 'edumall' ),
	),
) );
