<?php
/**
 * Define constant
 */
$theme = wp_get_theme();

if ( ! empty( $theme['Template'] ) ) {
	$theme = wp_get_theme( $theme['Template'] );
}

if ( ! defined( 'DS' ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

define( 'EDUMALL_THEME_NAME', $theme['Name'] );
define( 'EDUMALL_THEME_VERSION', $theme['Version'] );
define( 'EDUMALL_THEME_DIR', get_template_directory() );
define( 'EDUMALL_THEME_URI', get_template_directory_uri() );
define( 'EDUMALL_THEME_ASSETS_DIR', get_template_directory() . '/assets' );
define( 'EDUMALL_THEME_ASSETS_URI', get_template_directory_uri() . '/assets' );
define( 'EDUMALL_THEME_IMAGE_URI', EDUMALL_THEME_ASSETS_URI . '/images' );
define( 'EDUMALL_THEME_SVG_DIR', EDUMALL_THEME_ASSETS_DIR . '/svg' );
define( 'EDUMALL_THEME_SVG_URI', EDUMALL_THEME_ASSETS_URI . '/svg' );
define( 'EDUMALL_FRAMEWORK_DIR', get_template_directory() . DS . 'framework' );
define( 'EDUMALL_CUSTOMIZER_DIR', EDUMALL_THEME_DIR . DS . 'customizer' );
define( 'EDUMALL_WIDGETS_DIR', get_template_directory() . DS . 'widgets' );
define( 'EDUMALL_PROTOCOL', is_ssl() ? 'https' : 'http' );
define( 'EDUMALL_IS_RTL', is_rtl() ? true : false );

define( 'EDUMALL_TUTOR_DIR', get_template_directory() . DS . 'framework' . DS . 'tutor' );
define( 'EDUMALL_FAQ_DIR', get_template_directory() . DS . 'framework' . DS . 'faq' );
define( 'EDUMALL_EVENT_MANAGER_DIR', get_template_directory() . DS . 'framework' . DS . 'event-manager' );

define( 'EDUMALL_ELEMENTOR_DIR', get_template_directory() . DS . 'elementor' );
define( 'EDUMALL_ELEMENTOR_URI', get_template_directory_uri() . '/elementor' );
define( 'EDUMALL_ELEMENTOR_ASSETS', get_template_directory_uri() . '/elementor/assets' );
define( 'EDUMALL_WOO_TEMPLATE', get_template_directory() . '/mobile/woocommerce/template' );

/**
 * Define a constant if it is not already defined.
 *
 * @param string $name  Constant name.
 * @param mixed  $value Value.
 */
function edumall_maybe_define_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

/**
 * Load Framework.
 */
require_once EDUMALL_FRAMEWORK_DIR . '/class-functions.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-debug.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-ajax.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-aqua-resizer.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-performance.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-static.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-init.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-helper.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-global.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-actions-filters.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-kses.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-notices.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-popup.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-admin.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-compatible.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-customize.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-nav-menu.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-enqueue.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-image.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-minify.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-color.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-datetime.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-import.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-kirki.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-login-register.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-metabox.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-plugins.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-custom-css.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-templates.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-walker-nav-menu.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-sidebar.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-top-bar.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-header.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-title-bar.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-footer.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-post-type.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-post-type-blog.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-post-type-portfolio.php';

require_once EDUMALL_WIDGETS_DIR . '/class-widget-init.php';

require_once EDUMALL_TUTOR_DIR . '/class-tutor.php';

require_once EDUMALL_EVENT_MANAGER_DIR . '/class-event.php';

require_once EDUMALL_FRAMEWORK_DIR . '/class-post-type-zoom-meeting.php';

require_once EDUMALL_FAQ_DIR . '/main.php';

require_once get_template_directory() . DS . 'buddypress' . DS . '_classes/main.php';

require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/class-woo.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-content-protected.php';
require_once EDUMALL_FRAMEWORK_DIR . '/tgm-plugin-activation.php';
require_once EDUMALL_FRAMEWORK_DIR . '/tgm-plugin-registration.php';
require_once EDUMALL_FRAMEWORK_DIR . '/class-tha.php';

require_once EDUMALL_ELEMENTOR_DIR . '/class-entry.php';

/**
 * Init the theme
 */
Edumall_Init::instance()->initialize();
