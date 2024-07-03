<?php
$section  = 'color_';
$priority = 1;
$prefix   = 'color_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'site_skin',
	'label'    => esc_html__( 'Site Skin', 'edumall' ),
	'description' => esc_html__( 'Dark Mode compatible for all pages except ones built with Elementor. You can add custom css to make them completely compatible with 2 css classes selectors: edumall-dark-scheme, edumall-light-scheme', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'light',
	'choices'  => array(
		'light' => esc_html__( 'Light', 'edumall' ),
		'dark'  => esc_html__( 'Dark', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'allows_user_custom_site_skin',
	'label'       => esc_html__( 'Allow User\'s Site Skin', 'edumall' ),
	'description' => esc_html__( 'Allows users to choose site skin by themselves in Dashboard Settings page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'primary_color',
	'label'     => esc_html__( 'Primary Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Edumall::PRIMARY_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'secondary_color',
	'label'     => esc_html__( 'Secondary Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Edumall::SECONDARY_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'third_color',
	'label'     => esc_html__( 'Third Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Edumall::THIRD_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'body_color',
	'label'       => esc_html__( 'Text Color', 'edumall' ),
	'description' => esc_html__( 'Controls the default color of all text.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Edumall::TEXT_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'body_lighten_color',
	'label'     => esc_html__( 'Text Lighten Color', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'transport' => 'auto',
	'default'   => Edumall::TEXT_LIGHTEN_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'link_color',
	'label'       => esc_html__( 'Link Color', 'edumall' ),
	'description' => esc_html__( 'Controls the default color of all links.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'     => array(
		'normal' => '#696969',
		'hover'  => Edumall::PRIMARY_COLOR,
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'heading_color',
	'label'       => esc_html__( 'Heading Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of heading.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'default'     => Edumall::HEADING_COLOR,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Button Color', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Button Default', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_color',
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
		'color'      => '#fff',
		'background' => Edumall::PRIMARY_COLOR,
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => Edumall_Helper::get_button_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Edumall_Helper::get_button_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Edumall_Helper::get_button_css_selector(),
			'property' => 'background-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.wp-block-button.is-style-outline',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_hover_color',
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
		'color'      => Edumall::THIRD_COLOR,
		'background' => Edumall::SECONDARY_COLOR,
		'border'     => Edumall::SECONDARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => Edumall_Helper::get_button_hover_css_selector(),
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => Edumall_Helper::get_button_hover_css_selector(),
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => Edumall_Helper::get_button_hover_css_selector(),
			'property' => 'background-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.wp-block-button.is-style-outline .wp-block-button__link:hover',
			'property' => 'color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Button Flat', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_style_flat_color',
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
		'color'      => '#fff',
		'background' => Edumall::PRIMARY_COLOR,
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '.tm-button.style-flat',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.tm-button.style-flat',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.tm-button.style-flat:before',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_style_flat_hover_color',
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
		'color'      => Edumall::THIRD_COLOR,
		'background' => Edumall::SECONDARY_COLOR,
		'border'     => Edumall::SECONDARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '.tm-button.style-flat:hover',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '.tm-button.style-flat:hover',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '.tm-button.style-flat:after',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Button Border', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_style_border_color',
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
		'color'      => Edumall::PRIMARY_COLOR,
		'background' => 'rgba(0, 0, 0, 0)',
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '
			.tm-button.style-border,
			.tm-button.style-thick-border
			',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '
			.tm-button.style-border,
			.tm-button.style-thick-border
			',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '
			.tm-button.style-border:before,
			.tm-button.style-thick-border:before
			',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'multicolor',
	'settings'  => 'button_style_border_hover_color',
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
		'background' => Edumall::PRIMARY_COLOR,
		'border'     => Edumall::PRIMARY_COLOR,
	),
	'output'    => array(
		array(
			'choice'   => 'color',
			'element'  => '
			.tm-button.style-border:hover,
			.tm-button.style-thick-border:hover
			',
			'property' => 'color',
		),
		array(
			'choice'   => 'border',
			'element'  => '
			.tm-button.style-border:hover,
			.tm-button.style-thick-border:hover
			',
			'property' => 'border-color',
		),
		array(
			'choice'   => 'background',
			'element'  => '
			.tm-button.style-border:after,
			.tm-button.style-thick-border:after
			',
			'property' => 'background-color',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Form Color', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'form_input_color',
	'label'       => esc_html__( 'Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of form inputs.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'     => array(
		'color'      => Edumall::HEADING_COLOR,
		'background' => '#f8f8f8',
		'border'     => '#f8f8f8',
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicolor',
	'settings'    => 'form_input_focus_color',
	'label'       => esc_html__( 'Focus Color', 'edumall' ),
	'description' => esc_html__( 'Controls the color of form inputs when focus.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'transport'   => 'auto',
	'choices'     => array(
		'color'      => esc_attr__( 'Color', 'edumall' ),
		'background' => esc_attr__( 'Background', 'edumall' ),
		'border'     => esc_attr__( 'Border', 'edumall' ),
	),
	'default'     => array(
		'color'      => Edumall::HEADING_COLOR,
		'background' => '#fff',
		'border'     => Edumall::PRIMARY_COLOR,
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
	'type'            => 'color-alpha',
	'settings'        => 'dark_body_color',
	'label'           => esc_html__( 'Text Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the default color of all text.', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'default'         => 'rgba(255, 255, 255, 0.7)',
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'color-alpha',
	'settings'        => 'dark_body_lighten_color',
	'label'           => esc_html__( 'Text Lighten Color', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'default'         => 'rgba(255, 255, 255, 0.5)',
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => 'dark_link_color',
	'label'           => esc_html__( 'Link Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the default color of all links.', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'choices'         => array(
		'normal' => esc_attr__( 'Normal', 'edumall' ),
		'hover'  => esc_attr__( 'Hover', 'edumall' ),
	),
	'default'         => array(
		'normal' => 'rgba(255, 255, 255, 0.7)',
		'hover'  => Edumall::PRIMARY_COLOR,
	),
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'color-alpha',
	'settings'        => 'dark_heading_color',
	'label'           => esc_html__( 'Heading Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the color of heading.', 'edumall' ),
	'section'         => $section,
	'priority'        => $priority++,
	'transport'       => 'auto',
	'default'         => '#fff',
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Form Color', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => 'dark_form_input_color',
	'label'           => esc_html__( 'Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the color of form inputs.', 'edumall' ),
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
		'background' => 'rgba(255, 255, 255, 0.1)',
		'border'     => 'rgba(255, 255, 255, 0.1)',
	),
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'multicolor',
	'settings'        => 'dark_form_input_focus_color',
	'label'           => esc_html__( 'Focus Color', 'edumall' ),
	'description'     => esc_html__( 'Controls the color of form inputs when focus.', 'edumall' ),
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
		'background' => '#020D1B',
		'border'     => Edumall::SECONDARY_COLOR,
	),
	'active_callback' => array(
		array(
			'setting'  => 'site_skin',
			'operator' => '==',
			'value'    => 'dark',
		),
	),
) );
