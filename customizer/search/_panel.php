<?php
$panel    = 'search';
$priority = 1;

Edumall_Kirki::add_section('search_page', array(
	'title'    => esc_html__('Search Page', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('search_popup', array(
	'title'    => esc_html__('Search Popup', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
