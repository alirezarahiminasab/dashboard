<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP_Groups' ) ) {
	class Edumall_BP_Groups extends Edumall_BP {

		private static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'bp_core_default_avatar', [ $this, 'groups_default_avatar' ], 10, 4 );
			add_filter( 'bp_core_avatar_default_thumb', [ $this, 'groups_default_avatar' ], 10, 4 );

			/**
			 * Priority 4 to make sure this function run after BP global setup & before canonical_stack.
			 */
			add_action( 'bp_init', [ $this, 'change_default_tab' ], 4 );
		}

		/**
		 * Change default group tab.
		 * home => activity
		 */
		public function change_default_tab() {
			if ( ! bp_is_active( 'group' ) ) {
				return;
			}

			// Skip if set in wp-config.
			if ( defined( 'BP_GROUPS_DEFAULT_EXTENSION' ) ) {
				return;
			}

			/**
			 * Skip if used Youzify plugin.
			 * Fix single group link show 404.
			 *
			 * @since 2.7.4
			 */
			if ( defined( 'YOUZIFY_VERSION' ) ) {
				return;
			}

			/**
			 * Fix Private Group infinity redirect if current user not a member of group.
			 *
			 * @since 2.7.4
			 */
			if ( ! bp_group_is_member() ) {
				return;
			}

			if ( bp_is_active( 'activity' ) ) {
				define( 'BP_GROUPS_DEFAULT_EXTENSION', bp_get_activity_slug() );
			} else {
				define( 'BP_GROUPS_DEFAULT_EXTENSION', 'members' );
			}
		}

		/**
		 * Change group default avatar.
		 *
		 * @see   bp_groups_default_avatar()
		 *
		 * Use the mystery group avatar for groups.
		 *
		 * @since 2.6.0
		 *
		 * @param string $avatar Current avatar src.
		 * @param array  $params Avatar params.
		 *
		 * @return string
		 */
		public function groups_default_avatar( $avatar, $params ) {
			if ( isset( $params['object'] ) && 'group' === $params['object'] ) {
				if ( isset( $params['type'] ) && 'thumb' === $params['type'] ) {
					$file = 'mystery-group-50.jpg';
				} else {
					$file = 'mystery-group.jpg';
				}

				$avatar = EDUMALL_BP_ASSETS_URI . "/images/$file";
			}

			return $avatar;
		}
	}

	Edumall_BP_Groups::instance()->initialize();
}
