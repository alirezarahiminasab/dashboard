<?php
$panel    = 'advanced';
$priority = 1;

Edumall_Kirki::add_section( 'advanced', array(
	'title'    => esc_html__( 'Advanced', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Edumall_Kirki::add_section( 'light_gallery', array(
	'title'    => esc_html__( 'Light Gallery', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );
