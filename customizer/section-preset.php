<?php
$section  = 'settings_preset';
$priority = 1;
$prefix   = 'settings_preset_';

Edumall_Kirki::add_field( 'theme', array(
	'type'     => 'preset',
	'settings' => 'settings_preset',
	'label'    => esc_html__( 'Settings Preset', 'edumall' ),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1'           => array(
			'label'    => esc_html__( 'None', 'edumall' ),
			'settings' => [],
		),
		'rtl'          => array(
			'label'    => esc_html__( 'RTL', 'edumall' ),
			'settings' => [
				'typography_body'    => [
					'font-family'    => 'Geeza Pro',
					'variant'        => '400',
					'font-size'      => '14px',
					'line-height'    => '1.74',
					'letter-spacing' => '0em',
				],
				'typography_heading' => [
					'font-family'    => '',
					'variant'        => '700',
					'line-height'    => '1.3',
					'letter-spacing' => '0em',
				],
			],
		),
		'course-child' => array(
			'label'    => 'Course Child',
			'settings' => [
				'typography_body'    => [
					'font-family'    => 'Satoshi',
					'variant'        => '500',
					'font-size'      => '16px',
					'line-height'    => '1.625',
					'letter-spacing' => '0em',
				],
				'typography_heading' => [
					'font-family'    => 'Satoshi',
					'variant'        => '700',
					'line-height'    => '1.14285',
					'letter-spacing' => '0em',
				],
				'button_typography'  => [
					'font-family' => 'Satoshi',
					'font-size'   => '16px',
					'variant'     => '700',
				],
			],
		),
		'course-chef'  => array(
			'label'    => 'Course Chef',
			'settings' => [
				'typography_body'    => [
					'font-family'    => 'Satoshi',
					'variant'        => '500',
					'font-size'      => '16px',
					'line-height'    => '1.625',
					'letter-spacing' => '0em',
				],
				'typography_heading' => [
					'font-family'    => 'Satoshi',
					'variant'        => '700',
					'line-height'    => '1.14285',
					'letter-spacing' => '0em',
				],
				'button_typography'  => [
					'font-family' => 'Satoshi',
					'font-size'   => '16px',
					'variant'     => '700',
				],
				'primary_color'      => '#2A906A',
				'link_color'         => [
					'normal' => '#000',
					'hover'  => '#2A906A',
				],

				// Background Topbar.
				'bg_color'           => '#F8F8F8',
			],
		),
	),
) );
