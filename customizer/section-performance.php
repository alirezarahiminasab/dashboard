<?php
$section  = 'performance';
$priority = 1;
$prefix   = 'performance_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'disable_emoji',
	'label'       => esc_html__( 'Disable Emojis', 'edumall' ),
	'description' => esc_html__( 'Remove Wordpress Emojis functionality.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'disable_embeds',
	'label'       => esc_html__( 'Disable Embeds', 'edumall' ),
	'description' => esc_html__( 'Remove Wordpress Embeds functionality.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => 1,
) );
