<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Zoom_Meeting' ) ) {
	class Edumall_Zoom_Meeting {

		protected static $instance = null;

		const    POST_META_MEETING_ZOOM_DETAILS = '_meeting_zoom_details';

		const    SIDEBAR_ID = 'zoom_meeting_sidebar';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Do nothing if plugin not activated.
			if ( ! $this->is_activated() ) {
				return;
			}

			add_filter( 'edumall_customize_output_button_typography_selectors', [
				$this,
				'customize_output_button_typography_selectors',
			] );

			add_filter( 'edumall_customize_output_button_selectors', [
				$this,
				'customize_output_button_selectors',
			] );

			add_filter( 'edumall_customize_output_button_hover_selectors', [
				$this,
				'customize_output_button_hover_selectors',
			] );

			add_shortcode( 'tm_zoom_meeting', [ $this, 'shortcode_zoom_meeting' ] );

			add_action( 'pre_get_posts', array( $this, 'change_post_per_page' ) );

			// Register widget areas.
			add_action( 'widgets_init', [ $this, 'register_sidebars' ] );

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 100 );

			/**
			 * Fixed Category page not include template.
			 * Priority 100 to run after plugin's hook (99).
			 */
			add_filter( 'template_include', [ $this, 'load_archive_template' ], 100 );

			add_filter( 'body_class', [ $this, 'body_classes' ] );

			add_filter( 'edumall_title_bar_heading_text', [ $this, 'archive_title_bar_heading' ] );

			remove_action( 'vczoom_single_content_left', 'video_conference_zoom_featured_image', 10 );
			remove_action( 'vczoom_single_content_right', 'video_conference_zoom_countdown_timer', 10 );

			add_action( 'edumall_single_zoom_meeting_hero_content_bottom', 'video_conference_zoom_featured_image', 10 );
			add_action( 'edumall_single_zoom_meeting_hero_content_right', 'video_conference_zoom_countdown_timer', 10 );
		}

		/**
		 * Check plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( defined( 'ZVC_PLUGIN_SLUG' ) ) {
				return true;
			}

			return false;
		}

		public function get_post_type() {
			return 'zoom-meetings';
		}

		public function get_tax_category() {
			return 'zoom-meeting';
		}

		/**
		 * Check if current page is category or tag pages
		 */
		function is_taxonomy() {
			$taxonomies = get_object_taxonomies( $this->get_post_type() );

			return empty( $taxonomies ) ? false : is_tax( $taxonomies );
		}

		/**
		 * Check if current page is archive pages
		 */
		function is_archive() {
			return $this->is_taxonomy() || is_post_type_archive( $this->get_post_type() );
		}

		function is_single() {
			return is_singular( $this->get_post_type() );
		}

		/**
		 * Get all categories.
		 *
		 * @return false|WP_Error|WP_Term[]
		 */
		public function get_the_categories() {
			$terms = get_the_terms( get_the_ID(), $this->get_tax_category() );

			return empty( $terms ) || is_wp_error( $terms ) ? false : $terms;
		}

		/**
		 * Get the first group of current faq post.
		 */
		public function get_the_category() {
			$terms = $this->get_the_categories();

			if ( $terms ) {
				return $terms[0];
			}

			return false;
		}

		/**
		 * @param array $args
		 *
		 * Render first category of current zoom meeting post.
		 */
		function the_category( $args = array() ) {
			$term = $this->get_the_category();

			if ( ! $term ) {
				return;
			}

			$defaults = array(
				'classes'    => 'post-category',
				'show_links' => true,
			);
			$args     = wp_parse_args( $args, $defaults );
			?>
			<div class="<?php echo esc_attr( $args['classes'] ); ?>">
				<?php
				if ( $args['show_links'] ) {
					$link = get_term_link( $term );
					printf( '<a href="%1$s" rel="category tag"><span>%2$s</span></a>', $link, $term->name );
				} else {
					echo "<span>{$term->name}</span>";
				}
				?>
			</div>
			<?php
		}

		/**
		 * Change number post per page of main query.
		 *
		 * @param WP_Query $query Query instance.
		 */
		public function change_post_per_page( $query ) {
			if ( $query->is_main_query() && $this->is_archive() && ! is_admin() ) {
				$number = Edumall::setting( 'zoom_meeting_archive_number_item', 9 );

				$query->set( 'posts_per_page', $number );
			}
		}

		public function body_classes( $classes ) {
			if ( $this->is_archive() ) {
				$classes[] = 'archive-zoom-meetings';
			}

			return $classes;
		}

		public function archive_title_bar_heading( $text ) {
			if ( $this->is_archive() ) {
				$text = esc_html__( 'Zoom Meetings and Webinars', 'edumall' );
			}

			return $text;
		}

		/**
		 * Archive page template
		 *
		 * @param $template
		 *
		 * @return bool|string
		 * @return bool|string|void
		 * @since  3.0.0
		 *
		 * @author Deepen
		 */
		public function load_archive_template( $template ) {
			global $wp_query;

			if ( ! function_exists( 'vczapi_get_template' ) ) {
				return $template;
			}

			$post_type = get_query_var( 'post_type' );
			$category  = get_query_var( $this->get_tax_category() );

			if ( ( $post_type === $this->get_post_type() || ! empty( $category ) ) && $wp_query->is_archive ) {
				$new_template = vczapi_get_template( 'archive-meetings.php' );

				if ( ! empty( $new_template ) ) {
					return $new_template;
				}
			}

			return $template;
		}

		public function register_sidebars() {
			$default_args = Edumall_Sidebar::instance()->get_default_sidebar_args();

			register_sidebar( array_merge( $default_args, array(
				'id'          => self::SIDEBAR_ID,
				'name'        => esc_html__( 'Zoom Meeting Sidebar', 'edumall' ),
				'description' => esc_html__( 'Add widgets here.', 'edumall' ),
			) ) );
		}

		public function frontend_scripts() {
			$rtl = Edumall_Enqueue::instance()->get_rtl_suffix();

			if ( $this->is_archive() ) {
				wp_enqueue_script( 'edumall-grid-layout' );
			}

			wp_register_style( 'edumall-zoom-meetings', EDUMALL_THEME_URI . "/video-conferencing-zoom{$rtl}.css", null, null );

			wp_enqueue_style( 'edumall-zoom-meetings' );
		}

		public function customize_output_button_typography_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function customize_output_button_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function customize_output_button_hover_selectors( $selectors ) {
			$new_selectors = [ '.dpn-zvc-single-content-wrapper .dpn-zvc-sidebar-wrapper .dpn-zvc-sidebar-box .join-links .btn:hover' ];

			$final_selectors = array_merge( $selectors, $new_selectors );

			return $final_selectors;
		}

		public function enqueue_scripts() {
			wp_register_script( 'countdown', EDUMALL_THEME_ASSETS_URI . '/libs/jquery.countdown/js/jquery.countdown.min.js', [ 'jquery' ], '1.0.0', true );
			wp_register_script( 'edumall-zoom-meeting-countdown', EDUMALL_THEME_ASSETS_URI . '/js/shortcodes/shortcode-zoom-meeting.js', [
				'jquery',
				'countdown',
			], '1.0.0', true );
		}

		public function shortcode_zoom_meeting( $atts ) {
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment-locales' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api-moment-timezone' );
			wp_enqueue_script( 'video-conferencing-with-zoom-api' );
			wp_enqueue_script( 'edumall-zoom-meeting-countdown' );

			extract( shortcode_atts( array(
				'meeting_id' => 'javascript:void(0);',
			), $atts ) );

			unset( $GLOBALS['vanity_uri'] );
			unset( $GLOBALS['zoom_meetings'] );

			ob_start();

			if ( empty( $meeting_id ) ) {
				echo '<h4 class="no-meeting-id"><strong style="color:red;">' . esc_html__( 'ERROR: ', 'edumall' ) . '</strong>' . esc_html__( 'No meeting id set in the shortcode', 'edumall' ) . '</h4>';

				return false;
			}

			$zoom_states = get_option( 'zoom_api_meeting_options' );
			if ( isset( $zoom_states[ $meeting_id ]['state'] ) && $zoom_states[ $meeting_id ]['state'] === "ended" ) {
				echo '<h3>' . esc_html__( 'This meeting has been ended by host.', 'edumall' ) . '</h3>';

				return;
			}

			$vanity_uri               = get_option( 'zoom_vanity_url' );
			$meeting                  = $this->fetch_meeting( $meeting_id );
			$GLOBALS['vanity_uri']    = $vanity_uri;
			$GLOBALS['zoom_meetings'] = $meeting;
			if ( ! empty( $meeting ) && ! empty( $meeting->code ) ) {
				?>
				<p class="dpn-error dpn-mtg-not-found"><?php echo esc_html( $meeting->message ); ?></p>
				<?php
			} else {
				if ( $meeting ) {
					//Get Template
					vczapi_get_template( 'shortcode/tm-zoom-meeting.php', true, false );
				} else {
					printf( esc_html__( 'Please try again ! Some error occured while trying to fetch meeting with id:  %d', 'edumall' ), $meeting_id );
				}
			}

			return ob_get_clean();
		}

		/**
		 * @see Zoom_Video_Conferencing_Shorcodes::fetch_meeting()
		 * @see Zoom_Video_Conferencing_Api::instance() zoom_conference()
		 * Get Meeting INFO
		 *
		 * @param $meeting_id
		 *
		 * @return bool|mixed|null
		 */
		public function fetch_meeting( $meeting_id ) {
			$transient_name = "zoom-us-fetch-meeting-id-{$meeting_id}";

			$meeting = get_transient( $transient_name );

			if ( false === $meeting ) {
				$meeting = json_decode( zoom_conference()->getMeetingInfo( $meeting_id ) );

				if ( ! empty( $meeting->error ) ) {
					return false;
				}

				set_transient( $transient_name, $meeting, apply_filters( 'edumall_zoom_us_fetch_meeting_cache_time', DAY_IN_SECONDS * 1 ) );
			}

			return $meeting;
		}

		/**
		 * @see    video_conference_zoom_shortcode_join_link()
		 * Generate join links
		 *
		 * @param $zoom_meetings
		 */
		public function zoom_shortcode_join_link( $zoom_meetings ) {
			if ( empty( $zoom_meetings ) ) {
				echo "<p>" . esc_html__( 'Meeting is not defined. Try updating this meeting', 'edumall' ) . "</p>";

				return;
			}

			$now               = new DateTime( 'now -1 hour', new DateTimeZone( $zoom_meetings->timezone ) );
			$closest_occurence = false;
			if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 8 && ! empty( $zoom_meetings->occurrences ) ) {
				foreach ( $zoom_meetings->occurrences as $occurrence ) {
					if ( $occurrence->status === "available" ) {
						$start_date = new DateTime( $occurrence->start_time, new DateTimeZone( $zoom_meetings->timezone ) );
						if ( $start_date >= $now ) {
							$closest_occurence = $occurrence->start_time;
							break;
						}
					}
				}
			} else if ( empty( $zoom_meetings->occurrences ) ) {
				$zoom_meetings->start_time = false;
			} else if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 3 ) {
				$zoom_meetings->start_time = false;
			}

			$start_time = ! empty( $closest_occurence ) ? $closest_occurence : $zoom_meetings->start_time;
			$start_time = new DateTime( $start_time, new DateTimeZone( $zoom_meetings->timezone ) );
			$start_time->setTimezone( new DateTimeZone( $zoom_meetings->timezone ) );
			if ( $now <= $start_time ) {
				unset( $GLOBALS['meetings'] );

				if ( ! empty( $zoom_meetings->password ) ) {
					$browser_join = vczapi_get_browser_join_shortcode( $zoom_meetings->id, $zoom_meetings->password, true );
				} else {
					$browser_join = vczapi_get_browser_join_shortcode( $zoom_meetings->id, false, true );
				}

				$join_url            = ! empty( $zoom_meetings->encrypted_password ) ? vczapi_get_pwd_embedded_join_link( $zoom_meetings->join_url, $zoom_meetings->encrypted_password ) : $zoom_meetings->join_url;
				$GLOBALS['meetings'] = array(
					'join_uri'    => apply_filters( 'vczoom_join_meeting_via_app_shortcode', $join_url, $zoom_meetings ),
					'browser_url' => apply_filters( 'vczoom_join_meeting_via_browser_disable', $browser_join ),
				);
				vczapi_get_template( 'shortcode/tm-join-links.php', true, false );
			}
		}
	}

	Edumall_Zoom_Meeting::instance()->initialize();
}
