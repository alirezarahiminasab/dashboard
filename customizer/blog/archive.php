<?php
$section  = 'blog_archive';
$priority = 1;
$prefix   = 'blog_archive_';

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
	'settings'    => 'blog_archive_header_type',
	'label'       => esc_html__( 'Header Style', 'edumall' ),
	'description' => esc_html__( 'Select header style that displays on blog archive & taxonomy pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '',
	'choices'     => Edumall_Header::instance()->get_list( true, esc_html__( 'Use Global Header Style', 'edumall' ) ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'blog_archive_header_overlay',
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
	'settings' => 'blog_archive_header_skin',
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
	'settings'    => 'blog_archive_title_bar_layout',
	'label'       => esc_html__( 'Title Bar Style', 'edumall' ),
	'description' => esc_html__( 'Select default Title Bar that displays on blog archive & taxonomy pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'choices'     => Edumall_Title_Bar::instance()->get_list( true, esc_html__( 'Use Global Title Bar', 'edumall' ) ),
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
	'settings'    => 'blog_archive_page_sidebar_1',
	'label'       => esc_html__( 'Sidebar 1', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 1 that will display on blog archive & taxonomy pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'blog_sidebar',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'blog_archive_page_sidebar_2',
	'label'       => esc_html__( 'Sidebar 2', 'edumall' ),
	'description' => esc_html__( 'Select sidebar 2 that will display on blog archive & taxonomy pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'none',
	'choices'     => $registered_sidebars,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'blog_archive_page_sidebar_position',
	'label'    => esc_html__( 'Sidebar Position', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'right',
	'choices'  => $sidebar_positions,
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
	'settings' => 'blog_archive_preset',
	'label'    => esc_html__( 'Blog Layout Preset', 'edumall' ),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1'           => array(
			'label'    => esc_html__( 'None', 'edumall' ),
			'settings' => array(),
		),
		'grid'         => array(
			'label'    => esc_html__( 'Grid', 'edumall' ),
			'settings' => array(
				'blog_archive_style'          => 'grid',
				'blog_archive_page_sidebar_1' => 'none',
			),
		),
		'grid-sidebar' => array(
			'label'    => esc_html__( 'Grid with Sidebar', 'edumall' ),
			'settings' => array(
				'blog_archive_style' => 'grid',
			),
		),
		'grid-02'      => array(
			'label'    => esc_html__( 'Grid Wide', 'edumall' ),
			'settings' => array(
				'blog_archive_style'          => 'grid-wide',
				'blog_archive_caption_style'  => '02',
				'blog_archive_page_sidebar_1' => 'none',
			),
		),
		'special'      => array(
			'label'    => esc_html__( 'Special', 'edumall' ),
			'settings' => array(
				'blog_archive_special_layout' => '1',
			),
		),
		'list-01'      => array(
			'label'    => esc_html__( 'List Layout 01', 'edumall' ),
			'settings' => array(
				'blog_archive_style'         => 'list-01',
				'blog_archive_caption_style' => '02',
			),
		),
		'list-02'      => array(
			'label'    => esc_html__( 'List Layout 02', 'edumall' ),
			'settings' => array(
				'blog_archive_style'         => 'list-02',
				'blog_archive_caption_style' => '02',
			),
		),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'blog_archive_style',
	'label'       => esc_html__( 'Blog Style', 'edumall' ),
	'description' => esc_html__( 'Select style that used for blog archive & taxonomy pages', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 'grid',
	'choices'     => array(
		'grid'      => esc_attr__( 'Grid', 'edumall' ),
		'grid-wide' => esc_attr__( 'Grid Wide', 'edumall' ),
		'list-01'   => esc_attr__( 'List 01', 'edumall' ),
		'list-02'   => esc_attr__( 'List 02', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'blog_archive_masonry',
	'label'    => esc_html__( 'Masonry', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '1',
	'choices'  => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'blog_archive_caption_style',
	'label'       => esc_html__( 'Blog Caption Style', 'edumall' ),
	'description' => esc_html__( 'Select blog caption style that used for blog archive & taxonomy pages', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => array(
		'01' => '01',
		'02' => '02',
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'number',
	'settings'    => 'blog_archive_posts_per_page',
	'label'       => esc_html__( 'Number posts', 'edumall' ),
	'description' => esc_html__( 'Controls the number of posts per page', 'edumall' ),
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
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Home Special Layout', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'blog_archive_special_layout',
	'label'       => esc_html__( 'Blog Page Special Layout?', 'edumall' ),
	'description' => esc_html__( 'Turn on this option to used special layout for home blog page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'blog_archive_post_by_cat_block_on',
	'label'       => esc_html__( 'Show Post Blocks', 'edumall' ),
	'description' => esc_html__( 'Turn on this option to show all post blocks with each categories.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

$categories = array();

if ( is_customize_preview() ) {
	$terms = get_categories( [
		'parent' => 0,
	] );

	if ( ! empty( $terms ) ) {
		foreach ( $terms as $category ) {
			$categories[ $category->term_id ] = $category->name;
		}
	}
}

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'blog_archive_post_by_cat_ids',
	'label'       => esc_html__( 'Narrow categories', 'edumall' ),
	'description' => esc_html__( 'Select which categories that you want to show post block.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'multiple'    => 1000,
	'choices'     => $categories,
	'default'     => array(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'number',
	'settings'    => 'blog_archive_post_by_cat_number',
	'label'       => esc_html__( 'Number items', 'edumall' ),
	'description' => esc_html__( 'Controls the number of posts for each category', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 5,
	'choices'     => array(
		'min'  => 1,
		'max'  => 50,
		'step' => 1,
	),
) );
