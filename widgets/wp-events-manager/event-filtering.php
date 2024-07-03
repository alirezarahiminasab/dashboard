<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_Event_Filtering' ) ) {
	class Edumall_WP_Widget_Event_Filtering extends Edumall_WP_Widget_Base {

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-event-filtering';
			$this->widget_cssclass    = 'edumall-wp-widget-event-filtering';
			$this->widget_name        = esc_html__( '[Edumall] Event Filtering', 'edumall' );
			$this->widget_description = esc_html__( 'Display a form to filter events with some criteria.', 'edumall' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Find events', 'edumall' ),
					'label' => esc_html__( 'Title', 'edumall' ),
				),
			);

			parent::__construct();

			$min = Edumall_Enqueue::instance()->get_min_suffix();

			wp_register_script( 'edumall-event-filtering', EDUMALL_THEME_ASSETS_URI . "/js/events-manager/event-filtering{$min}.js", [ 'jquery-ui-datepicker' ], EDUMALL_THEME_VERSION, true );

			if ( is_customize_preview() ) {
				wp_enqueue_script( 'edumall-event-filtering' );
			}
		}

		public function widget( $args, $instance ) {
			global $wp;

			if ( ! Edumall_Event::instance()->is_archive() ) {
				return;
			}

			wp_enqueue_script( 'edumall-event-filtering' );

			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array(
					'page',
					'paged',
					'product-page',
				), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
			}

			$current_start_date = isset( $_GET['filter_start_date'] ) ? Edumall_Helper::data_clean( $_GET['filter_start_date'] ) : ''; // WPCS: input var ok, CSRF ok.
			$current_category   = isset( $_GET['filter_category'] ) ? Edumall_Helper::data_clean( $_GET['filter_category'] ) : ''; // WPCS: input var ok, CSRF ok.
			$current_location   = isset( $_GET['filter_location'] ) ? Edumall_Helper::data_clean( $_GET['filter_location'] ) : ''; // WPCS: input var ok, CSRF ok.
			$current_name       = isset( $_GET['filter_name'] ) ? Edumall_Helper::data_clean( $_GET['filter_name'] ) : ''; // WPCS: input var ok, CSRF ok.

			// Filter by type on archive bar.
			$current_type = isset( $_GET['filter_type'] ) ? Edumall_Helper::data_clean( $_GET['filter_type'] ) : ''; // WPCS: input var ok, CSRF ok.
			// Customize layout preset.
			$theme_preset = isset( $_GET['event_archive_preset'] ) ? Edumall_Helper::data_clean( $_GET['event_archive_preset'] ) : ''; // WPCS: input var ok, CSRF ok.

			$current_category = intval( $current_category );

			$category_dropdown_args = array(
				'taxonomy'        => Edumall_Event::instance()->get_tax_category(),
				'orderby'         => 'name',
				'show_count'      => 0,
				'hierarchical'    => 1,
				'show_option_all' => esc_html__( 'All categories', 'edumall' ),
				'selected'        => $current_category,
				'name'            => 'filter_category',
			);

			$this->widget_start( $args, $instance );
			?>
			<form method="get" action="<?php echo esc_url( $form_action ); ?>" class="event-filtering-form">
				<div class="form-group">
					<input type="text" id="filter_start_date"
					       class="form-input-date readonly"
					       autocomplete="off"
					       readonly
					       placeholder="<?php echo esc_attr_x( 'Event from', 'placeholder', 'edumall' ); ?>"
					       value="<?php echo esc_attr( $current_start_date ); ?>" name="filter_start_date"/>
					<span class="form-icon">
						<i class="fa-regular fa-calendar"></i>
					</span>
				</div>

				<div class="form-group">
					<?php wp_dropdown_categories( $category_dropdown_args ); ?>
				</div>

				<div class="form-group">
					<input type="text" id="filter_location"
					       class="search-field"
					       placeholder="<?php echo esc_attr_x( 'Location', 'placeholder', 'edumall' ); ?>"
					       value="<?php echo esc_attr( $current_location ); ?>" name="filter_location"/>
					<span class="form-icon">
						<i class="fa-regular fa-map-marker-alt"></i>
					</span>
				</div>

				<div class="form-group">
					<input type="search"
					       class="search-field"
					       placeholder="<?php echo esc_attr_x( 'Keyword&hellip;', 'placeholder', 'edumall' ); ?>"
					       value="<?php echo esc_attr( $current_name ); ?>" name="filter_name"/>
					<span class="form-icon">
						<i class="fa-regular fa-search"></i>
					</span>
				</div>

				<div class="form-submit">
					<input type="hidden" value="<?php echo esc_attr( $theme_preset ); ?>"
					       name="event_archive_preset">
					<input type="hidden" value="<?php echo esc_attr( $current_type ); ?>"
					       name="filter_type">
					<button type="submit" class="search-submit">
						<span class="search-btn-text">
							<?php echo esc_html_x( 'Find events', 'submit button', 'edumall' ); ?>
						</span>
					</button>
				</div>
			</form>
			<?php
			$this->widget_end( $args );
		}
	}
}
