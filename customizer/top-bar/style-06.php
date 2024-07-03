<?php
$section  = 'top_bar_style_06';
$priority = 1;
$prefix   = 'top_bar_style_06_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'layout',
	'label'    => esc_html__( 'Layout', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1c',
	'choices'  => array(
		'1l' => esc_html__( '1 Column - Left', 'edumall' ),
		'1c' => esc_html__( '1 Column - Center', 'edumall' ),
		'1r' => esc_html__( '1 Column - Right', 'edumall' ),
		'2'  => esc_html__( '2 Columns', 'edumall' ),
		'3'  => esc_html__( '3 Columns', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicheck',
	'settings'        => $prefix . 'left_components',
	'label'           => esc_html__( 'Left Components', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => [ 'info_list' ],
	'choices'         => Edumall_Top_Bar::instance()->get_support_components(),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'layout',
			'operator' => 'in',
			'value'    => [
				'1l',
				'2',
				'3',
			],
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicheck',
	'settings'        => $prefix . 'center_components',
	'label'           => esc_html__( 'Center Components', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => [ 'text' ],
	'choices'         => Edumall_Top_Bar::instance()->get_support_components(),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'layout',
			'operator' => 'in',
			'value'    => [
				'1c',
				'3',
			],
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicheck',
	'settings'        => $prefix . 'right_components',
	'label'           => esc_html__( 'Right Components', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => [ 'user_links', 'social_links' ],
	'choices'         => Edumall_Top_Bar::instance()->get_support_components(),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'layout',
			'operator' => 'in',
			'value'    => [
				'1r',
				'2',
				'3',
			],
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'textarea',
	'settings' => $prefix . 'text',
	'label'    => esc_html__( 'Text', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => wp_kses( __( '<span class="font-500"> Keep Learning With Free Resources During <span class="font-700">COVID-19.</span> </span> <a href="#" class="link-transition-02 display-inline-block">Learn More</a>', 'edumall' ), [
		'a'    => [
			'class' => [],
			'href'  => [],
		],
		'span' => [
			'class' => [],
		],
	] ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'         => 'repeater',
	'settings'     => $prefix . 'info_list',
	'label'        => esc_html__( 'Info List', 'edumall' ),
	'section'      => $section,
	'priority'     => $priority++,
	'button_label' => esc_html__( 'Add new info', 'edumall' ),
	'row_label'    => array(
		'type'  => 'field',
		'field' => 'text',
	),
	'default'      => array(
		array(
			'text'       => '(+88) 1990 6886',
			'url'        => 'tel:+8819906886',
			'icon_class' => 'fa-solid fa-phone',
			'link_class' => '',
		),
		array(
			'text'       => 'agency@thememove.com',
			'url'        => 'mailto:agency@thememove.com',
			'icon_class' => 'fa-regular fa-envelope',
			'link_class' => 'font-400',
		),
	),
	'fields'       => array(
		'text'       => array(
			'type'    => 'textarea',
			'label'   => esc_html__( 'Title', 'edumall' ),
			'default' => '',
		),
		'url'        => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Link', 'edumall' ),
			'default' => '',
		),
		'icon_class' => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Icon Class', 'edumall' ),
			'default' => '',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'padding_top',
	'label'     => esc_html__( 'Padding top', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 2,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.top-bar-06',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 2,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.top-bar-06',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'border_width',
	'label'     => esc_html__( 'Border Bottom Width', 'edumall' ),
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
			'element'  => '.top-bar-06',
			'property' => 'border-bottom-width',
			'units'    => 'px',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'text_typography',
	'label'       => esc_html__( 'Text Typography', 'edumall' ),
	'description' => esc_html__( 'These settings control the typography of text', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '500',
		'line-height'    => '1.625',
		'letter-spacing' => '',
		'font-size'      => '16px',
	),
	'output'      => array(
		array(
			'element' => '.top-bar-06',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'kirki_typography',
	'settings'    => $prefix . 'link_typography',
	'label'       => esc_html__( 'Link Typography', 'edumall' ),
	'description' => esc_html__( 'These settings control the typography of link', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => '',
		'variant'        => '700',
		'line-height'    => '1.625',
		'letter-spacing' => '',
		'font-size'      => '16px',
	),
	'output'      => array(
		array(
			'element' => '.top-bar-06 a',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Header Dark Skin', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'bg_color',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color of top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#FDEFEE',
	'output'      => array(
		array(
			'element'  => '.top-bar-06',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'border_color',
	'label'       => esc_html__( 'Border Bottom Color', 'edumall' ),
	'description' => esc_html__( 'Controls the border bottom color of top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => 'rgba(0, 0, 0, 0)',
	'output'      => array(
		array(
			'element'  => '.top-bar-06',
			'property' => 'border-bottom-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => $prefix . 'separator_color',
	'label'     => esc_html__( 'Separator Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => 'rgba(255, 255, 255, 0.4)',
	'output'    => array(
		array(
			'element'  => '
			.top-bar-06 .top-bar-user-links a + a:before,
			.top-bar-06 .top-bar-info .info-item + .info-item:before
			',
			'property' => 'background',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'text_color',
	'label'       => esc_html__( 'Text', 'edumall' ),
	'description' => esc_html__( 'Controls the color of text on top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#000',
	'output'      => array(
		array(
			'element'  => '.top-bar-06',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'link_color',
	'label'       => esc_html__( 'Link Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of links on top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#000',
		'hover'  => '#0071DC',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.top-bar-06 a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.top-bar-06 a:hover, .top-bar-06 a:focus',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'info_icon_color',
	'label'     => esc_html__( 'Info Icon Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'   => array(
		'normal' => Edumall::SECONDARY_COLOR,
		'hover'  => Edumall::SECONDARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.top-bar-06 .info-list .info-icon',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.top-bar-06 .info-list .info-link:hover .info-icon',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Header Light Skin', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'light_bg_color',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background color of top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#FDEFEE',
	'output'      => array(
		array(
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => $prefix . 'light_border_color',
	'label'       => esc_html__( 'Border Bottom Color', 'edumall' ),
	'description' => esc_html__( 'Controls the border bottom color of top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Edumall::THIRD_COLOR,
	'output'      => array(
		array(
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06',
			'property' => 'border-bottom-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => $prefix . 'light_separator_color',
	'label'     => esc_html__( 'Separator Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => 'rgba(255, 255, 255, 0.35)',
	'output'    => array(
		array(
			'element'  => '
			.header-light:not(.headroom--not-top) .top-bar-06 .top-bar-user-links a + a:before,
			.header-light:not(.headroom--not-top) .top-bar-06 .top-bar-info .info-item + .info-item:before
			',
			'property' => 'background',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color',
	'settings'    => $prefix . 'light_text_color',
	'label'       => esc_html__( 'Text', 'edumall' ),
	'description' => esc_html__( 'Controls the color of text on top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'light_link_color',
	'label'       => esc_html__( 'Link Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of links on top bar.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#fff',
		'hover'  => '#2A906A',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06 a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.header-light:not(.headroom--not-top) .top-bar-06 a:hover,
			.header-light:not(.headroom--not-top) .top-bar-06 a:focus
			',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'light_info_icon_color',
	'label'     => esc_html__( 'Info Icon Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'   => array(
		'normal' => '#fff',
		'hover'  => Edumall::SECONDARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06 .info-list .info-icon',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.header-light:not(.headroom--not-top) .top-bar-06 .info-list .info-link:hover .info-icon',
			'property' => 'color',
		),
	),
) );
