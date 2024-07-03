<?php
$panel    = 'blog';
$priority = 1;

Edumall_Kirki::add_section( 'blog_archive', array(
	'title'    => esc_html__( 'Blog Archive', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );

Edumall_Kirki::add_section( 'blog_single', array(
	'title'    => esc_html__( 'Blog Single Post', 'edumall' ),
	'panel'    => $panel,
	'priority' => $priority++,
) );
