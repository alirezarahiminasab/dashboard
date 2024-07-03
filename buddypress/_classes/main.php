<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_BP' ) ) {
	class Edumall_BP {

		private static $instance = null;

		/**
		 * Minimum BuddyPress version required to run the theme.
		 *
		 * @since 2.8.4
		 *
		 * @var string
		 */
		const MINIMUM_BP_VERSION = '12.0.0';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function define_constants() {
			define( 'EDUMALL_BP_DIR', get_template_directory() . DS . 'buddypress' );
			define( 'EDUMALL_BP_CORE_DIR', EDUMALL_BP_DIR . DS . '_classes' );
			define( 'EDUMALL_BP_ASSETS_URI', get_template_directory_uri() . '/buddypress/assets' );
		}

		public function initialize() {
			if ( ! $this->is_activated() ) {
				return;
			}

			$this->check_compatible();
			$this->define_constants();
			$this->set_up();

			require_once EDUMALL_BP_CORE_DIR . '/functions.php';
			require_once EDUMALL_BP_CORE_DIR . '/enqueue.php';
			require_once EDUMALL_BP_CORE_DIR . '/customizer.php';
			require_once EDUMALL_BP_CORE_DIR . '/widgets.php';
			require_once EDUMALL_BP_CORE_DIR . '/layout.php';
			require_once EDUMALL_BP_CORE_DIR . '/notifications.php';
			require_once EDUMALL_BP_CORE_DIR . '/activity.php';
			require_once EDUMALL_BP_CORE_DIR . '/members.php';
			require_once EDUMALL_BP_CORE_DIR . '/groups.php';

			if ( class_exists( 'MediaPress' ) ) {
				require_once EDUMALL_BP_CORE_DIR . '/add-ons/media-press.php';
			}
		}

		public function is_activated() {
			if ( class_exists( 'BuddyPress' ) ) {
				return true;
			}

			return false;
		}

		public function check_compatible() {
			if ( defined( 'BP_VERSION' ) && version_compare( BP_VERSION, self::MINIMUM_BP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_version' ] );
			}
		}

		public function admin_notice_minimum_version() {
			edumall_notice_required_plugin_version( 'BuddyPress', self::MINIMUM_BP_VERSION );
		}

		public function set_up() {
			add_filter( 'bp_before_members_cover_image_settings_parse_args', [ $this, 'change_cover_size' ] );
			add_filter( 'bp_before_groups_cover_image_settings_parse_args', [ $this, 'change_cover_size' ] );

			add_filter( 'bp_core_avatar_thumb_width', [ $this, 'change_avatar_thumb_size' ] );
			add_filter( 'bp_core_avatar_thumb_height', [ $this, 'change_avatar_thumb_size' ] );
			add_filter( 'bp_core_avatar_full_width', [ $this, 'change_avatar_full_size' ] );
			add_filter( 'bp_core_avatar_full_height', [ $this, 'change_avatar_full_size' ] );

			add_filter( 'edumall_user_profile_text', [ $this, 'update_profile_text' ], 15 );
			add_filter( 'edumall_user_profile_url', [ $this, 'update_profile_url' ], 15 );
			add_filter( 'edumall_login_url', [ $this, 'update_profile_url' ], 15 );
			add_filter( 'edumall_register_url', [ $this, 'update_profile_url' ], 15 );
		}

		public function change_cover_size( $settings ) {
			$settings['width']  = 1170;
			$settings['height'] = 270;

			return $settings;
		}

		public function change_avatar_thumb_size() {
			return 56;
		}

		public function change_avatar_full_size() {
			return 170;
		}

		public function update_profile_url() {
			return bp_displayed_user_url();
		}

		public function update_profile_text() {
			return bp_get_displayed_user_fullname();
		}
	}

	Edumall_BP::instance()->initialize();
}
