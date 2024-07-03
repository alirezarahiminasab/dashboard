<?php
defined( 'ABSPATH' ) || exit;

/**
 * Helper functions
 */
if ( ! class_exists( 'Edumall_Helper' ) ) {
	class Edumall_Helper {

		static $preloader_style = array();

		function __construct() {
			self::$preloader_style = array(
				'rotating-plane'  => esc_attr__( 'Rotating Plane', 'edumall' ),
				'double-bounce'   => esc_attr__( 'Double Bounce', 'edumall' ),
				'three-bounce'    => esc_attr__( 'Three Bounce', 'edumall' ),
				'wave'            => esc_attr__( 'Wave', 'edumall' ),
				'wandering-cubes' => esc_attr__( 'Wandering Cubes', 'edumall' ),
				'pulse'           => esc_attr__( 'Pulse', 'edumall' ),
				'chasing-dots'    => esc_attr__( 'Chasing dots', 'edumall' ),
				'circle'          => esc_attr__( 'Circle', 'edumall' ),
				'cube-grid'       => esc_attr__( 'Cube Grid', 'edumall' ),
				'fading-circle'   => esc_attr__( 'Fading Circle', 'edumall' ),
				'folding-cube'    => esc_attr__( 'Folding Cube', 'edumall' ),
				'gif-image'       => esc_attr__( 'Gif Image', 'edumall' ),
			);
		}

		public static function array_insert( &$array, $position, $insert ) {
			if ( is_int( $position ) ) {
				array_splice( $array, $position, 0, $insert );
			} else {
				$pos = array_search( $position, array_keys( $array ) );

				$array = array_merge(
					array_slice( $array, 0, $pos ),
					$insert,
					array_slice( $array, $pos )
				);
			}
		}

		public static function e( $var = '' ) {
			echo "{$var}";
		}

		public static function get_preloader_list() {
			$list = self::$preloader_style + array( 'random' => esc_attr__( 'Random', 'edumall' ) );

			return $list;
		}

		public static function get_post_meta( $name, $default = false ) {
			global $edumall_page_options;

			if ( $edumall_page_options != false && isset( $edumall_page_options[ $name ] ) ) {
				return $edumall_page_options[ $name ];
			}

			return $default;
		}

		public static function get_the_post_meta( $options, $name, $default = false ) {
			if ( $options != false && isset( $options[ $name ] ) ) {
				return $options[ $name ];
			}

			return $default;
		}

		/**
		 * @return array
		 */
		public static function get_list_revslider() {
			global $wpdb;
			$revsliders = array(
				'' => esc_attr__( 'Select a slider', 'edumall' ),
			);

			if ( function_exists( 'rev_slider_shortcode' ) ) {

				$table_name = $wpdb->prefix . 'revslider_sliders';
				$query      = $wpdb->prepare( "SELECT * FROM $table_name WHERE type != %s ORDER BY title ASC", 'template' );
				$results    = $wpdb->get_results( $query );
				if ( ! empty( $results ) ) {
					foreach ( $results as $result ) {
						$revsliders[ $result->alias ] = $result->title;
					}
				}
			}

			return $revsliders;
		}

		/**
		 * @param bool $default_option
		 *
		 * @return array
		 */
		public static function get_registered_sidebars( $default_option = false, $empty_option = true ) {
			global $wp_registered_sidebars;
			$sidebars = array();
			if ( $empty_option === true ) {
				$sidebars['none'] = esc_html__( 'No Sidebar', 'edumall' );
			}
			if ( $default_option === true ) {
				$sidebars['default'] = esc_html__( 'Default', 'edumall' );
			}
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}

			return $sidebars;
		}

		/**
		 * Get list sidebar positions
		 *
		 * @return array
		 */
		public static function get_list_sidebar_positions( $default = false ) {
			$positions = array(
				'left'  => esc_html__( 'Left', 'edumall' ),
				'right' => esc_html__( 'Right', 'edumall' ),
			);


			if ( $default === true ) {
				$positions['default'] = esc_html__( 'Default', 'edumall' );
			}

			return $positions;
		}

		/**
		 * Get content of file
		 *
		 * @param string $path
		 *
		 * @return mixed
		 */
		static function get_file_contents( $path = '' ) {
			$content = '';
			if ( $path !== '' ) {
				global $wp_filesystem;

				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();

				$path = str_replace( '/', DS, $path );

				if ( file_exists( $path ) ) {
					$content = $wp_filesystem->get_contents( $path );
				}
			}

			return $content;
		}

		public static function placeholder_avatar_src() {
			$src = EDUMALL_THEME_IMAGE_URI . '/avatar-placeholder.jpg';

			return apply_filters( 'edumall_placeholder_avatar_src', $src );
		}

		public static function strposa( $haystack, $needle, $offset = 0 ) {
			if ( ! is_array( $needle ) ) {
				$needle = array( $needle );
			}
			foreach ( $needle as $query ) {
				if ( strpos( $haystack, $query, $offset ) !== false ) {
					return true;
				} // stop on first true result
			}

			return false;
		}

		public static function w3c_iframe( $iframe ) {
			$iframe = str_replace( 'frameborder="0"', '', $iframe );
			$iframe = str_replace( 'frameborder="no"', '', $iframe );
			$iframe = str_replace( 'scrolling="no"', '', $iframe );
			$iframe = str_replace( 'gesture="media"', '', $iframe );
			$iframe = str_replace( 'allow="encrypted-media"', '', $iframe );

			return $iframe;
		}

		public static function get_md_media_query() {
			return '@media (max-width: 1199px)';
		}

		public static function get_sm_media_query() {
			return '@media (max-width: 991px)';
		}

		public static function get_xs_media_query() {
			return '@media (max-width: 767px)';
		}

		public static function get_body_font() {
			$font = Edumall::setting( 'typography_body' );

			if ( isset( $font['font-family'] ) ) {
				return "{$font['font-family']} Helvetica, Arial, sans-serif";
			}

			return 'Helvetica, Arial, sans-serif';
		}

		/**
		 * Check search page has results
		 *
		 * @return boolean true if has any results
		 */
		public static function is_search_has_results() {
			if ( is_search() ) {
				global $wp_query;
				$result = ( 0 != $wp_query->found_posts ) ? true : false;

				return $result;
			}

			return 0 != $GLOBALS['wp_query']->found_posts;
		}

		public static function get_button_typography_css_selector() {
			$default_selectors = '
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.wp-block-button__link,
				.rev-btn,
				.tm-button,
				.button,
				.wc-forward,
				.elementor-button
			';

			$selectors = apply_filters( 'edumall_customize_output_button_typography_selectors', [ $default_selectors ] );

			return $selectors;
		}

		public static function get_button_css_selector() {
			$default_selectors = '
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.wp-block-button__link,
				.button,
				.wc-forward,
				.button.button-alt:hover,
				.elementor-button
				';

			$selectors = apply_filters( 'edumall_customize_output_button_selectors', [ $default_selectors ] );

			return $selectors;
		}

		public static function get_button_hover_css_selector() {
			$default_selectors = '
				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				.wp-block-button__link:hover,
				.button:hover,
				.button:focus,
				.button-alt,
				.wc-forward:hover,
				.wc-forward:focus,
				.elementor-button:hover
				';

			$selectors = apply_filters( 'edumall_customize_output_button_hover_selectors', [ $default_selectors ] );

			return $selectors;
		}

		public static function get_form_input_css_selector() {
			$default_selectors = "
				input[type='text'],
				input[type='email'],
				input[type='url'],
				input[type='password'],
				input[type='search'],
				input[type='number'],
				input[type='tel'],
				select,
				textarea,
				.select2-container.select2-container--default .select2-selection--single,
				.select2-container.select2-container--default .select2-selection--single .select2-selection__rendered,
				.select2-container.select2-container--default .select2-search--dropdown .select2-search__field,
				.elementor-field-group .elementor-field-textual
			";

			$selectors = apply_filters( 'edumall_customize_output_form_input_selectors', [ $default_selectors ] );

			return $selectors;
		}

		public static function get_form_input_focus_css_selector() {
			$default_selectors = "
				input[type='text']:focus,
				input[type='email']:focus,
				input[type='url']:focus,
				input[type='password']:focus,
				input[type='search']:focus,
				input[type='number']:focus,
				input[type='tel']:focus,
				textarea:focus, select:focus,
				select:focus,
				textarea:focus,
				.select2-container.select2-container--default .select2-search--dropdown .select2-search__field:focus,
				.select2-container.select2-container--default.select2-container--open .select2-selection--single,
				.select2-container.select2-container--default.select2-container--open .select2-dropdown,
				.elementor-field-group .elementor-field-textual:focus
			";

			$selectors = apply_filters( 'edumall_customize_output_form_input_focus_selectors', [ $default_selectors ] );

			return $selectors;
		}

		public static function is_page_template( $template_file ) {
			$template_full = 'templates/' . $template_file;

			return is_page_template( $template_full );
		}

		/**
		 * @param int|float $value1
		 * @param int|float $value2 Total number
		 *
		 * @return int
		 */
		public static function calculate_percentage( $value1, $value2 ) {
			$percent = ( $value1 > 0 ) ? ( $value1 * 100 ) / $value2 : 0;

			return round( $percent );
		}

		/**
		 * Format number as float 2 decimals.
		 * Then trim last char 0
		 * For eg:
		 * 0 => 0
		 * 4.50 => 4.5
		 * 4.75 => 4.7.5
		 * 5.00 => 5.0
		 *
		 * @param $number Number to convert.
		 *
		 * @return string Formatted number.
		 */
		public static function number_format_nice_float( $number ) {
			// Not type.
			if ( 0 == $number ) {
				return $number;
			}

			$number = number_format( (float) $number, 2 );

			if ( 4 === strlen( $number ) && '0' === substr( $number, -1 ) ) {
				$number = substr_replace( $number, '', -1 );
			}

			return $number;
		}

		/**
		 * @see wc_clean() Function clone from woocommerce.
		 *
		 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
		 * Non-scalar values are ignored.
		 *
		 * @param string|array $var Data to sanitize.
		 *
		 * @return string|array
		 */
		public static function data_clean( $var ) {
			if ( is_array( $var ) ) {
				return array_map( 'data_clean', $var );
			} else {
				return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
			}
		}

		public static function is_elementor_editor() {
			if ( ! class_exists( '\Elementor\Plugin' ) || ( class_exists( '\Elementor\Plugin' ) && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
				return false;
			}

			return true;
		}

		public static function bool_to_str( $check ) {
			return $check ? 'true' : 'false';
		}

		public static function is_demo_site() {
			if ( defined( 'EDUMALL_DEMO_SITE' ) && true === EDUMALL_DEMO_SITE ) {
				return true;
			}

			$domain = wp_parse_url( get_stylesheet_directory_uri() );
			$host   = $domain['host'];

			if ( 'edumall.thememove.com' === $host ) {
				return true;
			}

			return false;
		}

		public static function is_live_site() {
			if ( defined( 'EDUMALL_LIVE_SITE' ) && true === EDUMALL_LIVE_SITE ) {
				return true;
			}

			$domain = wp_parse_url( get_stylesheet_directory_uri() );
			$host   = $domain['host'];

			if ( 'live-edumall.thememove.com' === $host ) {
				return true;
			}

			return false;
		}

		public static function get_user_social_networks_support() {
			$user_socials = array(
				'twitter'   => array(
					'label'        => esc_html__( 'Twitter', 'edumall' ),
					'icon_classes' => 'fa-brands fa-x-twitter',
					'placeholder'  => 'https://twitter.com/username',
				),
				'facebook'  => array(
					'label'        => esc_html__( 'Facebook', 'edumall' ),
					'icon_classes' => 'fa-brands fa-facebook-f',
					'placeholder'  => 'https://facebook.com/username',
				),
				'instagram' => array(
					'label'        => esc_html__( 'Instagram', 'edumall' ),
					'icon_classes' => 'fa-brands fa-instagram',
					'placeholder'  => 'https://instagram.com/username',
				),
				'linkedin'  => array(
					'label'        => esc_html__( 'Linkedin', 'edumall' ),
					'icon_classes' => 'fa-brands fa-linkedin',
					'placeholder'  => 'https://linkedin.com/username',
				),
				'pinterest' => array(
					'label'        => esc_html__( 'Pinterest', 'edumall' ),
					'icon_classes' => 'fa-brands fa-pinterest',
					'placeholder'  => 'https://pinterest.com/username',
				),
				'youtube'   => array(
					'label'        => esc_html__( 'Youtube', 'edumall' ),
					'icon_classes' => 'fa-brands fa-youtube',
					'placeholder'  => 'https://youtube.com',
				),
				'github'    => array(
					'label'        => esc_html__( 'Github', 'edumall' ),
					'icon_classes' => 'fa-brands fa-github',
					'placeholder'  => 'https://github.com/username',
				),
			);

			$user_socials = apply_filters( 'edumall_user_social_networks', $user_socials );

			return $user_socials;
		}

		public static function get_all_pages() {
			$options = [
				0 => esc_html__( 'Select a page', 'edumall' ),
			];

			$pages = get_pages();

			if ( $pages ) {
				foreach ( $pages as $page ) {
					$options [ $page->ID ] = $page->post_title;
				}
			}

			return $options;
		}
	}

	new Edumall_Helper();
}
