<?php
$section  = 'social_sharing';
$priority = 1;
$prefix   = 'social_sharing_';

Edumall_Kirki::add_field('theme', array(
	'type'        => 'multicheck',
	'settings'    => $prefix . 'item_enable',
	'label'       => esc_attr__('Sharing Links', 'edumall-child'),
	'description' => esc_html__('Check to the box to enable social share links.', 'edumall-child'),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => array('facebook', 'twitter', 'linkedin', 'tumblr', 'email'),
	'choices'     => array(
		'facebook' => esc_attr__('Facebook', 'edumall-child'),
		'twitter'  => esc_attr__('Twitter', 'edumall-child'),
		'linkedin' => esc_attr__('Linkedin', 'edumall-child'),
		'tumblr'   => esc_attr__('Tumblr', 'edumall-child'),
		'email'    => esc_attr__('Email', 'edumall-child'),
	),
));

Edumall_Kirki::add_field('theme', array(
	'type'        => 'sortable',
	'settings'    => $prefix . 'order',
	'label'       => esc_attr__('Order', 'edumall-child'),
	'description' => esc_html__('Controls the order of social share links.', 'edumall-child'),
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
		'facebook' => esc_attr__('Facebook', 'edumall-child'),
		'twitter'  => esc_attr__('Twitter', 'edumall-child'),
		'linkedin' => esc_attr__('Linkedin', 'edumall-child'),
		'tumblr'   => esc_attr__('Tumblr', 'edumall-child'),
		'email'    => esc_attr__('Email', 'edumall-child'),
	),
));
