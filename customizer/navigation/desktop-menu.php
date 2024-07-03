<?php
$section  = 'navigation';
$priority = 1;
$prefix   = 'navigation_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Main Menu Dropdown', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'dropdown_link_typography',
	'label'       => esc_html__( 'Typography', 'edumall' ),
	'description' => esc_html__( 'Controls the typography for all dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '500',
		'line-height'    => '1.39',
		'letter-spacing' => '0em',
		'text-transform' => 'none',
	),
	'output'      => array(
		array(
			'element' => '
			.page-navigation .children > li > a,
			.page-navigation .children > li > a .menu-item-title
			',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => $prefix . 'dropdown_link_font_size',
	'label'       => esc_html__( 'Font Size', 'edumall' ),
	'description' => esc_html__( 'Controls the font size for dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 13,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => '.page-navigation .children > li > a',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

/*--------------------------------------------------------------
# Styling
--------------------------------------------------------------*/

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dropdown_bg_color',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color for dropdown menu', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children',
				'.primary-menu-sub-visual',
			),
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'dropdown_box_shadow',
	'label'       => esc_html__( 'Box Shadow', 'edumall' ),
	'description' => esc_html__( 'Input valid box-shadow for dropdown menu. For e.g: "0 0 37px rgba(0, 0, 0, .07)"', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0 0 30px rgba(0, 0, 0, 0.12)',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children',
				'.primary-menu-sub-visual',
			),
			'property' => 'box-shadow',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dropdown_link_color',
	'label'       => esc_html__( 'Link Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color for dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#7e7e7e',
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.page-navigation .children > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
				.page-navigation .children > li:hover > a,
				.page-navigation .children > li.current-menu-item > a,
				.page-navigation .children > li.current-menu-ancestor > a
			',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dropdown_link_hover_bg_color',
	'label'       => esc_html__( 'Hover Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color when hover for dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element'  => array(
				'.page-navigation .children > li:hover > a',
				'.page-navigation .children > li.current-menu-item > a',
				'.page-navigation .children > li.current-menu-ancestor > a',
			),
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Dark Mode Colors', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dark_dropdown_bg_color',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color for dropdown menu', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#19222D',
	'output'      => array(
		array(
			'element'  => array(
				'.edumall-dark-scheme .page-navigation .children',
				'.edumall-dark-scheme .primary-menu-sub-visual',
			),
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'dark_dropdown_box_shadow',
	'label'       => esc_html__( 'Box Shadow', 'edumall' ),
	'description' => esc_html__( 'Input valid box-shadow for dropdown menu. For e.g: "0 0 37px rgba(0, 0, 0, .07)"', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0 0 30px rgba(0, 0, 0, 0.12)',
	'output'      => array(
		array(
			'element'  => array(
				'.edumall-dark-scheme .page-navigation .children',
				'.edumall-dark-scheme .primary-menu-sub-visual',
			),
			'property' => 'box-shadow',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dark_dropdown_link_color',
	'label'       => esc_html__( 'Link Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color for dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#fff',
		'hover'  => Edumall::SECONDARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.edumall-dark-scheme .page-navigation .children > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
				.edumall-dark-scheme .page-navigation .children > li:hover > a,
				.edumall-dark-scheme .page-navigation .children > li.current-menu-item > a,
				.edumall-dark-scheme .page-navigation .children > li.current-menu-ancestor > a
			',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dark_dropdown_link_hover_bg_color',
	'label'       => esc_html__( 'Hover Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color when hover for dropdown menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element'  => array(
				'.edumall-dark-scheme .page-navigation .children > li:hover > a',
				'.edumall-dark-scheme .page-navigation .children > li.current-menu-item > a',
				'.edumall-dark-scheme .page-navigation .children > li.current-menu-ancestor > a',
			),
			'property' => 'background-color',
		),
	),
) );
