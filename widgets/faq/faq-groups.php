<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_WP_Widget_FAQ_Group' ) ) {
	class Edumall_WP_Widget_FAQ_Group extends Edumall_WP_Widget_Base {

		/**
		 * Category ancestors.
		 *
		 * @var array
		 */
		public $cat_ancestors;

		/**
		 * Current Category.
		 *
		 * @var bool
		 */
		public $current_cat;

		public function __construct() {
			$this->widget_id          = 'edumall-wp-widget-faq-groups';
			$this->widget_cssclass    = 'edumall-wp-widget-faq-groups';
			$this->widget_name        = esc_html__( '[Edumall] FAQ Groups', 'edumall' );
			$this->widget_description = esc_html__( 'A list or dropdown of FAQ group.', 'edumall' );
			$this->settings           = array(
				'title'              => array(
					'type'  => 'text',
					'std'   => esc_html__( 'FAQ Groups', 'edumall' ),
					'label' => esc_html__( 'Title', 'edumall' ),
				),
				'source'             => array(
					'type'    => 'select',
					'std'     => '',
					'label'   => esc_html__( 'Source', 'edumall' ),
					'options' => array(
						''             => esc_html__( 'All', 'edumall' ),
						'children'     => esc_html__( 'Only show children of the current group', 'edumall' ),
						'top_children' => esc_html__( 'Only show top group\'s children of the current group', 'edumall' ),
					),
				),
				'orderby'            => array(
					'type'    => 'select',
					'std'     => 'name',
					'label'   => esc_html__( 'Order by', 'edumall' ),
					'options' => array(
						'order' => esc_html__( 'Group order', 'edumall' ),
						'name'  => esc_html__( 'Name', 'edumall' ),
					),
				),
				'dropdown'           => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show as dropdown', 'edumall' ),
				),
				'count'              => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show post counts', 'edumall' ),
				),
				'hierarchical'       => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Show hierarchy', 'edumall' ),
				),
				'hide_empty'         => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide empty groups', 'edumall' ),
				),
				'max_depth'          => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Maximum depth', 'edumall' ),
					'desc'  => esc_html__( 'For eg: Input 1 to show only top groups.', 'edumall' ),
				),
				'custom_button_text' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button Text', 'edumall' ),
				),
				'custom_button_link' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button Link', 'edumall' ),
				),
			);

			parent::__construct();
		}

		public function widget( $args, $instance ) {
			global $wp_query, $post;

			$count        = $this->get_value( $instance, 'count' );
			$hierarchical = $this->get_value( $instance, 'hierarchical' );
			$source       = $this->get_value( $instance, 'source' );
			$dropdown     = $this->get_value( $instance, 'dropdown' );
			$orderby      = $this->get_value( $instance, 'orderby' );
			$hide_empty   = $this->get_value( $instance, 'hide_empty' );
			$max_depth    = absint( $this->get_value( $instance, 'max_depth' ) );

			$custom_button_text = $this->get_value( $instance, 'custom_button_text' );
			$custom_button_link = $this->get_value( $instance, 'custom_button_link' );

			$dropdown_args = array(
				'hide_empty' => $hide_empty,
			);
			$tax_name      = Edumall_FAQ::instance()->get_tax_group();

			$list_args = array(
				'show_count'   => $count,
				'hierarchical' => $hierarchical,
				'taxonomy'     => $tax_name,
				'hide_empty'   => $hide_empty,
			);

			$list_args['menu_order'] = false;
			$dropdown_args['depth']  = $max_depth;
			$list_args['depth']      = $max_depth;

			if ( 'order' === $orderby ) {
				$list_args['orderby']      = 'meta_value_num';
				$dropdown_args['orderby']  = 'meta_value_num';
				$list_args['meta_key']     = 'order';
				$dropdown_args['meta_key'] = 'order';
			}

			$this->current_cat   = false;
			$this->cat_ancestors = array();

			if ( is_tax( $tax_name ) ) {
				$this->current_cat   = $wp_query->queried_object;
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, $tax_name );
			} elseif ( Edumall_FAQ::instance()->is_single() ) {
				$terms = wp_get_post_terms( $post->ID, $tax_name, [
					'orderby' => 'parent',
					'order'   => 'DESC',
				] );

				if ( $terms ) {
					$main_term           = apply_filters( 'edumall_faq_groups_widget_main_term', $terms[0], $terms );
					$this->current_cat   = $main_term;
					$this->cat_ancestors = get_ancestors( $main_term->term_id, $tax_name );
				}
			}

			if ( 'top_children' === $source ) {
				if ( $this->cat_ancestors ) {
					$top_ancestor = $this->cat_ancestors[ count( $this->cat_ancestors ) - 1 ];

					$list_args['parent'] = $top_ancestor;
					$list_args['depth']  = 0;

					$this->cat_ancestors = [ $top_ancestor ];
				} else {
					if ( $this->current_cat ) {
						$list_args['parent'] = $this->current_cat->term_id;
					}

					$list_args['depth'] = 0;
				}
			} elseif ( 'children' === $source && $this->current_cat ) { // Show Siblings and Children Only.
				if ( $hierarchical ) {
					$include = array_merge(
						$this->cat_ancestors,
						array( $this->current_cat->term_id ),
						get_terms( [
							'taxonomy'     => $tax_name,
							'fields'       => 'ids',
							'parent'       => 0,
							'hierarchical' => true,
							'hide_empty'   => false,
						] ),
						get_terms( [
							'taxonomy'     => $tax_name,
							'fields'       => 'ids',
							'parent'       => $this->current_cat->term_id,
							'hierarchical' => true,
							'hide_empty'   => false,
						] )
					);
					// Gather siblings of ancestors.
					if ( $this->cat_ancestors ) {
						foreach ( $this->cat_ancestors as $ancestor ) {
							$include = array_merge(
								$include,
								get_terms( [
									'taxonomy'     => $tax_name,
									'fields'       => 'ids',
									'parent'       => $ancestor,
									'hierarchical' => false,
									'hide_empty'   => false,
								] )
							);
						}
					}
				} else {
					// Direct children.
					$include = get_terms( [
						'taxonomy'     => $tax_name,
						'fields'       => 'ids',
						'parent'       => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false,
					] );
				}

				$list_args['include']     = implode( ',', $include );
				$dropdown_args['include'] = $list_args['include'];

				if ( empty( $include ) ) {
					return;
				}
			} elseif ( 'children' === $source ) {
				$dropdown_args['depth']        = 1;
				$dropdown_args['child_of']     = 0;
				$dropdown_args['hierarchical'] = 1;
				$list_args['depth']            = 1;
				$list_args['child_of']         = 0;
				$list_args['hierarchical']     = 1;
			}

			$this->widget_start( $args, $instance );

			if ( $dropdown ) {
				Edumall_FAQ::instance()->faq_dropdown_groups( wp_parse_args(
					$dropdown_args,
					array(
						'show_count'         => $count,
						'hierarchical'       => $hierarchical,
						'show_uncategorized' => 0,
						'selected'           => $this->current_cat ? $this->current_cat->slug : '',
					)
				) );

				wp_enqueue_script( 'selectWoo' );
				wp_enqueue_style( 'select2' );

				wc_enqueue_js(
					"
				jQuery( '.dropdown-faq-group' ).change( function() {
					if ( jQuery(this).val() != '' ) {
						var this_page = '';
						var home_url  = '" . esc_js( home_url( '/' ) ) . "';
						if ( home_url.indexOf( '?' ) > 0 ) {
							this_page = home_url + '&faq-group=' + jQuery(this).val();
						} else {
							this_page = home_url + '?faq-group=' + jQuery(this).val();
						}
						location.href = this_page;
					} else {
						location.href = '" . esc_js( tutor_utils()->course_archive_page_url() ) . "';
					}
				});

				if ( jQuery().selectWoo ) {
					var faq_group_select = function() {
						jQuery( '.dropdown-faq-group' ).selectWoo( {
							placeholder: '" . esc_js( __( 'Select a group', 'edumall' ) ) . "',
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: true,
							language: {
								noResults: function() {
									return '" . esc_js( _x( 'No matches found', 'enhanced select', 'edumall' ) ) . "';
								}
							}
						} );
					};
					faq_group_select();
				}
			"
				);
			} else {
				require_once EDUMALL_FAQ_DIR . '/class-faq-group-list-walker.php';

				$list_args['walker']                     = new Edumall_FAQ_Group_List_Walker();
				$list_args['title_li']                   = '';
				$list_args['pad_counts']                 = 1;
				$list_args['show_option_none']           = esc_html__( 'No groups exist.', 'edumall' );
				$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
				$list_args['current_category_ancestors'] = $this->cat_ancestors;
				$list_args['max_depth']                  = $max_depth;

				echo '<ul class="faq-groups">';

				wp_list_categories( apply_filters( 'edumall_faq_groups_widget_args', $list_args ) );

				echo '</ul>';
			}

			if ( ! empty( $custom_button_text ) && ! empty( $custom_button_link ) ) {
				Edumall_Templates::render_button( [
					'text'          => esc_html( $custom_button_text ),
					'link'          => [
						'url' => esc_url( $custom_button_link ),
					],
					'size'          => 'xs',
					'full_wide'     => true,
					'wrapper_class' => 'faq-group-custom-btn',
				] );
			}

			$this->widget_end( $args );
		}
	}
}
