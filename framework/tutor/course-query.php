<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Course_Query' ) ) {
	class Edumall_Course_Query {

		protected static $instance = null;

		/**
		 * Reference to the main course query on the page.
		 *
		 * @var array
		 */
		private static $course_query;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'pre_get_posts', [ $this, 'course_filtering' ], 999 );
		}

		/**
		 * @param WP_Query $query
		 */
		public function course_filtering( $query ) {
			if ( ! $query->is_main_query() || ! Edumall_Tutor::instance()->is_course_listing() || is_admin() ) {
				return;
			}

			// Fix Events Manager plugin add some owner post status.
			$query->set( 'post_status', 'publish' );

			$layout_preset = isset( $_GET['course_archive_preset'] ) ? Edumall_Helper::data_clean( $_GET['course_archive_preset'] ) : false;

			// Numbers per page.
			$numbers = Edumall::setting( 'course_archive_number_item', 16 );

			// Hard set post per page. because override preset settings run after init hook.
			if ( ! empty( $layout_preset ) ) {
				switch ( $layout_preset ) {
					case '01':
						$numbers = 16;
						break;
					case '02':
						$numbers = 20;
						break;
					case '03':
						$numbers = 15;
						break;
					case '04':
						$numbers = 12;
						break;
					case '05':
					case '06':
						$numbers = 8;
						break;
				}
			}

			// Work out how many products to query.
			$query->set( 'posts_per_page', apply_filters( 'edumall_loop_course_per_page', $numbers ) );

			$search_term = isset( $_GET['filter_name'] ) ? Edumall_Helper::data_clean( $_GET['filter_name'] ) : '';
			if ( ! empty( $search_term ) ) {
				$query->set( 'post_title_like', $search_term );
			}

			// Query vars that affect posts shown.
			$query->set( 'meta_query', $this->get_meta_query( $query->get( 'meta_query' ), true ) );
			$query->set( 'tax_query', $this->get_tax_query( $query->get( 'tax_query' ), true ) );

			// Filter by instructor.
			if ( isset( $_GET['instructor'] ) ) {
				$selected_instructors = array_map( 'absint', explode( ',', $_GET['instructor'] ) );

				if ( ! empty( $selected_instructors ) ) {
					$query->set( 'author__in', $selected_instructors );
				}
			}

			// Order by.
			$orderby = isset( $_GET['orderby'] ) ? Edumall_Helper::data_clean( $_GET['orderby'] ) : Edumall_Tutor::instance()->get_course_default_sort_option();

			switch ( $orderby ) {
				case 'newest_first':
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'desc' );
					break;
				case 'oldest_first':
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'asc' );
					break;
				case 'course_title_az':
					$query->set( 'orderby', 'post_title' );
					$query->set( 'order', 'asc' );
					break;
				case 'course_title_za':
					$query->set( 'orderby', 'post_title' );
					$query->set( 'order', 'desc' );
					break;
				default:
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'desc' );
					break;
			}

			self::$course_query = $query;

			do_action( 'edumall_course_query', $query, $this );
		}

		/**
		 * Get the main query which product queries ran against.
		 *
		 * @return array
		 */
		public static function get_main_query() {
			return self::$course_query;
		}

		/**
		 * Appends meta queries to an array.
		 *
		 * @param  array $meta_query Meta query.
		 * @param  bool  $main_query If is main query.
		 *
		 * @return array
		 */
		public function get_meta_query( $meta_query = array(), $main_query = false ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			// Filter by difficulty level.
			if ( isset( $_GET['level'] ) ) {
				$selected_levels = explode( ',', Edumall_Helper::data_clean( $_GET['level'] ) );

				if ( ! empty( $selected_levels ) && ! in_array( 'all_levels', $selected_levels ) ) {
					$meta_query[] = array(
						'key'     => '_tutor_course_level',
						'value'   => $selected_levels,
						'compare' => 'IN',
					);
				}
			}

			// Filter by price type.
			if ( isset( $_GET['price_type'] ) ) {
				$price_type = Edumall_Helper::data_clean( $_GET['price_type'] );

				$meta_query = self::set_meta_query_price( $meta_query, $price_type );
			}

			// Filter by duration.
			if ( isset( $_GET['duration'] ) ) {
				$durations = explode( ',', Edumall_Helper::data_clean( $_GET['duration'] ) );

				$meta_query = self::set_meta_query_duration( $meta_query, $durations );
			}

			return apply_filters( 'edumall_course_query_meta_query', $meta_query, $this );
		}

		/**
		 * Appends tax queries to an array.
		 *
		 * @param  array $tax_query  Tax query.
		 * @param  bool  $main_query If is main query.
		 *
		 * @return array
		 */
		public function get_tax_query( $tax_query = array(), $main_query = false ) {
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array(
					'relation' => 'AND',
				);
			}

			$category_taxonomy = Edumall_Tutor::instance()->get_tax_category();
			if ( taxonomy_exists( $category_taxonomy ) && isset( $_GET[ 'filter_' . $category_taxonomy ] ) ) {
				$selected_cats = explode( ',', Edumall_Helper::data_clean( $_GET[ 'filter_' . $category_taxonomy ] ) );

				$tax_query[] = array(
					'taxonomy' => $category_taxonomy,
					'field'    => 'term_id',
					'terms'    => $selected_cats,
				);
			}

			$language_taxonomy = Edumall_Tutor::instance()->get_tax_language();
			if ( taxonomy_exists( $language_taxonomy ) && isset( $_GET[ 'filter_' . $language_taxonomy ] ) ) {
				$selected_languages = explode( ',', Edumall_Helper::data_clean( $_GET[ 'filter_' . $language_taxonomy ] ) );

				$tax_query[] = array(
					'taxonomy' => $language_taxonomy,
					'field'    => 'term_id',
					'terms'    => $selected_languages,
				);
			}

			$tag_taxonomy = Edumall_Tutor::instance()->get_tax_tag();
			if ( taxonomy_exists( $tag_taxonomy ) && isset( $_GET[ 'filter_' . $tag_taxonomy ] ) ) {
				$selected_tags = explode( ',', Edumall_Helper::data_clean( $_GET[ 'filter_' . $tag_taxonomy ] ) );

				$tax_query[] = array(
					'taxonomy' => $tag_taxonomy,
					'field'    => 'term_id',
					'terms'    => $selected_tags,
				);
			}

			$visibility_taxonomy = Edumall_Tutor::instance()->get_tax_visibility();
			if ( taxonomy_exists( $visibility_taxonomy ) && isset( $_GET['rating_filter'] ) && '' !== $_GET['rating_filter'] ) {
				$selected_ratings = explode( ',', Edumall_Helper::data_clean( $_GET['rating_filter'] ) );
				$selected_ratings = array_map( 'intval', $selected_ratings );

				$terms = Edumall_Tutor::instance()->get_course_visibility_term_ids();

				$term_ids = [];

				foreach ( $selected_ratings as $selected_rating ) {
					$rating_key = 'rated-' . $selected_rating;

					if ( isset( $terms[ $rating_key ] ) ) {
						$term_ids[] = $terms[ $rating_key ];
					}
				}

				if ( ! empty( $term_ids ) ) {
					$tax_query[] = array(
						'taxonomy' => $visibility_taxonomy,
						'field'    => 'term_id',
						'terms'    => $term_ids,
					);
				}
			}

			return $tax_query;
		}

		/**
		 * Get the tax query which was used by the main query.
		 *
		 * @return array
		 */
		public static function get_main_tax_query() {
			$tax_query = isset( self::$course_query->tax_query, self::$course_query->tax_query->queries ) ? self::$course_query->tax_query->queries : array();

			return $tax_query;
		}

		/**
		 * Get the meta query which was used by the main query.
		 *
		 * @return array
		 */
		public static function get_main_meta_query() {
			$args       = self::$course_query->query_vars;
			$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

			return $meta_query;
		}

		public static function get_main_author_query() {
			$args = self::$course_query->query_vars;

			$author_query = ! empty( $args['author__in'] ) ? $args['author__in'] : array();

			return $author_query;
		}

		public static function get_main_author_sql() {
			global $wpdb;

			$author_ids = self::get_main_author_query();
			$sql        = array(
				'where' => '',
			);

			if ( ! empty( $author_ids ) ) {
				$sql['where'] = ' AND ' . $wpdb->posts . '.post_author IN (' . implode( ',', $author_ids ) . ')';
			}

			return $sql;
		}

		public static function get_search_title_query() {
			$args = self::$course_query->query_vars;

			$search_query = ! empty( $args['post_title_like'] ) ? $args['post_title_like'] : '';

			return $search_query;
		}

		public static function get_search_title_sql() {
			global $wpdb;

			$search_term = self::get_search_title_query();
			$sql         = array(
				'where' => '',
			);

			if ( ! empty( $search_term ) ) {
				$sql['where'] = ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
			}

			return $sql;
		}

		/**
		 * Helper function to get sql string where by author.
		 *
		 * @param  array $ids
		 *
		 * @return array SQL where by author.
		 */
		public static function get_author_sql( $ids ) {
			global $wpdb;

			$sql = array(
				'where' => '',
			);

			if ( ! empty( $ids ) ) {
				$sql['where'] = ' AND ' . $wpdb->posts . '.post_author IN (' . implode( ',', $ids ) . ')';
			}

			return $sql;
		}

		/**
		 * @param array $meta_query
		 * @param       $price_type
		 *
		 * @return array
		 */
		public static function set_meta_query_price( array $meta_query, $price_type ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			switch ( $price_type ) {
				case 'free':
					$meta_query[] = array(
						'key'     => '_tutor_course_product_id',
						'compare' => 'NOT EXISTS',
					);

					break;

				case 'paid':
					$meta_query[] = array(
						'key'     => '_tutor_course_product_id',
						'compare' => 'EXISTS',
					);

					break;
			}

			return $meta_query;
		}

		public static function set_meta_query_duration( array $meta_query, $durations ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			$meta_key = '_course_duration_in_seconds';

			$duration_meta_query = [];

			foreach ( $durations as $duration ) {
				switch ( $duration ) {
					case 'short':
						$end_time = self::get_time_seconds( 2 );

						$duration_meta_query[] = array(
							'key'     => $meta_key,
							'value'   => array( 0, $end_time ),
							'compare' => 'BETWEEN',
							'type'    => 'NUMERIC',
						);
						break;

					case 'medium':
						$start_time = self::get_time_seconds( 2 ) + 1;
						$end_time   = self::get_time_seconds( 7 ) - 1;

						$duration_meta_query[] = array(
							'key'     => $meta_key,
							'value'   => array( $start_time, $end_time ),
							'compare' => 'BETWEEN',
							'type'    => 'NUMERIC',
						);
						break;

					case 'long':
						$start_time = self::get_time_seconds( 7 );
						$end_time   = self::get_time_seconds( 17 ) - 1;

						$duration_meta_query[] = array(
							'key'     => $meta_key,
							'value'   => array( $start_time, $end_time ),
							'compare' => 'BETWEEN',
							'type'    => 'NUMERIC',
						);
						break;

					case 'extraLong':
						$start_time = self::get_time_seconds( 17 );

						$duration_meta_query[] = array(
							'key'     => $meta_key,
							'value'   => $start_time,
							'compare' => '>=',
							'type'    => 'NUMERIC',
						);
						break;
				}
			}

			if ( ! empty ( $duration_meta_query ) ) {
				$duration_meta_query['relation'] = 'OR';

				// set key name for easy to remove.
				$meta_query['_course_duration_in_seconds'] = $duration_meta_query;
			}

			return $meta_query;
		}

		/**
		 * @param $time_value
		 * @param $time_type
		 *
		 * @return float|int
		 */
		public static function get_time_seconds( $time_value, $time_type = 'h' ) {
			$time = 0;

			switch ( $time_type ) {
				case 'y':
					$time = $time_value * YEAR_IN_SECONDS;
					break;

				case 'M':
					$time = $time_value * MONTH_IN_SECONDS;
					break;

				case 'd':
					$time = $time_value * DAY_IN_SECONDS;
					break;

				case 'h':
					$time = $time_value * HOUR_IN_SECONDS;
					break;

				case 'm':
					$time = $time_value * MINUTE_IN_SECONDS;
					break;
			}

			return $time;
		}
	}
}
