<?php
$section  = 'navigation_minimal_01';
$priority = 1;
$prefix   = 'navigation_minimal_01_';

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'menu_title',
	'label'       => esc_html__('Menu Title', 'edumall-child'),
	'description' => esc_html__('Input a text that displays next to open button.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'background_type',
	'label'    => esc_html__('Background Type', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'solid',
	'choices'  => array(
		'solid'    => esc_html__('Solid', 'edumall-child'),
		'gradient' => esc_html__('Gradient', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'background',
	'settings'        => $prefix . 'background',
	'label'           => esc_html__('Background', 'edumall-child'),
	'description'     => esc_html__('Controls the background of canvas menu.', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => array(
		'background-color'      => '#f9f9fb',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
		'background-position'   => 'center center',
	),
	'output'          => array(
		array(
			'element' => '.popup-canvas-menu',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'background_type',
			'operator' => '==',
			'value'    => 'solid',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'background_gradient_color',
	'label'           => esc_html__('Background Gradient', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color_1' => esc_attr__('Color 1', 'edumall-child'),
		'color_2' => esc_attr__('Color 2', 'edumall-child'),
	),
	'default'         => array(
		'color_1' => '#000000',
		'color_2' => '#434343',
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'background_type',
			'operator' => '==',
			'value'    => 'gradient',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'close_button_color',
	'label'       => esc_html__('Close Button Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of close button.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#111',
	'output'      => array(
		array(
			'element'  => '.page-close-main-menu:before, .page-close-main-menu:after',
			'property' => 'background-color',
		),
	),
));

/*--------------------------------------------------------------
# Level 1
--------------------------------------------------------------*/
Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Main Menu Level 1', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'typography',
	'label'       => esc_html__('Typography', 'edumall-child'),
	'description' => esc_html__('These settings control the typography for menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '500',
		'line-height'    => '1.5',
		'letter-spacing' => '',
		'text-transform' => '',
	),
	'output'      => array(
		array(
			'element' => '.popup-canvas-menu .menu__container > li > a',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'item_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the color for main menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#111',
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container > li > a',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'item_hover_color',
	'label'       => esc_html__('Hover Color', 'edumall-child'),
	'description' => esc_html__('Controls the color when hover for main menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Edumall::PRIMARY_COLOR,
	'output'      => array(
		array(
			'element'  => '
            .popup-canvas-menu .menu__container  > li > a:hover,
            .popup-canvas-menu .menu__container  > li > a:focus
            ',
			'property' => 'color',
		),
	),
));

/*--------------------------------------------------------------
# Main Menu Dropdown Menu
--------------------------------------------------------------*/
Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Main Menu Dropdown', 'edumall-child') . '</div>',
));

/*--------------------------------------------------------------
# Styling
--------------------------------------------------------------*/

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'dropdown_link_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the color for dropdown menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#777',
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container .children a',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'dropdown_link_hover_color',
	'label'       => esc_html__('Hover Color', 'edumall-child'),
	'description' => esc_html__('Controls the color when hover for dropdown menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Edumall::PRIMARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.popup-canvas-menu .menu__container .children a:hover',
			'property' => 'color',
		),
	),
));
