<?php
$panel    = 'faq';
$priority = 1;

Edumall_Kirki::add_section('faq_archive', array(
	'title'    => esc_html__('FAQ Archive', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('faq_single', array(
	'title'    => esc_html__('FAQ Single', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));
