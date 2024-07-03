<?php

namespace Edumall_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

defined( 'ABSPATH' ) || exit;

class Widget_Course_Tabs extends Base {

	private $tab_key = '';

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'edumall-widget-course-tabs', EDUMALL_ELEMENTOR_URI . '/assets/js/widgets/widget-course-tabs.js', array(
			'edumall-tab-panel',
			'edumall-swiper-wrapper',
			'elementor-frontend',
			'edumall-grid-layout',
			'edumall-grid-query',
		), null, true );
	}

	public function get_name() {
		return 'tm-course-tabs';
	}

	public function get_title() {
		return esc_html__( 'Course Tabs', 'edumall' );
	}

	public function get_icon_part() {
		return 'eicon-product-tabs';
	}

	public function get_keywords() {
		return [ 'course', 'tabs', 'course tabs' ];
	}

	protected function get_post_type() {
		return \Edumall_Tutor::instance()->get_course_type();
	}

	protected function get_post_category() {
		return \Edumall_Tutor::instance()->get_tax_category();
	}

	public function get_tab_key() {
		return $this->tab_key;
	}

	public function get_script_depends() {
		return [ 'edumall-widget-course-tabs' ];
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_course_tabs_section();

		$this->add_grid_section();

		$this->add_tabs_style_section();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'edumall' ),
		] );

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'grid'     => esc_html__( 'Grid', 'edumall' ),
				'carousel' => esc_html__( 'Carousel', 'edumall' ),
			],
			'default' => 'grid',
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

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'thumbnail_default_size!' => '1',
			],
		] );

		$this->add_control( 'title_collapse', [
			'label'        => esc_html__( 'Title Collapse', 'edumall' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'separator'    => 'before',
			'prefix_class' => 'course-title-collapse-',
		] );

		$this->add_control( 'tabs_style', [
			'label'        => esc_html__( 'Tabs Style', 'edumall' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => '01',
				'02' => '02',
			],
			'default'      => '01',
			'prefix_class' => 'course-tabs-style-',
		] );

		$this->end_controls_section();
	}

	protected function add_course_tabs_section() {
		$this->start_controls_section( 'course_tabs_section', [
			'label' => esc_html__( 'Course Tabs', 'edumall' ),
		] );

		$this->add_control( 'number_posts', [
			'label'       => esc_html__( 'Number posts', 'edumall' ),
			'description' => esc_html__( 'Select number of courses display on each of tab.', 'edumall' ),
			'type'        => Controls_Manager::NUMBER,
			'min'         => 1,
			'max'         => 30,
			'step'        => 1,
			'default'     => 10,
		] );

		$source_options = [
			'latest'      => esc_html__( 'All Courses (Latest)', 'edumall' ),
			'trending'    => esc_html__( 'Trending Courses', 'edumall' ),
			'popular'     => esc_html__( 'Popular Courses', 'edumall' ),
			'featured'    => esc_html__( 'Featured Courses', 'edumall' ),
			'by_category' => esc_html__( 'By Category', 'edumall' ),
		];

		$categories = get_terms( [
			'taxonomy'   => $this->get_post_category(),
			'parent'     => 0,
			'hide_empty' => 0,
		] );

		$category_options = [];

		foreach ( $categories as $category ) {
			$category_options[ $category->term_id ] = $category->name;
		}

		$repeater = new Repeater();

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Tab Title', 'edumall' ),
			'type'        => Controls_Manager::TEXT,
			'description' => esc_html__( 'Leave blank to use default.', 'edumall' ),
		] );

		$repeater->add_control( 'query_source', [
			'label'   => esc_html__( 'Source', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => $source_options,
			'default' => 'latest',
		] );

		$repeater->add_control( 'category', [
			'label'     => esc_html__( 'Category', 'edumall' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => $category_options,
			'condition' => [
				'query_source' => 'by_category',
			],
		] );

		$this->add_control( 'tabs', [
			'label'       => esc_html__( 'Course Tabs', 'edumall' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => "{{{ title || EdumallElementor.helpers.getRepeaterSelectOptionText('tm-course-tabs', 'tabs', 'query_source', query_source) }}}",
			'default'     => [
				[
					'title'        => esc_html__( 'All', 'edumall' ),
					'query_source' => 'latest',
				],
			],
		] );

		$this->end_controls_section();
	}

	private function add_grid_section() {
		$this->start_controls_section( 'grid_options_section', [
			'label'     => esc_html__( 'Grid Options', 'edumall' ),
			'condition' => [
				'layout' => 'grid',
			],
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'              => esc_html__( 'Columns', 'edumall' ),
			'type'               => Controls_Manager::NUMBER,
			'min'                => 1,
			'max'                => 12,
			'step'               => 1,
			'default'            => 4,
			'tablet_default'     => 3,
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

		$this->end_controls_section();
	}

	private function add_tabs_style_section() {
		$this->start_controls_section( 'course_tabs_style_section', [
			'label' => esc_html__( 'Tabs Style', 'edumall' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'nav_tab_text_align', [
			'label'                => esc_html__( 'Alignment', 'edumall' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align(),
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'default'              => '',
			'selectors'            => [
				'{{WRAPPER}} .edumall-nav-tabs' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'nav_tab_item_padding', [
			'label'      => esc_html__( 'Item Padding', 'edumall' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'nav_tab_item_typography',
			'label'    => esc_html__( 'Item Typography', 'edumall' ),
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li a',
		] );

		$this->start_controls_tabs( 'nav_colors_tabs' );

		$this->start_controls_tab( 'nav_colors_normal', [
			'label' => esc_html__( 'Normal', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'nav_title',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs > li > a',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'nav_background',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs > li > a',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'nav_colors_hover', [
			'label' => esc_html__( 'Hover', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_nav_title',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li a:hover',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'hover_nav_background',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li a:hover',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'nav_colors_active', [
			'label' => esc_html__( 'Active', 'edumall' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'active_nav_title',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li.active a',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'active_nav_background',
			'selector' => '{{WRAPPER}} .edumall-tabpanel > .edumall-nav-tabs li.active a',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['tabs'] ) ) {
			return;
		}

		$course_tabs  = $settings['tabs'];
		$layout       = $settings['layout'];
		$number_posts = $settings['number_posts'];

		$tabs_key = 'course_tabs';

		$this->add_render_attribute( $tabs_key, 'class', 'edumall-tabpanel edumall-tabpanel-horizontal course-tabs-style-' . $settings['tabs_style'] );
		?>
		<div <?php $this->print_render_attribute_string( $tabs_key ); ?>>
			<ul class="edumall-nav-tabs">
				<?php $loop_count = 0; ?>
				<?php foreach ( $course_tabs as $key => $course_tab ) : ?>
					<?php
					$tab_key       = "nav_tab_{$key}_";
					$this->tab_key = $tab_key;
					$loop_count ++;

					$this->add_render_attribute( $tab_key, 'role', 'tab' );

					if ( 1 === $loop_count ) {
						$this->add_render_attribute( $tab_key, 'class', 'active' );
					}
					?>
					<li <?php $this->print_render_attribute_string( $tab_key ); ?>>
						<a href="javascript:void(0);">
							<span class="nav-tab-title"><?php echo '' . $this->get_tab_title( $course_tab ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="edumall-tab-content">
				<?php $loop_count = 0; ?>
				<?php foreach ( $course_tabs as $key => $course_tab ) : ?>
					<?php
					$tab_key       = "content_tab_{$key}_";
					$this->tab_key = $tab_key;
					$source        = $course_tab['query_source'];
					$loop_count ++;

					$query = [
						'source' => $source,
						'number' => $number_posts,
						'layout' => $layout,
					];

					if ( 'by_category' === $source ) {
						$query['term_id'] = $course_tab['category'];
					}

					$this->add_render_attribute( $tab_key, 'class', 'tab-panel' );

					if ( 1 === $loop_count ) {
						$this->add_render_attribute( $tab_key, 'class', 'active' );
					}

					$this->add_render_attribute( $tab_key, 'data-query', wp_json_encode( $query ) );
					$this->add_render_attribute( $tab_key, 'data-layout', $layout );
					?>
					<div <?php $this->print_render_attribute_string( $tab_key ); ?>>
						<div class="tab-mobile-heading">
							<?php echo '' . $this->get_tab_title( $course_tab ); ?>
						</div>
						<div class="tab-content">
							<?php if ( 'grid' === $layout ) : ?>
								<?php $this->print_grid(); ?>
							<?php else: ?>
								<?php $this->print_slider(); ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	private function get_tab_title( $tab ) {
		if ( ! empty( $tab['title'] ) ) {
			return $tab['title'];
		}

		$text = '';

		switch ( $tab['query_source'] ) {
			case 'latest' :
				$text = esc_html__( 'All', 'edumall' );
				break;
			case 'trending' :
				$text = esc_html__( 'Trending', 'edumall' );
				break;
			case 'popular' :
				$text = esc_html__( 'Popularity', 'edumall' );
				break;
			case 'featured' :
				$text = esc_html__( 'Featured', 'edumall' );
				break;
			case 'by_category' :
				$term = get_term_by( 'id', $tab['category'], $this->get_post_category() );
				if ( ! empty( $term ) ) {
					$text = $term->name;
				}

				break;
		}

		return $text;
	}

	private function print_skeleton_loading_item() {
		?>
		<div class="edumall-skeleton-card style-01">
			<div class="edumall-skeleton-item edumall-skeleton-image"></div>
			<div class="edumall-skeleton-item edumall-skeleton-title"></div>
			<div
				class="edumall-skeleton-item edumall-skeleton-description"></div>
		</div>
		<?php
	}

	private function print_slider() {
		$settings     = $this->get_settings_for_display();
		$number_posts = $settings['number_posts'];
		?>
		<div
			class="tm-tab-course-element tm-swiper v-stretch bullets-v-align-below nav-style-01 pagination-style-01 edumall-courses style-carousel-02"
			data-lg-items="auto"
			data-lg-gutter="30"
			data-nav="1"
			data-loop="0"
		>
			<div class="swiper-inner">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php for ( $i = $number_posts; $i > 0; $i -- ): ?>
							<div class="swiper-slide">
								<?php $this->print_skeleton_loading_item(); ?>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="edumall-grid-response-messages"></div>
		<?php
	}

	private function print_grid() {
		$settings     = $this->get_settings_for_display();
		$number_posts = $settings['number_posts'];

		$grid_key = $this->get_tab_key() . '_grid';

		$grid_options = $this->get_grid_options( $settings );

		$this->add_render_attribute( $grid_key, 'class', 'tm-tab-course-element tm-grid-wrapper edumall-courses style-grid-02' );
		$this->add_render_attribute( $grid_key, 'data-grid', wp_json_encode( $grid_options ) );
		?>
		<div <?php $this->print_render_attribute_string( $grid_key ); ?>>
			<div class="edumall-grid lazy-grid">
				<div class="grid-sizer"></div>
				<?php for ( $i = $number_posts; $i > 0; $i -- ): ?>
					<div class="grid-item grid-skeleton-item">
						<?php $this->print_skeleton_loading_item(); ?>
					</div>
				<?php endfor; ?>
			</div>
			<div class="edumall-grid-response-messages"></div>
		</div>
		<?php
	}

	private function get_grid_options( array $settings ) {
		$grid_options = [
			'type' => 'grid',
		];

		// Columns.
		if ( ! empty( $settings['grid_columns'] ) ) {
			$grid_options['columns'] = $settings['grid_columns'];
		}

		if ( ! empty( $settings['grid_columns_tablet'] ) ) {
			$grid_options['columnsTablet'] = $settings['grid_columns_tablet'];
		}

		if ( ! empty( $settings['grid_columns_mobile'] ) ) {
			$grid_options['columnsMobile'] = $settings['grid_columns_mobile'];
		}

		// Gutter
		if ( ! empty( $settings['grid_gutter'] ) ) {
			$grid_options['gutter'] = $settings['grid_gutter'];
		}

		if ( ! empty( $settings['grid_gutter_tablet'] ) ) {
			$grid_options['gutterTablet'] = $settings['grid_gutter_tablet'];
		}

		if ( ! empty( $settings['grid_gutter_mobile'] ) ) {
			$grid_options['gutterMobile'] = $settings['grid_gutter_mobile'];
		}

		return $grid_options;
	}
}
