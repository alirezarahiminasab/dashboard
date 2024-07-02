<?php
$section  = 'settings_preset';
$priority = 1;
$prefix   = 'settings_preset_';

Edumall_Kirki::add_field('theme', array(
	'type'     => 'preset',
	'settings' => 'settings_preset',
	'label'    => esc_html__('Settings Preset', 'edumall-child'),
	'section'  => $section,
	'default'  => '-1',
	'priority' => $priority++,
	'multiple' => 0,
	'choices'  => array(
		'-1'  => array(
			'label'    => esc_html__('None', 'edumall-child'),
			'settings' => [],
		),
		'rtl' => array(
			'label'    => esc_html__('RTL', 'edumall-child'),
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
					'variant'        => 700,
					'line-height'    => '1.3',
					'letter-spacing' => '0em',
				],
			],
		),
	),
));
