<?php
$section  = 'header_style_01';
$priority = 1;
$prefix   = 'header_style_01_';

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header Style', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'border_width',
	'label'     => esc_html__('Border Bottom Width', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.header-01 .page-header-inner',
			'property' => 'border-bottom-width',
			'units'    => 'px',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header Components', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'category_menu_enable',
	'label'    => esc_html__('Category Menu', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'search_enable',
	'label'    => esc_html__('Search', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'inline',
	'choices'  => array(
		'0'      => esc_html__('Hide', 'edumall-child'),
		'inline' => esc_html__('Inline Form', 'edumall-child'),
		'popup'  => esc_html__('Popup Search', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'login_enable',
	'label'    => esc_html__('Login', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
	'choices'  => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'cart_enable',
	'label'    => esc_html__('Mini Cart', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0'             => esc_html__('Hide', 'edumall-child'),
		'1'             => esc_html__('Show', 'edumall-child'),
		'hide_on_empty' => esc_html__('Hide On Empty', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'notification_enable',
	'label'    => esc_html__('Notification', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Customize::instance()->field_social_networks_enable(array(
	'settings' => $prefix . 'social_networks_enable',
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
));

Edumall_Customize::instance()->field_language_switcher_enable(array(
	'settings' => $prefix . 'language_switcher_enable',
	'section'  => $section,
	'priority' => $priority++,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Button', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'text',
	'settings' => $prefix . 'button_text',
	'label'    => esc_html__('Button Text', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'text',
	'settings' => $prefix . 'button_link',
	'label'    => esc_html__('Button Link', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'text',
	'settings' => $prefix . 'button_link_rel',
	'label'    => esc_html__('Button Link Relationship (XFN)', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'button_link_target',
	'label'    => esc_html__('Open link in a new tab.', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '0',
	'choices'  => array(
		'0' => esc_html__('No', 'edumall-child'),
		'1' => esc_html__('Yes', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'button_style',
	'label'    => esc_html__('Button Style', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'thick-border',
	'choices'  => Edumall_Header::instance()->get_button_style(),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header Navigation (Level 1)', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'navigation_typography',
	'label'       => esc_html__('Typography', 'edumall-child'),
	'description' => esc_html__('These settings control the typography for menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '500',
		'font-size'      => '14px',
		'line-height'    => '1.6',
		'letter-spacing' => '',
		'text-transform' => '',
	),
	'output'      => array(
		array(
			'element' => '.header-01 .menu--primary > ul > li > a',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'spacing',
	'settings'  => $prefix . 'navigation_item_padding',
	'label'     => esc_html__('Item Padding', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => array(
		'top'    => '25px',
		'bottom' => '25px',
		'left'   => '12px',
		'right'  => '12px',
	),
	'transport' => 'auto',
	'output'    => array(
		array(
			'element'  => array(
				'.desktop-menu .header-01 .menu--primary > ul > li > a',
			),
			'property' => 'padding',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header Dark Skin', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Style', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'background',
	'settings' => $prefix . 'dark_background',
	'label'    => esc_html__('Background', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => array(
		'background-color'      => '#fff',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
		'background-position'   => 'center center',
	),
	'output'   => array(
		array(
			'element' => '.header-01.header-dark .page-header-inner',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'dark_border_color',
	'label'       => esc_html__('Border Color', 'edumall-child'),
	'description' => esc_html__('Controls the border color of header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#eee',
	'output'      => array(
		array(
			'element'  => '.header-01.header-dark .page-header-inner',
			'property' => 'border-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'dark_box_shadow',
	'label'       => esc_html__('Box Shadow', 'edumall-child'),
	'description' => esc_html__('Input box shadow for header. For e.g: 0 0 5px #ccc', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0 10px 26px rgba(0, 0, 0, 0.05)',
	'output'      => array(
		array(
			'element'  => '.header-01.header-dark .page-header-inner',
			'property' => 'box-shadow',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Icon', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dark_header_icon_color',
	'label'       => esc_html__('Icon Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icons on header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => Edumall::THIRD_COLOR,
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '
			.header-01.header-dark .header-icon,
			.header-01.header-dark .wpml-ls-item-toggle',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-dark .header-icon:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-dark .wpml-ls-slot-shortcode_actions:hover > .js-wpml-ls-item-toggle',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Icon Badge', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dark_icon_badge_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icon badge.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
	),
	'default'     => array(
		'color'      => '#fff',
		'background' => Edumall::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => '.header-01.header-dark .header-icon .badge, .header-01.header-dark .mini-cart .mini-cart-icon:after',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.header-01.header-dark .header-icon .badge, .header-01.header-dark .mini-cart .mini-cart-icon:after',
			'property' => 'background-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Navigation', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'dark_navigation_link_color',
	'label'       => esc_html__('Link Color', 'edumall-child'),
	'description' => esc_html__('Controls the color for main menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => Edumall::HEADING_SECONDARY_COLOR,
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-01.header-dark .menu--primary > ul > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.header-01.header-dark .menu--primary > ul > li:hover > a,
            .header-01.header-dark .menu--primary > ul > li > a:hover,
            .header-01.header-dark .menu--primary > ul > li > a:focus,
            .header-01.header-dark .menu--primary > ul > .current-menu-ancestor > a,
            .header-01.header-dark .menu--primary > ul > .current-menu-item > a',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Search Form', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'dark_search_form_color',
	'label'           => esc_html__('Normal', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#9B9B9B',
		'background' => '#F2F2F2',
		'border'     => '#F2F2F2',
	),
	'output'          => Edumall_Header::instance()->get_search_form_kirki_output('01', 'dark', false),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'search_enable',
			'operator' => '==',
			'value'    => 'inline',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'dark_search_form_focus_color',
	'label'           => esc_html__('Hover', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#333',
		'background' => '#fff',
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'          => Edumall_Header::instance()->get_search_form_kirki_output('01', 'dark', true),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'search_enable',
			'operator' => '==',
			'value'    => 'inline',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Button', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'dark_button_color',
	'label'    => esc_html__('Button Color', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'custom',
	'choices'  => array(
		''       => esc_html__('Default', 'edumall-child'),
		'custom' => esc_html__('Custom', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'dark_button_custom_color',
	'label'           => esc_html__('Button Color', 'edumall-child'),
	'description'     => esc_html__('Controls the color of button.', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#fff',
		'background' => Edumall::PRIMARY_COLOR,
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'          => Edumall_Header::instance()->get_button_kirki_output('01', 'dark', false),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'dark_button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'dark_button_hover_custom_color',
	'label'           => esc_html__('Button Hover Color', 'edumall-child'),
	'description'     => esc_html__('Controls the color of button when hover.', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => Edumall::PRIMARY_COLOR,
		'background' => 'rgba(0, 0, 0, 0)',
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'          => Edumall_Header::instance()->get_button_kirki_output('01', 'dark', true),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'dark_button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Social Networks', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'dark_social_networks_color',
	'label'     => esc_html__('Color', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'   => array(
		'normal' => Edumall::HEADING_COLOR,
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-01.header-dark .header-social-networks a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-dark .header-social-networks a:hover',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header Light Skin', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Style', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'light_border_color',
	'label'       => esc_html__('Border Color', 'edumall-child'),
	'description' => esc_html__('Controls the border color of header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => 'rgba(255, 255, 255, 0.2)',
	'output'      => array(
		array(
			'element'  => '.header-01.header-light .page-header-inner',
			'property' => 'border-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'light_box_shadow',
	'label'       => esc_html__('Box Shadow', 'edumall-child'),
	'description' => esc_html__('Input box shadow for header. For e.g: 0 0 5px #ccc', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'output'      => array(
		array(
			'element'  => '.header-01.header-light .page-header-inner',
			'property' => 'box-shadow',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Icon', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'light_header_icon_color',
	'label'       => esc_html__('Icon Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icons on header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => '#fff',
		'hover'  => '#fff',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '
			.header-01.header-light .header-icon,
			.header-01.header-light .wpml-ls-item-toggle',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-light .header-icon:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-light .wpml-ls-slot-shortcode_actions:hover > .js-wpml-ls-item-toggle',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Icon Badge', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'light_icon_badge_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icon badge.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
	),
	'default'     => array(
		'color'      => Edumall::THIRD_COLOR,
		'background' => Edumall::SECONDARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => '.header-01.header-light .header-icon .badge, .header-01.header-light .mini-cart .mini-cart-icon:after',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.header-01.header-light .header-icon .badge, .header-01.header-light .mini-cart .mini-cart-icon:after',
			'property' => 'background-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Navigation', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'light_navigation_link_color',
	'label'       => esc_html__('Navigation Link Color', 'edumall-child'),
	'description' => esc_html__('Controls the color for main menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => '#fff',
		'hover'  => '#fff',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-01.header-light .menu--primary > ul > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
            .header-01.header-light .menu--primary > ul > li:hover > a,
            .header-01.header-light .menu--primary > ul > li > a:hover,
            .header-01.header-light .menu--primary > ul > li > a:focus,
            .header-01.header-light .menu--primary > ul > .current-menu-ancestor > a,
            .header-01.header-light .menu--primary > ul > .current-menu-item > a',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Button', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'light_button_color',
	'label'    => esc_html__('Button Color', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'custom',
	'choices'  => array(
		''       => esc_html__('Default', 'edumall-child'),
		'custom' => esc_html__('Custom', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'light_button_custom_color',
	'label'           => esc_html__('Button Color', 'edumall-child'),
	'description'     => esc_html__('Controls the color of button.', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#fff',
		'background' => 'rgba(255, 255, 255, 0)',
		'border'     => 'rgba(255, 255, 255, 0.3)',
	),
	'output'          => Edumall_Header::instance()->get_button_kirki_output('01', 'light', false),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'light_button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'light_button_hover_custom_color',
	'label'           => esc_html__('Button Hover Color', 'edumall-child'),
	'description'     => esc_html__('Controls the color of button when hover.', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#111',
		'background' => '#fff',
		'border'     => '#fff',
	),
	'output'          => Edumall_Header::instance()->get_button_kirki_output('01', 'light', true),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'light_button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Social Networks', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'light_social_networks_color',
	'label'     => esc_html__('Normal Color', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'   => array(
		'normal' => '#fff',
		'hover'  => '#fff',
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-01.header-light .header-social-networks a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-01.header-light .header-social-networks a:hover',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Dark Mode Colors', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => sprintf('<div class="desc">
			<strong class="insight-label insight-label-info">%1$s</strong>
			<p>%2$s</p>
		</div>', esc_html__('NOTE: ', 'edumall-child'), esc_html__('These settings below will control colors of Header Dark in Dark Mode.', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'background',
	'settings' => 'scheme_dark_' . $prefix . 'dark_background',
	'label'    => esc_html__('Background', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => array(
		'background-color'      => '#020c18',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
		'background-position'   => 'center center',
	),
	'output'   => array(
		array(
			'element' => '.edumall-dark-scheme .header-01.header-dark .page-header-inner',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'scheme_dark_' . $prefix . 'dark_border_color',
	'label'       => esc_html__('Border Color', 'edumall-child'),
	'description' => esc_html__('Controls the border color of header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#020c18',
	'output'      => array(
		array(
			'element'  => '.edumall-dark-scheme .header-01.header-dark .page-header-inner',
			'property' => 'border-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Icon', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => 'scheme_dark_' . $prefix . 'dark_header_icon_color',
	'label'       => esc_html__('Icon Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icons on header.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => '#fff',
		'hover'  => Edumall::SECONDARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '
			.edumall-dark-scheme .header-01.header-dark .header-icon,
			.edumall-dark-scheme .header-01.header-dark .wpml-ls-item-toggle',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .header-icon:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .wpml-ls-slot-shortcode_actions:hover > .js-wpml-ls-item-toggle',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Icon Badge', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => 'scheme_dark_' . $prefix . 'dark_icon_badge_color',
	'label'       => esc_html__('Color', 'edumall-child'),
	'description' => esc_html__('Controls the color of icon badge.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
	),
	'default'     => array(
		'color'      => Edumall::THIRD_COLOR,
		'background' => Edumall::SECONDARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .header-icon .badge, .edumall-dark-scheme .header-01.header-dark .mini-cart .mini-cart-icon:after',
			'property' => 'color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .header-icon .badge, .edumall-dark-scheme .header-01.header-dark .mini-cart .mini-cart-icon:after',
			'property' => 'background-color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Navigation', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicolor',
	'settings'    => 'scheme_dark_' . $prefix . 'dark_navigation_link_color',
	'label'       => esc_html__('Link Color', 'edumall-child'),
	'description' => esc_html__('Controls the color for main menu items.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'     => array(
		'normal' => 'rgba(255, 255, 255, 0.7)',
		'hover'  => '#fff',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .menu--primary > ul > li > a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.edumall-dark-scheme .header-01.header-dark .menu--primary > ul > li:hover > a,
            .edumall-dark-scheme .header-01.header-dark .menu--primary > ul > li > a:hover,
            .edumall-dark-scheme .header-01.header-dark .menu--primary > ul > li > a:focus,
            .edumall-dark-scheme .header-01.header-dark .menu--primary > ul > .current-menu-ancestor > a,
            .edumall-dark-scheme .header-01.header-dark .menu--primary > ul > .current-menu-item > a',
			'property' => 'color',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Search Form', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => 'scheme_dark_' . $prefix . 'dark_search_form_color',
	'label'           => esc_html__('Normal', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#80868d',
		'background' => '#19222d',
		'border'     => '#19222d',
	),
	'output'          => Edumall_Header::instance()->get_search_form_kirki_output('01', 'dark', false, true),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'search_enable',
			'operator' => '==',
			'value'    => 'inline',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicolor',
	'settings'        => 'scheme_dark_' . $prefix . 'dark_search_form_focus_color',
	'label'           => esc_html__('Hover', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__('Color', 'edumall-child'),
		'background' => esc_attr__('Background', 'edumall-child'),
		'border'     => esc_attr__('Border', 'edumall-child'),
	),
	'default'         => array(
		'color'      => '#fff',
		'background' => '#19222d',
		'border'     => '#fff',
	),
	'output'          => Edumall_Header::instance()->get_search_form_kirki_output('01', 'dark', true, true),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'search_enable',
			'operator' => '==',
			'value'    => 'inline',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Header Social Networks', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'multicolor',
	'settings'  => 'scheme_dark_' . $prefix . 'dark_social_networks_color',
	'label'     => esc_html__('Color', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__('Normal', 'edumall-child'),
		'hover'  => esc_attr__('Hover', 'edumall-child'),
	),
	'default'   => array(
		'normal' => '#fff',
		'hover'  => Edumall::SECONDARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .header-social-networks a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.edumall-dark-scheme .header-01.header-dark .header-social-networks a:hover',
			'property' => 'color',
		),
	),
));
