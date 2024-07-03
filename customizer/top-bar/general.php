<?php
$section  = 'top_bar';
$priority = 1;
$prefix   = 'top_bar_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'global_top_bar',
	'label'    => esc_html__( 'Default Top Bar', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '01',
	'choices'  => Edumall_Top_Bar::instance()->get_list(),
) );

