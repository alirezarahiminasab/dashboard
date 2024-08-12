<?php
$panel    = 'advanced';
$priority = 1;

Edumall_Kirki::add_section('advanced', array(
	'title'    => esc_html__('Advanced', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('light_gallery', array(
	'title'    => esc_html__('Light Gallery', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
