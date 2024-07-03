<?php
$section  = 'social_sharing';
$priority = 1;
$prefix   = 'social_sharing_';

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'multicheck',
	'settings'    => $prefix . 'item_enable',
	'label'       => esc_attr__( 'Sharing Links', 'edumall' ),
	'description' => esc_html__( 'Check to the box to enable social share links.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array( 'facebook', 'twitter', 'linkedin', 'tumblr', 'email' ),
	'choices'     => array(
		'facebook' => esc_attr__( 'Facebook', 'edumall' ),
		'twitter'  => esc_attr__( 'Twitter', 'edumall' ),
		'linkedin' => esc_attr__( 'Linkedin', 'edumall' ),
		'tumblr'   => esc_attr__( 'Tumblr', 'edumall' ),
		'email'    => esc_attr__( 'Email', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'sortable',
	'settings'    => $prefix . 'order',
	'label'       => esc_attr__( 'Order', 'edumall' ),
	'description' => esc_html__( 'Controls the order of social share links.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array(
		'twitter',
		'facebook',
		'linkedin',
		'tumblr',
		'email',
	),
	'choices'     => array(
		'facebook' => esc_attr__( 'Facebook', 'edumall' ),
		'twitter'  => esc_attr__( 'Twitter', 'edumall' ),
		'linkedin' => esc_attr__( 'Linkedin', 'edumall' ),
		'tumblr'   => esc_attr__( 'Tumblr', 'edumall' ),
		'email'    => esc_attr__( 'Email', 'edumall' ),
	),
) );
