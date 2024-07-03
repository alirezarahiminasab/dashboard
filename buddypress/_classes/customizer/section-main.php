<?php
$section  = 'buddypress';
$priority = 1;
$prefix   = 'buddypress_';

$sidebar_positions   = Edumall_Helper::get_list_sidebar_positions();
$registered_sidebars = Edumall_Helper::get_registered_sidebars();

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Header', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'page_top_bar_type',
	'label'    => esc_html__( 'Top Bar Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '05',
	'choices'  => Edumall_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'page_header_type',
	'label'    => esc_html__( 'Header Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '08',
	'choices'  => Edumall_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'page_header_overlay',
	'label'    => esc_html__( 'Header Overlay', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''  => esc_html__( 'Use Global', 'edumall' ),
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'page_header_skin',
	'label'    => esc_html__( 'Header Skin', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''      => esc_html__( 'Use Global', 'edumall' ),
		'dark'  => esc_html__( 'Dark', 'edumall' ),
		'light' => esc_html__( 'Light', 'edumall' ),
	),
) );
