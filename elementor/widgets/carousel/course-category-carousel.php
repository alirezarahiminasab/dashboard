<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined( 'ABSPATH' ) || exit;

class Widget_Course_Category_Carousel extends Terms_Carousel_Base {

	public function get_name() {
		return 'tm-course-category-carousel';
	}

	public function get_title() {
		return esc_html__( 'Course Category Carousel', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'course', 'course-category', 'carousel' ];
	}

	protected function get_taxonomy_name() {
		return \Edumall_Tutor::instance()->get_tax_category();
	}

	private function update_controls() {
		$this->update_responsive_control( 'swiper_items', [
			'default'        => '5',
			'tablet_default' => '3',
			'mobile_default' => '2',
		] );

		$this->update_responsive_control( 'swiper_gutter', [
			'default' => 30,
		] );
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->update_controls();

		$this->add_content_style_section();

		parent::register_controls();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'hover_effect', [
			'label'        => esc_html__( 'Hover Effect', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''         => esc_html__( 'None', 'edumall' ),
				'zoom-in'  => esc_html__( 'Zoom In', 'edumall' ),
				'zoom-out' => esc_html__( 'Zoom Out', 'edumall' ),
			],
			'default'      => '',
			'prefix_class' => 'edumall-animation-',
		] );

		$this->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => esc_html__( '01', 'edumall' ),
				'02' => esc_html__( '02', 'edumall' ),
			],
			'default' => '01',
		] );

		$this->add_control( 'show_description', [
			'label'        => esc_html__( 'Show Description', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'condition'    => [
				'style' => '02',
			],
		] );

		$this->add_control( 'show_count', [
			'label'        => esc_html__( 'Show Count', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'condition'    => [
				'style' => '02',
			],
		] );

		$this->add_control( 'thumbnail_default_size', [
			'label'        => esc_html__( 'Use Default Thumbnail Size', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'thumbnail_default_size!' => '1',
			],
		] );

		$this->end_controls_section();
	}

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => esc_html__( 'Course Info', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_name', [
			'label'     => esc_html__( 'Name', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'name_top_space', [
			'label'     => esc_html__( 'Top Spacing', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .category-name' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'selector' => '{{WRAPPER}} .category-name',
			'global'   => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->start_controls_tabs( 'name_style_tabs' );

		$this->start_controls_tab( 'name_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'name_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-name' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'name_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'name_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-name:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_description', [
			'label'     => esc_html__( 'Description', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_responsive_control( 'description_top_space', [
			'label'     => esc_html__( 'Top Spacing', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .category-description' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'description_typography',
			'selector'  => '{{WRAPPER}} .category-description',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_TEXT,
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-description' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'heading_count', [
			'label'     => esc_html__( 'Count', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_responsive_control( 'count_top_space', [
			'label'     => esc_html__( 'Top Spacing', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'count_typography',
			'selector'  => '{{WRAPPER}} .category-count',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->start_controls_tabs( 'count_style_tabs' );

		$this->start_controls_tab( 'count_style_normal_tab', [
			'label'     => esc_html__( 'Normal', 'edumall' ),
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_background', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_border', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'count_style_hover_tab', [
			'label'     => esc_html__( 'Hover', 'edumall' ),
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count:hover' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_hover_background', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count:hover' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_control( 'count_hover_border', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .category-count:hover' => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '02',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function before_slider() {
		/**
		 * Add more attrs to slider.
		 */
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( self::SLIDER_KEY, 'class', 'style-category-carousel-' . $settings['style'] );
	}

	protected function print_slide() {
		$settings  = $this->get_settings_for_display();
		$slide_key = $this->get_current_key();
		$category  = $this->get_current_slide();

		$box_key = $slide_key . 'box';

		$link = get_term_link( $category );

		$this->add_render_attribute( $box_key, [
			'class' => 'edumall-box link-secret',
			'href'  => $link,
		] );

		$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
		?>
		<div class="swiper-slide">
			<a <?php $this->print_render_attribute_string( $box_key ); ?>>
				<div class="edumall-image">
					<?php if ( $thumbnail_id ) { ?>
						<?php $size = \Edumall_Image::elementor_parse_image_size( $settings, '260x320' ); ?>
						<?php \Edumall_Image::the_attachment_by_id( [
							'id'   => $thumbnail_id,
							'size' => $size,
						] ); ?>
					<?php } else { ?>
						<?php \Edumall_Templates::image_placeholder( 260, 320 ); ?>
					<?php } ?>

					<?php if ( $settings['style'] == '01' ): ?>
						<div class="category-info">
							<h6 class="category-name"><?php echo esc_html( $category->name ); ?></h6>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $settings['style'] == '02' ): ?>
					<div class="category-info">
						<h6 class="category-name"><?php echo esc_html( $category->name ); ?></h6>
						<?php if ( ! empty( $settings['show_description'] ) ) { ?>
							<div class="category-description">
								<p><?php echo esc_html( $category->description ); ?></p>
							</div>
						<?php } ?>

						<?php if ( ! empty( $settings['show_count'] ) ) { ?>
							<div class="category-count">
								<?php printf( esc_html( _n( '%s Course', '%s Courses', $category->count, 'edumall' ) ), '<span class="count">' . $category->count . '</span>' ); ?>
							</div>
						<?php } ?>
					</div>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}
}
