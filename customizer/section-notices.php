<?php
$section  = 'notices';
$priority = 1;
$prefix   = 'notice_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => $prefix . 'group_title_' . $priority++,
	'section'  => $section,
	'priority' => $priority++,
	'default'  => '<div class="big_title">' . esc_html__( 'Cookie Notice', 'edumall' ) . '</div>',
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'notice_cookie_enable',
	'label'       => esc_html__( 'Cookie Notice', 'edumall' ),
	'description' => esc_html__( 'The notice about cookie auto show when a user visits the site.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => '0',
	'choices'     => array(
		'0' => esc_html__( 'Hide', 'edumall' ),
		'1' => esc_html__( 'Show', 'edumall' ),
	),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'        => 'textarea',
	'settings'    => 'notice_cookie_messages',
	'label'       => esc_html__( 'Messages', 'edumall' ),
	'description' => esc_html__( 'Enter the messages that displays for cookie notice.', 'edumall' ),
	'section'     => $section,
	'priority'    => $priority++,
	'default'     => esc_html__( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'edumall' ),
) );

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'text',
	'settings' => 'notice_cookie_button_text',
	'label'    => esc_html__( 'Button Text', 'edumall' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => esc_html__( 'Ok, got it!', 'edumall' ),
) );
