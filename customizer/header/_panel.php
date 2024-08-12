<?php
$panel    = 'header';
$priority = 1;

Edumall_Kirki::add_section('header', array(
	'title'       => esc_html__('General', 'edumall-child'),
	'description' => '<div class="desc">
			<strong class="insight-label insight-label-info">' . esc_html__('IMPORTANT NOTE: ', 'edumall-child') . '</strong>
			<p>' . esc_html__('These settings can be overridden by settings from Page Options Box in separator page.', 'edumall-child') . '</p>
			<p><img src="' . esc_url(EDUMALL_THEME_IMAGE_URI . '/customize/header-settings.jpg') . '" alt="' . esc_attr__('header-settings', 'edumall-child') . '"/></p>
			<strong class="insight-label insight-label-info">' . esc_html__('Powerful header control: ', 'edumall-child') . '</strong>
			<p>' . esc_html__('These header settings for whole website. If you want use different header style for different post or page. then please go to specific section.', 'edumall-child') . '</p>
		</div>',
	'panel'       => $panel,
	'priority'    => $priority++,
));

Edumall_Kirki::add_section('header_sticky', array(
	'title'    => esc_html__('Header Sticky', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('header_more_options', array(
	'title'    => esc_html__('Header More Options', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

Edumall_Kirki::add_section('header_category_menu', array(
	'title'    => esc_html__('Header Category Menu', 'edumall-child'),
	'panel'    => $panel,
	'priority' => $priority++,
));

$header_types = Edumall_Header::instance()->get_type();

foreach ($header_types as $key => $name) {
	$section_id = 'header_style_' . $key;

	Edumall_Kirki::add_section($section_id, array(
		'title'    => $name,
		'panel'    => $panel,
		'priority' => $priority++,
	));
}
