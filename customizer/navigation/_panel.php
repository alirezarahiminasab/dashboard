<?php
$panel    = 'navigation';
$priority = 1;

Edumall_Kirki::add_section( 'navigation', array(
	'title'    => esc_html__( 'Desktop Menu', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Edumall_Kirki::add_section( 'navigation_minimal_01', array(
	'title'    => esc_html__( 'Off Canvas Menu', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );

Edumall_Kirki::add_section( 'navigation_mobile', array(
	'title'    => esc_html__( 'Mobile Menu', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority ++,
) );
