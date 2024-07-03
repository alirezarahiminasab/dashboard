<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined( 'ABSPATH' ) || exit;

class Widget_Team_Member_Carousel extends Static_Carousel {

	public function get_name() {
		return 'tm-team-member-carousel';
	}

	public function get_title() {
		return esc_html__( 'Team Member Carousel', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'team', 'member', 'avatar', 'carousel' ];
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_image_style_section();

		$this->add_content_style_section();

		$this->update_controls();

		parent::register_controls();
	}

	private function update_controls() {
		$this->update_control( 'slides', [
			'title_field' => '{{{ name }}}',
		] );
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
			],
			'default' => '01',
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

		$this->end_controls_section();
	}

	private function add_image_style_section() {
		$this->start_controls_section( 'images_style_section', [
			'label' => esc_html__( 'Images', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'images_effects' );

		$this->start_controls_tab( 'images_effects_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .edumall-image img',
		] );

		$this->add_control( 'images_opacity', [
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

		$this->start_controls_tab( 'images_effects_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}} .edumall-box:hover .edumall-image img',
		] );

		$this->add_control( 'images_opacity_hover', [
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

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => esc_html__( 'Content', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'content_alignment', [
			'label'                => esc_html__( 'Alignment', 'edumall' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .tm-team-member.edumall-box' => 'justify-content: {{VALUE}}',
			],
		] );

		$this->add_control( 'content_text_align', [
			'label'                => esc_html__( 'Text Align', 'edumall' ),
			'label_block'          => false,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align(),
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'prefix_class'         => 'align-',
			'selectors'            => [
				'{{WRAPPER}} .tm-team-member.edumall-box' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_control( 'rounded', [
			'label'      => esc_html__( 'Rounded', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .tm-team-member.edumall-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => '02',
			],
		] );

		$this->add_control( 'name_heading', [
			'label'     => esc_html__( 'Name', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'name_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .name' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .name',
		] );

		$this->add_control( 'position_heading', [
			'label'     => esc_html__( 'Position', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'position_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .position' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'position_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .position',
		] );

		$this->add_control( 'content_heading', [
			'label'     => esc_html__( 'Content', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'content_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'content_typography',
			'label'    => esc_html__( 'Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .description',
		] );

		$this->add_responsive_control( 'content_margin', [
			'label'      => esc_html__( 'Margin', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'rating_heading', [
			'label'     => esc_html__( 'Rating', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'star_empty_color', [
			'label'     => esc_html__( 'Star Empty Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-star-half:after, {{WRAPPER}} .tm-star-empty:before' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'star_full_color', [
			'label'     => esc_html__( 'Star Full Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-star-half:before, {{WRAPPER}} .tm-star-full:before' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_heading', [
			'label'     => esc_html__( 'Button', 'edumall' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'text',
			'selector' => '{{WRAPPER}} .tm-button',
		] );

		$this->start_controls_tabs( 'text_style_tabs' );

		$this->start_controls_tab( 'text_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_control( 'btn_bgr_color', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button a' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'btn_border_color', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button a' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'btn_color', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button .tm-button.style-border' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'text_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_control( 'btn_bgr_hover', [
			'label'     => esc_html__( 'Background Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button a:after, .course a:before' => 'background-color: {{VALUE}} ;',
			],
		] );

		$this->add_control( 'btn_border_hover', [
			'label'     => esc_html__( 'Border Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button a:hover' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'btn_color_hover', [
			'label'     => esc_html__( 'Color', 'edumall' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .course-button .tm-button.style-border:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function add_repeater_controls( Repeater $repeater ) {
		$repeater->add_control( 'name', [
			'label'   => esc_html__( 'Name', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'John Doe', 'edumall' ),
		] );

		$repeater->add_control( 'content', [
			'label' => esc_html__( 'Content', 'edumall' ),
			'type'  => Controls_Manager::TEXTAREA,
		] );

		$repeater->add_control( 'image', [
			'label' => esc_html__( 'Image', 'edumall' ),
			'type'  => Controls_Manager::MEDIA,
		] );

		$repeater->add_control( 'position', [
			'label'   => esc_html__( 'Position', 'edumall' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO', 'edumall' ),
		] );

		$repeater->add_control( 'profile', [
			'label'         => esc_html__( 'Profile', 'edumall' ),
			'type'          => Controls_Manager::URL,
			'placeholder'   => esc_html__( 'https://your-link.com', 'edumall' ),
			'show_external' => true,
			'default'       => [
				'url'         => '',
				'is_external' => true,
				'nofollow'    => true,
			],
		] );

		$repeater->add_control( 'course', [
			'label' => esc_html__( 'Button', 'edumall' ),
			'type'  => Controls_Manager::TEXT,
		] );

		$repeater->add_control( 'rating', [
			'label' => esc_html__( 'Rating', 'edumall' ),
			'type'  => Controls_Manager::NUMBER,
			'min'   => 0,
			'max'   => 5,
			'step'  => 0.1,
		] );

		$repeater->add_control( 'total_rating', [
			'label' => esc_html__( 'Total Rating', 'edumall' ),
			'type'  => Controls_Manager::NUMBER,
		] );

		$repeater->add_control( 'socials', [
			'label'       => esc_html__( 'Socials', 'edumall' ),
			'description' => esc_html__( 'One social per line. Icon class & url separator with |. For eg: fa-brands fa-facebook|https://facebook.com', 'edumall' ),
			'type'        => Controls_Manager::TEXTAREA,
		] );
	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		return [
			[
				'name'     => 'Frankie Kao',
				'position' => 'CEO',
				'image'    => [ 'url' => $placeholder_image_src ],
			],
			[
				'name'     => 'Frankie Kao',
				'position' => 'CEO',
				'image'    => [ 'url' => $placeholder_image_src ],
			],
			[
				'name'     => 'Frankie Kao',
				'position' => 'CEO',
				'image'    => [ 'url' => $placeholder_image_src ],
			],
		];
	}

	protected function before_slider() {
		/**
		 * Add more attrs to slider.
		 */
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( self::SLIDER_KEY, 'class', 'edumall-courses style-carousel-' . $settings['style'] );
	}

	protected function print_slide() {
		$settings      = $this->get_settings_for_display();
		$slide         = $this->get_current_slide();
		$current_key   = $this->get_current_key();
		$item_link_key = $current_key . '_link';

		if ( ! empty( $slide['profile']['url'] ) ) {
			$this->add_link_attributes( $item_link_key, $slide['profile'] );
		}
		?>
		<div class="tm-team-member edumall-box">
			<div class="item">
				<?php if ( $slide['image']['url'] ) : ?>
					<div class="photo edumall-image">
						<?php echo \Edumall_Image::get_elementor_attachment( [
							'settings'       => $slide,
							'image_size_key' => 'image_size',
						] ); ?>

						<div class="overlay"></div>

						<?php if ( '01' === $settings['style'] ) : ?>
							<?php $this->print_socials(); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="info">
					<h3 class="name">
						<?php if ( ! empty( $slide['profile']['url'] ) ) { ?>
							<a <?php $this->print_render_attribute_string( $item_link_key ); ?>><?php echo esc_html( $slide['name'] ); ?></a>
						<?php } else {
							echo esc_html( $slide['name'] );
						} ?>
					</h3>

					<?php if ( '02' === $settings['style'] ) : ?>
						<?php $this->print_socials(); ?>
					<?php endif; ?>

					<?php if ( ! empty( $slide['position'] ) ) : ?>
						<div class="position"><?php echo esc_html( $slide['position'] ); ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $slide['content'] ) ) : ?>
						<div class="description">
							<?php echo wp_kses( $slide['content'], 'edumall-default' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $slide['rating'] ) ): ?>
						<?php echo \Edumall_Templates::render_rating( $slide['rating'], [ 'wrapper_class' => 'team-member-rating' ] ); ?>

						<?php if ( ! empty( $slide['total_rating'] ) ) : ?>
							<span class="rating member-rating">
								<?php echo '(' . esc_html( $slide['total_rating'] ) . ')'; ?>
							</span>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( ! empty( $slide['course'] ) ) : ?>
						<div class="course-button">
							<a class="tm-button style-border" <?php $this->print_render_attribute_string( $item_link_key ); ?>>
								<span class="button-text"><?php echo esc_html( $slide['course'] ); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function print_socials() {
		$slide = $this->get_current_slide();

		if ( empty( $slide['socials'] ) ) {
			return;
		}

		$socials = explode( "\n", str_replace( "\r", "", $slide['socials'] ) );
		?>
		<div class="social-networks">
			<div class="inner">
				<?php
				foreach ( $socials as $social ) {
					$item = explode( '|', $social );
					if ( empty( $item ) || count( $item ) < 2 ) {
						continue;
					}
					$icon_class = $item[0];
					$url        = $item[1];
					?>
					<a href="<?php esc_url( $url ); ?>" target="_blank" rel="nofollow">
						<span class="link-icon <?php echo esc_attr( $icon_class ); ?>"></span>
					</a>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'wrapper', 'class', 'tm-team-member-carousel style-' . $settings['style'] );
		?>
		<div <?php $this->print_attributes_string( 'wrapper' ); ?>>
			<?php $this->print_slider(); ?>
		</div>
		<?php
	}
}
