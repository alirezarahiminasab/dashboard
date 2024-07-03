<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP_Activity' ) ) {
	class Edumall_BP_Activity extends Edumall_BP {

		private static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'bp_nouveau_get_activity_entry_buttons', [ $this, 'change_activity_buttons' ], 10, 2 );
		}

		public function change_activity_buttons( $buttons, $activity_id ) {
			if ( isset( $buttons['activity_favorite'] ) ) {
				// Change text.
				$buttons['activity_favorite']['link_text'] = '<span class="bp-screen-reader-text">' . esc_html__( 'Like', 'edumall' ) . '</span>';

				// Move it first.
				$buttons['activity_favorite']['position'] = 4;
			}

			return $buttons;
		}
	}

	Edumall_BP_Activity::instance()->initialize();
}
