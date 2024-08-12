<?php
$panel    = 'course';
$priority = 1;

Edumall_Kirki::add_section('course_archive', array(
	'title'    => esc_html__('Course Archive', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('course_category', array(
	'title'    => esc_html__('Course Category', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('course_single', array(
	'title'    => esc_html__('Course Single', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
