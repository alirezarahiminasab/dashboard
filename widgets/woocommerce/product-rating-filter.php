<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_Product_Rating_Filter' ) ) {
	class Edumall_WP_Widget_Product_Rating_Filter extends Edumall_WC_Widget_Base {

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-product-rating-filter';
			$this->widget_cssclass    = 'edumall-wp-widget-product-rating-filter';
			$this->widget_name        = esc_html__( '[Edumall] Filter Products by Rating', 'edumall' );
			$this->widget_description = esc_html__( 'Display a list of star ratings to filter products in your store.', 'edumall' );

			$this->settings = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Average rating', 'edumall' ),
					'label' => esc_html__( 'Title', 'edumall' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Count products after other filters have occurred by adjusting the main query.
		 *
		 * @param  int $rating Rating.
		 *
		 * @return int
		 */
		protected function get_filtered_product_count( $rating ) {
			global $wpdb;

			$tax_query  = WC_Query::get_main_tax_query();
			$meta_query = WC_Query::get_main_meta_query();

			// Unset current rating filter.
			foreach ( $tax_query as $key => $query ) {
				if ( ! empty( $query['rating_filter'] ) ) {
					unset( $tax_query[ $key ] );
					break;
				}
			}

			// Set new rating filter.
			$product_visibility_terms = wc_get_product_visibility_term_ids();
			$tax_query[]              = array(
				'taxonomy'      => 'product_visibility',
				'field'         => 'term_taxonomy_id',
				'terms'         => $product_visibility_terms[ 'rated-' . $rating ],
				'operator'      => 'IN',
				'rating_filter' => true,
			);

			$meta_query     = new WP_Meta_Query( $meta_query );
			$tax_query      = new WP_Tax_Query( $tax_query );
			$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

			$sql = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) FROM {$wpdb->posts} ";
			$sql .= $tax_query_sql['join'] . $meta_query_sql['join'];
			$sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' ";
			$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

			$search = WC_Query::get_main_search_query_sql();
			if ( $search ) {
				$sql .= ' AND ' . $search;
			}

			return absint( $wpdb->get_var( $sql ) ); // WPCS: unprepared SQL ok.
		}

		/**
		 * Widget function.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args     Arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			if ( ! is_shop() && ! is_product_taxonomy() ) {
				return;
			}

			if ( ! WC()->query->get_main_query()->post_count ) {
				return;
			}

			ob_start();

			$found         = false;
			$rating_filter = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // WPCS: input var ok, CSRF ok, sanitization ok.
			$base_link     = remove_query_arg( 'paged', $this->get_current_page_url() );

			$this->widget_start( $args, $instance );

			echo '<ul>';

			for ( $rating = 5; $rating >= 1; $rating-- ) {
				$count = $this->get_filtered_product_count( $rating );

				$found = true;
				$link  = $base_link;

				if ( in_array( $rating, $rating_filter, true ) ) {
					$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
				} else {
					$link_ratings = implode( ',', array_merge( $rating_filter, array( $rating ) ) );
				}

				$class       = in_array( $rating, $rating_filter, true ) ? 'wc-layered-nav-rating chosen' : 'wc-layered-nav-rating';
				$link        = apply_filters( 'woocommerce_rating_filter_link', $link_ratings ? add_query_arg( 'rating_filter', $link_ratings, $link ) : remove_query_arg( 'rating_filter' ) );
				$link        = add_query_arg( 'filtering', '1', $link );
				$rating_html = Edumall_Templates::render_rating( $rating, [
					'style'         => '02',
					'echo'          => false,
					'wrapper_class' => 'star-rating',
				] );
				$count_html  = wp_kses(
					apply_filters( 'woocommerce_rating_filter_count', "({$count})", $count, $rating ),
					array(
						'em'     => array(),
						'span'   => array(),
						'strong' => array(),
					)
				);

				printf( '<li class="%s"><a href="%s"><span class="star-rating">%s</span> %s</a></li>', esc_attr( $class ), esc_url( $link ), $rating_html, '<span class="count">' . $count_html . '</span>' ); // WPCS: XSS ok.
			}

			echo '</ul>';

			$this->widget_end( $args );

			if ( ! $found ) {
				ob_end_clean();
			} else {
				echo ob_get_clean(); // WPCS: XSS ok.
			}
		}
	}
}
