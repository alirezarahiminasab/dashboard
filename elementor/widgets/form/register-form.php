<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

class Widget_Register_Form extends Form_Base {

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		wp_register_script( 'validate', EDUMALL_THEME_URI . '/assets/libs/validate/jquery.validate.min.js', [ 'jquery' ], '1.17.0', true );

		wp_register_script( 'edumall-widget-register-form', EDUMALL_ELEMENTOR_URI . '/assets/js/widgets/widget-form-register.js', [
			'elementor-frontend',
			'validate',
		], null, true );

		$js_variables = array(
			'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
			'validatorMessages' => [
				'required'    => esc_html__( 'This field is required', 'edumall' ),
				'remote'      => esc_html__( 'Please fix this field', 'edumall' ),
				'email'       => esc_html__( 'A valid email address is required', 'edumall' ),
				'url'         => esc_html__( 'Please enter a valid URL', 'edumall' ),
				'date'        => esc_html__( 'Please enter a valid date', 'edumall' ),
				'dateISO'     => esc_html__( 'Please enter a valid date (ISO)', 'edumall' ),
				'number'      => esc_html__( 'Please enter a valid number.', 'edumall' ),
				'digits'      => esc_html__( 'Please enter only digits.', 'edumall' ),
				'creditcard'  => esc_html__( 'Please enter a valid credit card number', 'edumall' ),
				'equalTo'     => esc_html__( 'Please enter the same value again', 'edumall' ),
				'accept'      => esc_html__( 'Please enter a value with a valid extension', 'edumall' ),
				'maxlength'   => esc_html__( 'Please enter no more than {0} characters', 'edumall' ),
				'minlength'   => esc_html__( 'Please enter at least {0} characters', 'edumall' ),
				'rangelength' => esc_html__( 'Please enter a value between {0} and {1} characters long', 'edumall' ),
				'range'       => esc_html__( 'Please enter a value between {0} and {1}', 'edumall' ),
				'max'         => esc_html__( 'Please enter a value less than or equal to {0}', 'edumall' ),
				'min'         => esc_html__( 'Please enter a value greater than or equal to {0}', 'edumall' ),
			],
		);
		wp_localize_script( 'edumall-widget-register-form', '$edumallLogin', $js_variables );


	}

	public function get_script_depends() {
		return [ 'edumall-widget-register-form' ];
	}

	public function get_name() {
		return 'tm-register-form';
	}

	public function get_title() {
		return esc_html__( 'Register Form', 'edumall' );
	}

	public function get_keywords() {
		return [ 'register', 'form', 'sign-up' ];
	}

	protected function register_controls() {
		$this->add_content_section();

		$this->add_button_section();

		$this->add_field_style_section();

		$this->add_button_style_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'show_labels', [
			'label'        => esc_html__( 'Label', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_off'    => esc_html__( 'Hide', 'edumall' ),
			'label_on'     => esc_html__( 'Show', 'edumall' ),
			'prefix_class' => 'labels-',
			'render_type'  => 'template',
		] );

		$this->add_control( 'show_icons', [
			'label'        => esc_html__( 'Icon', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_off'    => esc_html__( 'Hide', 'edumall' ),
			'label_on'     => esc_html__( 'Show', 'edumall' ),
			'prefix_class' => 'icons-',
			'render_type'  => 'template',
		] );

		$this->end_controls_section();
	}

	private function add_button_section() {
		$this->start_controls_section( 'submit_section', [
			'label' => esc_html__( 'Button', 'edumall' ),
		] );

		$this->add_control( 'button_text', [
			'label'   => esc_html__( 'Text', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
			'default' => esc_html__( 'Sign Up', 'edumall' ),
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'form', [
			'class'  => 'register-form',
			'action' => '#',
			'method' => 'POST',
		] );

		$extra_class[] = ! empty( $settings['show_labels'] ) && 'yes' === $settings['show_labels'] ? 'labels-on' : 'labels-off';

		$show_icon = ! empty( $settings['show_icons'] ) && 'yes' === $settings['show_icons'] ? true : false;

		$extra_class[] = ! empty( $settings['show_icons'] ) && 'yes' === $settings['show_icons'] ? 'icons-on' : 'icons-off';

		$this->add_render_attribute( 'form', 'class', $extra_class );

		$button_text = $settings['button_text'];

		$form_id           = $this->get_id();
		$field_username_id = "field_username_$form_id";
		$field_email_id    = "field_email_$form_id";
		$field_password_id = "field_password_$form_id";
		?>
		<form <?php $this->print_render_attribute_string( 'form' ); ?>>
			<div class="form-group">
				<label for="<?php echo esc_attr( $field_username_id ); ?>"
				       class="form-label"><?php esc_html_e( 'Username', 'edumall' ); ?></label>
				<div class="form-input-group">
					<?php if ( $show_icon ) : ?>
						<span class="form-icon"><i class="fa-regular fa-user"></i></span>
					<?php endif; ?>
					<input type="text" id="<?php echo esc_attr( $field_username_id ); ?>"
					       class="form-control form-input"
					       name="username" placeholder="<?php esc_attr_e( 'Username', 'edumall' ); ?>"/>
				</div>
			</div>

			<div class="form-group">
				<label for="<?php echo esc_attr( $field_email_id ); ?>"
				       class="form-label"><?php esc_html_e( 'Email', 'edumall' ); ?></label>
				<div class="form-input-group">
					<?php if ( $show_icon ) : ?>
						<span class="form-icon"><i class="fa-regular fa-envelope"></i></span>
					<?php endif; ?>
					<input type="email" id="<?php echo esc_attr( $field_email_id ); ?>" class="form-control form-input"
					       name="email" placeholder="<?php esc_attr_e( 'Your Email', 'edumall' ); ?>"/>
				</div>
			</div>

			<div class="form-group">
				<label for="<?php echo esc_attr( $field_password_id ); ?>"
				       class="form-label"><?php esc_html_e( 'Password', 'edumall' ); ?></label>
				<div class="form-input-group form-input-password">
					<?php if ( $show_icon ) : ?>
						<span class="form-icon"><i class="fa-regular fa-key"></i></span>
					<?php endif; ?>
					<input type="password" id="<?php echo esc_attr( $field_password_id ); ?>"
					       class="form-control form-input"
					       name="password" placeholder="<?php esc_attr_e( 'Password', 'edumall' ); ?>">
				</div>
			</div>

			<div class="form-response-messages"></div>

			<div class="form-submit">
				<?php wp_nonce_field( 'edumall_elementor_widget_user_register', 'edumall_elementor_widget_user_register_nonce' ); ?>
				<input type="hidden" name="action" value="edumall_elementor_widget_user_register">
				<button type="submit" class="button button-submit"><?php echo esc_html( $button_text ); ?></button>
			</div>
		</form>
		<?php
	}
}
