<?php
$section  = 'title_bar';
$priority = 1;
$prefix   = 'title_bar_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => $prefix . 'layout',
	'label'       => esc_html__( 'Global Title Bar', 'edumall' ),
	'description' => esc_html__( 'Select default title bar that displays on all pages.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '01',
	'choices'     => Edumall_Title_Bar::instance()->get_list(),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'title_bar_breadcrumb_enable',
	'label'       => esc_html__( 'Breadcrumb Enable', 'edumall' ),
	'description' => esc_html__( 'This setting control visibility of Breadcrumb in Title Bar (type 01, 02, 06, 08)', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'No', 'edumall' ),
		'1' => esc_html__( 'Yes', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Heading', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'search_title',
	'label'       => esc_html__( 'Search Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on search results page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Search results for: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'home_title',
	'label'       => esc_html__( 'Home Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text that displays on front latest posts page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => wp_kses( __( 'Latest news <br/> are on top all times', 'edumall' ), [
		'br' => [],
	] ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_category_title',
	'label'       => esc_html__( 'Archive Category Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Category: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_tag_title',
	'label'       => esc_html__( 'Archive Tag Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive tag page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Tag: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_author_title',
	'label'       => esc_html__( 'Archive Author Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive author page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Author: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_year_title',
	'label'       => esc_html__( 'Archive Year Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive year page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Year: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_month_title',
	'label'       => esc_html__( 'Archive Month Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive month page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Month: ', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => $prefix . 'archive_day_title',
	'label'       => esc_html__( 'Archive Day Heading', 'edumall' ),
	'description' => esc_html__( 'Enter text prefix that displays on archive day page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'Day: ', 'edumall' ),
) );
