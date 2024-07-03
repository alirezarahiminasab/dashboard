<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP_Layout' ) ) {
	class Edumall_BP_Layout extends Edumall_BP {

		private static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Register widget areas.
			add_action( 'widgets_init', [ $this, 'register_sidebars' ], 11 );

			add_filter( 'edumall_top_bar_type', [ $this, 'change_top_bar_type' ] );

			add_filter( 'edumall_header_type', [ $this, 'change_header_type' ] );
			add_filter( 'edumall_header_overlay', [ $this, 'change_header_overlay' ] );
			add_filter( 'edumall_header_skin', [ $this, 'change_header_skin' ] );

			add_filter( 'edumall_title_bar_type', [ $this, 'change_title_bar' ], 99 );

			add_filter( 'edumall_sidebar_1', [ $this, 'change_sidebar_1' ], 99 );
			add_filter( 'edumall_sidebar_position', [ $this, 'change_sidebar_position' ], 99 );
			add_filter( 'edumall_one_sidebar_offset', [ $this, 'change_sidebar_offset' ], 99 );
		}

		public function change_top_bar_type( $type ) {
			if ( bp_is_active() ) {
				$new_type = Edumall::setting( 'buddypress_page_top_bar_type' );

				if ( '' !== $new_type ) {
					return $new_type;
				}
			}

			return $type;
		}

		public function change_header_type( $type ) {
			if ( bp_is_active() ) {
				$new_type = Edumall::setting( 'buddypress_page_header_type' );

				if ( '' !== $new_type ) {
					return $new_type;
				}
			}

			return $type;
		}

		public function change_header_overlay( $value ) {
			if ( bp_is_active() ) {
				$new_value = Edumall::setting( 'buddypress_page_header_overlay' );

				if ( '' !== $new_value ) {
					return $new_value;
				}
			}

			return $value;
		}

		public function change_header_skin( $value ) {
			if ( bp_is_active() ) {
				$new_value = Edumall::setting( 'buddypress_page_header_skin' );

				if ( '' !== $new_value ) {
					return $new_value;
				}
			}

			return $value;
		}

		public function change_title_bar( $type ) {
			/**
			 * Disable title bar for group pages
			 */
			if ( bp_is_groups_component() ) {
				return 'none';
			}

			/**
			 * Disable title bar for member pages
			 */
			if ( bp_is_user() || bp_is_members_component() ) {
				return 'none';
			}

			/**
			 * Disable title bar for activity page
			 */
			if ( bp_is_activity_directory() ) {
				return 'none';
			}

			return $type;
		}

		public function register_sidebars() {
			$default_args = Edumall_Sidebar::instance()->get_default_sidebar_args();

			register_sidebar( array_merge( $default_args, [
				'id'          => 'activity_top_sidebar',
				'name'        => esc_html__( 'Activity Directory Top Sidebar', 'edumall' ),
				'description' => esc_html__( 'Widgets in this area will shown on News feed page.', 'edumall' ),
			] ) );

			register_sidebar( array_merge( $default_args, [
				'id'          => 'activity_sidebar',
				'name'        => esc_html__( 'Activity Directory Sidebar', 'edumall' ),
				'description' => esc_html__( 'Widgets in this area will shown on News feed page.', 'edumall' ),
			] ) );

			register_sidebar( array_merge( $default_args, [
				'id'          => 'groups_sidebar',
				'name'        => esc_html__( 'Groups Directory Sidebar', 'edumall' ),
				'description' => esc_html__( 'Widgets in this area will shown on Groups page.', 'edumall' ),
			] ) );

			/*register_sidebar( array_merge( $default_args, [
				'id'          => 'group_single_sidebar',
				'name'        => esc_html__( 'Groups Single Directory Sidebar', 'edumall' ),
				'description' => esc_html__( 'Widgets in this area will shown on individual group page.', 'edumall' ),
			] ) );*/

			register_sidebar( array_merge( $default_args, [
				'id'          => 'member_single_sidebar',
				'name'        => esc_html__( 'Members Single Profile Sidebar', 'edumall' ),
				'description' => esc_html__( 'Widgets in this area will shown on individual member profiles.', 'edumall' ),
			] ) );
		}

		public function change_sidebar_1( $type ) {
			if ( bp_is_groups_directory() ) {
				return 'groups_sidebar';
			}

			if ( bp_is_group() ) {
				return 'groups_sidebar';
			}

			if ( bp_is_user() || bp_is_members_component() ) {
				return 'member_single_sidebar';
			}

			if ( bp_is_activity_component() ) {
				return 'activity_sidebar';
			}

			return $type;
		}

		public function change_sidebar_position( $position ) {
			if ( bp_is_groups_component() ) {
				return 'left';
			}

			if ( bp_is_user() || bp_is_members_component() ) {
				return 'left';
			}

			if ( bp_is_activity_component() ) {
				return 'left';
			}

			return $position;
		}

		public function change_sidebar_offset( $offset ) {
			if ( bp_is_groups_component() ) {
				return 0;
			}

			if ( bp_is_user() || bp_is_members_component() ) {
				return 0;
			}

			if ( bp_is_activity_component() ) {
				return 0;
			}

			return $offset;
		}
	}

	Edumall_BP_Layout::instance()->initialize();
}
