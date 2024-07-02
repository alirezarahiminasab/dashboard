<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;

defined('ABSPATH') || exit;

class Widget_Carousel_Nav_Buttons extends Base
{

	public function get_name()
	{
		return 'tm-carousel-nav-buttons';
	}

	public function get_title()
	{
		return esc_html__('Carousel Nav Buttons', 'edumall-child');
	}

	public function get_icon_part()
	{
		return 'eicon-posts-carousel';
	}

	public function get_keywords()
	{
		return ['carousel', 'slider'];
	}


	protected function register_controls()
	{
		$this->add_layout_section();
	}

	private function add_layout_section()
	{
		$this->start_controls_section('layout_section', [
			'label' => esc_html__('Layout', 'edumall-child'),
		]);

		$this->add_control('style', [
			'label'   => esc_html__('Style', 'edumall-child'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => esc_html__('01', 'edumall-child'),
			],
			'default' => '01',
		]);

		$this->add_control('button_id', [
			'label'       => esc_html__('Button ID', 'edumall-child'),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => '',
			'title'       => esc_html__('Add your custom id WITHOUT the Pound key. e.g: my-id', 'edumall-child'),
			'label_block' => false,
			'description' => wp_kses(__('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'edumall-child'), 'edumall-default'),
			'separator'   => 'before',
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('slider-button', [
			'class' => 'edumall-slider-buttons style-' . $settings['style'],
			'id'    => $settings['button_id'],
		]);
?>
		<div <?php $this->print_render_attribute_string('slider-button'); ?>>
			<div class="button-wrap">
				<div class="slider-btn slider-prev-btn">
					<span class="fas fa-angle-left"></span>
				</div>
				<div class="slider-btn slider-next-btn">
					<span class="fas fa-angle-right"></span>
				</div>
			</div>
		</div>
<?php
	}
}
