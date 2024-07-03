<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Tutor_Enqueue' ) ) {
	class Edumall_Tutor_Enqueue {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ], 11 );
		}

		public function frontend_scripts() {
			$min = Edumall_Enqueue::instance()->get_min_suffix();
			$rtl = Edumall_Enqueue::instance()->get_rtl_suffix();

			/*wp_dequeue_style( 'tutor' );
			wp_dequeue_style( 'tutor-frontend' );
			wp_dequeue_style( 'tutor-course-builder-css' );*/

			// Disable social share on all pages then add it for single course only.
			wp_dequeue_script( 'tutor-social-share' );

			wp_register_script( 'edumall-course-archive', EDUMALL_THEME_ASSETS_URI . "/js/tutor/archive{$min}.js", [ 'jquery' ], 'null', true );
			wp_register_script( 'edumall-course-single', EDUMALL_THEME_ASSETS_URI . "/js/tutor/single{$min}.js", [ 'jquery' ], 'null', true );
			wp_register_script( 'edumall-tutor-dashboard', EDUMALL_THEME_ASSETS_URI . "/js/tutor/dashboard{$min}.js", [ 'jquery' ], 'null', true );

			wp_register_style( 'edumall-tutor', EDUMALL_THEME_URI . "/tutor-lms{$rtl}.css", null, EDUMALL_THEME_VERSION );

			wp_enqueue_style( 'edumall-tutor' );

			if ( Edumall_Tutor::instance()->is_create_course() ) {
				wp_enqueue_style( 'edumall-tutor-course-builder', EDUMALL_THEME_URI . "/tutor-lms-course-builder{$rtl}.css", null, EDUMALL_THEME_VERSION );
			}

			$wishlist_dependency = [];
			if ( ! is_user_logged_in() ) {
				$wishlist_dependency[] = 'edumall-login';
			}
			wp_register_script( 'edumall-course-general', EDUMALL_THEME_ASSETS_URI . "/js/tutor/general{$min}.js", $wishlist_dependency, 'null', true );

			wp_enqueue_script( 'edumall-course-general' );

			$js_variables = array(
				'addedText' => esc_html__( 'Remove from wishlist', 'edumall' ),
				'addText'   => esc_html__( 'Add to wishlist', 'edumall' ),
			);
			wp_localize_script( 'edumall-course-general', '$edumallCourseWishlist', $js_variables );

			if ( Edumall_Tutor::instance()->is_dashboard() ) {
				wp_enqueue_script( 'edumall-tutor-dashboard' );
			}

			if ( Edumall_Tutor::instance()->is_category() ) {
				wp_enqueue_script( 'edumall-tab-panel' );
			}

			if ( Edumall_Tutor::instance()->is_course_listing() ) {
				wp_enqueue_script( 'edumall-common-archive' );
				wp_enqueue_script( 'edumall-course-archive' );
			}

			if ( Edumall_Tutor::instance()->is_single_course() ) {
				wp_enqueue_script( 'tutor-social-share' );

				wp_enqueue_script( 'edumall-course-single' );

				wp_enqueue_script( 'sticky-kit' );
			}

			if ( Edumall_Tutor::instance()->is_single_course_bundle() ) {
				wp_enqueue_script( 'tutor-social-share' );
			}
		}
	}
}
