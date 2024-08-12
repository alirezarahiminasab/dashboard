<?php
$section  = 'single_portfolio';
$priority = 1;
$prefix   = 'single_portfolio_';

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
	'settings'    => 'portfolio_single_header_type',
	'label'       => esc_html__('Header Style', 'edumall-child'),
	'description' => esc_html__('Select default header style that displays on all single portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list(true, esc_html__('Use Global Header Style', 'edumall-child')),
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_single_header_overlay',
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
	'settings' => 'portfolio_single_header_skin',
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
	'settings'    => 'portfolio_single_title_bar_layout',
	'label'       => esc_html__('Page Title Bar', 'edumall-child'),
	'description' => esc_html__('Select default Title Bar that displays on all single portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list(true, esc_html__('Use Global Title Bar', 'edumall-child')),
	'default'     => 'none',
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'text',
	'settings'    => 'portfolio_single_title_bar_title',
	'label'       => esc_html__('Heading', 'edumall-child'),
	'description' => esc_html__('Enter text that displays on single portfolio pages. Leave blank to use portfolio title.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__('Portfolio', 'edumall-child'),
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
	'settings'    => 'portfolio_page_sidebar_1',
	'label'       => esc_html__('Sidebar 1', 'edumall-child'),
	'description' => esc_html__('Select sidebar 1 that will display on single portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'portfolio_page_sidebar_2',
	'label'       => esc_html__('Sidebar 2', 'edumall-child'),
	'description' => esc_html__('Select sidebar 2 that will display on single portfolio pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
));

Edumall_Kirki::add_field('theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'portfolio_page_sidebar_position',
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
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_sticky_detail_enable',
	'label'       => esc_html__('Sticky Detail Column', 'edumall-child'),
	'description' => esc_html__('Turn on to enable sticky of detail column.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_site_skin',
	'label'       => esc_html__('Site Skin', 'edumall-child'),
	'description' => esc_html__('Select skin of all single portfolio post pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'light',
	'choices'     => array(
		'dark'  => esc_html__('Dark', 'edumall-child'),
		'light' => esc_html__('Light', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_style',
	'label'       => esc_html__('Single Portfolio Style', 'edumall-child'),
	'description' => esc_html__('Select style of all single portfolio post pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'image-list',
	'choices'     => array(
		'blank'           => esc_html__('Blank (Build with Elementor)', 'edumall-child'),
		'image-list'      => esc_html__('Image List', 'edumall-child'),
		'image-list-wide' => esc_html__('Image List - Wide', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_video_enable',
	'label'       => esc_html__('Video', 'edumall-child'),
	'description' => esc_html__('Controls the video visibility on portfolio post pages.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => array(
		'none'  => esc_html__('Hide', 'edumall-child'),
		'above' => esc_html__('Show Above Feature Image', 'edumall-child'),
		'below' => esc_html__('Show Below Feature Image', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_feature_caption',
	'label'       => esc_html__('Image Caption', 'edumall-child'),
	'description' => esc_html__('Turn on to display comments on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Hide', 'edumall-child'),
		'1' => esc_html__('Show', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_comment_enable',
	'label'       => esc_html__('Comments', 'edumall-child'),
	'description' => esc_html__('Turn on to display comments on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_categories_enable',
	'label'       => esc_html__('Categories', 'edumall-child'),
	'description' => esc_html__('Turn on to display categories on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_tags_enable',
	'label'       => esc_html__('Tags', 'edumall-child'),
	'description' => esc_html__('Turn on to display tags on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_share_enable',
	'label'       => esc_html__('Share', 'edumall-child'),
	'description' => esc_html__('Turn on to display Share list on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_portfolio_related_enable',
	'label'       => esc_html__('Related Portfolio', 'edumall-child'),
	'description' => esc_html__('Turn on this option to display related portfolio section.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__('Off', 'edumall-child'),
		'1' => esc_html__('On', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'text',
	'settings'        => 'portfolio_related_title',
	'label'           => esc_html__('Related Title Section', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => esc_html__('Related Projects', 'edumall-child'),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'multicheck',
	'settings'        => 'portfolio_related_by',
	'label'           => esc_attr__('Related By', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => array('portfolio_category'),
	'choices'         => array(
		'portfolio_category' => esc_html__('Portfolio Category', 'edumall-child'),
		'portfolio_tags'     => esc_html__('Portfolio Tags', 'edumall-child'),
	),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'            => 'number',
	'settings'        => 'portfolio_related_number',
	'label'           => esc_html__('Number related portfolio', 'edumall-child'),
	'description'     => esc_html__('Controls the number of related portfolio', 'edumall-child'),
	'section'         => $section,
	'priority'        => $priority++,
	'default'         => 5,
	'choices'         => array(
		'min'  => 3,
		'max'  => 30,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'single_portfolio_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'select',
	'settings'    => 'single_portfolio_pagination',
	'label'       => esc_html__('Previous/Next Pagination', 'edumall-child'),
	'description' => esc_html__('Select type of previous/next portfolio pagination on single portfolio posts.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'none' => esc_html__('None', 'edumall-child'),
		'01'   => esc_html__('Style 01', 'edumall-child'),
		'02'   => esc_html__('Style 02', 'edumall-child'),
		'03'   => esc_html__('Style 03', 'edumall-child'),
	),
));
