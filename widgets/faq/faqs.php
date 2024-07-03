<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_FAQs' ) ) {
	class Edumall_WP_Widget_FAQs extends Edumall_WP_Widget_Base {

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-faqs';
			$this->widget_cssclass    = 'edumall-wp-widget-faqs';
			$this->widget_name        = esc_html__( '[Edumall] FAQs', 'edumall' );
			$this->widget_description = esc_html__( 'Get list faq post.', 'edumall' );
			$this->settings           = array(
				'title'      => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'edumall' ),
				),
				'filter_by'  => array(
					'type'    => 'select',
					'std'     => 'recent',
					'label'   => esc_html__( 'Filter By', 'edumall' ),
					'options' => [],
				),
				'show_group' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show Group', 'edumall' ),
				),
				'show_date'  => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show Date', 'edumall' ),
				),
				'num'        => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => 40,
					'std'   => 5,
					'label' => esc_html__( 'Number', 'edumall' ),
				),
			);

			parent::__construct();
		}

		public function set_form_settings() {
			$filter_by_options = array(
				'recent'  => esc_html__( 'Recent FAQs', 'edumall' ),
				'related' => esc_html__( 'Related FAQs', 'edumall' ),
			);
			$terms             = get_terms( [
				'taxonomy'   => Edumall_FAQ::instance()->get_tax_group(),
				'parent'     => 0,
				'hide_empty' => false,
			] );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$filter_by_options[ $term->term_id ] = sprintf( __( 'Group: %s', 'edumall' ), $term->name ); // XSS OK.
				}
			}

			$this->settings['filter_by']['options'] = $filter_by_options;
		}

		public function widget( $args, $instance ) {
			$filter_by  = $this->get_value( $instance, 'filter_by' );
			$num        = $this->get_value( $instance, 'num' );
			$show_group = $this->get_value( $instance, 'show_group' );
			$show_date  = $this->get_value( $instance, 'show_date' );

			if ( 'related' === $filter_by && ! Edumall_FAQ::instance()->is_single() ) {
				return;
			}

			$query_args = [
				'post_type'           => Edumall_FAQ::instance()->get_post_type(),
				'posts_per_page'      => $num,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
			];

			if ( 'recent' === $filter_by ) {
				$query_args = wp_parse_args( $query_args, [
					'orderby' => 'date',
					'order'   => 'DESC',
				] );
			} elseif ( 'related' === $filter_by ) {
				$current_post = get_the_ID();

				$group_tax = Edumall_FAQ::instance()->get_tax_group();

				$related_by = [ $group_tax ];

				$query_args['tax_query'] = [];

				foreach ( $related_by as $tax ) {
					$terms = get_the_terms( $current_post, $tax );
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
					'post__not_in' => [ $current_post ],
				] );
			} else {
				$group_tax = Edumall_FAQ::instance()->get_tax_group();

				$query_args = wp_parse_args( $query_args, [
					'tax_query' => array(
						array(
							'taxonomy' => $group_tax,
							'field'    => 'id',
							'terms'    => $filter_by,
						),
					),
				] );
			}

			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				$this->widget_start( $args, $instance );
				?>
				<ul class="edumall-faqs-list">
					<?php while ( $query->have_posts() ) :$query->the_post(); ?>
						<?php
						$classes = array( 'faq-item' );
						?>
						<li <?php post_class( implode( ' ', $classes ) ); ?> >
							<?php if ( $show_group ) : ?>
								<?php Edumall_FAQ::instance()->the_group(); ?>
							<?php endif; ?>
							<h5 class="post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h5>
							<?php if ( $show_date ) : ?>
								<span class="post-date style-1"><?php echo get_the_date(); ?></span>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</ul>
				<?php
				$this->widget_end( $args );
			}
		}
	}
}
