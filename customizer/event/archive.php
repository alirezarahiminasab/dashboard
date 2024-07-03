<?php
$section  = 'event_archive';
$priority = 1;
$prefix   = 'event_archive_';

$sidebar_positions   = Edumall_Helper::get_list_sidebar_positions();
$registered_sidebars = Edumall_Helper::get_registered_sidebars();

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Header', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'event_archive_header_type',
	'label'       => esc_html__( 'Header Style', 'edumall' ),
	'description' => esc_html__( 'Select header style that displays on event archive pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'event_archive_header_overlay',
	'label'    => esc_html__( 'Header Overlay', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'choices'  => array(
		''  => esc_html__( 'Use Global', 'edumall' ),
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'event_archive_header_skin',
	'label'    => esc_html__( 'Header Skin', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'choices'  => array(
		''      => esc_html__( 'Use Global', 'edumall' ),
		'dark'  => esc_html__( 'Dark', 'edumall' ),
		'light' => esc_html__( 'Light', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Page Title Bar', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'event_archive_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'edumall' ),
	'description' => esc_html__( 'Select default Title Bar that displays on archive event pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'edumall' ) ),
	'default'     => '01',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'event_archive_title_bar_title',
	'label'       => esc_html__( 'Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text that displays on archive event pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Events', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Sidebar', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'event_archive_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on event archive pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'event_sidebar',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'event_archive_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on event archive pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'event_archive_page_sidebar_position',
	'label'    => esc_html__( 'Sidebar Position', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'left',
	'choices'  => $sidebar_positions,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'number',
	'settings'    => 'event_archive_single_sidebar_width',
	'label'       => esc_html__( 'Single Sidebar Width', 'edumall' ),
	'description' => esc_html__( 'Controls the width of the sidebar when only one sidebar is present. Input value as % unit. For e.g: 33.33333. Leave blank to use global setting.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '25',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'dimension',
	'settings'    => 'event_archive_single_sidebar_offset',
	'label'       => esc_html__( 'Single Sidebar Offset', 'edumall' ),
	'description' => esc_html__( 'Controls the offset of the sidebar when only one sidebar is present. Enter value including any valid CSS unit. For e.g: 70px. Leave blank to use global setting.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '20px',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => 'event_archive_page_sidebar_style',
	'label'    => esc_html__( 'Sidebar Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '01',
	'choices'  => [
		'01' => '01',
		'02' => '02',
		'03' => '03',
	],
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Others', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'preset',
	'settings' => 'event_archive_preset',
	'label'    => esc_html__( 'Event Layout Preset', 'edumall' ),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1' => array(
			'label'    => esc_html__( 'None', 'edumall' ),
			'settings' => array(),
		),
		'01' => array(
			'label'    => esc_html__( 'Layout 01', 'edumall' ),
			'settings' => array(
				'event_archive_style' => 'grid-01',
			),
		),
		'02' => array(
			'label'    => esc_html__( 'Layout 02', 'edumall' ),
			'settings' => array(
				'event_archive_style'          => 'grid-02',
				'event_archive_page_sidebar_1' => 'none',
				'event_archive_filtering'      => '1',
			),
		),
		'03' => array(
			'label'    => esc_html__( 'Layout 03', 'edumall' ),
			'settings' => array(
				'event_archive_style'          => 'list',
				'event_archive_page_sidebar_1' => 'none',
				'event_archive_filtering'      => '1',
			),
		),
		'04' => array(
			'label'    => esc_html__( 'Layout 04', 'edumall' ),
			'settings' => array(
				'event_archive_style' => 'list',
			),
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'event_archive_style',
	'label'       => esc_html__( 'Style', 'edumall' ),
	'description' => esc_html__( 'Select event style that display for event listing page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'grid-01',
	'choices'     => array(
		'grid-01' => esc_attr__( 'Grid 01', 'edumall' ),
		'grid-02' => esc_attr__( 'Grid 02', 'edumall' ),
		'list'    => esc_attr__( 'List', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'number',
	'settings'    => 'event_archive_number_item',
	'label'       => esc_html__( 'Number items', 'edumall' ),
	'description' => esc_html__( 'Controls the number of products display on events page', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 12,
	'choices'     => array(
		'min'  => 1,
		'max'  => 50,
		'step' => 1,
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'event_archive_filtering',
	'label'       => esc_html__( 'Filtering Bar', 'edumall' ),
	'description' => esc_html__( 'Turn on to show filtering form bar that displays above event list.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="group_title">' . esc_html__( 'Grid Columns', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'event_archive_lg_columns',
	'label'     => esc_html__( 'Large Device', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 4,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'event_archive_md_columns',
	'label'     => esc_html__( 'Medium Device', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 2,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'event_archive_sm_columns',
	'label'     => esc_html__( 'Small Device', 'edumall' ),
	'section'   => $section,
	'priority'  => $priority++,
	'default'   => 1,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 6,
		'step' => 1,
	),
) );
