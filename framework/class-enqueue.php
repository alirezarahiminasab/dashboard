<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue scripts and styles.
 */
if ( ! class_exists( 'Edumall_Enqueue' ) ) {
	class Edumall_Enqueue {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Set priority 4 to make it run before elementor register scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_swiper' ), 4 );

			add_action( 'wp_enqueue_scripts', array( $this, 'polyfill_script' ), 1 );

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

			/**
			 * Make it run after main style & components.
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'rtl_styles' ), 20 );

			/**
			 * Make it run after main style & components.
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'dark_skin' ), 30 );

			// Disable woocommerce all styles.
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

			// Disable all contact form 7 scripts.
			add_filter( 'wpcf7_load_js', '__return_false' );
			add_filter( 'wpcf7_load_css', '__return_false' );
		}

		/**
		 * Register swiper lib.
		 * Use on wp_enqueue_scripts action.
		 */
		public function register_swiper() {
			$min = $this->get_min_suffix();

			wp_register_style( 'swiper', EDUMALL_THEME_URI . '/assets/libs/swiper/css/swiper.min.css', null, '5.4.1' );
			wp_register_script( 'swiper', EDUMALL_THEME_URI . '/assets/libs/swiper/js/swiper.min.js', array(
				'jquery',
				'imagesloaded',
			), '5.4.1', true );

			wp_register_script( 'edumall-swiper-wrapper', EDUMALL_THEME_URI . "/assets/js/swiper-wrapper{$min}.js", array( 'swiper' ), EDUMALL_THEME_VERSION, true );

			$edumall_swiper_js = array(
				'fractionPrefixText' => esc_html__( 'Show', 'edumall' ),
				'prevText'           => esc_html__( 'Prev', 'edumall' ),
				'nextText'           => esc_html__( 'Next', 'edumall' ),
			);
			wp_localize_script( 'edumall-swiper-wrapper', '$edumallSwiper', $edumall_swiper_js );
		}

		/**
		 * Fix elementor broken on old browsers
		 * Safari < 12.1
		 * Firefox < 55
		 * Chrome < 51
		 */
		public function polyfill_script() {
			wp_enqueue_script( 'intersection-observer', EDUMALL_THEME_URI . '/assets/libs/polyfill/intersection-observer.min.js', null, null, true );
		}

		/**
		 * Enqueue scripts & styles for frond-end.
		 *
		 * @access public
		 */
		public function frontend_scripts() {
			$min       = $this->get_min_suffix();
			$rtl       = $this->get_rtl_suffix();
			$post_type = get_post_type();

			// Remove prettyPhoto, default light box of woocommerce.
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

			// Remove font awesome from Yith Wishlist plugin.
			wp_dequeue_style( 'yith-wcwl-font-awesome' );

			// Remove hint from Woo Smart Compare plugin.
			wp_dequeue_style( 'hint' );

			// Remove feather font from Woo Smart Wishlist plugin.
			wp_dequeue_style( 'woosw-feather' );

			/*
			 * Begin register scripts & styles to be enqueued later.
			 */
			wp_register_style( 'edumall-woocommerce', EDUMALL_THEME_URI . "/woocommerce{$rtl}.css", null, EDUMALL_THEME_VERSION );

			wp_register_style( 'font-awesome-pro', EDUMALL_THEME_URI . '/assets/fonts/awesome/css/fontawesome-all.min.css', null, '6.4.2' );

			wp_register_style( 'select2', EDUMALL_THEME_URI . '/assets/libs/select2/select2.css' );
			wp_register_script( 'select2', EDUMALL_THEME_URI . '/assets/libs/select2/select2.full.min.js', array( 'jquery' ), '4.0.3', true );
			wp_register_script( 'selectWoo', EDUMALL_THEME_URI . '/assets/libs/selectWoo/selectWoo.full.min.js', array( 'jquery' ), '1.0.6', true );

			wp_register_style( 'justifiedGallery', EDUMALL_THEME_URI . '/assets/libs/justifiedGallery/css/justifiedGallery.min.css', null, '3.7.0' );
			wp_register_script( 'justifiedGallery', EDUMALL_THEME_URI . '/assets/libs/justifiedGallery/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '3.7.0', true );

			wp_register_script( 'powertip', EDUMALL_THEME_URI . '/assets/libs/powertip/js/jquery.powertip.min.js', array( 'jquery' ), '1.3.1', true );

			wp_register_style( 'lightgallery', EDUMALL_THEME_URI . '/assets/libs/lightGallery/css/lightgallery.min.css', null, '1.6.12' );
			wp_register_script( 'lightgallery', EDUMALL_THEME_URI . '/assets/libs/lightGallery/js/lightgallery-all.min.js', array(
				'jquery',
			), '1.6.12', true );

			wp_register_style( 'magnific-popup', EDUMALL_THEME_URI . "/assets/libs/magnific-popup/magnific-popup{$min}.css" );
			wp_register_script( 'magnific-popup', EDUMALL_THEME_URI . "/assets/libs/magnific-popup/jquery.magnific-popup{$min}.js", array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			wp_register_style( 'growl', EDUMALL_THEME_URI . '/assets/libs/growl/css/jquery.growl.min.css', null, '1.3.3' );
			wp_register_script( 'growl', EDUMALL_THEME_URI . '/assets/libs/growl/js/jquery.growl.min.js', array( 'jquery' ), '1.3.3', true );

			wp_register_script( 'matchheight', EDUMALL_THEME_URI . '/assets/libs/matchHeight/jquery.matchHeight-min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			wp_register_script( 'countdown', EDUMALL_THEME_URI . "/assets/libs/jquery.countdown/js/jquery.countdown{$min}.js", [ 'jquery' ], '1.0.0', true );

			wp_register_script( 'smooth-scroll', EDUMALL_THEME_URI . '/assets/libs/smooth-scroll-for-web/SmoothScroll.min.js', array(
				'jquery',
			), '1.4.9', true );

			// Fix Wordpress old version not registered this script.
			if ( ! wp_script_is( 'imagesloaded', 'registered' ) ) {
				wp_register_script( 'imagesloaded', EDUMALL_THEME_URI . '/assets/libs/imagesloaded/imagesloaded.min.js', array( 'jquery' ), null, true );
			}

			$this->register_swiper();

			wp_register_script( 'sticky-kit', EDUMALL_THEME_URI . '/assets/js/jquery.sticky-kit.min.js', array(
				'jquery',
				'edumall-script',
			), EDUMALL_THEME_VERSION, true );

			/**
			 * Fix Elementor load out-date version 1.0.1
			 */
			wp_deregister_script( 'smartmenus' );
			wp_register_script( 'smartmenus', EDUMALL_THEME_URI . '/assets/libs/smartmenus/jquery.smartmenus.min.js', array( 'jquery' ), '1.1.1', true );

			wp_register_script( 'picturefill', EDUMALL_THEME_URI . '/assets/libs/picturefill/picturefill.min.js', array( 'jquery' ), null, true );

			wp_register_script( 'mousewheel', EDUMALL_THEME_URI . '/assets/libs/mousewheel/jquery.mousewheel.min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			$google_api_key = $this->get_google_api_key();
			wp_register_script( 'edumall-gmap3', EDUMALL_THEME_URI . '/assets/libs/gmap3/gmap3.min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );
			wp_register_script( 'edumall-maps', EDUMALL_PROTOCOL . '://maps.google.com/maps/api/js?key=' . $google_api_key . '&amp;language=en' );

			wp_register_script( 'isotope-masonry', EDUMALL_THEME_URI . "/assets/js/isotope.pkgd{$min}.js", array( 'jquery' ), EDUMALL_THEME_VERSION, true );
			wp_register_script( 'isotope-packery', EDUMALL_THEME_URI . "/assets/libs/packery-mode/packery-mode.pkgd{$min}.js", array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			wp_register_script( 'edumall-grid-layout', EDUMALL_THEME_ASSETS_URI . "/js/grid-layout{$min}.js", array(
				'jquery',
				'imagesloaded',
				'matchheight',
				'isotope-masonry',
				'isotope-packery',
			), null, true );

			wp_register_script( 'edumall-common-archive', EDUMALL_THEME_URI . "/assets/js/common-archive{$min}.js", [
				'jquery',
				'perfect-scrollbar',
			], EDUMALL_THEME_VERSION, true );
			wp_register_script( 'edumall-quantity-button', EDUMALL_THEME_URI . "/assets/js/woo/quantity-button{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );

			wp_register_script( 'edumall-woo-general', EDUMALL_THEME_URI . "/assets/js/woo/general{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );
			wp_register_script( 'edumall-woo-checkout', EDUMALL_THEME_URI . "/assets/js/woo/checkout{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );
			wp_register_script( 'edumall-woo-single', EDUMALL_THEME_URI . "/assets/js/woo/single{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );

			wp_register_script( 'edumall-tab-panel', EDUMALL_THEME_URI . "/assets/js/tab-panel{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );
			wp_register_script( 'edumall-modal', EDUMALL_THEME_URI . "/assets/js/modal{$min}.js", [ 'jquery' ], EDUMALL_THEME_VERSION, true );

			/*
			 * End register scripts
			 */

			wp_enqueue_style( 'font-awesome-pro' );
			wp_enqueue_style( 'swiper' );
			wp_enqueue_style( 'lightgallery' );

			/*
			 * Enqueue the theme's style.css.
			 * This is recommended because we can add inline styles there
			 * and some plugins use it to do exactly that.
			 */
			wp_enqueue_style( 'edumall-style', get_template_directory_uri() . "/style{$rtl}.css" );

			if ( Edumall::setting( 'header_sticky_enable' ) ) {
				wp_enqueue_script( 'headroom', EDUMALL_THEME_URI . '/assets/js/headroom.min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );
			}

			if ( Edumall::setting( 'smooth_scroll_enable' ) && ! Edumall_Helper::is_elementor_editor() ) {
				wp_enqueue_script( 'smooth-scroll' );
			}

			wp_enqueue_script( 'lightgallery' );

			// Use waypoints lib edited by Elementor to avoid duplicate the script.
			if ( ! wp_script_is( 'elementor-waypoints', 'registered' ) ) {
				wp_register_script( 'elementor-waypoints', EDUMALL_THEME_URI . '/assets/libs/elementor-waypoints/jquery.waypoints.min.js', array( 'jquery' ), null, true );
			}

			wp_enqueue_script( 'elementor-waypoints' );

			wp_enqueue_script( 'powertip' );

			wp_enqueue_script( 'jquery-smooth-scroll', EDUMALL_THEME_URI . '/assets/libs/smooth-scroll/jquery.smooth-scroll.min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			wp_enqueue_script( 'edumall-swiper-wrapper' );

			wp_enqueue_script( 'smartmenus' );

			wp_enqueue_style( 'perfect-scrollbar', EDUMALL_THEME_URI . '/assets/libs/perfect-scrollbar/css/perfect-scrollbar.min.css' );
			wp_enqueue_script( 'perfect-scrollbar', EDUMALL_THEME_URI . '/assets/libs/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), EDUMALL_THEME_VERSION, true );

			//if ( Edumall::setting( 'notice_cookie_enable' ) === '1' && ! isset( $_COOKIE['notice_cookie_confirm'] ) ) {
			wp_enqueue_script( 'growl' );
			wp_enqueue_style( 'growl' );
			//}

			wp_enqueue_script( 'edumall-modal' );

			if ( is_search() ) {
				wp_enqueue_script( 'edumall-grid-layout' );
			}

			$is_product = false;

			//  Enqueue styles & scripts for single pages.
			if ( is_singular() ) {

				switch ( $post_type ) {
					case 'portfolio':
						$_sticky = Edumall::setting( 'single_portfolio_sticky_detail_enable' );


						if ( $_sticky == '1' ) {
							wp_enqueue_script( 'sticky-kit' );
						}

						wp_enqueue_style( 'lightgallery' );
						wp_enqueue_script( 'lightgallery' );

						break;

					case 'product':
						$is_product = true;

						$single_product_sticky = Edumall::setting( 'single_product_sticky_enable' );
						if ( $single_product_sticky == '1' ) {
							wp_enqueue_script( 'sticky-kit' );
						}

						wp_enqueue_style( 'lightgallery' );
						wp_enqueue_script( 'lightgallery' );

						break;
				}
			}

			/*
			 * The comment-reply script.
			 */
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				switch ( $post_type ) {
					case 'post':
						if ( Edumall::setting( 'single_post_comment_enable' ) === '1' ) {
							wp_enqueue_script( 'comment-reply' );
						}
						break;
					case 'portfolio':
						if ( Edumall::setting( 'single_portfolio_comment_enable' ) === '1' ) {
							wp_enqueue_script( 'comment-reply' );
						}
						break;
					default:
						wp_enqueue_script( 'comment-reply' );
						break;
				}
			}

			wp_enqueue_script( 'edumall-nice-select', EDUMALL_THEME_URI . "/assets/js/nice-select{$min}.js", array(
				'jquery',
			), EDUMALL_THEME_VERSION, true );

			/*
			 * Enqueue main JS
			 */
			wp_enqueue_script( 'edumall-script', EDUMALL_THEME_URI . "/assets/js/main{$min}.js", array(
				'jquery',
			), EDUMALL_THEME_VERSION, true );

			if ( Edumall_Woo::instance()->is_activated() ) {
				wp_enqueue_style( 'edumall-woocommerce' );

				if ( '1' === Edumall::setting( 'shop_archive_quick_view' ) ) {
					wp_enqueue_style( 'magnific-popup' );
					wp_enqueue_script( 'magnific-popup' );

					/**
					 * Enable ajax add to cart variation in Quick View popup on all pages.
					 */
					wp_enqueue_script( 'wc-add-to-cart-variation' );

					// Quick view need change quantity.
					wp_enqueue_script( 'edumall-quantity-button' );
				}

				wp_enqueue_script( 'edumall-woo-general' );

				if ( Edumall_Woo::instance()->is_product_archive() ) {
					wp_enqueue_script( 'edumall-grid-layout' );
					wp_enqueue_script( 'edumall-common-archive' );
				}

				if ( is_cart() || is_product() ) {
					wp_enqueue_script( 'edumall-quantity-button' );
				}

				if ( is_checkout() ) {
					wp_enqueue_script( 'edumall-woo-checkout' );
				}

				if ( is_product() ) {
					wp_enqueue_script( 'edumall-woo-single' );
				}
			}

			/*
			 * Enqueue custom variable JS
			 */

			if ( class_exists( 'WooCommerce' ) ) {
				$notice_cart_url = wc_get_cart_url();
			} else {
				$notice_cart_url = get_home_url( 'cart' );
			}

			$js_variables = array(
				'ajaxurl'                   => admin_url( 'admin-ajax.php' ),
				'edumall_ajax_url'          => Edumall_AJAX::get_endpoint( '%%endpoint%%' ),
				'header_sticky_enable'      => Edumall::setting( 'header_sticky_enable' ),
				'header_sticky_height'      => Edumall::setting( 'header_sticky_height' ),
				'scroll_top_enable'         => Edumall::setting( 'scroll_top_enable' ),
				'light_gallery_auto_play'   => Edumall::setting( 'light_gallery_auto_play' ),
				'light_gallery_download'    => Edumall::setting( 'light_gallery_download' ),
				'light_gallery_full_screen' => Edumall::setting( 'light_gallery_full_screen' ),
				'light_gallery_zoom'        => Edumall::setting( 'light_gallery_zoom' ),
				'light_gallery_thumbnail'   => Edumall::setting( 'light_gallery_thumbnail' ),
				'light_gallery_share'       => Edumall::setting( 'light_gallery_share' ),
				'mobile_menu_breakpoint'    => Edumall::setting( 'mobile_menu_breakpoint' ),
				'isRTL'                     => EDUMALL_IS_RTL,
				'isProduct'                 => $is_product,
				'productFeatureStyle'       => Edumall_Woo::instance()->get_single_product_style(),
				'noticeCookieEnable'        => Edumall::setting( 'notice_cookie_enable' ),
				'noticeCookieConfirm'       => isset( $_COOKIE['notice_cookie_confirm'] ) ? 'yes' : 'no',
				'noticeCookieMessages'      => Edumall_Notices::instance()->get_notice_cookie_messages(),
				'noticeCartUrl'             => esc_js( $notice_cart_url ),
				'noticeCartText'            => esc_js( esc_html__( 'View Cart', 'edumall' ) ),
				'noticeAddedCartText'       => esc_js( esc_html__( 'added to cart!', 'edumall' ) ),
				'countdownDaysText'         => esc_html__( 'Days', 'edumall' ),
				'countdownHoursText'        => esc_html__( 'Hours', 'edumall' ),
				'countdownMinutesText'      => esc_html__( 'Mins', 'edumall' ),
				'countdownSecondsText'      => esc_html__( 'Secs', 'edumall' ),
			);
			wp_localize_script( 'edumall-script', '$edumall', $js_variables );

			/**
			 * Custom JS
			 */
			if ( Edumall::setting( 'custom_js_enable' ) == 1 ) {
				wp_add_inline_script( 'edumall-script', html_entity_decode( Edumall::setting( 'custom_js' ) ) );
			}
		}

		public function rtl_styles() {
			wp_register_style( 'edumall-style-rtl-custom', EDUMALL_THEME_URI . '/style-rtl-custom.css', null, EDUMALL_THEME_VERSION );

			if ( is_rtl() ) {
				wp_enqueue_style( 'edumall-style-rtl-custom' );
			}
		}

		public function dark_skin() {
			wp_register_style( 'edumall-skin-dark', EDUMALL_THEME_URI . '/style-dark.css', null, EDUMALL_THEME_VERSION );

			if ( Edumall::is_dark_version() ) {
				wp_enqueue_style( 'edumall-skin-dark' );
			}
		}

		public function get_google_api_key() {
			if ( defined( 'EDUMALL_GOOGLE_MAP_API_KEY' ) && ! empty( EDUMALL_GOOGLE_MAP_API_KEY ) ) {
				return EDUMALL_GOOGLE_MAP_API_KEY;
			}

			return Edumall::setting( 'google_api_key' );
		}

		/**
		 * @return string
		 */
		public function get_min_suffix() {
			$min = '.min';

			if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
				$min = '';
			}

			return $min;
		}

		public function get_rtl_suffix() {
			return is_rtl() ? '-rtl' : '';
		}
	}

	Edumall_Enqueue::instance()->initialize();
}
