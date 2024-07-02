<?php
$section  = 'archive_portfolio';
$priority = 1;
$prefix   = 'archive_portfolio_';

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
	'settings'    => 'portfolio_archive_header_type',
	'label'       => esc_html__('Header Style', 'edumall-child'),
	'description' => esc_html__('Select default header style that displays on archive portfolio page.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list(true, esc_html__('Use Global Header Style', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_archive_header_overlay',
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
	'settings' => 'portfolio_archive_header_skin',
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
	'settings'    => 'portfolio_archive_title_bar_layout',
	'label'       => esc_html__('Title Bar Style', 'edumall-child'),
	'description' => esc_html__('Select default Title Bar that displays on all archive portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list(true, esc_html__('Use Global Title Bar', 'edumall-child')),
	'default'     => 'none',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => 'portfolio_archive_title_bar_title',
	'label'       => esc_html__('Heading', 'edumall-child'),
	'description' => esc_html__('Enter text that displays on archive portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__('Portfolios', 'edumall-child'),
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
	'settings'    => 'portfolio_archive_page_sidebar_1',
	'label'       => esc_html__('Sidebar 1', 'edumall-child'),
	'description' => esc_html__('Select sidebar 1 that will display on portfolio archive pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'portfolio_archive_page_sidebar_2',
	'label'       => esc_html__('Sidebar 2', 'edumall-child'),
	'description' => esc_html__('Select sidebar 2 that will display on portfolio archive pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_archive_page_sidebar_position',
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
	'type'        => 'number',
	'settings'    => 'archive_portfolio_posts_per_page',
	'label'       => esc_html__('Number posts', 'edumall-child'),
	'description' => esc_html__('Controls the number of portfolios per page', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 12,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => $prefix . 'external_url',
	'label'       => esc_html__('External Url', 'edumall-child'),
	'description' => esc_html__('Go to external url instead of go to single portfolio pages from archive portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__('No', 'edumall-child'),
		'1' => esc_html__('Yes', 'edumall-child'),
	),
));
