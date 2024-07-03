<?php
$section  = 'course_category';
$priority = 1;
$prefix   = 'course_category_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_category_course_tabs',
	'label'       => esc_html__( 'Course Tabs', 'edumall' ),
	'description' => esc_html__( 'Turn on to show course tabs on category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_category_featured_courses',
	'label'       => esc_html__( 'Featured Course Carousel', 'edumall' ),
	'description' => esc_html__( 'Turn on to show featured courses carousel on category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_category_popular_topics',
	'label'       => esc_html__( 'Popular Topics', 'edumall' ),
	'description' => esc_html__( 'Turn on to show popular topics section on category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_category_popular_instructors',
	'label'       => esc_html__( 'Popular Instructors', 'edumall' ),
	'description' => esc_html__( 'Turn on to show popular instructors section on category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'course_category_page_heading',
	'label'       => esc_html__( 'Page Heading', 'edumall' ),
	'description' => esc_html__( 'Turn on to show page heading above course list on category page.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '1',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );
