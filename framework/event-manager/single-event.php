<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Single_Event' ) ) {
	class Edumall_Single_Event extends Edumall_Event {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'edumall_title_bar_type', [ $this, 'change_title_bar' ] );

			// Change map marker
			add_filter( 'tp-event-map-marker', [ $this, 'change_map_marker' ] );

			add_filter( 'body_class', [ $this, 'body_class' ] );
		}

		public function body_class( $classes ) {
			if ( $this->is_single() ) {
				$layout    = Edumall::setting( 'single_event_style' );
				$classes[] = 'single-event-style-' . $layout;
			}

			return $classes;
		}

		public function change_title_bar( $type ) {
			if ( $this->is_single() ) {
				$style = Edumall::setting( 'single_event_style' );
				if ( '02' === $style ) {
					return 'none';
				} else {
					return Edumall::setting( 'event_single_title_bar_layout', '05' );
				}
			}

			return $type;
		}

		public function change_map_marker() {
			return EDUMALL_THEME_IMAGE_URI . '/map-marker.png';
		}
	}
}
