<?php
$panel    = 'zoom_meeting';
$priority = 1;

Edumall_Kirki::add_section('zoom_meeting_archive', array(
	'title'    => esc_html__('Archive', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('zoom_meeting_single', array(
	'title'    => esc_html__('Single', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
