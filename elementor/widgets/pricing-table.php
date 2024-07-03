<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || exit;

class Widget_Pricing_Table extends Base {

	public function get_name() {
		return 'tm-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Modern Pricing', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-price-table';
	}

	public function get_keywords() {
		return [ 'modern', 'pricing', 'price' ];
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_header_section();

		$this->add_pricing_section();

		$this->add_features_section();

		$this->add_footer_section();

		$this->add_ribbon_section();

		$this->add_box_style_section();

		$this->add_content_style_section();

		$this->add_graphic_style_section();

		$this->add_icon_style_section();

		$this->register_common_button_style_section();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__( '01', 'edumall' ),
				'02' => esc_html__( '02', 'edumall' ),
			],
			'default'      => '01',
			'prefix_class' => 'edumall-pricing-style-',
		] );

		$this->end_controls_section();
	}

	private function add_header_section() {
		$this->start_controls_section( 'header_section', [
			'label' => esc_html__( 'Header', 'edumall' ),
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Title', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Enter your title', 'edumall' ),
		] );

		$this->add_control( 'sub_heading', [
			'label' => esc_html__( 'Description', 'edumall' ),
			'type'  => Controls_Manager::TEXT,
		] );

		$this->add_control( 'heading_tag', [
			'label'   => esc_html__( 'Heading Tag', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
			],
			'default' => 'h3',
		] );

		$this->add_control( 'graphic_element', [
			'label'       => esc_html__( 'Graphic Element', 'edumall' ),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'none'  => [
					'title' => esc_html__( 'None', 'edumall' ),
					'icon'  => 'eicon-ban',
				],
				'image' => [
					'title' => esc_html__( 'Image', 'edumall' ),
					'icon'  => 'fa fa-picture-o',
				],
				'icon'  => [
					'title' => esc_html__( 'Icon', 'edumall' ),
					'icon'  => 'eicon-star',
				],
			],
			'default'     => 'none',
		] );

		$this->add_control( 'image', [
			'label'     => esc_html__( 'Choose Image', 'edumall' ),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'graphic_element' => 'image',
			],
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'image', // Actually its `image_size`
			'default'   => 'thumbnail',
			'condition' => [
				'graphic_element' => 'image',
			],
		] );

		$this->add_control( 'icon', [
			'label'     => esc_html__( 'Icon', 'edumall' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [
				'value'   => 'fa-solid fa-star',
				'library' => 'fa-solid',
			],
			'condition' => [
				'graphic_element' => 'icon',
			],
		] );

		$this->add_control( 'icon_view', [
			'label'        => esc_html__( 'View', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'default' => esc_html__( 'Default', 'edumall' ),
				'stacked' => esc_html__( 'Stacked', 'edumall' ),
				'bubble'  => esc_html__( 'Bubble', 'edumall' ),
			],
			'default'      => 'default',
			'prefix_class' => 'edumall-view-',
			'condition'    => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
			],
			'render_type'  => 'template',
		] );

		$this->add_control( 'icon_shape', [
			'label'        => esc_html__( 'Shape', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'circle' => esc_html__( 'Circle', 'edumall' ),
				'square' => esc_html__( 'Square', 'edumall' ),
			],
			'default'      => 'circle',
			'condition'    => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
				'icon_view'       => [ 'stacked' ],
			],
			'prefix_class' => 'edumall-shape-',
		] );

		$this->end_controls_section();
	}

	private function add_pricing_section() {
		$this->start_controls_section( 'pricing_section', [
			'label' => esc_html__( 'Pricing', 'edumall' ),
		] );

		$this->add_control( 'currency', [
			'label'   => esc_html__( 'Currency', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '$',
		] );

		$this->add_control( 'price', [
			'label'   => esc_html__( 'Price', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '39.99',
		] );

		$this->add_control( 'period', [
			'label'   => esc_html__( 'Period', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Monthly', 'edumall' ),
		] );

		$this->end_controls_section();
	}

	private function add_features_section() {
		$this->start_controls_section( 'features_section', [
			'label' => esc_html__( 'Features', 'edumall' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'text', [
			'label'       => esc_html__( 'Text', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Text', 'edumall' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'icon', [
			'label' => esc_html__( 'Icon', 'edumall' ),
			'type'  => Controls_Manager::ICONS,
		] );

		$this->add_control( 'features', [
			/*'label'       => esc_html__( 'Features', 'edumall' ),
			'show_label'  => false,*/
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'text' => esc_html__( 'List Item #1', 'edumall' ),
				],
				[
					'text' => esc_html__( 'List Item #2', 'edumall' ),
				],
				[
					'text' => esc_html__( 'List Item #3', 'edumall' ),
				],
			],
			'title_field' => '{{{ elementor.helpers.renderIcon( this, icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
		] );

		$this->end_controls_section();
	}

	private function add_footer_section() {
		$this->start_controls_section( 'footer_section', [
			'label' => esc_html__( 'Footer', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Button::get_type(), [
			'name' => 'button',
		] );

		$this->end_controls_section();
	}

	private function add_ribbon_section() {
		$this->start_controls_section( 'ribbon_section', [
			'label' => esc_html__( 'Ribbon', 'edumall' ),
		] );

		$this->add_control( 'show_ribbon', [
			'label' => esc_html__( 'Show', 'edumall' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'ribbon_title', [
			'label'     => esc_html__( 'Title', 'edumall' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Popular', 'edumall' ),
			'condition' => [
				'show_ribbon' => 'yes',
			],
		] );

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => esc_html__( 'Box', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'text_align', [
			'label'                => esc_html__( 'Alignment', 'edumall' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align_full(),
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'selectors'            => [
				'{{WRAPPER}} .edumall-box' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => esc_html__( 'Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-box > .inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_max_width', [
			'label'      => esc_html__( 'Max Width', 'edumall' ),
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
				'{{WRAPPER}} .edumall-box' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_horizontal_alignment', [
			'label'                => esc_html__( 'Horizontal Alignment', 'edumall' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'default'              => 'center',
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		] );

		$this->start_controls_tabs( 'box_colors' );

		$this->start_controls_tab( 'box_colors_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .edumall-box > .inner',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .edumall-box > .inner',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_colors_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover > .inner',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .edumall-box:hover > .inner',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => esc_html__( 'Content', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title',
			'label'    => esc_html__( 'Title Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .title',
			'global' => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->add_control( 'pricing_content_skin_hr', [
			'label' => esc_html__( 'Skin', 'edumall' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->start_controls_tabs( 'pricing_content_skin' );

		$this->start_controls_tab( 'pricing_content_skin_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'title_skin_hr', [
			'label' => esc_html__( 'Title', 'edumall' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'label'    => esc_html__( 'Title', 'edumall' ),
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .title',
		] );

		$this->add_control( 'features_skin_hr', [
			'label'     => esc_html__( 'Features', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'features_text_color', [
			'label'     => esc_html__( 'Text', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-features' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'features_icon_color', [
			'label'     => esc_html__( 'Icon', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-features .edumall-icon' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_skin_hr', [
			'label'     => esc_html__( 'Pricing', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'price_color', [
			'label'     => esc_html__( 'Price', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-price' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_currency_color', [
			'label'     => esc_html__( 'Currency', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-currency' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_period_color', [
			'label'     => esc_html__( 'Period', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-period' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ribbon_skin_hr', [
			'label'     => esc_html__( 'Ribbon', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'ribbon_primary_color', [
			'label'     => esc_html__( 'Primary', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-ribbon span' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ribbon_secondary_color', [
			'label'     => esc_html__( 'Secondary', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-pricing-ribbon:before' => 'border-top-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'pricing_content_skin_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'title_hover_skin_hr', [
			'label' => esc_html__( 'Title', 'edumall' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'label'    => esc_html__( 'Title', 'edumall' ),
			'name'     => 'title_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .title',
		] );

		$this->add_control( 'features_hover_skin_hr', [
			'label'     => esc_html__( 'Features', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'features_text_hover_color', [
			'label'     => esc_html__( 'Text', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-features' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'features_icon_hover_color', [
			'label'     => esc_html__( 'Icon', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-features .edumall-icon' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_hover_skin_hr', [
			'label'     => esc_html__( 'Pricing', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'price_hover_color', [
			'label'     => esc_html__( 'Price', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-price' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_currency_hover_color', [
			'label'     => esc_html__( 'Currency', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-currency' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'price_period_hover_color', [
			'label'     => esc_html__( 'Period', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-period' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ribbon_hover_skin_hr', [
			'label'     => esc_html__( 'Ribbon', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'ribbon_hover_primary_color', [
			'label'     => esc_html__( 'Primary', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-ribbon span' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ribbon_hover_secondary_color', [
			'label'     => esc_html__( 'Secondary', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .edumall-box:hover .edumall-pricing-ribbon:before' => 'border-top-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_graphic_style_section() {
		$this->start_controls_section( 'graphic_style_section', [
			'label'     => esc_html__( 'Graphic Element', 'edumall' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element!' => 'none',
			],
		] );

		$this->add_control( 'media_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-graphic-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'media_wrap_height', [
			'label'     => esc_html__( 'Wrap Height', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-graphic-wrap' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	private function add_icon_style_section() {
		$this->start_controls_section( 'icon_style_section', [
			'label'     => esc_html__( 'Icon', 'edumall' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element' => 'icon',
				'icon[value]!'    => '',
			],
		] );

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab( 'icon_colors_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon',
			'selector' => '{{WRAPPER}} .icon',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_colors_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_icon',
			'selector' => '{{WRAPPER}} .edumall-box:hover .icon',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'icon_size', [
			'label'     => esc_html__( 'Size', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-icon-view, {{WRAPPER}} .edumall-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
		] );

		$this->add_control( 'icon_rotate', [
			'label'     => esc_html__( 'Rotate', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'default'   => [
				'unit' => 'deg',
			],
			'selectors' => [
				'{{WRAPPER}} .edumall-icon > svg, {{WRAPPER}} .edumall-icon > i' => 'transform: rotate({{SIZE}}{{UNIT}});',
			],
		] );

		// Icon View Settings.
		$this->add_control( 'icon_view_heading', [
			'label'     => esc_html__( 'Icon View', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'icon_view' => [ 'stacked', 'bubble' ],
			],
		] );

		$this->add_control( 'icon_padding', [
			'label'     => esc_html__( 'Padding', 'edumall' ),
			'type'      => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .edumall-icon-view' => 'padding: {{SIZE}}{{UNIT}};',
			],
			'range'     => [
				'em' => [
					'min' => 0,
					'max' => 5,
				],
			],
			'condition' => [
				'icon_view' => [ 'stacked' ],
			],
		] );

		$this->add_control( 'icon_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-icon-view' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'icon_view' => [ 'stacked' ],
			],
		] );

		$this->start_controls_tabs( 'icon_view_colors', [
			'condition' => [
				'icon_view' => [ 'stacked', 'bubble' ],
			],
		] );

		$this->start_controls_tab( 'icon_view_colors_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .edumall-icon-view',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .edumall-icon-view',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_view_colors_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .edumall-box:hover .edumall-icon-view',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .edumall-box:hover .edumall-icon-view',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'edumall-pricing edumall-box' );

		if ( 'yes' === $settings['show_ribbon'] && isset( $settings['ribbon_title'] ) && '' !== $settings['ribbon_title'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'has-ribbon' );
		}

		$this->add_render_attribute( 'heading', 'class', 'title' );
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<div class="inner">

				<?php $this->print_pricing_ribbon(); ?>

				<div class="edumall-pricing-header">
					<?php if ( ! empty( $settings['heading'] ) ) : ?>
						<div class="heading-wrap">
							<?php printf( '<%1$s %2$s>%3$s</%1$s>', $settings['heading_tag'], $this->get_render_attribute_string( 'heading' ), $settings['heading'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['sub_heading'] ) ) : ?>
						<div class="sub-heading-wrap">
							<?php echo esc_html( $settings['sub_heading'] ); ?>
						</div>
					<?php endif; ?>

					<?php $this->print_graphic_element(); ?>
				</div>

				<?php $this->print_pricing(); ?>

				<?php if ( '02' === $settings['style'] ) : ?>
					<?php $this->print_pricing_footer(); ?>
				<?php endif; ?>

				<div class="edumall-pricing-body">
					<?php if ( $settings['features'] && count( $settings['features'] ) > 0 ) { ?>
						<ul class="edumall-pricing-features">
							<?php foreach ( $settings['features'] as $item ) {
								$item_key = 'item_' . $item['_id'];
								$this->add_render_attribute( $item_key, 'class', 'item' );
								?>
								<li>
									<?php if ( ! empty( $item['icon']['value'] ) ) { ?>
										<div class="edumall-icon icon">
											<?php $this->render_icon( $settings, $item['icon'], [ 'aria-hidden' => 'true' ], false, 'icon' ); ?>
										</div>
									<?php } ?>
									<?php echo wp_kses( $item['text'], 'edumall-default' ); ?>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>

				<?php if ( '01' === $settings['style'] ) : ?>
					<?php $this->print_pricing_footer(); ?>
				<?php endif; ?>

			</div>
		</div>
		<?php
	}

	private function print_pricing_ribbon() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_ribbon'] || ! isset( $settings['ribbon_title'] ) || '' === $settings['ribbon_title'] ) {
			return;
		}
		?>
		<div class="edumall-pricing-ribbon">
			<span><?php echo esc_html( $settings['ribbon_title'] ); ?></span>
		</div>
		<?php
	}

	private function print_pricing() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['price'] ) || '' === $settings['price'] ) {
			return;
		}
		?>
		<div class="price-wrap">
			<div class="price-wrap-inner">
				<?php if ( ! empty( $settings['currency'] ) ) : ?>
					<div class="edumall-pricing-currency"><?php echo esc_html( $settings['currency'] ); ?></div>
				<?php endif; ?>

				<div class="edumall-pricing-price"><?php echo esc_html( $settings['price'] ); ?></div>

				<?php if ( ! empty( $settings['period'] ) ) : ?>
					<div class="edumall-pricing-period"><?php echo esc_html( $settings['period'] ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function print_pricing_footer() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['button_text'] ) || empty( $settings['button_link'] ) ) {
			return;
		}
		?>
		<div class="edumall-pricing-footer">
			<?php $this->render_common_button(); ?>
		</div>
		<?php
	}

	private function print_graphic_element() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['graphic_element'] ) || 'none' === $settings['graphic_element'] ) {
			return;
		}

		switch ( $settings['graphic_element'] ) {
			case 'image' :
				$this->print_graphic_image();
				break;
			case 'icon' :
				$this->print_graphic_icon();
				break;
		}
	}

	private function print_graphic_image() {
		$settings = $this->get_settings_for_display();

		if ( 'image' !== $settings['graphic_element'] || empty( $settings['image']['url'] ) ) {
			return;
		}
		?>
		<div class="edumall-graphic-wrap image">
			<?php echo \Edumall_Image::get_elementor_attachment( [
				'settings'  => $settings,
				'image_key' => 'image',
			] ); ?>
		</div>
		<?php
	}

	private function print_graphic_icon() {
		$settings = $this->get_settings_for_display();

		if ( 'icon' !== $settings['graphic_element'] || empty( $settings["icon"]['value'] ) ) {
			return;
		}

		$icon_key = 'icon';

		$this->add_render_attribute( $icon_key, 'class', [
			'edumall-icon',
			'icon',
		] );

		$is_svg = isset( $settings['icon']['library'] ) && 'svg' === $settings['icon']['library'] ? true : false;

		if ( $is_svg ) {
			$this->add_render_attribute( $icon_key, 'class', 'edumall-svg-icon' );
		}

		if ( isset( $settings['icon_color_type'] ) && '' !== $settings['icon_color_type'] ) {
			switch ( $settings['icon_color_type'] ) {
				case 'gradient' :
					$this->add_render_attribute( $icon_key, 'class', 'edumall-gradient-icon' );
					break;
				case 'classic' :
					$this->add_render_attribute( $icon_key, 'class', 'edumall-solid-icon' );
					break;
			}
		}
		?>
		<div class="edumall-graphic-wrap edumall-icon-wrap">
			<div class="edumall-icon-view first">
				<div class="edumall-icon-view-inner">
					<div <?php $this->print_attributes_string( $icon_key ); ?>>
						<?php $this->render_icon( $settings, $settings['icon'], [ 'aria-hidden' => 'true' ], $is_svg, 'icon' ); ?>
					</div>
				</div>
			</div>

			<?php if ( 'bubble' === $settings['icon_view'] ) { ?>
				<div class="edumall-icon-view second"></div>
			<?php } ?>
		</div>
		<?php
	}
}
