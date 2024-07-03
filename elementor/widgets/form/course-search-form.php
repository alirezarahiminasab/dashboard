<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

class Widget_Course_Search_Form extends Base {

	public function get_name() {
		return 'tm-course-search-form';
	}

	public function get_title() {
		return esc_html__( 'Course Search Form', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-form-horizontal';
	}

	public function get_keywords() {
		return [ 'course', 'form', 'search' ];
	}

	protected function register_controls() {
		$this->add_content_section();

		$this->add_field_style_section();

		$this->add_button_style_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => '01',
			],
			'default'      => '01',
			'prefix_class' => 'style-',
		] );

		$this->add_control( 'search_field_placeholder', [
			'label'       => esc_html__( 'Placeholder Text', 'edumall' ),
			'description' => esc_html__( 'Leave blank to use default.', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
		] );

		$this->end_controls_section();
	}

	private function add_field_style_section() {
		$this->start_controls_section( 'form_field_style_section', [
			'label' => esc_html__( 'Field', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'field_padding', [
			'label'      => esc_html__( 'Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'field_border_width', [
			'label'       => esc_html__( 'Border Width', 'edumall' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'placeholder' => '1',
			'size_units'  => [ 'px' ],
			'selectors'   => [
				'{{WRAPPER}} .form-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'field_border_radius', [
			'label'       => esc_html__( 'Border Width', 'edumall' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'placeholder' => '5',
			'size_units'  => [ 'px', '%' ],
			'selectors'   => [
				'{{WRAPPER}} .form-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'field_colors_tabs' );

		$this->start_controls_tab( 'field_colors_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'field_text_color', [
			'label'     => esc_html__( 'Text Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'field_background_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'field_border_color', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input' => 'border-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'field_colors_focus_tab', [
			'label' => esc_html__( 'Focus', 'edumall' ),
		] );

		$this->add_control( 'field_text_focus_color', [
			'label'     => esc_html__( 'Text Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input:focus' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'field_background_focus_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input:focus' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'field_border_focus_color', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .form-input:focus' => 'border-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_button_style_section() {
		$this->start_controls_section( 'form_button_style_section', [
			'label' => esc_html__( 'Button', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => esc_html__( 'Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'button_border_width', [
			'label'       => esc_html__( 'Border Width', 'edumall' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'placeholder' => '1',
			'size_units'  => [ 'px' ],
			'selectors'   => [
				'{{WRAPPER}} button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'button_border_radius', [
			'label'       => esc_html__( 'Border Width', 'edumall' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'placeholder' => '5',
			'size_units'  => [ 'px', '%' ],
			'selectors'   => [
				'{{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'button_colors_tabs' );

		$this->start_controls_tab( 'button_colors_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'button_text_color', [
			'label'     => esc_html__( 'Text Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_border_color', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_background_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button' => 'background-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_colors_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'button_text_hover_color', [
			'label'     => esc_html__( 'Text Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_border_hover_color', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button:hover' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_background_hover_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button:hover' => 'background-color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function get_html_wrapper_class() {
		return 'edumall-widget-course-search-form';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$placeholder_text = ! empty( $settings['search_field_placeholder'] ) ? $settings['search_field_placeholder'] : esc_attr_x( 'What do you want to learn?', 'placeholder', 'edumall' );

		$this->add_render_attribute( 'input', [
			'placeholder' => $placeholder_text,
			'class'       => 'search-field form-input',
			'type'        => 'search',
			'name'        => 'filter_name',
			'title'       => esc_attr__( 'Search', 'edumall' ),
			'value'       => '',
		] );

		$form_action = get_post_type_archive_link( \Edumall_Tutor::instance()->get_course_type() );
		?>
		<form class="course-search-form" role="search" method="get"
		      action="<?php echo esc_url( $form_action ); ?>">
			<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'edumall' ); ?></label>
			<input <?php $this->print_render_attribute_string( 'input' ); ?>/>
			<button type="submit" class="search-submit">
				<span class="search-btn-icon fa-regular fa-search"></span>
				<span class="search-btn-text">
					<?php echo esc_html_x( 'Search', 'submit button', 'edumall' ); ?>
				</span>
			</button>
		</form>
		<?php
	}
}
