<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Event' ) ) {
	class Edumall_Event {

		protected static $instance = null;

		const    POST_TYPE                = 'tp_event';
		const    TAXONOMY_CATEGORY        = 'tp_event_category';
		const    TAXONOMY_TAGS            = 'tp_event_tag';
		const    TAXONOMY_SPEAKER         = 'event-speaker';
		const    POST_META_STATUS         = 'tp_event_status';
		const    POST_META_LOCATION       = 'tp_event_location';
		const    POST_META_SHORT_LOCATION = 'tp_event_short_location';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			require_once EDUMALL_EVENT_MANAGER_DIR . '/post-type.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/template.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/query.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/enqueue.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/sidebar.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/archive-event.php';
			require_once EDUMALL_EVENT_MANAGER_DIR . '/single-event.php';

			// Do nothing if plugin not activated.
			if ( ! $this->is_activated() ) {
				return;
			}

			Edumall_Event_Post_Type::instance()->initialize();
			Edumall_Event_Template::instance()->initialize();
			Edumall_Event_Query::instance()->initialize();
			Edumall_Event_Enqueue::instance()->initialize();
			Edumall_Event_Sidebar::instance()->initialize();
			Edumall_Archive_Event::instance()->initialize();
			Edumall_Single_Event::instance()->initialize();

			// Add meta data for event.
			add_action( 'tp_event_admin_event_metabox_after_fields', [
				$this,
				'add_event_meta_short_location',
			], 10, 2 );

			add_action( 'tp_event_admin_event_metabox_after_fields', [
				$this,
				'add_event_meta_place',
			], 10, 2 );

			add_action( 'tp_event_admin_event_metabox_after_fields', [
				$this,
				'add_event_meta_phone_number',
			], 10, 2 );

			add_action( 'tp_event_admin_event_metabox_after_fields', [
				$this,
				'add_event_meta_website',
			], 10, 2 );

			add_filter( 'tp_event_price_format', [ $this, 'add_wrapper_decimals_separator' ], 10, 3 );

			add_filter( 'thimpress_event_l18n', [ $this, 'change_countdown_title' ] );
		}

		public function get_event_type() {
			return self::POST_TYPE;
		}

		public function get_tax_category() {
			return self::TAXONOMY_CATEGORY;
		}

		public function get_tax_tag() {
			return self::TAXONOMY_TAGS;
		}

		public function get_tax_speaker() {
			return self::TAXONOMY_SPEAKER;
		}

		/**
		 * Check The Events Calendar plugin activated.
		 *
		 * @return boolean true if plugin activated
		 */
		public function is_activated() {
			if ( class_exists( 'WPEMS' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Check if current page is category or tag pages
		 */
		public function is_taxonomy() {
			$taxonomies = get_object_taxonomies( self::POST_TYPE );

			return empty( $taxonomies ) ? false : is_tax( $taxonomies );
		}

		/**
		 * Check if current page is archive pages
		 */
		public function is_archive() {
			return $this->is_taxonomy() || is_post_type_archive( self::POST_TYPE );
		}

		public function is_single() {
			return is_singular( self::POST_TYPE );
		}

		public function get_filtering_type_options() {
			return [
				''          => esc_html__( 'All', 'edumall' ),
				'happening' => esc_html__( 'Happening', 'edumall' ),
				'upcoming'  => esc_html__( 'Upcoming', 'edumall' ),
				'expired'   => esc_html__( 'Expired', 'edumall' ),
			];
		}

		public function get_selected_type_option() {
			$type = isset( $_GET['filter_type'] ) ? Edumall_Helper::data_clean( $_GET['filter_type'] ) : '';

			return $type;
		}

		public function add_event_meta_short_location( $post, $prefix ) {
			$post_id    = $post->ID;
			$meta_key   = $prefix . 'short_location';
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			?>
			<div class="option_group">
				<p class="form-field">
					<label for="event_meta_short_location"><?php esc_html_e( 'Short Location', 'edumall' ); ?></label>
					<input type="text" class="short" name="<?php echo esc_attr( $meta_key ); ?>"
					       id="event_meta_short_location"
					       value="<?php echo esc_attr( $meta_value ); ?>">
				</p>
			</div>
			<?php
		}

		public function add_event_meta_place( $post, $prefix ) {
			$post_id    = $post->ID;
			$meta_key   = $prefix . 'place';
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			?>
			<div class="option_group">
				<p class="form-field">
					<label for="event_meta_place"><?php esc_html_e( 'Place', 'edumall' ); ?></label>
					<input type="text" class="short" name="<?php echo esc_attr( $meta_key ); ?>"
					       id="event_meta_place"
					       value="<?php echo esc_attr( $meta_value ); ?>">
				</p>
			</div>
			<?php
		}

		public function add_event_meta_phone_number( $post, $prefix ) {
			$post_id    = $post->ID;
			$meta_key   = $prefix . 'phone_number';
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			?>
			<div class="option_group">
				<p class="form-field">
					<label for="event_meta_phone_number"><?php esc_html_e( 'Phone Number', 'edumall' ); ?></label>
					<input type="text" class="short" name="<?php echo esc_attr( $meta_key ); ?>"
					       id="event_meta_phone_number"
					       value="<?php echo esc_attr( $meta_value ); ?>">
				</p>
			</div>
			<?php
		}

		public function add_event_meta_website( $post, $prefix ) {
			$post_id    = $post->ID;
			$meta_key   = $prefix . 'website';
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			?>
			<div class="option_group">
				<p class="form-field">
					<label for="event_meta_website"><?php esc_html_e( 'Website', 'edumall' ); ?></label>
					<input type="text" class="short" name="<?php echo esc_attr( $meta_key ); ?>"
					       id="event_meta_website"
					       value="<?php echo esc_attr( $meta_value ); ?>">
				</p>
			</div>
			<?php
		}

		public function add_wrapper_decimals_separator( $price_format, $price, $with_currency ) {
			$price_decimals_separator = wpems_get_option( 'currency_separator', ',' );

			if ( ! empty( $price_decimals_separator ) ) {
				$price_format = str_replace( $price_decimals_separator, '<span class="decimals-separator">' . $price_decimals_separator, $price_format );
				$price_format .= '</span>';
			}

			return $price_format;
		}

		public function change_countdown_title( $js_vars ) {
			$js_vars['l18n']['labels'] = [
				esc_html__( 'Years', 'edumall' ),
				esc_html__( 'Months', 'edumall' ),
				esc_html__( 'Weeks', 'edumall' ),
				esc_html__( 'Days', 'edumall' ),
				esc_html__( 'Hours', 'edumall' ),
				esc_html__( 'Mins', 'edumall' ),
				esc_html__( 'Secs', 'edumall' ),
			];

			$js_vars['l18n']['labels1'] = [
				esc_html__( 'Year', 'edumall' ),
				esc_html__( 'Month', 'edumall' ),
				esc_html__( 'Week', 'edumall' ),
				esc_html__( 'Day', 'edumall' ),
				esc_html__( 'Hour', 'edumall' ),
				esc_html__( 'Min', 'edumall' ),
				esc_html__( 'Sec', 'edumall' ),
			];

			return $js_vars;
		}

		public function get_the_speakers() {
			$terms = get_the_terms( get_the_ID(), self::TAXONOMY_SPEAKER );

			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				return false;
			}

			return $terms;
		}

		/**
		 * Get first category of current course.
		 */
		public function event_loop_category() {
			$terms = get_the_terms( get_the_ID(), $this->get_tax_category() );

			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				return;
			}
			?>
			<div class="event-category">
				<?php
				foreach ( $terms as $category ) {
					$category_name = $category->name;
					$category_link = get_term_link( $category->term_id );
					echo "<a href='$category_link'>$category_name</a>";

					break;
				}
				?>
			</div>
			<?php
		}
	}

	Edumall_Event::instance()->initialize();
}
