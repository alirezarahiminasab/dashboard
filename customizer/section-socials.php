<?php
$section  = 'socials';
$priority = 1;
$prefix   = 'social_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'social_link_target',
	'label'    => esc_html__( 'Open link in a new tab.', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'         => 'repeater',
	'settings'     => 'social_link',
	'section'      => $section,
	'priority'     => $priority++,
	'button_label' => esc_html__( 'Add new social network', 'edumall' ),
	'row_label'    => array(
		'type'  => 'field',
		'field' => 'tooltip',
	),
	'default'      => array(
		array(
			'tooltip'    => esc_html__( 'Twitter', 'edumall' ),
			'icon_class' => 'fa-brands fa-x-twitter',
			'link_url'   => 'https://twitter.com',
		),
		array(
			'tooltip'    => esc_html__( 'Facebook', 'edumall' ),
			'icon_class' => 'fa-brands fa-facebook-f',
			'link_url'   => 'https://facebook.com',
		),
		array(
			'tooltip'    => esc_html__( 'Instagram', 'edumall' ),
			'icon_class' => 'fa-brands fa-instagram',
			'link_url'   => 'https://instagram.com',
		),
		array(
			'tooltip'    => esc_html__( 'Linkedin', 'edumall' ),
			'icon_class' => 'fa-brands fa-linkedin-in',
			'link_url'   => 'https://linkedin.com',
		),
	),
	'fields'       => array(
		'tooltip'    => array(
			'type'        => 'text',
			'label'       => esc_html__( 'Tooltip', 'edumall' ),
			'description' => esc_html__( 'Enter your hint text for your icon', 'edumall' ),
			'default'     => '',
		),
		'icon_class' => array(
			'type'        => 'text',
			'label'       => esc_html__( 'Icon Class', 'edumall' ),
			'description' => esc_html__( 'This will be the icon class for your link', 'edumall' ),
			'default'     => '',
		),
		'link_url'   => array(
			'type'        => 'text',
			'label'       => esc_html__( 'Link URL', 'edumall' ),
			'description' => esc_html__( 'This will be the link URL', 'edumall' ),
			'default'     => '',
		),
	),
) );
