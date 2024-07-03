<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Tutor_Sidebar' ) ) {
	class Edumall_Tutor_Sidebar {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Register widget areas.
			add_action( 'widgets_init', [ $this, 'register_sidebars' ] );

			// Different style for sidebar.
			add_filter( 'edumall_page_sidebar_class', [ $this, 'sidebar_class' ] );

			// Add inner sidebar in main sidebar.
			add_action( 'edumall_page_sidebar_after_content', [ $this, 'add_sidebar_filter' ], 10, 2 );

			// Custom sidebar width.
			add_filter( 'edumall_one_sidebar_width', [ $this, 'one_sidebar_width' ] );

			// Custom sidebar offset.
			add_filter( 'edumall_one_sidebar_offset', [ $this, 'one_sidebar_offset' ] );
		}

		public function register_sidebars() {
			$default_args = Edumall_Sidebar::instance()->get_default_sidebar_args();

			register_sidebar( array_merge( $default_args, [
				'id'          => 'course_top_filters',
				'name'        => esc_html__( 'Course Top Filters', 'edumall' ),
				'description' => esc_html__( 'This sidebar displays above course list on course listing page.', 'edumall' ),
			] ) );

			register_sidebar( array_merge( $default_args, [
				'id'          => 'course_sidebar_filters',
				'name'        => esc_html__( 'Course Sidebar Filters', 'edumall' ),
				'description' => esc_html__( 'This sidebar displays below Sidebar 1 on course listing page.', 'edumall' ),
			] ) );

			register_sidebar( array_merge( $default_args, [
				'id'          => 'course_sidebar',
				'name'        => esc_html__( 'Course Listing Sidebar', 'edumall' ),
				'description' => esc_html__( 'Add widgets displays on course listing pages.', 'edumall' ),
			] ) );

			register_sidebar( array_merge( $default_args, [
				'id'          => 'course_single_sidebar',
				'name'        => esc_html__( 'Single Course Sidebar', 'edumall' ),
				'description' => esc_html__( 'Add widgets displays on single course pages.', 'edumall' ),
			] ) );
		}

		public function sidebar_class( $class ) {
			if ( Edumall_Tutor::instance()->is_course_listing() ) {
				$sidebar_style = Edumall::setting( 'course_archive_page_sidebar_style' );

				if ( ! empty( $sidebar_style ) ) {
					$class[] = 'style-' . $sidebar_style;
				}
			}

			return $class;
		}

		public function add_sidebar_filter( $name, $is_first_sidebar ) {
			if ( ! $is_first_sidebar || ! Edumall_Tutor::instance()->is_course_listing() ) {
				return;
			}
			?>
			<div class="archive-sidebar-filter">
				<p class="archive-sidebar-filter-heading heading"><?php esc_html_e( 'Filter by', 'edumall' ); ?></p>
				<?php Edumall_Sidebar::instance()->generated_sidebar( 'course_sidebar_filters' ); ?>
			</div>
			<?php
		}

		public function one_sidebar_width( $width ) {
			if ( Edumall_Tutor::instance()->is_course_listing() ) {
				$new_width = Edumall::setting( 'course_archive_single_sidebar_width' );
			} elseif ( Edumall_Tutor::instance()->is_single_course() ) {
				$new_width = Edumall::setting( 'course_page_single_sidebar_width' );
			}

			// Use isset instead of empty avoid skip value 0.
			if ( isset( $new_width ) && '' !== $new_width ) {
				return $new_width;
			}

			return $width;
		}

		public function one_sidebar_offset( $offset ) {
			if ( Edumall_Tutor::instance()->is_course_listing() ) {
				$new_offset = Edumall::setting( 'course_archive_single_sidebar_offset' );
			} elseif ( Edumall_Tutor::instance()->is_single_course() ) {
				$new_offset = Edumall::setting( 'course_page_single_sidebar_offset' );
			}

			// Use isset instead of empty avoid skip value 0.
			if ( isset( $new_offset ) && '' !== $new_offset ) {
				return $new_offset;
			}

			return $offset;
		}
	}
}
