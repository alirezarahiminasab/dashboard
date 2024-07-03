<?php
$section  = 'header_sticky';
$priority = 1;
$prefix   = 'header_sticky_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => $prefix . 'enable',
	'label'       => esc_html__( 'Enable', 'edumall' ),
	'description' => esc_html__( 'Enable this option to turn on header sticky feature.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio',
	'settings'    => $prefix . 'behaviour',
	'label'       => esc_html__( 'Behaviour', 'edumall' ),
	'description' => esc_html__( 'Controls the behaviour of header sticky when you scroll down to page', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'both',
	'choices'     => array(
		'both' => esc_html__( 'Sticky on scroll up/down', 'edumall' ),
		'up'   => esc_html__( 'Sticky on scroll up', 'edumall' ),
		'down' => esc_html__( 'Sticky on scroll down', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'height',
	'label'     => esc_html__( 'Height', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 80,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 50,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.headroom--not-top .page-header-inner .header-wrap',
			'property' => 'min-height',
			'units'    => 'px',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'padding_top',
	'label'     => esc_html__( 'Padding top', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.headroom--not-top .page-header-inner .header-wrap',
			'property' => 'padding-top',
			'units'    => 'px',
			'suffix'   => '!important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => $prefix . 'padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.headroom--not-top .page-header-inner .header-wrap',
			'property' => 'padding-bottom',
			'units'    => 'px',
			'suffix'   => '!important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'logo',
	'label'    => esc_html__( 'Logo', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'dark',
	'choices'  => array(
		'light' => esc_html__( 'Light', 'edumall' ),
		'dark'  => esc_html__( 'Dark', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'background',
	'settings'    => $prefix . 'background',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background of header when sticky.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array(
		'background-color'      => '#ffffff',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
		'background-position'   => 'center center',
	),
	'output'      => array(
		array(
			'element' => '#page-header.headroom--not-top .page-header-inner',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Header Icons', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'icon_color',
	'label'       => esc_html__( 'Icon Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of icons on header.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#111',
		'hover'  => '#111',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '
			.page-header.headroom--not-top .header-icon,
			.page-header.headroom--not-top .wpml-ls-item-toggle
			',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.page-header.headroom--not-top .header-icon:hover
			',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.page-header.headroom--not-top .wpml-ls-slot-shortcode_actions:hover > .js-wpml-ls-item-toggle',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Icon Badge', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'icon_badge_color',
	'label'       => esc_html__( 'Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of icon badge.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => '.page-header.headroom--not-top .mini-cart .mini-cart-icon:after, .page-header.headroom--not-top .header-icon .badge',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'background',
			'element'  => '.page-header.headroom--not-top .mini-cart .mini-cart-icon:after, .page-header.headroom--not-top .header-icon .badge',
			'property' => 'background-color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Social Networks', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'social_networks_color',
	'label'     => esc_html__( 'Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'   => array(
		'normal' => '#111',
		'hover'  => '#111',
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.page-header.headroom--not-top .header-social-networks a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.page-header.headroom--not-top .header-social-networks a:hover',
			'property' => 'color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Navigation', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => $prefix . 'navigation_link_color',
	'label'       => esc_html__( 'Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color for main menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#111',
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.page-header.headroom--not-top .menu--primary > ul > li > a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
            .page-header.headroom--not-top .menu--primary > li:hover > a,
            .page-header.headroom--not-top .menu--primary > ul > li > a:hover,
            .page-header.headroom--not-top .menu--primary > ul > li > a:focus,
            .page-header.headroom--not-top .menu--primary > ul > .current-menu-ancestor > a,
            .page-header.headroom--not-top .menu--primary > ul > .current-menu-item > a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Button', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => $prefix . 'button_style',
	'label'    => esc_html__( 'Button Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'thick-border',
	'choices'  => Edumall_Header::instance()->get_button_style(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => $prefix . 'button_color',
	'label'    => esc_html__( 'Button Color', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'custom',
	'choices'  => array(
		''       => esc_html__( 'Default', 'edumall' ),
		'custom' => esc_html__( 'Custom', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'button_custom_color',
	'label'           => esc_html__( 'Button Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the color of button.', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'         => array(
		'color'      => '#111',
		'background' => 'rgba(17, 17, 17, 0)',
		'border'     => '#eee',
	),
	'output'          => array(
		array(
			'choice'   => 'color',
			'element'  => '.header-sticky-button.tm-button',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.header-sticky-button.tm-button',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.header-sticky-button.tm-button:before',
			'property' => 'background',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => $prefix . 'button_hover_custom_color',
	'label'           => esc_html__( 'Button Hover Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the color of button when hover.', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'         => array(
		'color'      => '#fff',
		'background' => '#111',
		'border'     => '#111',
	),
	'output'          => array(
		array(
			'choice'   => 'color',
			'element'  => '.header-sticky-button.tm-button:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.header-sticky-button.tm-button:hover',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.header-sticky-button.tm-button:after',
			'property' => 'background',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => $prefix . 'button_color',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
) );


Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Search Form', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'search_form_color',
	'label'     => esc_html__( 'Normal', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'   => array(
		'color'      => '#696969',
		'background' => '#f5f5f5',
		'border'     => '#f5f5f5',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'property' => 'color',
			'element'  => '#page-header.headroom--not-top .search-field',
		),
		array(
			'choice'   => 'border',
			'property' => 'border-color',
			'element'  => '#page-header.headroom--not-top .search-field',
		),
		array(
			'choice'   => 'background',
			'property' => 'background',
			'element'  => '#page-header.headroom--not-top .search-field',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => $prefix . 'search_form_focus_color',
	'label'     => esc_html__( 'Hover', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'   => array(
		'color'      => '#333',
		'background' => '#fff',
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'property' => 'color',
			'element'  => '#page-header.headroom--not-top .search-field:focus',
		),
		array(
			'choice'   => 'border',
			'property' => 'border-color',
			'element'  => '#page-header.headroom--not-top .search-field:focus',
		),
		array(
			'choice'   => 'background',
			'property' => 'background',
			'element'  => '#page-header.headroom--not-top .search-field:focus',
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
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => sprintf( '<div class="desc">
			<strong class="insight-label insight-label-info">%1$s</strong>
			<p>%2$s</p>
		</div>', esc_html__( 'NOTE: ', 'edumall' ), esc_html__( 'These settings below will control colors of Header Sticky in Dark Mode.', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'dark_scheme_' . $prefix . 'logo',
	'label'    => esc_html__( 'Logo', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'light',
	'choices'  => array(
		'light' => esc_html__( 'Light', 'edumall' ),
		'dark'  => esc_html__( 'Dark', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'background',
	'settings'    => 'dark_scheme_' . $prefix . 'background',
	'label'       => esc_html__( 'Background', 'edumall' ),
	'description' => esc_html__( 'Controls the background of header when sticky.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array(
		'background-color'      => '#020c18',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
		'background-position'   => 'center center',
	),
	'output'      => array(
		array(
			'element' => '.edumall-dark-scheme #page-header.headroom--not-top .page-header-inner',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Header Icons', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'dark_scheme_' . $prefix . 'icon_color',
	'label'       => esc_html__( 'Icon Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of icons on header.', 'edumall' ),
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
			'element'  => '
			.edumall-dark-scheme .page-header.headroom--not-top .header-icon,
			.edumall-dark-scheme .page-header.headroom--not-top .wpml-ls-item-toggle
			',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
			.edumall-dark-scheme .page-header.headroom--not-top .header-icon:hover
			',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .wpml-ls-slot-shortcode_actions:hover > .js-wpml-ls-item-toggle',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Icon Badge', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'dark_scheme_' . $prefix . 'icon_badge_color',
	'label'       => esc_html__( 'Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of icon badge.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
	),
	'output'      => array(
		array(
			'choice'   => 'color',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .mini-cart .mini-cart-icon:after, .page-header.headroom--not-top .header-icon .badge',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'background',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .mini-cart .mini-cart-icon:after, .page-header.headroom--not-top .header-icon .badge',
			'property' => 'background-color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Social Networks', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'dark_scheme_' . $prefix . 'social_networks_color',
	'label'     => esc_html__( 'Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'   => array(
		'normal' => '#111',
		'hover'  => '#111',
	),
	'output'    => array(
		array(
			'choice'   => 'normal',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .header-social-networks a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .header-social-networks a:hover',
			'property' => 'color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Navigation', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'dark_scheme_' . $prefix . 'navigation_link_color',
	'label'       => esc_html__( 'Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color for main menu items.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => 'rgba(255, 255, 255, 0.7)',
		'hover'  => '#fff',
	),
	'output'      => array(
		array(
			'choice'   => 'normal',
			'element'  => '.edumall-dark-scheme .page-header.headroom--not-top .menu--primary > ul > li > a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'choice'   => 'hover',
			'element'  => '
            .edumall-dark-scheme .page-header.headroom--not-top .menu--primary > li:hover > a,
            .edumall-dark-scheme .page-header.headroom--not-top .menu--primary > ul > li > a:hover,
            .edumall-dark-scheme .page-header.headroom--not-top .menu--primary > ul > li > a:focus,
            .edumall-dark-scheme .page-header.headroom--not-top .menu--primary > ul > .current-menu-ancestor > a,
            .edumall-dark-scheme .page-header.headroom--not-top .menu--primary > ul > .current-menu-item > a',
			'property' => 'color',
			'suffix'   => ' !important',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Search Form', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'dark_scheme_' . $prefix . 'search_form_color',
	'label'     => esc_html__( 'Normal', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'   => array(
		'color'      => '#80868D',
		'background' => '#19222d',
		'border'     => '#19222d',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'property' => 'color',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field',
		),
		array(
			'choice'   => 'border',
			'property' => 'border-color',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field',
		),
		array(
			'choice'   => 'background',
			'property' => 'background',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'dark_scheme_' . $prefix . 'search_form_focus_color',
	'label'     => esc_html__( 'Hover', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'choices'   => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'   => array(
		'color'      => '#fff',
		'background' => 'rgba(255, 255, 255, 0)',
		'border'     => '#fff',
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'property' => 'color',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field:focus',
		),
		array(
			'choice'   => 'border',
			'property' => 'border-color',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field:focus',
		),
		array(
			'choice'   => 'background',
			'property' => 'background',
			'element'  => '.edumall-dark-scheme #page-header.headroom--not-top .search-field:focus',
		),
	),
) );
