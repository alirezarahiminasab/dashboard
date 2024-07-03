<?php
$section  = 'pre_loader';
$priority = 1;
$prefix   = 'pre_loader_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'enable',
	'label'    => esc_html__( 'Enable Preloader', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
	'choices'  => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'style',
	'label'    => esc_html__( 'Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'circle',
	'choices'  => Edumall_Helper::get_preloader_list(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => $prefix . 'background_color',
	'label'     => esc_html__( 'Background Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => '#fff',
	'output'    => array(
		array(
			'element'  => '.page-loading',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'color-alpha',
	'settings'        => $prefix . 'shape_color',
	'label'           => esc_html__( 'Shape Color', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'default'         => Edumall::PRIMARY_COLOR,
	'output'          => array(
		array(
			'element'  => '.page-loading .sk-wrap',
			'property' => 'color',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_loader_style',
			'operator' => '!=',
			'value'    => 'gif-image',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'image',
	'settings'        => 'pre_loader_image',
	'label'           => esc_html__( 'Gif Image', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => EDUMALL_THEME_IMAGE_URI . '/main-preloader.gif',
	'active_callback' => array(
		array(
			'setting'  => 'pre_loader_style',
			'operator' => '==',
			'value'    => 'gif-image',
		),
	),
) );
