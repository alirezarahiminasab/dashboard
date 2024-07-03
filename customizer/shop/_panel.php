<?php
$panel    = 'shop';
$priority = 1;

Edumall_Kirki::add_section( 'shop_general', array(
	'title'    => esc_html__( 'General', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'shop_archive', array(
	'title'    => esc_html__( 'Shop Archive', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'shop_single', array(
	'title'    => esc_html__( 'Shop Single', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'shopping_cart', array(
	'title'    => esc_html__( 'Shopping Cart', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
