<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Metabox' ) ) {
	class Edumall_Metabox {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'insight_core_meta_boxes', array( $this, 'register_meta_boxes' ) );
		}

		/**
		 * Register Metabox
		 *
		 * @param $meta_boxes
		 *
		 * @return array
		 */
		public function register_meta_boxes( $meta_boxes ) {
			$page_registered_sidebars = Edumall_Helper::get_registered_sidebars( true );

			$general_options = array(
				array(
					'title'  => esc_attr__( 'Layout', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'site_layout',
							'type'    => 'select',
							'title'   => esc_html__( 'Layout', 'edumall' ),
							'desc'    => esc_html__( 'Controls the layout of this page.', 'edumall' ),
							'options' => array(
								''      => esc_attr__( 'Default', 'edumall' ),
								'boxed' => esc_attr__( 'Boxed', 'edumall' ),
								'wide'  => esc_attr__( 'Wide', 'edumall' ),
							),
							'default' => '',
						),
						array(
							'id'    => 'site_width',
							'type'  => 'text',
							'title' => esc_html__( 'Site Width', 'edumall' ),
							'desc'  => esc_html__( 'Controls the site width for this page. Enter value including any valid CSS unit. For e.g: 1200px. Leave blank to use global setting.', 'edumall' ),
						),
						array(
							'id'    => 'site_top_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Site Top Spacing', 'edumall' ),
							'desc'  => esc_html__( 'Controls the top spacing of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'edumall' ),
						),
						array(
							'id'    => 'site_bottom_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Site Bottom Spacing', 'edumall' ),
							'desc'  => esc_html__( 'Controls the bottom spacing of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'edumall' ),
						),
						array(
							'id'    => 'site_class',
							'type'  => 'text',
							'title' => esc_html__( 'Body Class', 'edumall' ),
							'desc'  => esc_html__( 'Add a class name to body then refer to it in custom CSS.', 'edumall' ),
						),
					),
				),
				array(
					'title'  => esc_attr__( 'Background', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'site_background_message',
							'type'    => 'message',
							'title'   => esc_html__( 'Info', 'edumall' ),
							'message' => esc_html__( 'These options controls the background on boxed mode.', 'edumall' ),
						),
						array(
							'id'    => 'site_background_color',
							'type'  => 'color',
							'title' => esc_html__( 'Background Color', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background color of the outer background area in boxed mode of this page.', 'edumall' ),
						),
						array(
							'id'    => 'site_background_image',
							'type'  => 'media',
							'title' => esc_html__( 'Background Image', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background image of the outer background area in boxed mode of this page.', 'edumall' ),
						),
						array(
							'id'      => 'site_background_repeat',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Repeat', 'edumall' ),
							'desc'    => esc_html__( 'Controls the background repeat of the outer background area in boxed mode of this page.', 'edumall' ),
							'options' => array(
								'no-repeat' => esc_attr__( 'No repeat', 'edumall' ),
								'repeat'    => esc_attr__( 'Repeat', 'edumall' ),
								'repeat-x'  => esc_attr__( 'Repeat X', 'edumall' ),
								'repeat-y'  => esc_attr__( 'Repeat Y', 'edumall' ),
							),
						),
						array(
							'id'      => 'site_background_attachment',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Attachment', 'edumall' ),
							'desc'    => esc_html__( 'Controls the background attachment of the outer background area in boxed mode of this page.', 'edumall' ),
							'options' => array(
								''       => esc_attr__( 'Default', 'edumall' ),
								'fixed'  => esc_attr__( 'Fixed', 'edumall' ),
								'scroll' => esc_attr__( 'Scroll', 'edumall' ),
							),
						),
						array(
							'id'    => 'site_background_position',
							'type'  => 'text',
							'title' => esc_html__( 'Background Position', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background position of the outer background area in boxed mode of this page.', 'edumall' ),
						),
						array(
							'id'    => 'site_background_size',
							'type'  => 'text',
							'title' => esc_html__( 'Background Size', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background size of the outer background area in boxed mode of this page.', 'edumall' ),
						),
						array(
							'id'      => 'content_background_message',
							'type'    => 'message',
							'title'   => esc_html__( 'Info', 'edumall' ),
							'message' => esc_html__( 'These options controls the background of main content on this page.', 'edumall' ),
						),
						array(
							'id'    => 'content_background_color',
							'type'  => 'color',
							'title' => esc_html__( 'Background Color', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background color of main content on this page.', 'edumall' ),
						),
						array(
							'id'    => 'content_background_image',
							'type'  => 'media',
							'title' => esc_html__( 'Background Image', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background image of main content on this page.', 'edumall' ),
						),
						array(
							'id'      => 'content_background_repeat',
							'type'    => 'select',
							'title'   => esc_html__( 'Background Repeat', 'edumall' ),
							'desc'    => esc_html__( 'Controls the background repeat of main content on this page.', 'edumall' ),
							'options' => array(
								'no-repeat' => esc_attr__( 'No repeat', 'edumall' ),
								'repeat'    => esc_attr__( 'Repeat', 'edumall' ),
								'repeat-x'  => esc_attr__( 'Repeat X', 'edumall' ),
								'repeat-y'  => esc_attr__( 'Repeat Y', 'edumall' ),
							),
						),
						array(
							'id'    => 'content_background_position',
							'type'  => 'text',
							'title' => esc_html__( 'Background Position', 'edumall' ),
							'desc'  => esc_html__( 'Controls the background position of main content on this page.', 'edumall' ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Header', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'top_bar_type',
							'type'    => 'select',
							'title'   => esc_html__( 'Top Bar Type', 'edumall' ),
							'desc'    => esc_html__( 'Select top bar type that displays on this page.', 'edumall' ),
							'default' => '',
							'options' => Edumall_Top_Bar::instance()->get_list( true ),
						),
						array(
							'id'      => 'header_type',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Type', 'edumall' ),
							'desc'    => wp_kses(
								sprintf(
									__( 'Select header type that displays on this page. When you choose Default, the value in %s will be used.', 'edumall' ),
									'<a href="' . admin_url( '/customize.php?autofocus[section]=header' ) . '">Customize</a>'
								), 'edumall-a' ),
							'default' => '',
							'options' => Edumall_Header::instance()->get_list( true ),
						),
						array(
							'id'      => 'header_overlay',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Overlay', 'edumall' ),
							'default' => '',
							'options' => array(
								''  => esc_html__( 'Default', 'edumall' ),
								'0' => esc_html__( 'No', 'edumall' ),
								'1' => esc_html__( 'Yes', 'edumall' ),
							),
						),
						array(
							'id'      => 'header_skin',
							'type'    => 'select',
							'title'   => esc_attr__( 'Header Skin', 'edumall' ),
							'default' => '',
							'options' => array(
								''      => esc_html__( 'Default', 'edumall' ),
								'dark'  => esc_html__( 'Dark', 'edumall' ),
								'light' => esc_html__( 'Light', 'edumall' ),
							),
						),
						array(
							'id'      => 'menu_display',
							'type'    => 'select',
							'title'   => esc_html__( 'Primary menu', 'edumall' ),
							'desc'    => esc_html__( 'Select which menu displays on this page.', 'edumall' ),
							'default' => '',
							'options' => Edumall_Nav_Menu::get_all_menus(),
						),
						array(
							'id'      => 'menu_one_page',
							'type'    => 'switch',
							'title'   => esc_attr__( 'One Page Menu', 'edumall' ),
							'default' => '0',
							'options' => array(
								'0' => esc_attr__( 'Disable', 'edumall' ),
								'1' => esc_attr__( 'Enable', 'edumall' ),
							),
						),
						array(
							'id'      => 'custom_dark_logo',
							'type'    => 'media',
							'title'   => esc_html__( 'Custom Dark Logo', 'edumall' ),
							'desc'    => esc_html__( 'Select custom dark logo for this page.', 'edumall' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_light_logo',
							'type'    => 'media',
							'title'   => esc_html__( 'Custom Light Logo', 'edumall' ),
							'desc'    => esc_html__( 'Select custom light logo for this page.', 'edumall' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_logo_width',
							'type'    => 'text',
							'title'   => esc_html__( 'Custom Logo Width', 'edumall' ),
							'desc'    => esc_html__( 'Controls the width of logo. For e.g: 150px', 'edumall' ),
							'default' => '',
						),
						array(
							'id'      => 'custom_sticky_logo_width',
							'type'    => 'text',
							'title'   => esc_html__( 'Custom Sticky Logo Width', 'edumall' ),
							'desc'    => esc_html__( 'Controls the width of sticky logo. For e.g: 150px', 'edumall' ),
							'default' => '',
						),
					),
				),
				array(
					'title'  => esc_html__( 'Page Title Bar', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'page_title_bar_layout',
							'type'    => 'select',
							'title'   => esc_html__( 'Layout', 'edumall' ),
							'default' => '',
							'options' => Edumall_Title_Bar::instance()->get_list( true ),
						),
						array(
							'id'    => 'page_title_bar_bottom_spacing',
							'type'  => 'text',
							'title' => esc_html__( 'Spacing', 'edumall' ),
							'desc'  => esc_html__( 'Controls the bottom spacing of title bar of this page. Enter value including any valid CSS unit. For e.g: 50px. Leave blank to use global setting.', 'edumall' ),
						),
						array(
							'id'      => 'page_title_bar_background_color',
							'type'    => 'color',
							'title'   => esc_html__( 'Background Color', 'edumall' ),
							'default' => '',
						),
						array(
							'id'      => 'page_title_bar_background',
							'type'    => 'media',
							'title'   => esc_html__( 'Background Image', 'edumall' ),
							'default' => '',
						),
						array(
							'id'      => 'page_title_bar_background_overlay',
							'type'    => 'color',
							'title'   => esc_html__( 'Background Overlay', 'edumall' ),
							'default' => '',
						),
						array(
							'id'    => 'page_title_bar_custom_heading',
							'type'  => 'text',
							'title' => esc_html__( 'Custom Heading Text', 'edumall' ),
							'desc'  => esc_html__( 'Insert custom heading for the page title bar. Leave blank to use default.', 'edumall' ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Sidebars', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'page_sidebar_1',
							'type'    => 'select',
							'title'   => esc_html__( 'Sidebar 1', 'edumall' ),
							'desc'    => esc_html__( 'Select sidebar 1 that will display on this page.', 'edumall' ),
							'default' => 'default',
							'options' => $page_registered_sidebars,
						),
						array(
							'id'      => 'page_sidebar_2',
							'type'    => 'select',
							'title'   => esc_html__( 'Sidebar 2', 'edumall' ),
							'desc'    => esc_html__( 'Select sidebar 2 that will display on this page.', 'edumall' ),
							'default' => 'default',
							'options' => $page_registered_sidebars,
						),
						array(
							'id'      => 'page_sidebar_position',
							'type'    => 'switch',
							'title'   => esc_html__( 'Sidebar Position', 'edumall' ),
							'desc'    => wp_kses(
								sprintf(
									__( 'Select position of Sidebar 1 for this page. If sidebar 2 is selected, it will display on the opposite side. If you set as "Default" then the value in %s will be used.', 'edumall' ),
									'<a href="' . admin_url( '/customize.php?autofocus[section]=sidebars' ) . '">Customize -> Sidebar</a>'
								), 'edumall-a' ),
							'default' => 'default',
							'options' => Edumall_Helper::get_list_sidebar_positions( true ),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Sliders', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'revolution_slider',
							'type'    => 'select',
							'title'   => esc_html__( 'Revolution Slider', 'edumall' ),
							'desc'    => esc_html__( 'Select the unique name of the slider.', 'edumall' ),
							'options' => Edumall_Helper::get_list_revslider(),
						),
						array(
							'id'      => 'slider_position',
							'type'    => 'select',
							'title'   => esc_html__( 'Slider Position', 'edumall' ),
							'default' => 'below',
							'options' => array(
								'above' => esc_attr__( 'Above Header', 'edumall' ),
								'below' => esc_attr__( 'Below Header', 'edumall' ),
							),
						),
					),
				),
				array(
					'title'  => esc_html__( 'Footer', 'edumall' ),
					'fields' => array(
						array(
							'id'      => 'footer_enable',
							'type'    => 'select',
							'title'   => esc_html__( 'Footer Enable', 'edumall' ),
							'default' => '',
							'options' => array(
								''     => esc_html__( 'Yes', 'edumall' ),
								'none' => esc_html__( 'No', 'edumall' ),
							),
						),
					),
				),
			);

			// Page
			$meta_boxes[] = array(
				'id'         => 'insight_page_options',
				'title'      => esc_html__( 'Page Options', 'edumall' ),
				'post_types' => array( 'page' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => $general_options,
					),
				),
			);

			// Post
			$meta_boxes[] = array(
				'id'         => 'insight_post_options',
				'title'      => esc_html__( 'Page Options', 'edumall' ),
				'post_types' => array( 'post' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Post', 'edumall' ),
								'fields' => array(
									array(
										'id'    => 'post_gallery',
										'type'  => 'gallery',
										'title' => esc_html__( 'Gallery Format', 'edumall' ),
									),
									array(
										'id'    => 'post_video',
										'type'  => 'text',
										'title' => esc_html__( 'Video URL', 'edumall' ),
										'desc'  => esc_html__( 'Input the url of video vimeo or youtube. For e.g: https://www.youtube.com/watch?v=9No-FiEInLA', 'edumall' ),
									),
									array(
										'id'    => 'post_audio',
										'type'  => 'textarea',
										'title' => esc_html__( 'Audio Format', 'edumall' ),
									),
									array(
										'id'    => 'post_quote_text',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Text', 'edumall' ),
									),
									array(
										'id'    => 'post_quote_name',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Name', 'edumall' ),
									),
									array(
										'id'    => 'post_quote_url',
										'type'  => 'text',
										'title' => esc_html__( 'Quote Format - Source Url', 'edumall' ),
									),
									array(
										'id'    => 'post_link',
										'type'  => 'text',
										'title' => esc_html__( 'Link Format', 'edumall' ),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			// Product
			$meta_boxes[] = array(
				'id'         => 'insight_product_options',
				'title'      => esc_html__( 'Page Options', 'edumall' ),
				'post_types' => array( 'product' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Product', 'edumall' ),
								'fields' => array(
									array(
										'id'      => 'single_product_layout_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Single Product Style', 'edumall' ),
										'desc'    => esc_html__( 'Select style of this single product page.', 'edumall' ),
										'default' => '',
										'options' => array(
											''       => esc_html__( 'Default', 'edumall' ),
											'list'   => esc_html__( 'List', 'edumall' ),
											'slider' => esc_html__( 'Slider', 'edumall' ),
										),
									),
								),
							),
						), $general_options ),
					),
				),
			);

			// Portfolio
			$meta_boxes[] = array(
				'id'         => 'insight_portfolio_options',
				'title'      => esc_html__( 'Page Options', 'edumall' ),
				'post_types' => array( 'portfolio' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'type'  => 'tabpanel',
						'items' => array_merge( array(
							array(
								'title'  => esc_html__( 'Portfolio', 'edumall' ),
								'fields' => array(
									array(
										'id'      => 'portfolio_site_skin',
										'type'    => 'select',
										'title'   => esc_html__( 'Site Skin', 'edumall' ),
										'desc'    => esc_html__( 'Select skin of this single portfolio page.', 'edumall' ),
										'default' => '',
										'options' => array(
											''      => esc_html__( 'Default', 'edumall' ),
											'dark'  => esc_html__( 'Dark', 'edumall' ),
											'light' => esc_html__( 'Light', 'edumall' ),
										),
									),
									array(
										'id'      => 'portfolio_layout_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Single Portfolio Style', 'edumall' ),
										'desc'    => esc_html__( 'Select style of this single portfolio page.', 'edumall' ),
										'default' => '',
										'options' => array(
											''                => esc_html__( 'Default', 'edumall' ),
											'blank'           => esc_html__( 'Blank (Build with Elementor)', 'edumall' ),
											'image-list'      => esc_html__( 'Image List', 'edumall' ),
											'image-list-wide' => esc_html__( 'Image List - Wide', 'edumall' ),
										),
									),
									array(
										'id'      => 'portfolio_pagination_style',
										'type'    => 'select',
										'title'   => esc_html__( 'Pagination Style', 'edumall' ),
										'desc'    => esc_html__( 'Select style of pagination for this single portfolio page.', 'edumall' ),
										'default' => '',
										'options' => array(
											''     => esc_html__( 'Default', 'edumall' ),
											'none' => esc_html__( 'None', 'edumall' ),
											'01'   => esc_html__( '01', 'edumall' ),
											'02'   => esc_html__( '02', 'edumall' ),
											'03'   => esc_html__( '03', 'edumall' ),
										),
									),
									array(
										'id'    => 'portfolio_gallery',
										'type'  => 'gallery',
										'title' => esc_html__( 'Gallery', 'edumall' ),
									),
									array(
										'id'    => 'portfolio_video_url',
										'type'  => 'text',
										'title' => esc_html__( 'Video URL', 'edumall' ),
										'desc'  => esc_html__( 'Input the url of video vimeo or youtube. For e.g: https://www.youtube.com/watch?v=9No-FiEInLA', 'edumall' ),
									),
									array(
										'id'    => 'portfolio_client',
										'type'  => 'text',
										'title' => esc_html__( 'Client', 'edumall' ),
									),
									array(
										'id'    => 'portfolio_date',
										'type'  => 'text',
										'title' => esc_html__( 'Date', 'edumall' ),
									),
									array(
										'id'    => 'portfolio_url',
										'type'  => 'text',
										'title' => esc_html__( 'Url', 'edumall' ),
									),
									array(
										'id'      => 'portfolio_overlay_colored_faded_message',
										'type'    => 'message',
										'title'   => esc_html__( 'Info', 'edumall' ),
										'message' => esc_html__( 'These settings for Overlay Colored Faded Style.', 'edumall' ),
									),
									array(
										'id'    => 'portfolio_overlay_colored_faded_background',
										'type'  => 'color',
										'title' => esc_html__( 'Background Color', 'edumall' ),
										'desc'  => esc_html__( 'Controls the background color of overlay colored faded style.', 'edumall' ),
									),
									array(
										'id'      => 'portfolio_overlay_colored_faded_text_skin',
										'type'    => 'select',
										'title'   => esc_html__( 'Text Skin', 'edumall' ),
										'desc'    => esc_html__( 'Controls the text skin of overlay colored faded style.', 'edumall' ),
										'default' => 'light',
										'options' => array(
											'dark'  => esc_html__( 'Dark', 'edumall' ),
											'light' => esc_html__( 'Light', 'edumall' ),
										),
									),
								),
							),
						), $general_options ),
					),
				),
			);
			
			return $meta_boxes;
		}

	}

	Edumall_Metabox::instance()->initialize();
}
