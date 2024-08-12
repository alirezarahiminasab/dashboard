<?php
$section  = 'search_popup';
$priority = 1;
$prefix   = 'search_popup_';

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'close_button_color',
	'label'       => esc_html__('Close Button Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of close button.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.page-search-popup .popup-close-button',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.page-search-popup .popup-close-button .burger-icon-top:after,
			.page-search-popup .popup-close-button .burger-icon-bottom:after
			',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'bg_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the background color of the search popup content.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => '.page-search-popup',
			'property' => 'background',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'text_color',
	'label'       => esc_html__('Text Color', 'edumall-child'),
	'description' => esc_html__('Controls the text color search field.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#111',
	'output'      => array(
		array(
			'element'  => '
			.page-search-popup .search-form,
			.page-search-popup .search-field:focus
			',
			'property' => 'color',
		),
		array(
			'element'  => '.page-search-popup .search-field:-webkit-autofill',
			'property' => '-webkit-text-fill-color',
			'suffix'   => '!important',
		),
	),
));
