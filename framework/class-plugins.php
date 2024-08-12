<?php
defined('ABSPATH') || exit;

/**
 * Plugin installation and activation for WordPress themes
 */
if (!class_exists('Edumall_Register_Plugins')) {
	class Edumall_Register_Plugins
	{

		protected static $instance = null;

		public static function instance()
		{
			if (null === self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize()
		{
			add_filter('insight_core_tgm_plugins', array($this, 'register_required_plugins'));
		}

		public function register_required_plugins($plugins)
		{
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$new_plugins = array(
				array(
					'name'     => esc_html__('Insight Core', 'edumall-child'),
					'slug'     => 'insight-core',
					'source'   => 'https://www.dropbox.com/s/u4o8qjg3pzk26xz/insight-core-2.6.4.zip?dl=1',
					'version'  => '2.6.4',
					'required' => true,
				),
				array(
					'name'     => esc_html__('Edumall Addons', 'edumall-child'),
					'slug'     => 'edumall-addons',
					'source'   => 'https://www.dropbox.com/s/7vqi0rifunqo7cj/edumall-addons-1.2.0.zip?dl=1',
					'version'  => '1.2.0',
					'required' => true,
				),
				array(
					'name'     => esc_html__('Elementor', 'edumall-child'),
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'        => 'ThemeMove Addons For Elementor',
					'description' => 'Additional functions for Elementor',
					'slug'        => 'tm-addons-for-elementor',
					'logo'        => 'insight',
					'source'      => 'https://www.dropbox.com/s/mabcomq7s1lgkje/tm-addons-for-elementor-1.3.0.zip?dl=1',
					'version'     => '1.3.0',
				),
				array(
					'name'    => esc_html__('Revolution Slider', 'edumall-child'),
					'slug'    => 'revslider',
					'source'  => 'https://www.dropbox.com/scl/fi/uj0f5rlortjymzjjlts9q/revslider-6.6.15.zip?rlkey=zv4lnjuvdpivc2eo14ff1rdgf&dl=1',
					'version' => '6.6.15',
				),
				array(
					'name' => esc_html__('WP Events Manager', 'edumall-child'),
					'slug' => 'wp-events-manager',
				),
				array(
					'name' => esc_html__('Video Conferencing with Zoom', 'edumall-child'),
					'slug' => 'video-conferencing-with-zoom-api',
				),
				array(
					'name' => esc_html__('BuddyPress', 'edumall-child'),
					'slug' => 'buddypress',
				),
				array(
					'name' => esc_html__('MediaPress', 'edumall-child'),
					'slug' => 'mediapress',
				),
				array(
					'name' => esc_html__('WordPress Social Login', 'edumall-child'),
					'slug' => 'miniorange-login-openid',
				),
				array(
					'name' => esc_html__('Contact Form 7', 'edumall-child'),
					'slug' => 'contact-form-7',
				),
				array(
					'name' => esc_html__('MailChimp for WordPress', 'edumall-child'),
					'slug' => 'mailchimp-for-wp',
				),
				array(
					'name' => esc_html__('WooCommerce', 'edumall-child'),
					'slug' => 'woocommerce',
				),
				array(
					'name' => esc_html__('WPC Smart Compare for WooCommerce', 'edumall-child'),
					'slug' => 'woo-smart-compare',
				),
				array(
					'name' => esc_html__('WPC Smart Wishlist for WooCommerce', 'edumall-child'),
					'slug' => 'woo-smart-wishlist',
				),
				array(
					'name'    => esc_html__('Insight Swatches', 'edumall-child'),
					'slug'    => 'insight-swatches',
					'source'  => 'https://www.dropbox.com/s/sk7bt4mneusbhlb/insight-swatches-1.4.0.zip?dl=1',
					'version' => '1.4.0',
				),
				array(
					'name' => esc_html__('WP-PostViews', 'edumall-child'),
					'slug' => 'wp-postviews',
				),
				array(
					'name'    => esc_html__('Tutor LMS Pro', 'edumall-child'),
					'slug'    => 'tutor-pro',
					'source'  => 'https://www.dropbox.com/scl/fi/2apg05dsckzj8qxnwg8i4/tutor-pro-2.2.3.zip?rlkey=2h5636e7homhd9fpq7fayygov&dl=1',
					'version' => '2.2.3',
				),
				/**
				 * Tutor LMS has set up page after plugin activated.
				 * This made TGA stop activating other plugins after it.
				 * Move it to last activate plugin will resolve this problem.
				 */
				array(
					'name' => esc_html__('Tutor LMS', 'edumall-child'),
					'slug' => 'tutor',
				),
				array(
					'name'    => esc_html__('Tutor LMS Certificate Builder', 'edumall-child'),
					'slug'    => 'tutor-lms-certificate-builder',
					'source'  => 'https://www.dropbox.com/s/k8ss2um4vm38r66/tutor-lms-certificate-builder-1.0.4.zip?dl=1',
					'version' => '1.0.4',
				),
			);

			$plugins = array_merge($plugins, $new_plugins);

			return $plugins;
		}
	}

	Edumall_Register_Plugins::instance()->initialize();
}
