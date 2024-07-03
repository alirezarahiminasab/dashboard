<?php
$panel    = 'event';
$priority = 1;

Edumall_Kirki::add_section( 'event_archive', array(
	'title'    => esc_html__( 'Event Archive', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'event_single', array(
	'title'    => esc_html__( 'Event Single', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
