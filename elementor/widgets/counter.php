<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || exit;

class Widget_Counter extends Base {

	public function get_name() {
		return 'tm-counter';
	}

	public function get_title() {
		return esc_html__( 'Modern Counter', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-counter';
	}

	public function get_keywords() {
		return [ 'counter' ];
	}

	public function get_script_depends() {
		return [ 'edumall-widget-counter' ];
	}

	protected function register_controls() {
		$this->add_content_section();

		$this->add_box_style_section();

		$this->add_number_style_section();

		$this->add_title_style_section();

		$this->add_graphic_style_section();

		$this->add_icon_style_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'counter_section', [
			'label' => esc_html__( 'Counter', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''   => esc_html__( 'None', 'edumall' ),
				'01' => '01',
				'02' => '02',
			],
			'default'      => '',
			'prefix_class' => 'edumall-counter-style-',
		] );

		$this->add_control( 'number_heading', [
			'label'     => esc_html__( 'Number', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'starting_number', [
			'label'   => esc_html__( 'Starting Number', 'edumall' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 0,
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control( 'ending_number', [
			'label'   => esc_html__( 'Ending Number', 'edumall' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 100,
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control( 'prefix', [
			'label'       => esc_html__( 'Number Prefix', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => '',
			'placeholder' => 1,
		] );

		$this->add_control( 'suffix', [
			'label'       => esc_html__( 'Number Suffix', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => '',
			'placeholder' => esc_html__( 'Plus', 'edumall' ),
		] );

		$this->add_control( 'duration', [
			'label'   => esc_html__( 'Animation Duration', 'edumall' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 2000,
			'min'     => 100,
			'step'    => 100,
		] );

		$this->add_control( 'thousand_separator', [
			'label'     => esc_html__( 'Thousand Separator', 'edumall' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'label_on'  => esc_html__( 'Show', 'edumall' ),
			'label_off' => esc_html__( 'Hide', 'edumall' ),
		] );

		$this->add_control( 'thousand_separator_char', [
			'label'     => esc_html__( 'Separator', 'edumall' ),
			'type'      => Controls_Manager::SELECT,
			'condition' => [
				'thousand_separator' => 'yes',
			],
			'options'   => [
				''  => 'Default',
				'.' => 'Dot',
				' ' => 'Space',
			],
		] );

		$this->add_control( 'content_heading', [
			'label'     => esc_html__( 'Content', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
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

		$this->add_control( 'graphic_position', [
			'label'        => esc_html__( 'Position', 'edumall' ),
			'type'         => Controls_Manager::CHOOSE,
			'default'      => 'top',
			'options'      => [
				'left'  => [
					'title' => esc_html__( 'Left', 'edumall' ),
					'icon'  => 'eicon-h-align-left',
				],
				'top'   => [
					'title' => esc_html__( 'Top', 'edumall' ),
					'icon'  => 'eicon-v-align-top',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'edumall' ),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'prefix_class' => 'edumall-graphic-position-',
			'toggle'       => false,
			'condition'    => [
				'graphic_element!' => 'none',
			],
		] );

		$this->add_control( 'graphic_vertical_alignment', [
			'label'        => esc_html__( 'Vertical Alignment', 'edumall' ),
			'type'         => Controls_Manager::CHOOSE,
			'options'      => Widget_Utils::get_control_options_vertical_alignment(),
			'default'      => 'top',
			'prefix_class' => 'edumall-graphic-ver-align-',
			'condition'    => [
				'graphic_element!'  => 'none',
				'graphic_position!' => 'top',
			],
		] );

		$this->add_control( 'title_text', [
			'label'       => esc_html__( 'Title', 'edumall' ),
			'type'        => Controls_Manager::TEXTAREA,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_html__( 'Cool Number', 'edumall' ),
			'separator'   => 'before',
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
				'{{WRAPPER}} .edumall-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'selector' => '{{WRAPPER}} .edumall-box',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .edumall-box',
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
			'selector' => '{{WRAPPER}} .edumall-box:before',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

	private function add_number_style_section() {
		$this->start_controls_section( 'number_style_section', [
			'label' => esc_html__( 'Number', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'number',
			'selector' => '{{WRAPPER}} .counter-number-wrap',
			'global' => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->start_controls_tabs( 'number_colors' );

		$this->start_controls_tab( 'number_color_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'number',
			'selector' => '{{WRAPPER}} .counter-number-wrap',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'number_color_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'number_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .counter-number-wrap',
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

	private function add_title_style_section() {
		$this->start_controls_section( 'title_style_section', [
			'label' => esc_html__( 'Title', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .heading-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .counter-heading',
			'global' => [
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			],
		] );

		$this->start_controls_tabs( 'title_colors' );

		$this->start_controls_tab( 'title_color_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .counter-heading',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .counter-heading',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'box', 'class', 'edumall-box tm-counter' );

		if ( ! isset( $settings['ending_number'] ) ) {
			return;
		}

		$starting_number = isset( $settings['starting_number'] ) ? intval( $settings['starting_number'] ) : 0;
		$ending_number   = intval( $settings['ending_number'] );
		$duration        = isset( $settings['duration'] ) ? intval( $settings['duration'] ) : 2000;
		$separator_char  = '';

		if ( 'yes' === $settings['thousand_separator'] ) {
			$separator_char = ! empty( $settings['thousand_separator_char'] ) ? $settings['thousand_separator_char'] : ',';
		}

		$counter_options = [
			'from'      => $starting_number,
			'to'        => $ending_number,
			'duration'  => $duration,
			'separator' => $separator_char,
		];

		$this->add_render_attribute( 'box', 'data-counter', wp_json_encode( $counter_options ) );
		?>
		<div <?php $this->print_render_attribute_string( 'box' ); ?>>
			<?php if ( 'none' !== $settings['graphic_element'] ) : ?>
				<?php
				switch ( $settings['graphic_element'] ) {
					case 'image' :
						$this->print_graphic_image();
						break;
					case 'icon' :
						$this->print_graphic_icon();
						break;
				}
				?>
			<?php endif; ?>

			<div class="counter-content">
				<div class="counter-number-wrap">
					<span class="counter-number-prefix"><?php echo esc_html( $settings['prefix'] ); ?></span>
					<span class="counter-number"><?php echo esc_html( $starting_number ); ?></span>
					<span class="counter-number-suffix"><?php echo esc_html( $settings['suffix'] ); ?></span>
				</div>

				<?php $this->print_title(); ?>
			</div>
		</div>
		<?php
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

	private function print_title() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['title_text'] ) ) {
			return;
		}

		$title_text = wp_kses( $settings['title_text'], [
			'br'   => [],
			'span' => [
				'class' => [],
			],
			'mark' => [
				'class' => [],
			],
		] );

		$this->add_render_attribute( 'title', 'class', 'counter-heading' );
		?>
		<div class="heading-wrap">
			<?php printf( '<%1$s %2$s>%3$s</%1$s>', 'h3', $this->get_render_attribute_string( 'title' ), $title_text ); ?>
		</div>
		<?php
	}
}
