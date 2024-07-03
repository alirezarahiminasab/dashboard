<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined( 'ABSPATH' ) || exit;

class Widget_Course_Carousel extends Posts_Carousel_Base {

	public function get_name() {
		return 'tm-course-carousel';
	}

	public function get_title() {
		return esc_html__( 'Course Carousel', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'course', 'carousel' ];
	}

	protected function get_post_type() {
		return \Edumall_Tutor::instance()->get_course_type();
	}

	protected function get_query_author_object() {
		return Module_Query_Base::QUERY_OBJECT_USER;
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_image_style_section();

		$this->add_content_style_section();

		parent::register_controls();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => esc_html__( '01', 'edumall' ),
				'02' => esc_html__( '02', 'edumall' ),
				'03' => esc_html__( '03', 'edumall' ),
			],
			'default' => '03',
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

		/*$this->add_control( 'thumbnail_default_size', [
			'label'        => esc_html__( 'Use Default Thumbnail Size', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
		] );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'condition' => [
					'thumbnail_default_size!' => '1',
				],
			]
		);*/

		$this->end_controls_section();
	}

	private function add_image_style_section() {
		$this->start_controls_section( 'image_style_section', [
			'label'     => esc_html__( 'Image', 'edumall' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => '02',
			],
		] );

		$this->add_responsive_control( 'image_radius', [
			'label'      => esc_html__( 'Radius', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-courses .course-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => esc_html__( 'Course Info', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_meta', [
			'label'     => esc_html__( 'Meta', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => '01',
			],
		] );

		$this->add_responsive_control( 'meta_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-loop-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => '01',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'meta_typography',
			'selector'  => '{{WRAPPER}} .course-loop-meta .course-loop-meta-item .meta-value',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => '01',
			],
		] );

		$this->add_control( 'heading_level', [
			'label'     => esc_html__( 'Level', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => [ '02', '03' ],
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'level_typography',
			'selector'  => '{{WRAPPER}} .course-loop-badge-level .badge-text',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => [ '02', '03' ],
			],
		] );

		$this->add_responsive_control( 'level_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-loop-badge-level' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '02', '03' ],
			],
		] );

		$this->add_control( 'heading_category', [
			'label'     => esc_html__( 'Category', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_responsive_control( 'category_space', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-loop-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => '03',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'category_typography',
			'selector'  => '{{WRAPPER}} .course-loop-category a',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->start_controls_tabs( 'category_style_tabs' );

		$this->start_controls_tab( 'category_style_normal_tab', [
			'label'     => esc_html__( 'Normal', 'edumall' ),
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'category_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-category a' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'category_style_hover_tab', [
			'label'     => esc_html__( 'Hover', 'edumall' ),
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'category_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-category a:hover' => 'color: {{VALUE}} !important;',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_title', [
			'label'     => esc_html__( 'Title', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .edumall-courses .course-loop-title',
			'global'   => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->start_controls_tabs( 'title_style_tabs' );

		$this->start_controls_tab( 'title_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-courses .course-loop-title a' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'title_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-courses .course-loop-title a:hover' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_description', [
			'label'     => esc_html__( 'Description', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => [ '01', '03' ],
			],
		] );

		$this->add_responsive_control( 'description_margin', [
			'label'      => esc_html__( 'Description', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-courses .course-loop-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '01', '03' ],
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'description_typography',
			'selector'  => '{{WRAPPER}} .edumall-courses .course-loop-excerpt',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => [ '01', '03' ],
			],
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-courses .course-loop-excerpt' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '03' ],
			],
		] );

		$this->add_control( 'heading_instructor', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_responsive_control( 'instructor_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-courses .course-loop-instructor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'instructor_typography',
			'selector'  => '{{WRAPPER}} .edumall-courses .course-loop-instructor',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->start_controls_tabs( 'instructor_style_tabs' );

		$this->start_controls_tab( 'instructor_style_normal_tab', [
			'label'     => esc_html__( 'Normal', 'edumall' ),
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_control( 'instructor_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-courses .course-loop-instructor a' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'instructor_style_hover_tab', [
			'label'     => esc_html__( 'Hover', 'edumall' ),
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_control( 'instructor_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-courses .course-loop-instructor a:hover' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_price', [
			'label'     => esc_html__( 'Price', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'price_typography',
			'selector' => '{{WRAPPER}} .price ins .amount, {{WRAPPER}} .tutor-price.course-free',
			'global'   => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->add_control( 'price_box_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-price .tutor-price .price .amount' => 'color: {{VALUE}} !important;',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->add_control( 'price_bgr_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-price .tutor-price' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '03',
			],
		] );

		$this->start_controls_tabs( 'price_tabs' );

		$this->start_controls_tab( 'caption_regular_price_tab', [
			'label'     => esc_html__( 'Regular', 'minimog' ),
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_control( 'regular_price_color', [
			'label'     => esc_html__( 'Regular Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} ins .amount, {{WRAPPER}} .course-loop-price .course-free' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'sale_price_tab', [
			'label'     => esc_html__( 'Sale', 'minimog' ),
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_control( 'regular_price_sale_color', [
			'label'     => esc_html__( 'Regular Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-price del .amount' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->add_control( 'sale_price_color', [
			'label'     => esc_html__( 'Sale Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .on-sale ins .amount' => 'color: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '01', '02' ],
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_rating', [
			'label'     => esc_html__( 'Rating', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'rating_space', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-loop-info .tm-star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'rating_star_empty_color', [
			'label'     => esc_html__( 'Star Empty Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-star-rating .tm-star-empty, {{WRAPPER}} .tm-star-rating .tm-star-empty:before' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_control( 'rating_star_full_color', [
			'label'     => esc_html__( 'Star Full Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-star-rating .tm-star-full' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function before_slider() {
		/**
		 * Add more attrs to slider.
		 */
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( self::SLIDER_KEY, 'class', 'edumall-courses style-carousel-' . $settings['style'] );
	}

	protected function print_slides( array $settings ) {
		$settings = $this->get_settings_for_display();
		$this->query_posts();
		/**
		 * @var $query \WP_Query
		 */
		$query = $this->get_query();
		?>
		<?php if ( $query->have_posts() ) : ?>

			<?php
			global $edumall_course;
			$edumall_course_clone = $edumall_course;
			?>

			<?php while ( $query->have_posts() ) : $query->the_post(); ?><?php
				/**
				 * Setup course object.
				 */
				$edumall_course = new \Edumall_Course();
				?>
				<?php $this->print_slide( $settings ); ?>
			<?php endwhile; ?>

			<?php $this->after_loop(); ?>

			<?php wp_reset_postdata(); ?>
			<?php
			/**
			 * Reset course object.
			 */
			$edumall_course = $edumall_course_clone;
			?>

		<?php endif;
	}

	protected function print_slide( array $settings ) {
		$style = $settings['style'];
		?>
		<?php tutor_load_template( 'loop.custom.loop-before-slide-content' ); ?>
		<?php tutor_load_template( 'loop.custom.content-course-carousel-' . $style ); ?>
		<?php tutor_load_template( 'loop.custom.loop-after-slide-content' ); ?>
		<?php
	}
}
