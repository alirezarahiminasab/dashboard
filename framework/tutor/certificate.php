<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Tutor_Certificate' ) ) {
	class Edumall_Tutor_Certificate {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function is_certificate_page() {
			if ( isset( $_GET['cert_hash'] ) ) {
				return true;
			}

			return false;
		}

		public function initialize() {
			add_filter( 'body_class', [ $this, 'body_class' ] );

			add_filter( 'edumall_top_bar_type', [ $this, 'change_top_bar_type' ], 9999 );
			add_filter( 'edumall_header_type', [ $this, 'change_header_type' ], 9999 );
			add_filter( 'edumall_title_bar_type', [ $this, 'change_title_bar' ], 9999 );
			add_filter( 'edumall_title_bar_heading_text', [ $this, 'title_bar_heading_text' ] );
			add_filter( 'edumall_sidebar_1', [ $this, 'disable_sidebar' ], 9999 );

			add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ], 11 );
		}

		public function body_class( $classes ) {
			if ( $this->is_certificate_page() ) {
				$classes [] = 'course-certificate-page';
			}

			return $classes;
		}

		public function change_top_bar_type( $type ) {
			if ( $this->is_certificate_page() ) {
				return Edumall::setting( 'global_top_bar' );
			}

			return $type;
		}

		public function change_header_type( $type ) {
			if ( $this->is_certificate_page() ) {
				return Edumall::setting( 'global_header' );
			}

			return $type;
		}

		public function change_title_bar( $type ) {
			if ( $this->is_certificate_page() ) {
				return Edumall::setting( 'title_bar_layout' );
			}

			return $type;
		}

		public function title_bar_heading_text( $text ) {
			if ( $this->is_certificate_page() ) {
				return __( 'Certificate', 'edumall' );
			}

			return $text;
		}

		public function disable_sidebar( $type ) {
			if ( $this->is_certificate_page() ) {
				return 'none';
			}

			return $type;
		}

		public function frontend_scripts() {
			/**
			 * Re-enqueue share script.
			 *
			 * @since 2.8.4
			 */
			if ( $this->is_certificate_page() ) {
				wp_enqueue_script( 'tutor-social-share' );
			}
		}
	}
}
