<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Archive_Course' ) ) {
	class Edumall_Archive_Course {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'body_class', [ $this, 'body_class' ] );

			add_filter( 'post_class', [ $this, 'course_post_class' ], 10, 3 );

			add_action( 'tutor_course/loop/excerpt', [ $this, 'excerpt' ], 10 );

			add_filter( 'edumall_title_bar_heading_text', [ $this, 'archive_title_bar_heading' ] );

			add_filter( 'edumall_title_bar_type', [ $this, 'category_title_bar_type' ] );
			add_filter( 'edumall_title_bar_heading_text', [ $this, 'category_title_bar_heading' ], 20, 1 );

			add_action( 'edumall_before_main_content', [ $this, 'add_course_tabs' ], 20 );
			add_action( 'edumall_before_main_content', [ $this, 'add_featured_courses' ], 20 );
			add_action( 'edumall_before_main_content', [ $this, 'add_popular_topics' ], 30 );
			add_action( 'edumall_before_main_content', [ $this, 'add_popular_instructors' ], 40 );

			add_filter( 'edumall_category_course_tabs', [ $this, 'add_default_course_tabs' ] );
			add_filter( 'edumall_category_course_tabs', [ $this, 'sort_course_tabs' ], 999 );

			add_filter( 'edumall_sidebar_1', [ $this, 'disable_sidebar_no_results' ] );

			// Course tag template.
			add_filter( 'template_include', [ $this, 'load_course_archive_template' ], 99 );

			add_action( 'tutor_course/archive/before_loop', [ $this, 'render_filter_bar' ] );
		}

		public function render_filter_bar() {
			ob_start();
			tutor_load_template( 'global.course-archive-filter-bar' );
			$output = apply_filters( 'tutor_course_archive_filter_bar', ob_get_clean() );

			echo $output;
		}

		public function body_class( $classes ) {
			if ( Edumall_Tutor::instance()->is_archive() ) {
				global $wp_query;

				if ( $wp_query->post_count > 0 ) {
					$layout = Edumall_Tutor::instance()->get_course_archive_style();

					$classes[] = 'archive-course-style-' . $layout;
				} else {
					$classes[] = 'archive-course-style-grid-02 archive-course-no-results';
				}
			}

			return $classes;
		}

		public function excerpt() {
			tutor_load_template( 'loop.custom.excerpt' );
		}

		public function archive_title_bar_heading( $text ) {
			if ( Edumall_Tutor::instance()->is_course_listing() ) {
				$text = esc_html__( 'Courses', 'edumall' );
			}

			return $text;
		}

		public function category_title_bar_type( $type ) {
			if ( Edumall_Tutor::instance()->is_taxonomy() ) {
				return '02';
			}

			return $type;
		}

		public function category_title_bar_heading( $text ) {
			if ( Edumall_Tutor::instance()->is_taxonomy() ) {
				$queried_object = get_queried_object();

				$text = sprintf( esc_html__( '%s Courses', 'edumall' ), $queried_object->name );
			}

			return $text;
		}

		public function course_post_class( $classes, $class = '', $post_id = 0 ) {
			if ( ! $post_id || ! in_array( get_post_type( $post_id ), array( 'courses' ), true ) ) {
				return $classes;
			}

			global $edumall_course;

			if ( is_a( $edumall_course, 'Edumall_Course' ) ) {

				$price_type = $edumall_course->get_price_type();

				$classes[] = 'course-' . $price_type;

				if ( $edumall_course->is_purchasable() ) {
					$classes[] = 'course-purchasable';

					if ( $edumall_course->is_on_sale() ) {
						$classes[] = 'on-sale';
					}
				}
			}

			return $classes;
		}

		/**
		 * Add course tabs section for category page.
		 */
		public function add_course_tabs() {
			if ( ! Edumall_Tutor::instance()->is_category() || '1' !== Edumall::setting( 'course_category_course_tabs' ) ) {
				return;
			}

			tutor_load_template( 'category.course-tabs' );
		}

		/**
		 * Add featured courses section for category page.
		 */
		public function add_featured_courses() {
			if ( ! Edumall_Tutor::instance()->is_category() || '1' !== Edumall::setting( 'course_category_featured_courses' ) ) {
				return;
			}

			tutor_load_template( 'category.featured-courses' );
		}

		/**
		 * Add popular topics section for category page.
		 */
		public function add_popular_topics() {
			if ( ! Edumall_Tutor::instance()->is_category() || '1' !== Edumall::setting( 'course_category_popular_topics' ) ) {
				return;
			}

			tutor_load_template( 'category.popular-topics' );
		}

		/**
		 * Add popular instructors section for category page.
		 */
		public function add_popular_instructors() {
			if ( ! Edumall_Tutor::instance()->is_category() || '1' !== Edumall::setting( 'course_category_popular_instructors' ) ) {
				return;
			}

			tutor_load_template( 'category.popular-instructors' );
		}

		public function add_default_course_tabs( $tabs ) {
			$tabs [] = [
				'title'    => sprintf( esc_html__( 'Most %spopular%s', 'edumall' ), '<mark>', '</mark>' ),
				'priority' => 10,
				'callback' => [ $this, 'add_popular_course_tab' ],
			];

			$tabs [] = [
				'title'    => esc_html__( 'Trending', 'edumall' ),
				'priority' => 20,
				'callback' => [ $this, 'add_trending_course_tab' ],
			];

			return $tabs;
		}

		public function add_popular_course_tab() {
			if ( ! Edumall_Tutor::instance()->is_category() ) {
				return;
			}

			tutor_load_template( 'category.tabs.popular-course' );
		}

		public function add_trending_course_tab() {
			if ( ! Edumall_Tutor::instance()->is_category() ) {
				return;
			}

			tutor_load_template( 'category.tabs.trending-course' );
		}

		public function sort_course_tabs( $tabs = array() ) {
			// Make sure the $tabs parameter is an array.
			if ( ! is_array( $tabs ) ) {
				$tabs = array();
			}

			// Re-order tabs by priority.
			if ( ! function_exists( '_sort_priority_callback' ) ) {
				/**
				 * Sort Priority Callback Function
				 *
				 * @param array $a Comparison A.
				 * @param array $b Comparison B.
				 *
				 * @return bool
				 */
				function _sort_priority_callback( $a, $b ) {
					if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
						return 0;
					}

					return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
				}
			}

			uasort( $tabs, '_sort_priority_callback' );

			return $tabs;
		}

		public function disable_sidebar_no_results( $sidebar ) {
			global $wp_query;
			if ( Edumall_Tutor::instance()->is_archive() && is_main_query() && $wp_query->post_count <= 0 ) {
				return 'none';
			}

			return $sidebar;
		}

		/**
		 * Load archive template for Course Language & Tag
		 *
		 * @param $template
		 *
		 * @return mixed
		 */
		public function load_course_archive_template( $template ) {
			global $wp_query;

			$post_type       = get_query_var( 'post_type' );
			$course_tag      = get_query_var( 'course-tag' );
			$course_language = get_query_var( 'course-language' );

			if ( ( $post_type === Edumall_Tutor::instance()->get_course_type() || ( ! empty( $course_tag ) || ! empty( $course_language ) ) ) && $wp_query->is_archive ) {
				$template = tutor_get_template( 'archive-course' );
			}

			return $template;
		}
	}
}
