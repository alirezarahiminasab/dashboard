<?php
$section  = 'contact_info';
$priority = 1;
$prefix   = 'contact_info_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'text',
	'settings' => $prefix . 'phone',
	'label'    => esc_html__( 'Phone Number', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '(+1) 234567899',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'text',
	'settings' => $prefix . 'email',
	'label'    => esc_html__( 'Email', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => 'info@edumall.com',
) );
