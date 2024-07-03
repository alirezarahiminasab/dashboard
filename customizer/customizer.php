<?php
/**
 * Theme Customizer
 *
 * @package Edumall
 * @since   1.0
 */

/**
 * Setup configuration
 */
Edumall_Kirki::add_config( 'theme', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

/**
 * Add sections
 */

Edumall_Kirki::add_section( 'layout', array(
	'title'    => esc_html__( 'Site Layout & Background', 'edumall' ),
	'priority' => 10,
) );

Edumall_Kirki::add_section( 'color_', array(
	'title'    => esc_html__( 'Colors', 'edumall' ),
	'priority' => 20,
) );

Edumall_Kirki::add_section( 'typography', array(
	'title'    => esc_html__( 'Typography', 'edumall' ),
	'priority' => 20,
) );

Edumall_Kirki::add_panel( 'top_bar', array(
	'title'    => esc_html__( 'Top bar', 'edumall' ),
	'priority' => 30,
) );

Edumall_Kirki::add_panel( 'header', array(
	'title'    => esc_html__( 'Header', 'edumall' ),
	'priority' => 40,
) );

Edumall_Kirki::add_section( 'logo', array(
	'title'       => esc_html__( 'Logo', 'edumall' ),
	'description' => '<div class="desc">
			<strong class="insight-label insight-label-info">' . esc_html__( 'IMPORTANT NOTE: ', 'edumall' ) . '</strong>
			<p>' . esc_html__( 'These settings can be overridden by settings from Page Options Box in separator page.', 'edumall' ) . '</p>
			<p><img src="' . esc_url( EDUMALL_THEME_IMAGE_URI . '/customize/logo-settings.jpg' ) . '" alt="' . esc_attr__( 'logo-settings', 'edumall' ) . '"/></p>
		</div>',
	'priority'    => 50,
) );

Edumall_Kirki::add_panel( 'navigation', array(
	'title'    => esc_html__( 'Navigation', 'edumall' ),
	'priority' => 60,
) );

Edumall_Kirki::add_panel( 'title_bar', array(
	'title'    => esc_html__( 'Page Title Bar & Breadcrumb', 'edumall' ),
	'priority' => 60,
) );

Edumall_Kirki::add_section( 'sidebars', array(
	'title'    => esc_html__( 'Sidebars', 'edumall' ),
	'priority' => 70,
) );

Edumall_Kirki::add_section( 'footer', array(
	'title'    => esc_html__( 'Footer', 'edumall' ),
	'priority' => 80,
) );

Edumall_Kirki::add_section( 'pages', array(
	'title'    => esc_html__( 'Pages', 'edumall' ),
	'priority' => 90,
) );

Edumall_Kirki::add_panel( 'blog', array(
	'title'    => esc_html__( 'Blog', 'edumall' ),
	'priority' => 100,
) );

Edumall_Kirki::add_panel( 'course', array(
	'title'    => esc_html__( 'Course', 'edumall' ),
	'priority' => 110,
) );

Edumall_Kirki::add_panel( 'event', array(
	'title'    => esc_html__( 'Event', 'edumall' ),
	'priority' => 120,
) );

Edumall_Kirki::add_panel( 'faq', array(
	'title'    => esc_html__( 'FAQ', 'edumall' ),
	'priority' => 130,
) );

if ( Edumall_Zoom_Meeting::instance()->is_activated() ) {
	Edumall_Kirki::add_panel( 'zoom_meeting', array(
		'title'    => esc_html__( 'Zoom Meeting', 'edumall' ),
		'priority' => 140,
	) );
}

Edumall_Kirki::add_panel( 'portfolio', array(
	'title'    => esc_html__( 'Portfolio', 'edumall' ),
	'priority' => 150,
) );

Edumall_Kirki::add_panel( 'shop', array(
	'title'    => esc_html__( 'Shop', 'edumall' ),
	'priority' => 160,
) );

Edumall_Kirki::add_section( 'contact_info', array(
	'title'    => esc_html__( 'Contact Info', 'edumall' ),
	'priority' => 170,
) );

Edumall_Kirki::add_section( 'socials', array(
	'title'    => esc_html__( 'Social Networks', 'edumall' ),
	'priority' => 180,
) );

Edumall_Kirki::add_section( 'social_sharing', array(
	'title'    => esc_html__( 'Social Sharing', 'edumall' ),
	'priority' => 190,
) );

Edumall_Kirki::add_panel( 'search', array(
	'title'    => esc_html__( 'Search & Popup Search', 'edumall' ),
	'priority' => 200,
) );

Edumall_Kirki::add_section( 'error404_page', array(
	'title'    => esc_html__( 'Error 404 Page', 'edumall' ),
	'priority' => 210,
) );

Edumall_Kirki::add_panel( 'shortcode', array(
	'title'    => esc_html__( 'Shortcodes', 'edumall' ),
	'priority' => 220,
) );

Edumall_Kirki::add_section( 'pre_loader', array(
	'title'    => esc_html__( 'Pre Loader', 'edumall' ),
	'priority' => 230,
) );

Edumall_Kirki::add_panel( 'advanced', array(
	'title'    => esc_html__( 'Advanced', 'edumall' ),
	'priority' => 240,
) );

Edumall_Kirki::add_section( 'login', array(
	'title'    => esc_html__( 'Login', 'edumall' ),
	'priority' => 250,
) );

Edumall_Kirki::add_section( 'notices', array(
	'title'    => esc_html__( 'Notices', 'edumall' ),
	'priority' => 250,
) );

Edumall_Kirki::add_section( 'settings_preset', array(
	'title'    => esc_html__( 'Preset', 'edumall' ),
	'priority' => 260,
) );

Edumall_Kirki::add_section( 'performance', array(
	'title'    => esc_html__( 'Performance', 'edumall' ),
	'priority' => 270,
) );

Edumall_Kirki::add_section( 'custom_js', array(
	'title'    => esc_html__( 'Additional JS', 'edumall' ),
	'priority' => 280,
) );

/**
 * Load panel & section files
 */
require_once EDUMALL_CUSTOMIZER_DIR . '/section-color.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/general.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-01.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-02.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-03.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-04.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-05.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/top-bar/style-06.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/header/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/general.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/sticky.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/more-options.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/category.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-01.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-02.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-03.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-04.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-05.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-06.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-07.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-08.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-09.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/header/style-10.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/navigation/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/navigation/desktop-menu.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/navigation/off-canvas-menu.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/navigation/mobile-menu.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/general.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-01.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-02.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-03.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-04.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-05.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-06.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-07.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/title-bar/style-08.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-footer.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/advanced/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/advanced/advanced.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/advanced/light-gallery.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-notices.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-login.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-pre-loader.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-custom-js.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-error404.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-layout.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-logo.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-pages.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/blog/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/blog/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/blog/single.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/course/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/course/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/course/category.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/course/single.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/event/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/event/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/event/single.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/faq/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/faq/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/faq/single.php';

if ( Edumall_Zoom_Meeting::instance()->is_activated() ) {
	require_once EDUMALL_CUSTOMIZER_DIR . '/zoom-meeting/_panel.php';
	require_once EDUMALL_CUSTOMIZER_DIR . '/zoom-meeting/archive.php';
	require_once EDUMALL_CUSTOMIZER_DIR . '/zoom-meeting/single.php';
}

require_once EDUMALL_CUSTOMIZER_DIR . '/portfolio/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/portfolio/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/portfolio/single.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/shop/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/shop/general.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/shop/archive.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/shop/single.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/shop/cart.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/search/_panel.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/search/search-page.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/search/search-popup.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-preset.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-sidebars.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-contact-info.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-sharing.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-socials.php';
require_once EDUMALL_CUSTOMIZER_DIR . '/section-typography.php';

require_once EDUMALL_CUSTOMIZER_DIR . '/section-performance.php';

do_action( 'edumall_customizer_init' );
