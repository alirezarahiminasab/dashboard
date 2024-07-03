<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || exit;

class Widget_Event_Carousel extends Posts_Carousel_Base {

	public function get_name() {
		return 'tm-event-carousel';
	}

	public function get_title() {
		return esc_html__( 'Event Carousel', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'event', 'carousel' ];
	}

	protected function get_post_type() {
		return 'tp_event';
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_box_style_section();

		$this->add_caption_style_section();

		parent::register_controls();
	}

	protected function before_slider() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( self::SLIDER_KEY, 'class', 'edumall-event-carousel edumall-event style-' . $settings['style'] );
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'grid-01' => esc_html__( 'Grid 01', 'edumall' ),
				'grid-02' => esc_html__( 'Grid 02', 'edumall' ),
			],
			'default' => 'grid-01',
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

		$this->add_control( 'thumbnail_default_size', [
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
		);

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => esc_html__( 'Box', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'box_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-box' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		] );

		$this->start_controls_tabs( 'box_skin_tabs' );

		$this->start_controls_tab( 'box_skin_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'box_background_color', [
			'label'     => esc_html__( 'Background', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_box_shadow',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_skin_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'box_background_color_hover', [
			'label'     => esc_html__( 'Background', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_box_shadow_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_caption_style_section() {
		$this->start_controls_section( 'caption_style_section', [
			'label' => esc_html__( 'Caption', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_style_heading', [
			'label'     => esc_html__( 'Title', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .event-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .event-title',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'title_hover_color', [
			'label'     => esc_html__( 'Hover Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'date_style_heading', [
			'label'     => esc_html__( 'Date Time', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'date_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .event-date-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'date_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .event-date',
		] );

		$this->add_control( 'date_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-date-time' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'location_style_heading', [
			'label'     => esc_html__( 'Location', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'location_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .event-location' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'location_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .event-location',
		] );

		$this->add_control( 'location_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .event-location' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function print_slide( array $settings ) {
		$event_style = $settings['style'];
		?>
		<div class="swiper-slide">
			<?php wpems_get_template_part( 'content-event', $event_style ); ?>
		</div>
		<?php
	}
}
