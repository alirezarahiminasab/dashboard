<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP_Widgets' ) ) {
	class Edumall_BP_Widgets extends Edumall_BP {

		private static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Register widget areas.
			add_action( 'edumall_widgets_init', [ $this, 'register_widgets' ] );
		}

		public function register_widgets() {
			if ( bp_is_active( 'groups' ) ) {
				require_once EDUMALL_BP_CORE_DIR . '/widgets/featured-group-activities.php';

				register_widget( 'Edumall_WP_Widget_Featured_Group_Activities' );
			}
		}
	}

	Edumall_BP_Widgets::instance()->initialize();
}
