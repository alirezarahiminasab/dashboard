<?php
defined( 'ABSPATH' ) || exit;

// Do nothing if not an admin page.
if ( ! is_admin() ) {
	return;
}

/**
 * Hook & filter that run only on admin pages.
 */
if ( ! class_exists( 'Edumall_Admin' ) ) {
	class Edumall_Admin {

		protected static $instance = null;

		/**
		 * Minimum Insight Core version required to run the theme.
		 *
		 * @since 2.5.0
		 *
		 * @var string
		 */
		const MINIMUM_INSIGHT_CORE_VERSION = '2.2.0';

		const MINIMUM_EDUMALL_ADDONS_VERSION = '1.2.0';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize() {
			add_action( 'after_switch_theme', array( $this, 'count_switch_time' ), 1 );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'enqueue_block_editor_assets', array( $this, 'gutenberg_editor' ) );

			/**
			 * @since 2.5.0
			 */
			if ( class_exists( 'InsightCore' ) ) {
				if ( ! defined( 'INSIGHT_CORE_VERSION' ) || ( defined( 'INSIGHT_CORE_VERSION' ) && version_compare( INSIGHT_CORE_VERSION, self::MINIMUM_INSIGHT_CORE_VERSION, '<' ) ) ) {
					add_action( 'admin_notices', [ $this, 'admin_notice_minimum_insight_core_version' ] );
				}
			}

			/**
			 * @since 2.7.1
			 */
			if ( defined( 'EDUMALL_ADDONS_VERSION' ) && version_compare( EDUMALL_ADDONS_VERSION, self::MINIMUM_EDUMALL_ADDONS_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_edumall_addons_version' ] );
			}
		}

		public function admin_notice_minimum_insight_core_version() {
			edumall_notice_required_plugin_version( 'Insight Core', self::MINIMUM_INSIGHT_CORE_VERSION );
		}

		public function admin_notice_minimum_edumall_addons_version() {
			edumall_notice_required_plugin_version( 'Edumall Addons', self::MINIMUM_EDUMALL_ADDONS_VERSION );
		}

		public function gutenberg_editor() {
			/**
			 * Enqueue fonts for gutenberg editor.
			 */
			wp_enqueue_style( 'font-gordita', EDUMALL_THEME_URI . '/assets/fonts/gordita/font-gordita.min.css', null, null );
		}

		public function count_switch_time() {
			$count = get_option( 'edumall_switch_theme_count' );

			if ( $count ) {
				$count++;
			} else {
				$count = 1;
			}

			update_option( 'edumall_switch_theme_count', $count );
		}

		/**
		 * Enqueue scrips & styles.
		 *
		 * @access public
		 */
		function enqueue_scripts() {
			$this->enqueue_fonts_for_rev_slider_page();

			wp_enqueue_style( 'edumall-admin', EDUMALL_THEME_URI . '/assets/admin/css/style.min.css' );

			// Force light version for editor.
			$root_css = Edumall_Custom_Css::instance()->get_root_css( 'light' );

			wp_add_inline_style( 'edumall-admin', html_entity_decode( $root_css, ENT_QUOTES ) );

			wp_dequeue_style( 'wpc-notice' );
		}

		/**
		 * Enqueue fonts for Rev Slider edit page.
		 */
		function enqueue_fonts_for_rev_slider_page() {
			$screen = get_current_screen();

			if ( 'toplevel_page_revslider' !== $screen->base ) {
				return;
			}

			$typo_fields = array(
				'typography_body',
				'typography_heading',
				'button_typography',
			);

			if ( ! is_array( $typo_fields ) || empty( $typo_fields ) ) {
				return;
			}

			foreach ( $typo_fields as $field ) {
				$value = Edumall::setting( $field );

				if ( is_array( $value ) && isset( $value['font-family'] ) && $value['font-family'] !== '' ) {
					switch ( $value['font-family'] ) {
						case 'TTCommons':
							wp_enqueue_style( 'ttcommons-font', EDUMALL_THEME_URI . '/assets/fonts/TTCommons/TTCommons.css', null, null );
							break;
						default:
							do_action( 'edumall_enqueue_custom_font', $value['font-family'] ); // hook to custom do enqueue fonts
							break;
					}
				}
			}
		}
	}

	Edumall_Admin::instance()->initialize();
}
