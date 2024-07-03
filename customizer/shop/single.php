<?php
$section  = 'shop_single';
$priority = 1;
$prefix   = 'single_product_';

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
	'settings'    => 'product_single_header_type',
	'label'       => esc_html__( 'Header Style', 'edumall' ),
	'description' => esc_html__( 'Select default header style that displays on all single product pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_single_header_overlay',
	'label'    => esc_html__( 'Header Overlay', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
	'choices'  => array(
		''  => esc_html__( 'Use Global', 'edumall' ),
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_single_header_skin',
	'label'    => esc_html__( 'Header Skin', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '',
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
	'settings'    => 'product_single_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'edumall' ),
	'description' => esc_html__( 'Select default Title Bar that displays on all single product pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'edumall' ) ),
	'default'     => '05',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'product_single_title_bar_title',
	'label'       => esc_html__( 'Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text that displays on single product pages. Leave blank to use product title.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Our Shop', 'edumall' ),
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
	'settings'    => 'product_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on single product pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'single_shop_sidebar',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'product_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on single product pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'product_page_sidebar_position',
	'label'    => esc_html__( 'Sidebar Position', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'left',
	'choices'  => $sidebar_positions,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'number',
	'settings'    => 'product_page_single_sidebar_width',
	'label'       => esc_html__( 'Single Sidebar Width', 'edumall' ),
	'description' => esc_html__( 'Controls the width of the sidebar when only one sidebar is present. Input value as % unit. For e.g: 33.33333. Leave blank to use global setting.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '22.1',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'dimension',
	'settings'    => 'product_page_single_sidebar_offset',
	'label'       => esc_html__( 'Single Sidebar Offset', 'edumall' ),
	'description' => esc_html__( 'Controls the offset of the sidebar when only one sidebar is present. Enter value including any valid CSS unit. For e.g: 70px. Leave blank to use global setting.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
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
	'settings' => 'shop_single_preset',
	'label'    => esc_html__( 'Single Layout Preset', 'edumall' ),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1'                 => array(
			'label'    => esc_html__( 'None', 'edumall' ),
			'settings' => array(),
		),
		'list-left-sidebar'  => array(
			'label'    => esc_html__( 'List Layout - Left Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'        => 'single_shop_sidebar',
				'product_page_sidebar_position' => 'left',
				'single_product_tabs_style'     => 'list',
			),
		),
		'list-right-sidebar' => array(
			'label'    => esc_html__( 'List Layout - Right Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'        => 'single_shop_sidebar',
				'product_page_sidebar_position' => 'right',
				'single_product_tabs_style'     => 'list',
			),
		),
		'list-no-sidebar'    => array(
			'label'    => esc_html__( 'List Layout - No Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'    => 'none',
				'single_product_tabs_style' => 'list',
			),
		),
		'tabs-left-sidebar'  => array(
			'label'    => esc_html__( 'Tabs Layout - Left Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'        => 'single_shop_sidebar',
				'product_page_sidebar_position' => 'left',
				'single_product_tabs_style'     => 'tabs',
			),
		),
		'tabs-right-sidebar' => array(
			'label'    => esc_html__( 'Tabs Layout - Left Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'        => 'single_shop_sidebar',
				'product_page_sidebar_position' => 'right',
				'single_product_tabs_style'     => 'tabs',
			),
		),
		'tabs-no-sidebar'    => array(
			'label'    => esc_html__( 'Tabs Layout - No Sidebar', 'edumall' ),
			'settings' => array(
				'product_page_sidebar_1'    => 'none',
				'single_product_tabs_style' => 'tabs',
			),
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'single_product_layout_style',
	'label'    => esc_html__( 'Layout Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'slider',
	'choices'  => array(
		'list'   => esc_html__( 'List', 'edumall' ),
		'slider' => esc_html__( 'Slider', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_sticky_enable',
	'label'       => esc_html__( 'Sticky Feature/Details Columns', 'edumall' ),
	'description' => esc_html__( 'Turn on to enable sticky of product feature & details columns.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'single_product_tabs_style',
	'label'    => esc_html__( 'Tabs Style', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'list',
	'choices'  => array(
		'list' => esc_html__( 'List', 'edumall' ),
		'tabs' => esc_html__( 'Tabs', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'single_product_custom_attribute',
	'label'       => esc_html__( 'Custom Attribute', 'edumall' ),
	'description' => esc_html__( 'Select a custom attribute that displays on beside product review rating.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'book-author',
	'choices'     => Edumall_Woo::instance()->get_custom_attributes_list(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'single_product_custom_attribute_label',
	'label'    => esc_html__( 'Custom Attribute Label', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_categories_enable',
	'label'       => esc_html__( 'Categories', 'edumall' ),
	'description' => esc_html__( 'Turn on to display the categories.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_tags_enable',
	'label'       => esc_html__( 'Tags', 'edumall' ),
	'description' => esc_html__( 'Turn on to display the tags.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_sharing_enable',
	'label'       => esc_html__( 'Sharing', 'edumall' ),
	'description' => esc_html__( 'Turn on to display the sharing.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_up_sells_enable',
	'label'       => esc_html__( 'Up-sells products', 'edumall' ),
	'description' => esc_html__( 'Turn on to display the up-sells products section.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_related_enable',
	'label'       => esc_html__( 'Related products', 'edumall' ),
	'description' => esc_html__( 'Turn on to display the related products section.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Off', 'edumall' ),
		'1' => esc_html__( 'On', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'            => 'number',
	'settings'        => 'product_related_number',
	'label'           => esc_html__( 'Number related products', 'edumall' ),
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
			'setting'  => 'single_product_related_enable',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );
