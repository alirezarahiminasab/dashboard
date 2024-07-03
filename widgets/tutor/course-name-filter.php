<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_Course_Name_Filter' ) ) {
	class Edumall_WP_Widget_Course_Name_Filter extends Edumall_Course_Layered_Nav_Base {

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-course-name-filter';
			$this->widget_cssclass    = 'edumall-wp-widget-course-name-filter';
			$this->widget_name        = esc_html__( '[Edumall] Course Name Filter', 'edumall' );
			$this->widget_description = esc_html__( 'Show form to narrow courses by course name.', 'edumall' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Search', 'edumall' ),
					'label' => esc_html__( 'Title', 'edumall' ),
				),
			);

			parent::__construct();

			wp_register_script( 'edumall-course-search-form', EDUMALL_THEME_ASSETS_URI . '/js/tutor/course-search-form.js', [ 'jquery' ], EDUMALL_THEME_VERSION, true );

			if ( is_customize_preview() ) {
				wp_enqueue_script( 'edumall-course-search-form' );
			}
		}

		public function widget( $args, $instance ) {
			global $wp_the_query;

			if ( ! $wp_the_query->post_count ) {
				return;
			}

			if ( ! Edumall_Tutor::instance()->is_course_listing() && ! Edumall_Tutor::instance()->is_taxonomy() ) {
				return;
			}

			wp_enqueue_script( 'edumall-course-search-form' );

			$this->widget_start( $args, $instance );

			$this->search_form( $instance );

			$this->widget_end( $args );
		}

		protected function search_form( $instance ) {
			$filter_by_key = 'filter_name';
			$base_link     = Edumall_Tutor::instance()->get_course_listing_page_url();
			$base_link     = remove_query_arg( $filter_by_key, $base_link );

			$current_value = isset( $_GET[ $filter_by_key ] ) ? Edumall_Helper::data_clean( $_GET[ $filter_by_key ] ) : '';
			?>
			<form role="search" method="get" class="search-form"
			      action="<?php echo esc_url( $base_link ); ?>">
				<label class="screen-reader-text"
				       for="course-search-field"><?php esc_html_e( 'Search for:', 'edumall' ); ?></label>
				<input type="search"
				       id="course-search-field"
				       class="search-field"
				       placeholder="<?php echo esc_attr_x( 'Find your course', 'placeholder', 'edumall' ); ?>"
				       value="<?php echo esc_attr( $current_value ); ?>"
				       name="<?php echo esc_attr( $filter_by_key ); ?>"/>
				<button type="submit" class="search-submit">
					<span class="search-btn-icon fa-regular fa-search"></span>
					<span class="search-btn-text">
						<?php echo esc_html_x( 'Search', 'submit button', 'edumall' ); ?>
					</span>
				</button>
			</form>
			<?php
		}
	}
}

