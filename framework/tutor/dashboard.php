<?php
defined( 'ABSPATH' ) || exit;

/**
 * Templates & hooks for Dashboard page.
 */
if ( ! class_exists( 'Edumall_Tutor_Dashboard' ) ) {
	class Edumall_Tutor_Dashboard {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'body_class', [ $this, 'body_class' ] );
			add_filter( 'edumall_top_bar_type', [ $this, 'hide_top_bar' ] );
			add_filter( 'edumall_header_type', [ $this, 'hide_header' ] );
			add_filter( 'edumall_title_bar_type', [ $this, 'hide_title_bar' ] );
			add_filter( 'edumall_footer', [ $this, 'hide_footer' ] );
			add_filter( 'edumall_sidebar_1', [ $this, 'hide_sidebar' ] );

			add_action( 'wp_footer', [ $this, 'add_dashboard_nav_template' ] );

			/**
			 * WPML compatible
			 *
			 * @since 2.10.0
			 */
			add_filter( 'tutor_dashboard_page_id', [ $this, 'wpml_translation_page_id' ] );
			add_filter( 'tutor_dashboard_page_id_filter', [ $this, 'wpml_translation_page_id' ] );
			add_filter( 'generate_rewrite_rules', [ $this, 'add_rewrite_rules' ] );

			/**
			 * Add custom link to Dashboard menu
			 *
			 * @since 2.7.4
			 */
			add_filter( 'tutor_dashboard/instructor_nav_items', [ $this, 'add_my_students_nav_item' ] );
		}

		public function wpml_translation_page_id( $student_dashboard_page_id ) {
			if ( function_exists( 'wpml_object_id_filter' ) ) {
				$student_dashboard_page_id = wpml_object_id_filter( $student_dashboard_page_id );
			}

			return $student_dashboard_page_id;
		}

		/**
		 * Support wpml for dashboard page.
		 *
		 * @see \TUTOR\Rewrite_Rules::add_rewrite_rules()
		 *
		 * @param \WP_Rewrite $wp_rewrite
		 *
		 * @return \WP_Rewrite $wp_rewrite
		 */
		public function add_rewrite_rules( $wp_rewrite ) {
			global $sitepress;

			if ( $sitepress instanceof SitePress ) {
				// Student Dashboard URL.
				$dashboard_pages   = tutor_utils()->tutor_dashboard_permalinks();
				$dashboard_page_id = (int) tutor_utils()->get_option( 'tutor_dashboard_page_id' );

				$trid         = $sitepress->get_element_trid( $dashboard_page_id, 'post_page' );
				$translations = $sitepress->get_element_translations( $trid, 'post_page' );

				foreach ( $translations as $lang_code => $translation ) {
					$translate_page_id = $translation->element_id;

					$dashboard_page_slug = get_post_field( 'post_name', $translate_page_id );

					foreach ( $dashboard_pages as $dashboard_key => $dashboard_page ) {
						$new_rules["({$dashboard_page_slug})/{$dashboard_key}/?$"] = 'index.php?pagename=' . $wp_rewrite->preg_index( 1 ) . '&tutor_dashboard_page=' . $dashboard_key;

						// Sub Page of dashboard sub page.
						//regext = ([^/]*)
						$new_rules["({$dashboard_page_slug})/{$dashboard_key}/(.+?)/?$"] = 'index.php?pagename=' . $wp_rewrite->preg_index( 1 ) . '&tutor_dashboard_page=' . $dashboard_key . '&tutor_dashboard_sub_page=' . $wp_rewrite->preg_index( 2 );

						$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
					}
				}
			}

			return $wp_rewrite;
		}

		public function add_my_students_nav_item( $nav_items ) {
			$nav_items['my-students'] = array(
				'title'    => __( 'My Students', 'edumall' ),
				'auth_cap' => tutor()->instructor_role,
			);

			return $nav_items;
		}

		public function body_class( $classes ) {
			global $wp_query;

			$dashboard_page_slug = '';
			$dashboard_page_name = '';
			if ( isset( $wp_query->query_vars['tutor_dashboard_page'] ) && $wp_query->query_vars['tutor_dashboard_page'] ) {
				$dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
				$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
			}

			/**
			 * Getting dashboard sub pages
			 */
			if ( isset( $wp_query->query_vars['tutor_dashboard_sub_page'] ) && $wp_query->query_vars['tutor_dashboard_sub_page'] ) {
				if ( ! empty( $dashboard_page_slug ) ) {
					$dashboard_page_slug = $dashboard_page_slug . '-' . $wp_query->query_vars['tutor_dashboard_sub_page'];
				}
			}

			if ( Edumall_Tutor::instance()->is_dashboard() ) {
				$classes[] = "dashboard-{$dashboard_page_slug}-page";

				if ( is_user_logged_in() && 'create-course' !== $dashboard_page_name ) {
					$classes[] = 'dashboard-page';

					if ( ! Edumall::is_handheld() ) {
						$classes[] = 'dashboard-nav-fixed';
					}
				}
			}

			return $classes;
		}

		public function add_dashboard_nav_template() {
			global $wp_query;

			if ( $wp_query->is_page ) {
				if ( is_user_logged_in() && Edumall_Tutor::instance()->is_dashboard() && ! Edumall_Tutor::instance()->is_create_course() ) {
					tutor_load_template( 'dashboard.navs' );
					edumall_load_template( 'off-canvas' );
				}
			}
		}

		public function hide_top_bar( $type ) {
			if ( Edumall_Tutor::instance()->is_dashboard() && is_user_logged_in() ) {
				return 'none';
			}

			return $type;
		}

		public function hide_header( $type ) {
			if ( Edumall_Tutor::instance()->is_dashboard() && is_user_logged_in() ) {
				return 'none';
			}

			return $type;
		}

		public function hide_title_bar( $type ) {
			if ( Edumall_Tutor::instance()->is_dashboard() ) {
				if ( is_user_logged_in() ) {
					return 'none';
				} else {
					return '05';
				}
			}

			if( Edumall_Tutor::instance()->is_student_registration_page() ) {
				return '05';
			}

			return $type;
		}

		public function hide_footer( $type ) {
			if ( Edumall_Tutor::instance()->is_dashboard() && is_user_logged_in() ) {
				return 'none';
			}

			return $type;
		}

		public function hide_sidebar( $type ) {
			if ( Edumall_Tutor::instance()->is_dashboard() && is_user_logged_in() ) {
				return 'none';
			}

			return $type;
		}
	}
}
