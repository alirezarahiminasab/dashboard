<?php
$section  = 'course_archive';
$priority = 1;
$prefix   = 'course_archive_';

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
	'settings'    => 'course_archive_header_type',
	'label'       => esc_html__('Header Style', 'edumall-child'),
	'description' => esc_html__('Select header style that displays on course archive pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list(true, esc_html__('Use Global Header Style', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_archive_header_overlay',
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
	'settings' => 'course_archive_header_skin',
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
	'settings'    => 'course_archive_title_bar_layout',
	'label'       => esc_html__('Title Bar Style', 'edumall-child'),
	'description' => esc_html__('Select default Title Bar that displays on archive course pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list(true, esc_html__('Use Global Title Bar', 'edumall-child')),
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
	'settings'    => 'course_archive_page_sidebar_1',
	'label'       => esc_html__('Sidebar 1', 'edumall-child'),
	'description' => esc_html__('Select sidebar 1 that will display on course archive pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'course_sidebar',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'course_archive_page_sidebar_2',
	'label'       => esc_html__('Sidebar 2', 'edumall-child'),
	'description' => esc_html__('Select sidebar 2 that will display on course archive pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'course_archive_page_sidebar_position',
	'label'    => esc_html__('Sidebar Position', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'left',
	'choices'  => $sidebar_positions,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'number',
	'settings'    => 'course_archive_single_sidebar_width',
	'label'       => esc_html__('Single Sidebar Width', 'edumall-child'),
	'description' => esc_html__('Controls the width of the sidebar when only one sidebar is present. Input value as % unit. For e.g: 33.33333. Leave blank to use global setting.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '25',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'dimension',
	'settings'    => 'course_archive_single_sidebar_offset',
	'label'       => esc_html__('Single Sidebar Offset', 'edumall-child'),
	'description' => esc_html__('Controls the offset of the sidebar when only one sidebar is present. Enter value including any valid CSS unit. For e.g: 70px. Leave blank to use global setting.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '20px',
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'select',
	'settings' => 'course_archive_page_sidebar_style',
	'label'    => esc_html__('Sidebar Style', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '02',
	'choices'  => [
		'01' => '01',
		'02' => '02',
		'03' => '03',
	],
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
	'settings' => 'course_archive_preset',
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
			'label'    => esc_html__('Layout 01', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'          => 'grid',
				'course_archive_grid_style'      => 'grid-01',
				'course_archive_lg_columns'      => 4,
				'course_archive_number_item'     => 16,
				'course_archive_page_sidebar_1'  => 'none',
				'course_archive_sorting'         => '0',
				'course_archive_filtering'       => '1',
				'course_archive_layout_switcher' => '1',
			),
		),
		'02' => array(
			'label'    => esc_html__('Layout 02', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'          => 'grid',
				'course_archive_grid_style'      => 'grid-02',
				'course_archive_lg_columns'      => 5,
				'course_archive_number_item'     => 20,
				'course_archive_page_sidebar_1'  => 'none',
				'course_archive_sorting'         => '0',
				'course_archive_filtering'       => '1',
				'course_archive_layout_switcher' => '1',
			),
		),
		'03' => array(
			'label'    => esc_html__('Layout 03', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'          => 'grid',
				'course_archive_grid_style'      => 'grid-02',
				'course_archive_lg_columns'      => 4,
				'course_archive_number_item'     => 15,
				'course_archive_page_sidebar_1'  => 'course_sidebar',
				'course_archive_sorting'         => '0',
				'course_archive_filtering'       => '1',
				'course_archive_layout_switcher' => '1',
			),
		),
		'04' => array(
			'label'    => esc_html__('Layout 04', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'                => 'grid',
				'course_archive_grid_style'            => 'grid-01',
				'course_archive_lg_columns'            => 4,
				'course_archive_number_item'           => 12,
				'course_archive_page_sidebar_1'        => 'course_sidebar',
				'course_archive_page_sidebar_position' => 'right',
				'course_archive_page_sidebar_style'    => '03',
				'course_archive_sorting'               => '0',
				'course_archive_filtering'             => '1',
				'course_archive_layout_switcher'       => '1',
			),
		),
		'05' => array(
			'label'    => esc_html__('Layout 05', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'                => 'list',
				'course_archive_list_style'            => 'list',
				'course_archive_page_sidebar_1'        => 'course_sidebar',
				'course_archive_page_sidebar_position' => 'left',
				'course_archive_page_sidebar_style'    => '02',
				'course_archive_number_item'           => 8,
				'course_archive_sorting'               => '1',
				'course_archive_filtering'             => '0',
			),
		),
		'06' => array(
			'label'    => esc_html__('Layout 06', 'edumall-child'),
			'settings' => array(
				'course_archive_layout'                => 'list',
				'course_archive_list_style'            => 'list-02',
				'course_archive_page_sidebar_1'        => 'none',
				'course_archive_page_sidebar_position' => 'left',
				'course_archive_page_sidebar_style'    => '02',
				'course_archive_number_item'           => 8,
				'course_archive_sorting'               => '0',
				'course_archive_filtering'             => '1',
			),
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_archive_sorting',
	'label'       => esc_html__('Sorting', 'edumall-child'),
	'description' => esc_html__('Turn on to show sorting select options that displays above course list.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_archive_filtering',
	'label'       => esc_html__('Filtering', 'edumall-child'),
	'description' => esc_html__('Turn on to show filtering button that displays above course list.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_archive_layout_switcher',
	'label'       => esc_html__('Layout Switcher', 'edumall-child'),
	'description' => esc_html__('Turn on to show layout switcher button that displays above course list.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'course_archive_layout',
	'label'       => esc_html__('Layout', 'edumall-child'),
	'description' => esc_html__('Select course layout that display for course listing page.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'list',
	'choices'     => array(
		'list' => esc_attr__('List', 'edumall-child'),
		'grid' => esc_attr__('Grid', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'select',
	'settings' => 'course_archive_grid_style',
	'label'    => esc_html__('Grid Style', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'grid-01',
	'choices'  => array(
		'grid-01' => esc_attr__('Grid 01', 'edumall-child'),
		'grid-02' => esc_attr__('Grid 02', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'select',
	'settings' => 'course_archive_list_style',
	'label'    => esc_html__('List Style', 'edumall-child'),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'list',
	'choices'  => array(
		'list'    => esc_attr__('List 01', 'edumall-child'),
		'list-02' => esc_attr__('List 02', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'number',
	'settings'    => 'course_archive_number_item',
	'label'       => esc_html__('Number items', 'edumall-child'),
	'description' => esc_html__('Controls the number of courses display on course listing page', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 8,
	'choices'     => array(
		'min'  => 1,
		'max'  => 50,
		'step' => 1,
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__('Grid Columns', 'edumall-child') . '</div>',
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'slider',
	'settings'  => 'course_archive_lg_columns',
	'label'     => esc_html__('Large Device', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 4,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'slider',
	'settings'  => 'course_archive_md_columns',
	'label'     => esc_html__('Medium Device', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 2,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'      => 'slider',
	'settings'  => 'course_archive_sm_columns',
	'label'     => esc_html__('Small Device', 'edumall-child'),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 1,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
));
