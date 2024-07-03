<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Event_Post_Type' ) ) {
	class Edumall_Event_Post_Type extends Edumall_Event {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'admin_menu', [ $this, 'fix_invalid_capability_in_menus' ], 99 );

			add_filter( 'tp_event_register_event_post_type_args', [ $this, 'change_post_type_args' ], 10, 1 );
			add_filter( 'event_auth_book_args', [ $this, 'change_post_type_booking_args' ], 10, 1 );

			add_filter( 'register_taxonomy_args', [ $this, 'add_gutenberg_support_for_taxonomy' ], 10, 2 );

			add_action( 'after_switch_theme', [ $this, 'manage_admin_permissions' ], 10, 2 );
		}

		public function fix_invalid_capability_in_menus() {
			/**
			 * We need re-add the menu links because they has wrong capability => 'administrator'
			 *
			 * @see WPEMS_Admin_Menu::admin_menu()
			 */

			// We need remove sub menu first.
			remove_submenu_page( 'tp-event-setting', 'tp-event-users' );
			remove_submenu_page( 'tp-event-setting', 'tp-event-setting' );
			remove_menu_page( 'tp-event-setting' );

			add_menu_page( __( 'Events Manager', 'edumall' ), __( 'Events Manager', 'edumall' ), 'edit_tp_events', 'tp-event-setting', null, 'dashicons-calendar-alt', 4 );

			$menus = apply_filters( 'tp_event_admin_menu', [] );
			if ( ! empty( $menus ) ) {
				foreach ( $menus as $menu ) {
					call_user_func_array( 'add_submenu_page', $menu );
				}
			}

			add_submenu_page( 'tp-event-setting', __( 'WP Event Users', 'edumall' ), __( 'Users', 'edumall' ), 'manage_options', 'tp-event-users', array(
				'WPEMS_Admin_Users',
				'output',
			) );
			add_submenu_page( 'tp-event-setting', __( 'WP Event Settings', 'edumall' ), __( 'Settings', 'edumall' ), 'manage_options', 'tp-event-setting', array(
				'WPEMS_Admin_Settings',
				'output',
			) );
		}

		public function change_post_type_args( $args ) {
			$new_args = [
				// Add gutenberg editor for single page.
				'show_in_rest'    => true,

				// Update capability.
				'capability_type' => 'post',
				'capabilities'    => array(
					'edit_post'           => 'edit_tp_event',
					'read_post'           => 'read_tp_event',
					'delete_post'         => 'delete_tp_event',
					'delete_posts'        => 'delete_tp_events',
					'edit_posts'          => 'edit_tp_events',
					'edit_others_posts'   => 'edit_others_tp_events',
					'delete_others_posts' => 'delete_other_tp_events',
					'publish_posts'       => 'publish_tp_events',
					'read_private_posts'  => 'read_private_tp_events',
					'create_posts'        => 'edit_tp_events',
				),
				'map_meta_cap'    => true,
			];

			$args = wp_parse_args( $new_args, $args );

			return $args;
		}

		/**
		 * @param string   $old_name
		 * @param WP_Theme $old_theme
		 */
		public function manage_admin_permissions( $old_name, $old_theme ) {
			$custom_post_type_permission = [
				// Event
				'edit_tp_event',
				'read_tp_event',
				'delete_tp_event',
				'delete_tp_events',
				'edit_tp_events',
				'edit_others_tp_events',
				'delete_other_tp_events',
				'publish_tp_events',
				'read_private_tp_events',

				// Booking
				'edit_tp_booking',
				'read_tp_booking',
				'delete_tp_booking',
				'delete_tp_bookings',
				'edit_tp_bookings',
				'edit_others_tp_bookings',
				'delete_other_tp_bookings',
				'publish_tp_bookings',
				'read_private_tp_bookings',
			];

			$administrator = get_role( 'administrator' );

			if ( $administrator ) {
				foreach ( $custom_post_type_permission as $cap ) {
					$administrator->add_cap( $cap );
				}
			}
		}

		/**
		 * Set right capability to hide menu from non administrator.
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function change_post_type_booking_args( $args ) {
			$new_args = [
				// Update capability.
				'capabilities' => array(
					'edit_post'           => 'edit_tp_booking',
					'read_post'           => 'read_tp_booking',
					'delete_post'         => 'delete_tp_booking',
					'delete_posts'        => 'delete_tp_bookings',
					'edit_posts'          => 'edit_tp_bookings',
					'edit_others_posts'   => 'edit_others_tp_bookings',
					'delete_others_posts' => 'delete_other_tp_bookings',
					'publish_posts'       => 'publish_tp_bookings',
					'read_private_posts'  => 'read_private_tp_bookings',
					'create_posts'        => 'do_not_allow',
				),
			];

			$args = wp_parse_args( $new_args, $args );

			return $args;
		}

		public function add_gutenberg_support_for_taxonomy( $args, $taxonomy ) {
			if ( in_array( $taxonomy, [
				self::TAXONOMY_CATEGORY,
				self::TAXONOMY_TAGS,
			] ) ) {
				$args['show_in_rest'] = true;
			}

			return $args;
		}
	}
}
