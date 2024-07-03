<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin installation and activation for WordPress themes
 */
if ( ! class_exists( 'Edumall_Register_Plugins' ) ) {
	class Edumall_Register_Plugins {

		const GOOGLE_DRIVER_API = 'AIzaSyDXOs0Bxx-uBEA4fH4fzgoHtl64g0RWv-g';

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize() {
			add_filter( 'insight_core_tgm_plugins', array( $this, 'register_required_plugins' ) );
		}

		public function register_required_plugins( $plugins ) {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$new_plugins = array(
				array(
					'name'     => esc_html__( 'Insight Core', 'edumall' ),
					'slug'     => 'insight-core',
					'source'   => $this->get_plugin_google_driver_url( '13BECax_TBea1STUV7l6HRMgbcObuVpMq' ),
					'version'  => '2.7.0',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Edumall Addons', 'edumall' ),
					'slug'     => 'edumall-addons',
					'source'   => 'https://www.dropbox.com/scl/fi/oxouw7ejwaoi2er2rr6uj/edumall-addons-1.2.2.zip?rlkey=fyel5eb0r1yvf5klt8nwhiiq3&dl=1',
					'version'  => '1.2.2',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Elementor', 'edumall' ),
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'        => 'ThemeMove Addons For Elementor',
					'description' => 'Additional functions for Elementor',
					'slug'        => 'tm-addons-for-elementor',
					'logo'        => 'insight',
					'source'      => $this->get_plugin_google_driver_url( '1QAfYhzCC_Fi75pOE6AdfMbDuI4JYhbgq' ),
					'version'     => '2.0.0',
				),
				array(
					'name'    => esc_html__( 'Revolution Slider', 'edumall' ),
					'slug'    => 'revslider',
					'source'  => $this->get_plugin_google_driver_url( '1R2wcAJmq5_xkhUee-tp1FqxpFAccxxH9' ),
					'version' => '6.7.13',
				),
				array(
					'name' => esc_html__( 'WP Events Manager', 'edumall' ),
					'slug' => 'wp-events-manager',
				),
				array(
					'name' => esc_html__( 'Video Conferencing with Zoom', 'edumall' ),
					'slug' => 'video-conferencing-with-zoom-api',
				),
				array(
					'name' => esc_html__( 'BuddyPress', 'edumall' ),
					'slug' => 'buddypress',
				),
				array(
					'name' => esc_html__( 'MediaPress', 'edumall' ),
					'slug' => 'mediapress',
				),
				array(
					'name' => esc_html__( 'WordPress Social Login', 'edumall' ),
					'slug' => 'miniorange-login-openid',
				),
				array(
					'name' => esc_html__( 'Contact Form 7', 'edumall' ),
					'slug' => 'contact-form-7',
				),
				array(
					'name' => esc_html__( 'MailChimp for WordPress', 'edumall' ),
					'slug' => 'mailchimp-for-wp',
				),
				array(
					'name' => esc_html__( 'WooCommerce', 'edumall' ),
					'slug' => 'woocommerce',
				),
				array(
					'name' => esc_html__( 'WPC Smart Compare for WooCommerce', 'edumall' ),
					'slug' => 'woo-smart-compare',
				),
				array(
					'name' => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'edumall' ),
					'slug' => 'woo-smart-wishlist',
				),
				array(
					'name'    => esc_html__( 'Insight Swatches', 'edumall' ),
					'slug'    => 'insight-swatches',
					'source'  => 'https://www.dropbox.com/scl/fi/j2po0jzzlb8zs4b5t7zu4/insight-swatches-1.7.0.zip?rlkey=1st3r1s1w3w43fbyrek90df75&dl=1',
					'version' => '1.7.0',
				),
				array(
					'name' => esc_html__( 'WP-PostViews', 'edumall' ),
					'slug' => 'wp-postviews',
				),
				array(
					'name'    => esc_html__( 'Tutor LMS Pro', 'edumall' ),
					'slug'    => 'tutor-pro',
					'source'  => $this->get_plugin_google_driver_url( '1SpD-Jes_vig1fKrZ4bUJXJLw0zyiLtva' ),
					'version' => '2.7.1',
				),
				/**
				 * Tutor LMS has set up page after plugin activated.
				 * This made TGA stop activating other plugins after it.
				 * Move it to last activate plugin will resolve this problem.
				 */
				array(
					'name' => esc_html__( 'Tutor LMS', 'edumall' ),
					'slug' => 'tutor',
				),
				array(
					'name'    => esc_html__( 'Tutor LMS Certificate Builder', 'edumall' ),
					'slug'    => 'tutor-lms-certificate-builder',
					'source'  => 'https://www.dropbox.com/scl/fi/h6bkan0xh4z5db0l7of1k/tutor-lms-certificate-builder-1.0.5.zip?rlkey=96n6ilwvobldcmk3fpsna5yaq&dl=1',
					'version' => '1.0.5',
				),
			);

			$plugins = array_merge( $plugins, $new_plugins );

			return $plugins;
		}

		public function get_plugin_google_driver_url( $file_id ) {
			return "https://www.googleapis.com/drive/v3/files/{$file_id}?alt=media&key=" . self::GOOGLE_DRIVER_API;
		}
	}

	Edumall_Register_Plugins::instance()->initialize();
}
