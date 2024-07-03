<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;

defined( 'ABSPATH' ) || exit;

class Widget_Course extends Posts_Base {

	public function get_name() {
		return 'tm-course';
	}

	public function get_title() {
		return esc_html__( 'Courses', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-posts-grid';
	}

	public function get_keywords() {
		return [ 'course', 'courses', ];
	}

	protected function get_post_type() {
		return \Edumall_Tutor::instance()->get_course_type();
	}

	protected function get_post_category() {
		return \Edumall_Tutor::instance()->get_tax_category();
	}

	protected function get_query_author_object() {
		return Module_Query_Base::QUERY_OBJECT_USER;
	}

	public function get_script_depends() {
		return [
			'edumall-grid-query',
			'edumall-widget-grid-post',
		];
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_grid_section();

		$this->add_filter_section();

		$this->add_pagination_section();

		$this->add_sorting_section();

		/*$this->add_box_style_section();

		$this->add_thumbnail_style_section();

		$this->add_caption_style_section();*/

		$this->add_filter_style_section();

		$this->add_pagination_style_section();

		$this->add_image_style_section();

		$this->add_content_style_section();

		parent::register_controls();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'grid' => esc_html__( 'Grid', 'edumall' ),
				/*'masonry' => esc_html__( 'Masonry', 'edumall' ),
				'metro'   => esc_html__( 'Metro', 'edumall' ),*/
			],
			'default' => 'grid',
		] );

		$this->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'grid-01' => esc_html__( '01', 'edumall' ),
				'grid-02' => esc_html__( '02', 'edumall' ),
			],
			'default' => 'grid-01',
		] );

		$this->add_responsive_control( 'zigzag_height', [
			'label'     => esc_html__( 'Zigzag Height', 'edumall' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 1,
			'condition' => [
				'layout' => 'masonry',
			],
		] );

		$this->add_control( 'zigzag_reversed', [
			'label'     => esc_html__( 'Zigzag Reversed?', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => [
				'layout' => 'masonry',
			],
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

		//$this->add_caption_popover();

		$this->add_control( 'metro_image_size_width', [
			'label'     => esc_html__( 'Image Size', 'edumall' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 1,
			'default'   => 480,
			'condition' => [
				'layout' => 'metro',
			],
		] );

		$this->add_control( 'metro_image_ratio', [
			'label'     => esc_html__( 'Image Ratio', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 2,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'default'   => [
				'size' => 1,
			],
			'condition' => [
				'layout' => 'metro',
			],
		] );

		/*$this->add_control( 'thumbnail_default_size', [
			'label'        => esc_html__( 'Use Default Thumbnail Size', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
			'condition'    => [
				'layout!' => 'metro',
			],
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'layout!'                 => 'metro',
				'thumbnail_default_size!' => '1',
			],
		] );*/

		$this->end_controls_section();
	}

	private function add_caption_popover() {
		$this->add_control( 'show_caption', [
			'label'        => esc_html__( 'Caption', 'edumall' ),
			'type'         => Controls_Manager::POPOVER_TOGGLE,
			'label_off'    => esc_html__( 'Default', 'edumall' ),
			'label_on'     => esc_html__( 'Custom', 'edumall' ),
			'return_value' => 'yes',
		] );

		$this->start_popover();

		$this->add_control( 'caption_style', [
			'label'        => esc_html__( 'Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__( 'Style 01', 'edumall' ),
				'02' => esc_html__( 'Style 02', 'edumall' ),
			],
			'default'      => '01',
			'prefix_class' => 'course-caption-style-',
			'render_type'  => 'template',
		] );

		$this->add_control( 'show_caption_level', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
			'default'   => 'yes',
		] );

		$this->add_control( 'show_caption_instructor', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
		] );

		$this->add_control( 'show_caption_date', [
			'label'     => esc_html__( 'Date', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
		] );

		$this->add_control( 'show_caption_meta', [
			'label'       => esc_html__( 'Meta', 'edumall' ),
			'label_block' => true,
			'type'        => Controls_Manager::SELECT2,
			'multiple'    => true,
			'default'     => [
				'lessons',
				'students',
			],
			'options'     => [
				'lessons'  => esc_html__( 'Lessons', 'edumall' ),
				'students' => esc_html__( 'Students', 'edumall' ),
				'duration' => esc_html__( 'Duration', 'edumall' ),
				'category' => esc_html__( 'Category', 'edumall' ),
			],
		] );

		$this->add_control( 'show_caption_excerpt', [
			'label'     => esc_html__( 'Excerpt', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
		] );

		$this->add_control( 'excerpt_length', [
			'label'     => esc_html__( 'Excerpt Length', 'edumall' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 5,
			'condition' => [
				'show_caption_excerpt' => 'yes',
			],
		] );

		$this->add_control( 'show_caption_buttons', [
			'label'     => esc_html__( 'Buttons', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
		] );

		/*$this->add_control( 'purchase_button_text', [
			'label'       => esc_html__( 'Purchase Button', 'edumall' ),
			'label_block' => true,
			'description' => esc_html__( 'Custom text for purchase button.', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'condition'   => [
				'show_caption_buttons' => 'yes',
			],
		] );*/

		$this->end_popover();
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
			'default'            => 3,
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

		$metro_layout_repeater = new Repeater();

		$metro_layout_repeater->add_control( 'size', [
			'label'   => esc_html__( 'Item Size', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '1:1',
			'options' => Widget_Utils::get_grid_metro_size(),
		] );

		$this->add_control( 'grid_metro_layout', [
			'label'       => esc_html__( 'Metro Layout', 'edumall' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $metro_layout_repeater->get_controls(),
			'default'     => [
				[ 'size' => '2:2' ],
				[ 'size' => '1:1' ],
				[ 'size' => '1:1' ],
				[ 'size' => '1:1' ],
				[ 'size' => '2:2' ],
				[ 'size' => '1:1' ],
			],
			'title_field' => '{{{ size }}}',
			'condition'   => [
				'layout' => 'metro',
			],
		] );

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

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab( 'box_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_background',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_box_shadow',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover_background',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover_box_shadow',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_thumbnail_style_section() {
		$this->start_controls_section( 'thumbnail_style_section', [
			'label' => esc_html__( 'Thumbnail', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'thumbnail_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-image, {{WRAPPER}} .edumall-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		] );

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'thumbnail_effects_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'thumbnail_box_shadow',
			'selector' => '{{WRAPPER}} .edumall-image',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .edumall-image img',
		] );

		$this->add_control( 'thumbnail_opacity', [
			'label'     => esc_html__( 'Opacity', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'thumbnail_effects_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'thumbnail_box_shadow_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .edumall-image',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .edumall-image img',
		] );

		$this->add_control( 'thumbnail_opacity_hover', [
			'label'     => esc_html__( 'Opacity', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_caption_style_section() {
		$this->start_controls_section( 'caption_style_section', [
			'label'     => esc_html__( 'Caption', 'edumall' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_caption' => 'yes',
			],
		] );

		$this->add_responsive_control( 'caption_text_align', [
			'label'                => esc_html__( 'Alignment', 'edumall' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align(),
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'default'              => '',
			'selectors'            => [
				'{{WRAPPER}} .course-info' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'caption_padding', [
			'label'      => esc_html__( 'Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'caption_typography_hr', [
			'label'     => esc_html__( 'Typography', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_title_typography',
			'label'    => esc_html__( 'Title', 'edumall' ),
			'selector' => '{{WRAPPER}} .course-info .course-loop-title',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_date_typography',
			'label'    => esc_html__( 'Date', 'edumall' ),
			'selector' => '{{WRAPPER}} .course-info .course-date',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_meta_typography',
			'label'    => esc_html__( 'Meta', 'edumall' ),
			'selector' => '{{WRAPPER}} .course-info .course-meta',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_instructor_typography',
			'label'    => esc_html__( 'Instructor', 'edumall' ),
			'selector' => '{{WRAPPER}} .course-info .course-instructor',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'course_price_typography',
			'label'    => esc_html__( 'Price', 'edumall' ),
			'selector' => '{{WRAPPER}} .course-info .course-price',
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

		$this->add_control( 'course_title_color', [
			'label'     => esc_html__( 'Title', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-loop-title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_date_color', [
			'label'     => esc_html__( 'Date', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-date' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_meta_color', [
			'label'     => esc_html__( 'Meta', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-meta' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_instructor_color', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-instructor' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'caption_price_color', [
			'label'     => esc_html__( 'Price', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-price' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'caption_colors_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'course_title_hover_color', [
			'label'     => esc_html__( 'Title', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-info .course-loop-title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_date_hover_color', [
			'label'     => esc_html__( 'Date', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-date' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_meta_hover_color', [
			'label'     => esc_html__( 'Meta', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper .course-info .course-meta a:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_instructor_hover_color', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-instructor' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'course_price_hover_color', [
			'label'     => esc_html__( 'Price', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-wrapper:hover .course-info .course-price' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_image_style_section() {
		$this->start_controls_section( 'image_style_section', [
			'label'     => esc_html__( 'Image', 'edumall' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => 'grid-02',
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

		$this->add_control( 'heading_level', [
			'label'     => esc_html__( 'Level', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'level_typography',
			'selector' => '{{WRAPPER}} .course-loop-badge-level .badge-text',
			'global'   => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->add_responsive_control( 'level_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .course-loop-badge-level' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'heading_category', [
			'label'     => esc_html__( 'Category', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => 'grid-01',
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
				'style' => 'grid-01',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'category_typography',
			'selector'  => '{{WRAPPER}} .course-loop-category a',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => 'grid-01',
			],
		] );

		$this->start_controls_tabs( 'category_style_tabs' );

		$this->start_controls_tab( 'category_style_normal_tab', [
			'label'     => esc_html__( 'Normal', 'edumall' ),
			'condition' => [
				'style' => 'grid-01',
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
				'style' => 'grid-01',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'category_style_hover_tab', [
			'label'     => esc_html__( 'Hover', 'edumall' ),
			'condition' => [
				'style' => 'grid-01',
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
				'style' => 'grid-01',
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
				'style' => 'grid-01',
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
				'style' => 'grid-01',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'description_typography',
			'selector'  => '{{WRAPPER}} .edumall-courses .course-loop-excerpt',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => 'grid-01',
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
				'style' => 'grid-01',
			],
		] );

		$this->add_control( 'heading_instructor', [
			'label'     => esc_html__( 'Instructor', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => 'grid-02',
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
				'style' => 'grid-02',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'instructor_typography',
			'selector'  => '{{WRAPPER}} .edumall-courses .course-loop-instructor',
			'global'    => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
			'condition' => [
				'style' => 'grid-02',
			],
		] );

		$this->start_controls_tabs( 'instructor_style_tabs' );

		$this->start_controls_tab( 'instructor_style_normal_tab', [
			'label'     => esc_html__( 'Normal', 'edumall' ),
			'condition' => [
				'style' => 'grid-02',
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
				'style' => 'grid-02',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'instructor_style_hover_tab', [
			'label'     => esc_html__( 'Hover', 'edumall' ),
			'condition' => [
				'style' => 'grid-02',
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
				'style' => 'grid-02',
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

		$this->start_controls_tabs( 'price_tabs' );

		$this->start_controls_tab( 'caption_regular_price_tab', [
			'label' => esc_html__( 'Regular', 'minimog' ),
		] );

		$this->add_control( 'regular_price_color', [
			'label'     => esc_html__( 'Regular Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} ins .amount, {{WRAPPER}} .course-loop-price .course-free' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'sale_price_tab', [
			'label' => esc_html__( 'Sale', 'minimog' ),
		] );

		$this->add_control( 'regular_price_sale_color', [
			'label'     => esc_html__( 'Regular Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .course-loop-price del .amount' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'sale_price_color', [
			'label'     => esc_html__( 'Sale Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .on-sale ins .amount' => 'color: {{VALUE}};',
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

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->query_posts();
		/**
		 * @var $query \WP_Query
		 */
		$query     = $this->get_query();
		$post_type = $this->get_post_type();

		$this->add_render_attribute( 'wrapper', 'class', [
			'edumall-grid-wrapper edumall-courses',
			'style-' . $settings['style'],
		] );

		if ( 'metro' === $settings['layout'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'edumall-grid-metro' );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'edumall-grid' );

		if ( $this->is_grid() ) {
			$grid_options = $this->get_grid_options( $settings );

			$this->add_render_attribute( 'wrapper', 'data-grid', wp_json_encode( $grid_options ) );

			$this->add_render_attribute( 'content-wrapper', 'class', 'lazy-grid' );
		}

		if ( 'current_query' === $settings['query_source'] ) {
			$this->add_render_attribute( 'wrapper', 'data-query-main', '1' );
		}

		if ( ! empty( $settings['pagination_type'] ) && $query->found_posts > $settings['query_number'] ) {
			$this->add_render_attribute( 'wrapper', 'data-pagination', $settings['pagination_type'] );
		}

		if ( ! empty( $settings['pagination_custom_button_id'] ) ) {
			$this->add_render_attribute( 'wrapper', 'data-pagination-custom-button-id', $settings['pagination_custom_button_id'] );
		}

		if ( ! empty( $settings['filter_style'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'filter-style-' . $settings['filter_style'] );
		}
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php if ( $query->have_posts() ) : ?>
				<?php
				$edumall_grid_query['source']        = $settings['query_source'];
				$edumall_grid_query['action']        = "{$post_type}_infinite_load";
				$edumall_grid_query['max_num_pages'] = $query->max_num_pages;
				$edumall_grid_query['found_posts']   = $query->found_posts;
				$edumall_grid_query['count']         = $query->post_count;
				$edumall_grid_query['query_vars']    = $this->get_query_args();
				$edumall_grid_query                  = htmlspecialchars( wp_json_encode( $edumall_grid_query ) );
				?>
				<input type="hidden" class="edumall-query-input" <?php echo 'value="' . $edumall_grid_query . '"'; ?>/>

				<?php $this->print_result_count_and_sorting(); ?>

				<?php $this->print_filter( $query->found_posts ); ?>

				<?php
				global $edumall_course;
				$edumall_course_clone = $edumall_course;
				?>

				<div <?php $this->print_attributes_string( 'content-wrapper' ); ?>>
					<?php if ( $this->is_grid() ) : ?>
						<div class="edumall-grid-loader">
							<?php edumall_load_template( 'preloader/style', 'circle' ) ?>
						</div>

						<div class="grid-sizer"></div>
					<?php endif; ?>

					<?php
					set_query_var( 'edumall_query', $query );
					set_query_var( 'settings', $settings );

					get_template_part( 'loop/widgets/course/style', $settings['layout'] );
					?>
				</div>

				<?php $this->print_pagination( $query, $settings ); ?>
				<?php
				/**
				 * Reset course object.
				 */
				$edumall_course = $edumall_course_clone;
				?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
