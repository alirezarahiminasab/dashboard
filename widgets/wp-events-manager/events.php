<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_Events' ) ) {
	class Edumall_WP_Widget_Events extends Edumall_WP_Widget_Base {

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-events';
			$this->widget_cssclass    = 'edumall-wp-widget-events';
			$this->widget_name        = esc_html__( '[Edumall] Events', 'edumall' );
			$this->widget_description = esc_html__( 'Get list events.', 'edumall' );
			$this->settings           = array(
				'title'           => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Recent Events', 'edumall' ),
					'label' => esc_html__( 'Title', 'edumall' ),
				),
				'filter_by'       => array(
					'type'    => 'select',
					'std'     => 'recent',
					'label'   => esc_html__( 'Filter By', 'edumall' ),
					'options' => [],
				),
				'num'             => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => 40,
					'std'   => 5,
					'label' => esc_html__( 'Number', 'edumall' ),
				),
				'show_thumbnail'  => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Show Thumbnail', 'edumall' ),
				),
				'show_price'      => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Show Price', 'edumall' ),
				),
				'show_categories' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show Categories', 'edumall' ),
				),
				'show_date'       => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Show Date', 'edumall' ),
				),
			);

			parent::__construct();
		}

		public function set_form_settings() {
			$filter_by_options = array(
				'recent'  => esc_html__( 'Recent Events', 'edumall' ),
				'related' => esc_html__( 'Related Events', 'edumall' ),
				'popular' => esc_html__( 'Popular Events', 'edumall' ),
			);
			$terms             = get_terms( [
				'taxonomy'   => 'tp_event_category',
				'parent'     => 0,
				'hide_empty' => false,
			] );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$filter_by_options[ $term->term_id ] = esc_html__( 'Category: ', 'edumall' ) . $term->name;
				}
			}

			$this->settings['filter_by']['options'] = $filter_by_options;
		}

		public function widget( $args, $instance ) {
			$filter_by       = $this->get_value( $instance, 'filter_by' );
			$num             = $this->get_value( $instance, 'num' );
			$show_thumbnail  = $this->get_value( $instance, 'show_thumbnail' );
			$show_price      = $this->get_value( $instance, 'show_price' );
			$show_categories = $this->get_value( $instance, 'show_categories' );
			$show_date       = $this->get_value( $instance, 'show_date' );

			if ( 'related' === $filter_by && ! Edumall_Event::instance()->is_single() ) {
				return;
			}

			$query_args = [
				'post_type'      => Edumall_Event::instance()->get_event_type(),
				'posts_per_page' => $num,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
			];

			if ( 'recent' === $filter_by ) {
				$query_args = wp_parse_args( $query_args, [
					'orderby' => 'date',
					'order'   => 'DESC',
				] );
			} elseif ( 'popular' === $filter_by ) {
				$query_args = wp_parse_args( $query_args, [
					'meta_key' => 'views',
					'orderby' => 'meta_value_num',
					'order'   => 'DESC',
				] );
			} elseif ( 'related' === $filter_by ) {
				$current_event = get_the_ID();

				$related_by = [
					Edumall_Event::instance()->get_tax_category(),
					Edumall_Event::instance()->get_tax_tag(),
				];

				$query_args['tax_query'] = [];

				foreach ( $related_by as $tax ) {
					$terms = get_the_terms( $current_event, $tax );
					if ( $terms && ! is_wp_error( $terms ) ) {
						$term_ids = array();
						foreach ( $terms as $term ) {
							$term_ids[] = $term->term_id;
						}
						$query_args['tax_query'][] = array(
							'terms'    => $term_ids,
							'taxonomy' => $tax,
						);
					}
				}
				if ( count( $query_args['tax_query'] ) > 1 ) {
					$query_args['tax_query']['relation'] = 'OR';
				}

				$query_args = wp_parse_args( $query_args, [
					'orderby'      => 'date',
					'order'        => 'DESC',
					'post__not_in' => [ $current_event ],
				] );
			} else {
				$query_args = wp_parse_args( $query_args, [
					'tax_query' => array(
						array(
							'taxonomy' => Edumall_Event::instance()->get_tax_category(),
							'field'    => 'id',
							'terms'    => $filter_by,
						),
					),
				] );
			}

			$query = new WP_Query( $query_args );

			if ( $query->have_posts() ) :
				$this->widget_start( $args, $instance );

				?>
				<div class="edumall-animation-zoom-in">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php
						$event = new WPEMS_Event( get_the_ID() );

						$classes = array( 'event-item edumall-box' );
						?>
						<div <?php post_class( implode( ' ', $classes ) ); ?> >
							<?php if ( $show_thumbnail ) : ?>
								<div class="event-thumbnail edumall-image">
									<a href="<?php the_permalink(); ?>">
										<?php if ( has_post_thumbnail() ) { ?>
											<?php Edumall_Image::the_post_thumbnail( array( 'size' => '100x80' ) ); ?>
											<?php
										} else {
											Edumall_Templates::image_placeholder( 100, 80 );
										}
										?>
									</a>
								</div>
							<?php endif; ?>
							<div class="event-info">
								<?php if ( $show_categories ) : ?>
									<?php Edumall_Event::instance()->event_loop_category(); ?>
								<?php endif; ?>

								<?php if ( $show_price ): ?>
									<div class="event-price price">
										<?php printf( '%s', $event->is_free() ? esc_html__( 'Free', 'edumall' ) : wpems_format_price( $event->get_price() ) ); ?>
									</div>
								<?php endif; ?>

								<h5 class="event-title">
									<a href="<?php the_permalink(); ?>" class="link-in-title"><?php the_title(); ?></a>
								</h5>

								<?php if ( $show_date ) : ?>
									<?php
									$date_start = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
									$date_start = ! empty( $date_start ) ? strtotime( $date_start ) : time();

									$date_end = get_post_meta( get_the_ID(), 'tp_event_date_end', true );
									$date_end = ! empty( $date_end ) ? strtotime( $date_end ) : time();

									if ( $date_start === $date_end ) {
										$date_string = wp_date( get_option( 'date_format' ), $date_start );
									} else {
										$date_string = wp_date( get_option( 'date_format' ), $date_start ) . ' - ' . wp_date( get_option( 'date_format' ), $date_end );
									}
									?>
									<div class="event-date">
										<span><?php echo esc_html( $date_string ); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
				<?php
				$this->widget_end( $args );
			endif;
		}
	}
}
