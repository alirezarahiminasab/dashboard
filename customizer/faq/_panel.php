<?php
$panel    = 'faq';
$priority = 1;

Edumall_Kirki::add_section( 'faq_archive', array(
	'title'    => esc_html__( 'FAQ Archive', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'faq_single', array(
	'title'    => esc_html__( 'FAQ Single', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
