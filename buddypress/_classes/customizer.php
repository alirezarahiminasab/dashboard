<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP_Customizer' ) ) {
	class Edumall_BP_Customizer extends Edumall_BP {

		private static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Register widget areas.
			add_action( 'edumall_customizer_init', [ $this, 'customizer_settings' ] );
		}

		public function customizer_settings() {
			Edumall_Kirki::add_section( 'buddypress', array(
				'title'    => esc_html__( 'BuddyPress', 'edumall' ),
				'priority' => 170,
			) );

			require_once EDUMALL_BP_CORE_DIR . '/customizer/section-main.php';
		}
	}

	Edumall_BP_Customizer::instance()->initialize();
}
