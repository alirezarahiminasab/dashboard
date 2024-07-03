<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || exit;

class Widget_Course_Category_Cards extends Base {

	public function get_name() {
		return 'tm-course-category-cards';
	}

	public function get_title() {
		return esc_html__( 'Course Category Cards', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-gallery-grid';
	}

	public function get_keywords() {
		return [ 'course', 'category' ];
	}

	public function get_script_depends() {
		return [ 'edumall-group-widget-grid' ];
	}

	public function get_taxonomy_name() {
		return \Edumall_Tutor::instance()->get_tax_category();
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_grid_section();

		$this->card_style_section();

		$this->caption_style_section();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => esc_html__( 'Style 01', 'edumall' ),
				'02' => esc_html__( 'Style 02', 'edumall' ),
				'03' => esc_html__( 'Style 03', 'edumall' ),
			],
			'default' => '01',
		] );

		$this->add_control( 'show_description', [
			'label' => esc_html__( 'Show Description', 'edumall' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'show_count', [
			'label'     => esc_html__( 'Show Count', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => [
				'style' => '03',
			],
		] );

		$taxonomy_name = $this->get_taxonomy_name();

		$categories = get_terms( [
			'taxonomy'   => $taxonomy_name,
			'parent'     => 0,
			'hide_empty' => 0,
		] );

		$options = [];
		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}

		$repeater = new Repeater();

		$repeater->add_control( 'term_id', [
			'label'   => esc_html__( 'Category', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => $options,
		] );

		$repeater->add_control( 'icon_type', [
			'label'   => esc_html__( 'Icon Type', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'icon'  => esc_html__( 'Icon', 'edumall' ),
				'image' => esc_html__( 'Image', 'edumall' ),
			],
			'default' => 'icon',
		] );

		$repeater->add_control( 'icon', [
			'label'     => esc_html__( 'Icon', 'edumall' ),
			'type'      => Controls_Manager::ICONS,
			'condition' => [
				'icon_type' => 'icon',
			],
		] );

		$repeater->add_control( 'image', [
			'label'     => esc_html__( 'Image', 'edumall' ),
			'type'      => Controls_Manager::MEDIA,
			'condition' => [
				'icon_type' => 'image',
			],
		] );

		$this->add_control( 'categories', [
			'label'       => esc_html__( 'Select Categories', 'edumall' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => "{{ EdumallElementor.helpers.getRepeaterSelectOptionText('tm-course-category-cards', 'categories', 'term_id', term_id) }}",
		] );

		$this->end_controls_section();
	}

	private function add_grid_section() {
		$this->start_controls_section( 'grid_options_section', [
			'label' => esc_html__( 'Grid Options', 'edumall' ),
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'              => esc_html__( 'Columns', 'edumall' ),
			'type'               => Controls_Manager::NUMBER,
			'min'                => 1,
			'max'                => 12,
			'step'               => 1,
			'default'            => 4,
			'tablet_default'     => 2,
			'mobile_default'     => 1,
			'frontend_available' => true,
		] );

		$this->add_responsive_control( 'grid_gutter', [
			'label'   => esc_html__( 'Gutter', 'edumall' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 0,
			'max'     => 200,
			'step'    => 1,
			'default' => 30,
		] );

		$this->end_controls_section();
	}

	private function card_style_section() {
		$this->start_controls_section( 'card_style_section', [
			'label' => esc_html__( 'Card', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'box_min_height', [
			'label'      => esc_html__( 'Min Height', 'edumall' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .edumall-box' => 'min-height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => esc_html__( 'Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'box_colors' );

		$this->start_controls_tab( 'box_colors_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_background',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_shadow',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_colors_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover_background',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover_shadow',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function caption_style_section() {
		$this->start_controls_section( 'caption_style_section', [
			'label' => esc_html__( 'Caption', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'cat_name_hr', [
			'label'     => esc_html__( 'Category Name', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'cat_name_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .category-name',
		] );

		$this->add_control( 'cat_count_hr', [
			'label'     => esc_html__( 'Category Count', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'cat_count_typography',
			'label'     => esc_html__( 'Typography', 'edumall' ),
			'selector'  => '{{WRAPPER}} .category-count',
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'cat_description_hr', [
			'label'     => esc_html__( 'Category Description', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'show_description' => 'yes',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'cat_description_typography',
			'label'     => esc_html__( 'Typography', 'edumall' ),
			'selector'  => '{{WRAPPER}} .category-description',
			'condition' => [
				'show_description' => 'yes',
			],
		] );

		$this->add_responsive_control( 'cat_description_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .category-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'show_description' => 'yes',
			],
		] );

		$this->add_control( 'caption_colors_hr', [
			'label'     => esc_html__( 'Colors', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->start_controls_tabs( 'caption_colors_tabs' );

		$this->start_controls_tab( 'caption_colors_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'cat_icon_color', [
			'label'     => esc_html__( 'Category Icon', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-icon' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cat_name_color', [
			'label'     => esc_html__( 'Category Name', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-name' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cat_count_color', [
			'label'     => esc_html__( 'Category Count', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'cat_description_color', [
			'label'     => esc_html__( 'Category Description', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-description' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_description' => 'yes',
			],
		] );

		$this->add_control( 'cat_name_arrow_color', [
			'label'     => esc_html__( 'Arrow', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-name:after' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'caption_colors_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'cat_icon_hover_color', [
			'label'     => esc_html__( 'Category Icon', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .category-icon' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cat_name_hover_color', [
			'label'     => esc_html__( 'Category Name', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .category-name' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cat_count_hover_color', [
			'label'     => esc_html__( 'Category Count', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .category-count' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'cat_description_hover_color', [
			'label'     => esc_html__( 'Category Description', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .category-description' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_description' => 'yes',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['categories'] ) ) {
			return;
		}

		$new_cats    = [];
		$new_cat_ids = [];

		/**
		 * Valid terms.
		 * Skip invalid terms.
		 */
		foreach ( $settings['categories'] as $category ) {
			if ( isset( $category['term_id'] ) ) {
				$new_cats[ $category['term_id'] ] = $category;
				$new_cat_ids[]                    = intval( $category['term_id'] );
			}
		}

		if ( empty( $new_cat_ids ) ) {
			return;
		}

		$new_cat_ids = array_unique( $new_cat_ids );

		$new_terms = get_terms( [
			'taxonomy'   => $this->get_taxonomy_name(),
			'include'    => $new_cat_ids,
			'orderby'    => 'include',
			'hide_empty' => false,
		] );

		if ( is_wp_error( $new_terms ) || empty( $new_terms ) ) {
			return;
		}

		$this->add_render_attribute( 'grid-wrapper', 'class', 'edumall-grid-wrapper edumall-course-category-cards style-' . $settings['style'] );

		$this->add_render_attribute( 'content-wrapper', 'class', 'edumall-grid lazy-grid' );

		$grid_options = $this->get_grid_options();

		$this->add_render_attribute( 'grid-wrapper', 'data-grid', wp_json_encode( $grid_options ) );
		?>
		<div <?php $this->print_attributes_string( 'grid-wrapper' ); ?>>
			<div <?php $this->print_attributes_string( 'content-wrapper' ); ?>>
				<div class="grid-sizer"></div>
				<?php foreach ( $new_terms as $term ) : ?>
					<?php
					$item_key = "item_{$term->term_id}_";
					$box_key  = $item_key . 'box';

					$link = get_term_link( $term );

					$this->add_render_attribute( $box_key, [
						'class' => 'edumall-box',
						'href'  => $link,
					] );

					$term_settings = $new_cats[ $term->term_id ];

					$has_icon = ! empty( $term_settings['icon']['value'] ) ? true : false;

					$has_image = isset( $term_settings['image'] ) ? $term_settings['image'] : '';
					?>
					<div class="grid-item">
						<a <?php $this->print_render_attribute_string( $box_key ); ?>>
							<?php if ( $has_icon ) : ?>
								<div class="category-icon">
									<?php Icons_Manager::render_icon( $term_settings['icon'] ); ?>
								</div>
							<?php endif; ?>
							<?php if ( $has_image ) : ?>
								<div class="category-image">
									<?php \Edumall_Image::the_attachment_by_id( array(
										'id' => $has_image['id'],
									) ); ?>
								</div>
							<?php endif; ?>
							<div class="category-info">
								<h6 class="category-name">
									<?php echo esc_html( $term->name ); ?>
									<?php if ( ! empty( $settings['show_count'] ) ): ?>
										<span class="category-count">
											<?php echo esc_html( $term->count ); ?>
										</span>
									<?php endif; ?>
								</h6>
								<?php if ( ! empty( $settings['show_description'] ) ): ?>
									<div class="category-description">
										<?php echo esc_html( $term->description ); ?>
									</div>
								<?php endif; ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	protected function get_grid_options() {
		$settings = $this->get_settings_for_display();

		$grid_options = [
			'type' => 'grid',
		];

		// Columns.
		if ( ! empty( $settings['grid_columns'] ) ) {
			$grid_options['columns'] = $settings['grid_columns'];
		}

		if ( ! empty( $settings['grid_columns_tablet'] ) ) {
			$grid_options['columnsTablet'] = $settings['grid_columns_tablet'];
		}

		if ( ! empty( $settings['grid_columns_mobile'] ) ) {
			$grid_options['columnsMobile'] = $settings['grid_columns_mobile'];
		}

		// Gutter
		if ( ! empty( $settings['grid_gutter'] ) ) {
			$grid_options['gutter'] = $settings['grid_gutter'];
		}

		if ( ! empty( $settings['grid_gutter_tablet'] ) ) {
			$grid_options['gutterTablet'] = $settings['grid_gutter_tablet'];
		}

		if ( ! empty( $settings['grid_gutter_mobile'] ) ) {
			$grid_options['gutterMobile'] = $settings['grid_gutter_mobile'];
		}

		return $grid_options;
	}
}
