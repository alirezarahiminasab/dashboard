<?php
$section  = 'event_single';
$priority = 1;
$prefix   = 'single_event_';

$sidebar_positions   = Edumall_Helper::get_list_sidebar_positions();
$registered_sidebars = Edumall_Helper::get_registered_sidebars();

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Header', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'event_single_header_type',
	'label'       => esc_html__('Header Style', 'edumall-child'),
	'description' => esc_html__('Select default header style that displays on all single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list(true, esc_html__('Use Global Header Style', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'event_single_header_overlay',
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
	'settings' => 'event_single_header_skin',
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
	'settings'    => 'event_single_title_bar_layout',
	'label'       => esc_html__('Title Bar Style', 'edumall-child'),
	'description' => esc_html__('Select default Title Bar that displays on single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list(true, esc_html__('Use Global Title Bar', 'edumall-child')),
	'default'     => '05',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__('Sidebar', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'event_page_sidebar_1',
	'label'       => esc_html__('Sidebar 1', 'edumall-child'),
	'description' => esc_html__('Select sidebar 1 that will display on single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'event_page_sidebar_2',
	'label'       => esc_html__('Sidebar 2', 'edumall-child'),
	'description' => esc_html__('Select sidebar 2 that will display on single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'event_page_sidebar_position',
	'label'    => esc_html__('Sidebar Position', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'right',
	'choices'  => $sidebar_positions,
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
	'settings' => 'single_event_preset',
	'label'    => esc_html__('Event Layout Preset', 'edumall-child'),
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
			'label'    => esc_html__('Layout 01', 'edumall-child'),
			'settings' => array(
				'single_event_style' => '01',
			),
		),
		'02' => array(
			'label'    => esc_html__('Layout 02', 'edumall-child'),
			'settings' => array(
				'single_event_style' => '02',
			),
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_event_style',
	'label'       => esc_html__('Layout', 'edumall-child'),
	'description' => esc_html__('Select style of all single event post pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'01' => '01',
		'02' => '02',
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_event_speaker_enable',
	'label'       => esc_html__('Our Speakers', 'edumall-child'),
	'description' => esc_html__('Turn on to display our speakers block on single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'textarea',
	'settings' => 'single_event_speaker_text',
	'label'    => esc_html__('Speaker Description', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => esc_html__('Register online, get your ticket, meet up with our inspirational speakers and specialists in the field to share your ideas.', 'edumall-child'),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_event_comment_enable',
	'label'       => esc_html__('Comments', 'edumall-child'),
	'description' => esc_html__('Turn on to display comments on single event pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => 'single_event_comment_help_title',
	'label'       => esc_html__('Comment Title', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__('We\'re always eager to hear from you.', 'edumall-child'),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'textarea',
	'settings'    => 'single_event_comment_help_desc',
	'label'       => esc_html__('Comment Text', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__('If you’d like to learn more about us or have a general comments and suggestions about the site, email us at', 'edumall-child'),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => 'single_event_comment_help_email',
	'label'       => esc_html__('Comment Email', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
));
