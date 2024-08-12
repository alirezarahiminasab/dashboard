<?php
$panel    = 'portfolio';
$priority = 1;

Edumall_Kirki::add_section('archive_portfolio', array(
	'title'    => esc_html__('Archive', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('single_portfolio', array(
	'title'    => esc_html__('Single', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
