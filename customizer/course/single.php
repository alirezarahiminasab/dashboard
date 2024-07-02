<?php
$section  = 'course_single';
$priority = 1;
$prefix   = 'single_course_';

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'course_single_header_type',
	'label'       => esc_html__('Header Style', 'edumall-child'),
	'description' => esc_html__('Select default header style that displays on all single course pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list(true, esc_html__('Use Global Header Style', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_single_header_overlay',
	'label'    => esc_html__('Header Overlay', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''  => esc_html__('Use Global', 'edumall-child'),
		'0' => esc_html__('No', 'edumall-child'),
		'1' => esc_html__('Yes', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_single_header_skin',
	'label'    => esc_html__('Header Skin', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''      => esc_html__('Use Global', 'edumall-child'),
		'dark'  => esc_html__('Dark', 'edumall-child'),
		'light' => esc_html__('Light', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Page Title Bar', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'course_single_title_bar_layout',
	'label'       => esc_html__('Title Bar Style', 'edumall-child'),
	'description' => esc_html__('Select default Title Bar that displays on all single course pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list(true, esc_html__('Use Global Title Bar', 'edumall-child')),
	'default'     => '03',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Others', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'preset',
	'settings' => 'course_single_preset',
	'label'    => esc_html__('Course Layout Preset', 'edumall-child'),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1' => array(
			'label'    => esc_html__('None', 'edumall-child'),
			'settings' => array(),
		),
		'01' => array(
			'label'    => esc_html__('Preset 01', 'edumall-child'),
			'settings' => array(),
		),
		'02' => array(
			'label'    => esc_html__('Preset 02', 'edumall-child'),
			'settings' => array(
				'course_single_title_bar_layout' => '04',
			),
		),
		'03' => array(
			'label'    => esc_html__('Preset 03', 'edumall-child'),
			'settings' => array(
				'course_single_title_bar_layout' => '05',
				'single_course_layout'           => '02',
			),
		),
		'04' => array(
			'label'    => esc_html__('Preset 04', 'edumall-child'),
			'settings' => array(
				'course_single_title_bar_layout' => '03',
				'single_course_layout'           => '03',
			),
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_course_layout',
	'label'       => esc_html__('Layout', 'edumall-child'),
	'description' => esc_html__('Select default layout for single course pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'01' => esc_attr__('Layout 01', 'edumall-child'),
		'02' => esc_attr__('Layout 02', 'edumall-child'),
		'03' => esc_attr__('Layout 03', 'edumall-child'),
	),
));
