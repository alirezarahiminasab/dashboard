<?php
$section  = 'custom_js';
$priority = 1;

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'custom_js_enable',
	'label'       => esc_html__( 'Custom Javascript', 'edumall' ),
	'description' => esc_html__( 'Turn on to enable custom javascript', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 0,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'code',
	'settings' => 'custom_js',
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'jQuery(document).ready(function ($) {

});',
	'choices'  => array(
		'language' => 'javascript',
		'theme'    => 'monokai',
	),
) );
