<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

class Widget_Mailchimp_Form extends Form_Base {

	public function get_name() {
		return 'tm-mailchimp-form';
	}

	public function get_title() {
		return esc_html__( 'Mailchimp Form', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-form-horizontal';
	}

	public function get_keywords() {
		return [ 'mailchimp', 'form', 'subscribe' ];
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

		$this->add_control( 'form_id', [
			'label'       => esc_html__( 'Form Id', 'edumall' ),
			'description' => esc_html__( 'Input the id of form. Leave blank to show default form.', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
		] );

		$this->add_control( 'style', [
			'label'        => esc_html__( 'Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => '01',
				'02' => '02',
			],
			'default'      => '01',
			'prefix_class' => 'edumall-mailchimp-form-style-',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$form_id  = ! empty( $settings['form_id'] ) ? $settings['form_id'] : '';


		if ( '' === $form_id && function_exists( 'mc4wp_get_forms' ) ) {
			$mc_forms = mc4wp_get_forms();
			if ( count( $mc_forms ) > 0 ) {
				$form_id = $mc_forms[0]->ID;
			}
		}

		$this->add_render_attribute( 'box', 'class', 'edumall-mailchimp-form' );
		?>
		<?php if ( function_exists( 'mc4wp_show_form' ) && $form_id !== '' ) : ?>
			<div <?php $this->print_render_attribute_string( 'box' ) ?>>
				<?php mc4wp_show_form( $form_id ); ?>
			</div>
		<?php endif; ?>
		<?php
	}
}
