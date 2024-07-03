<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Tutor_Instructors' ) ) {
	class Edumall_Tutor_Instructors {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'template_include', [ $this, 'template_instructors' ] );

			add_filter( 'body_class', [ $this, 'body_class' ] );

			add_filter( 'tutor/options/extend/attr', [ $this, 'add_instructor_setting' ] );

			add_action( 'tutor_option_save_after', [ $this, 'instructor_role_manage' ] );
		}

		public function template_instructors( $template ) {
			if ( Edumall_Tutor::instance()->is_instructors_page() ) {
				$template = tutor_get_template( 'instructors' );
			}

			return $template;
		}

		public function body_class( $classes ) {
			if ( Edumall_Tutor::instance()->is_instructors_page() ) {
				$classes[] = ' instructors-page';
			}

			return $classes;
		}

		public function add_instructor_setting( $setting ) {
			$pages = tutor_utils()->get_pages();

			$cpts = array(
				'faq'      => __( 'FAQs', 'edumall' ),
				'tp_event' => __( 'Events', 'edumall' ),
			);

			$new_setting_fields = [
				[
					'key'         => 'instructor_register_immediately',
					'type'        => 'toggle_switch',
					'label'       => __( 'Become Instructor Immediately', 'edumall' ),
					'label_title' => '',
					'default'     => 'off',
					'desc'        => __( 'Enabling this feature will make user become Instructor immediately without review from Admin.', 'edumall' ),
				],
				[
					'key'     => 'instructor_manage_cpt',
					'type'    => 'checkbox_horizontal',
					'label'   => __( 'Manage Custom Post Type', 'edumall' ),
					'options' => $cpts,
					'desc'    => __( 'Allows instructors manage custom post types.', 'edumall' ),
				],
				[
					'key'     => 'instructor_listing_page',
					'type'    => 'select',
					'label'   => __( 'Instructor Listing Page', 'edumall' ),
					'default' => '0',
					'options' => $pages,
					'desc'    => __( 'This page will be used to show all approved instructors', 'edumall' ),
				],
				[
					'key'     => 'instructors_per_page',
					'type'    => 'number',
					'label'   => __( 'Pagination', 'edumall' ),
					'default' => '12',
					'desc'    => __( 'Number of instructors you would like displayed "per page" in the pagination', 'edumall' ),
				],
			];

			$general_blocks = $setting['general']['blocks'];

			foreach ( $general_blocks as $key => $general_block ) {
				if ( 'instructor' === $general_block['slug'] ) {
					$setting['general']['blocks'][ $key ]['fields'] = array_merge( $general_block['fields'], $new_setting_fields );

					break;
				}
			}

			return $setting;
		}

		public function instructor_role_manage() {
			$instructor = get_role( tutor()->instructor_role );

			$cpt_allowed         = tutor_utils()->get_option( 'instructor_manage_cpt' );
			$default_cpt_allowed = [
				'tp_event' => '',
				'faq'      => '',
			];

			$cpt_allowed = wp_parse_args( $cpt_allowed, $default_cpt_allowed );
			if ( ! empty( $cpt_allowed ) ) {
				foreach ( $cpt_allowed as $cpt_name => $allowed ) {
					$grant = false;

					if ( '1' === $allowed
					     || $allowed === $cpt_name // Tutor v2 option
					) {
						$grant = true;
					}

					switch ( $cpt_name ) {
						case Edumall_FAQ::instance()->get_post_type() :
							$instructor->add_cap( 'edit_faq', $grant );
							$instructor->add_cap( 'read_faq', $grant );
							$instructor->add_cap( 'delete_faq', $grant );

							$instructor->add_cap( 'edit_faqs', $grant );
							$instructor->add_cap( 'publish_faqs', $grant );
							$instructor->add_cap( 'read_private_faqs', $grant );

							break;
						case Edumall_Event::instance()->get_event_type() :
							$instructor->add_cap( 'edit_tp_event', $grant );
							$instructor->add_cap( 'read_tp_event', $grant );
							$instructor->add_cap( 'delete_tp_event', $grant );

							$instructor->add_cap( 'edit_tp_events', $grant );
							$instructor->add_cap( 'edit_others_tp_events', $grant );
							$instructor->add_cap( 'publish_tp_events', $grant );
							$instructor->add_cap( 'read_private_tp_events', $grant );
							$instructor->add_cap( 'delete_tp_events', $grant );

							break;
					}
				}
			}
		}
	}
}
