<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue custom styles.
 */
if ( ! class_exists( 'Edumall_Custom_Css' ) ) {
	class Edumall_Custom_Css {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_enqueue_scripts', [ $this, 'frontend_root_css' ] );

			add_action( 'wp_enqueue_scripts', [ $this, 'extra_css' ] );
		}

		public function get_root_css( $skin = '' ) {
			$primary_color     = Edumall::setting( 'primary_color' );
			$primary_color_rgb = Edumall_Color::hex2rgb_string( $primary_color );
			$secondary_color   = Edumall::setting( 'secondary_color' );
			$secondary_color_rgb = Edumall_Color::hex2rgb_string( $secondary_color );
			$third_color       = Edumall::setting( 'third_color' );

			if ( empty( $skin ) ) {
				$skin = Edumall_Global::instance()->get_site_skin();
			}

			if ( 'dark' === $skin ) {
				$form_colors            = Edumall::setting( 'dark_form_input_color' );
				$form_focus_colors      = Edumall::setting( 'dark_form_input_focus_color' );
				$text_color             = Edumall::setting( 'dark_body_color' );
				$text_bit_lighten_color = '#B3B6BB';
				$text_lighten_color     = Edumall::setting( 'dark_body_lighten_color' );
				$heading_color          = Edumall::setting( 'dark_heading_color' );
				$link_color             = Edumall::setting( 'dark_link_color' );
				$box_white_border       = '#031F42';
				$box_white_bg           = '#031F42';
				$box_grey_bg            = '#031F42';
				$box_light_grey_bg      = '#031F42';
				$box_separator          = 'rgba(255, 255, 255, 0.15)';
				$box_border             = 'rgba(230, 233, 236, 0.2)';
				$box_border_lighten     = 'rgba(230, 233, 236, 0.2)';
				$sub_menu_background    = Edumall::setting( 'navigation_dark_dropdown_bg_color' );
				$sub_menu_border        = '#2B3643';
			} else {
				$form_colors            = Edumall::setting( 'form_input_color' );
				$form_focus_colors      = Edumall::setting( 'form_input_focus_color' );
				$text_color             = Edumall::setting( 'body_color' );
				$text_bit_lighten_color = '#7e7e7e';
				$text_lighten_color     = Edumall::setting( 'body_lighten_color' );
				$heading_color          = Edumall::setting( 'heading_color' );
				$link_color             = Edumall::setting( 'link_color' );
				$box_white_border       = '#ededed';
				$box_white_bg           = '#fff';
				$box_grey_bg            = '#f8f8f8';
				$box_light_grey_bg      = '#f9f9fb';
				$box_separator          = '#eee';
				$box_border             = '#eee';
				$box_border_lighten     = '#ededed';
				$sub_menu_background    = Edumall::setting( 'navigation_dropdown_bg_color' );
				$sub_menu_border        = '#ededed';
			}

			$form_text             = $form_colors['color'];
			$form_border           = $form_colors['border'];
			$form_background       = $form_colors['background'];
			$form_focus_text       = $form_focus_colors['color'];
			$form_focus_border     = $form_focus_colors['border'];
			$form_focus_background = $form_focus_colors['background'];

			$body_font        = Edumall::setting( 'typography_body' );
			$body_font_weight = $body_font['variant'];
			$body_font_weight = 'regular' === $body_font_weight ? 400 : $body_font_weight; // Fix regular is not valid weight.

			$heading_font = Edumall::setting( 'typography_heading' );

			$heading_font_family = '' === $heading_font['font-family'] ? 'inherit' : $heading_font['font-family'];
			$heading_font_weight = $heading_font['variant'];
			$heading_font_weight = 'regular' === $heading_font_weight ? 400 : $heading_font_weight; // Fix regular is not valid weight.

			$css = ":root {
				--edumall-typography-body-font-family: {$body_font['font-family']};
				--edumall-typography-body-font-size: {$body_font['font-size']};
				--edumall-typography-body-font-weight: {$body_font_weight};
				--edumall-typography-body-line-height: {$body_font['line-height']};
				--edumall-typography-body-letter-spacing: {$body_font['letter-spacing']};
				--edumall-typography-headings-font-family: {$heading_font_family};
				--edumall-typography-headings-font-weight: {$heading_font_weight};
				--edumall-typography-headings-line-height: {$heading_font['line-height']};
				--edumall-typography-headings-letter-spacing: {$heading_font['letter-spacing']};
				--edumall-color-primary: {$primary_color};
				--edumall-color-primary-rgb: {$primary_color_rgb};
				--edumall-color-secondary: {$secondary_color};
				--edumall-color-secondary-rgb: {$secondary_color_rgb};
				--edumall-color-third: {$third_color};
				--edumall-color-text: {$text_color};
				--edumall-color-text-bit-lighten: {$text_bit_lighten_color};
				--edumall-color-text-lighten: {$text_lighten_color};
				--edumall-color-heading: {$heading_color};
				--edumall-color-link: {$link_color['normal']};
				--edumall-color-link-hover: {$link_color['hover']};
				--edumall-color-box-white-background: {$box_white_bg};
				--edumall-color-box-white-border: {$box_white_border};
				--edumall-color-box-grey-background: {$box_grey_bg};
				--edumall-color-box-light-grey-background: {$box_light_grey_bg};
				--edumall-color-box-fill-separator: {$box_separator};
				--edumall-color-box-border: {$box_border};
				--edumall-color-box-border-lighten: {$box_border_lighten};
				--edumall-color-form-text: {$form_text};
				--edumall-color-form-border: {$form_border};
				--edumall-color-form-background: {$form_background};
				--edumall-color-form-focus-text: {$form_focus_text};
				--edumall-color-form-focus-border: {$form_focus_border};
				--edumall-color-form-focus-background: {$form_focus_background};
				--edumall-color-sub-menu-border: {$sub_menu_border};
				--edumall-color-sub-menu-background: {$sub_menu_background};
				--tutor-color-primary: {$primary_color};
				--tutor-color-primary-rgb: {$primary_color_rgb};
				--tutor-border-color:{$box_border};
			}";

			return $css;
		}

		public function frontend_root_css() {
			$root_css = $this->get_root_css();

			wp_add_inline_style( 'edumall-style', html_entity_decode( $root_css, ENT_QUOTES ) );
		}

		/**
		 * Responsive styles.
		 *
		 * @access public
		 */
		public function extra_css() {
			$extra_style = '';

			// Background Topbar.
			$bgr_top_bar_color = Edumall::setting( 'bg_color' );
			if ( $bgr_top_bar_color !== '' ) {
				$extra_style .= ".top-bar-06 {
                    background-color: {$bgr_top_bar_color} !important;
                }";
			}

			$custom_logo_width        = Edumall_Helper::get_post_meta( 'custom_logo_width', '' );
			$custom_sticky_logo_width = Edumall_Helper::get_post_meta( 'custom_sticky_logo_width', '' );

			if ( $custom_logo_width !== '' ) {
				$extra_style .= ".branding__logo img {
                    width: {$custom_logo_width} !important;
                }";
			}

			if ( $custom_sticky_logo_width !== '' ) {
				$extra_style .= ".headroom--not-top .branding__logo .sticky-logo {
                    width: {$custom_sticky_logo_width} !important;
                }";
			}

			$site_width = Edumall_Helper::get_post_meta( 'site_width', '' );
			if ( $site_width === '' ) {
				$site_width = Edumall::setting( 'site_width' );
			}

			if ( $site_width !== '' ) {
				$extra_style .= "
				.boxed
				{
	                max-width: $site_width;
	            }";
			}

			$site_top_spacing = Edumall_Helper::get_post_meta( 'site_top_spacing', '' );

			if ( $site_top_spacing !== '' ) {
				$extra_style .= "
				.boxed
				{
	                margin-top: {$site_top_spacing};
	            }";
			}

			$site_bottom_spacing = Edumall_Helper::get_post_meta( 'site_bottom_spacing', '' );

			if ( $site_bottom_spacing !== '' ) {
				$extra_style .= "
				.boxed
				{
	                margin-bottom: {$site_bottom_spacing};
	            }";
			}

			$tmp = '';

			$site_background_color = Edumall_Helper::get_post_meta( 'site_background_color', '' );
			if ( $site_background_color !== '' ) {
				$tmp .= "background-color: $site_background_color !important;";
			}

			$site_background_image = Edumall_Helper::get_post_meta( 'site_background_image', '' );
			if ( $site_background_image !== '' ) {
				$site_background_repeat = Edumall_Helper::get_post_meta( 'site_background_repeat', '' );
				$tmp                    .= "background-image: url( $site_background_image ) !important; background-repeat: $site_background_repeat !important;";
			}

			$site_background_position = Edumall_Helper::get_post_meta( 'site_background_position', '' );
			if ( $site_background_position !== '' ) {
				$tmp .= "background-position: $site_background_position !important;";
			}

			$site_background_size = Edumall_Helper::get_post_meta( 'site_background_size', '' );
			if ( $site_background_size !== '' ) {
				$tmp .= "background-size: $site_background_size !important;";
			}

			$site_background_attachment = Edumall_Helper::get_post_meta( 'site_background_attachment', '' );
			if ( $site_background_attachment !== '' ) {
				$tmp .= "background-attachment: $site_background_attachment !important;";
			}

			if ( $tmp !== '' ) {
				$extra_style .= "body { $tmp; }";
			}

			$tmp = '';

			$content_background_color = Edumall_Helper::get_post_meta( 'content_background_color', '' );
			if ( $content_background_color !== '' ) {
				$tmp .= "background-color: $content_background_color !important;";
			}

			$content_background_image = Edumall_Helper::get_post_meta( 'content_background_image', '' );
			if ( $content_background_image !== '' ) {
				$content_background_repeat = Edumall_Helper::get_post_meta( 'content_background_repeat', '' );
				$tmp                       .= "background-image: url( $content_background_image ) !important; background-repeat: $content_background_repeat !important;";
			}

			$content_background_position = Edumall_Helper::get_post_meta( 'content_background_position', '' );
			if ( $content_background_position !== '' ) {
				$tmp .= "background-position: $content_background_position !important;";
			}

			if ( $tmp !== '' ) {
				$extra_style .= ".site { $tmp; }";
			}

			$extra_style .= $this->primary_color_css();
			$extra_style .= $this->secondary_color_css();
			$extra_style .= $this->header_css();
			$extra_style .= $this->sidebar_css();
			$extra_style .= $this->title_bar_css();
			$extra_style .= $this->light_gallery_css();
			$extra_style .= $this->off_canvas_menu_css();
			$extra_style .= $this->mobile_menu_css();

			$extra_style = apply_filters( 'edumall_custom_css', $extra_style );

			$extra_style = Edumall_Minify::css( $extra_style );

			wp_add_inline_style( 'edumall-style', html_entity_decode( $extra_style, ENT_QUOTES ) );
		}

		function header_css() {
			$header_type = Edumall_Global::instance()->get_header_type();
			$css         = '';

			$nav_bg_type = Edumall::setting( "header_style_{$header_type}_navigation_background_type" );

			if ( $nav_bg_type === 'gradient' ) {

				$gradient = Edumall::setting( "header_style_{$header_type}_navigation_background_gradient" );
				$_color_1 = $gradient['from'];
				$_color_2 = $gradient['to'];

				$css .= "
				.header-$header_type .header-bottom {
					background: {$_color_1};
                    background: -webkit-linear-gradient(-136deg, {$_color_2} 0%, {$_color_1} 100%);
                    background: linear-gradient(-136deg, {$_color_2} 0%, {$_color_1} 100%);
				}";
			}

			return $css;
		}

		function sidebar_css() {
			$css = '';

			$page_sidebar1  = Edumall_Global::instance()->get_sidebar_1();
			$page_sidebar2  = Edumall_Global::instance()->get_sidebar_2();
			$sidebar_status = Edumall_Global::instance()->get_sidebar_status();

			if ( 'none' !== $page_sidebar1 ) {

				if ( $sidebar_status === 'both' ) {
					$sidebars_breakpoint = Edumall::setting( 'both_sidebar_breakpoint' );
				} else {
					$sidebars_breakpoint = Edumall::setting( 'one_sidebar_breakpoint' );
				}

				$sidebars_below = Edumall::setting( 'sidebars_below_content_mobile' );

				if ( 'none' !== $page_sidebar2 ) {
					$sidebar_width  = apply_filters( 'edumall_dual_sidebar_width', Edumall::setting( 'dual_sidebar_width' ) );
					$sidebar_offset = apply_filters( 'edumall_dual_sidebar_offset', Edumall::setting( 'dual_sidebar_offset' ) );

					$content_width = 100 - $sidebar_width * 2;
				} else {
					$sidebar_width  = apply_filters( 'edumall_one_sidebar_width', Edumall::setting( 'single_sidebar_width' ) );
					$sidebar_offset = apply_filters( 'edumall_one_sidebar_offset', Edumall::setting( 'single_sidebar_offset' ) );

					$content_width = 100 - $sidebar_width;
				}

				$css .= "
				@media (min-width: {$sidebars_breakpoint}px) {
					.page-sidebar {
						flex: 0 0 $sidebar_width%;
						max-width: $sidebar_width%;
					}
					.page-main-content {
						flex: 0 0 $content_width%;
						max-width: $content_width%;
					}
				}";

				if ( is_rtl() ) {
					$css .= "@media (min-width: 1200px) {
						.page-sidebar-left .page-sidebar-inner {
							padding-left: $sidebar_offset;
						}
						.page-sidebar-right .page-sidebar-inner {
							padding-right: $sidebar_offset;
						}
					}";
				} else {
					$css .= "@media (min-width: 1200px) {
						.page-sidebar-left .page-sidebar-inner {
							padding-right: $sidebar_offset;
						}
						.page-sidebar-right .page-sidebar-inner {
							padding-left: $sidebar_offset;
						}
					}";
				}

				$_max_width_breakpoint = $sidebars_breakpoint - 1;

				if ( $sidebars_below === '1' ) {
					$css .= "
					@media (max-width: {$_max_width_breakpoint}px) {
						.page-sidebar {
							margin-top: 80px;
						}

						.page-main-content {
							-webkit-order: -1;
							-moz-order: -1;
							order: -1;
						}
					}";
				}
			}

			return $css;
		}

		function title_bar_css() {
			$css = $title_bar_tmp = $overlay_tmp = '';

			$type    = Edumall_Global::instance()->get_title_bar_type();
			$bg_type = Edumall::setting( "title_bar_{$type}_background_type" );

			if ( 'gradient' === $bg_type ) {
				$gradient_color = Edumall::setting( "title_bar_{$type}_background_gradient" );
				$color1         = $gradient_color['color_1'];
				$color2         = $gradient_color['color_2'];

				$css .= "
					.page-title-bar-bg
					{
						background-color: $color1;
						background-image: linear-gradient(-180deg, {$color1} 0%, {$color2} 100%);
					}
				";
			}

			$bg_color   = Edumall_Helper::get_post_meta( 'page_title_bar_background_color', '' );
			$bg_image   = Edumall_Helper::get_post_meta( 'page_title_bar_background', '' );
			$bg_overlay = Edumall_Helper::get_post_meta( 'page_title_bar_background_overlay', '' );

			if ( $bg_color !== '' ) {
				$title_bar_tmp .= "background-color: {$bg_color}!important;";
			}

			if ( '' !== $bg_image ) {
				$title_bar_tmp .= "background-image: url({$bg_image})!important;";
			}

			if ( '' !== $bg_overlay ) {
				$overlay_tmp .= "background-color: {$bg_overlay}!important;";
			}

			if ( '' !== $title_bar_tmp ) {
				$css .= ".page-title-bar-bg{ {$title_bar_tmp} }";
			}

			if ( '' !== $overlay_tmp ) {
				$css .= ".page-title-bar-bg:before{ {$overlay_tmp} }";
			}

			$bottom_spacing = Edumall_Helper::get_post_meta( 'page_title_bar_bottom_spacing', '' );
			if ( '' !== $bottom_spacing ) {
				$css .= "#page-title-bar{ margin-bottom: {$bottom_spacing}; }";
			}

			return $css;
		}

		function primary_color_css() {
			$color_selectors = "
				mark,
                .primary-color.primary-color,
                .growl-close:hover,
                .link-transition-02,
				.edumall-infinite-loader,
				.edumall-blog-caption-style-03 .tm-button,
				.tm-portfolio .post-categories a:hover,
				.tm-portfolio .post-title a:hover,
				.edumall-timeline.style-01 .title,
				.edumall-timeline.style-01 .timeline-dot,
				.tm-google-map .style-signal .animated-dot,
				.edumall-list .marker,
				.tm-social-networks .link:hover,
				.tm-social-networks.style-solid-rounded-icon .link,
				.edumall-team-member-style-01 .social-networks a:hover,
				.edumall-modern-carousel-style-02 .slide-button,
				.tm-slider a:hover .heading,
				.woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-content-bot-inner .woosw-page a:hover,
				.woosw-continue:hover,
				.tm-menu .menu-price,
				.woocommerce-widget-layered-nav-list a:hover,
				.blog-nav-links h6:before,
				.page-main-content .search-form .search-submit,
				.page-sidebar .widget_pages .current-menu-item > a,
				.page-sidebar .widget_nav_menu .current-menu-item > a,
				.comment-list .comment-actions a:hover,
				.portfolio-nav-links.style-01 .inner > a:hover,
				.portfolio-nav-links.style-02 .nav-list .hover,
				.edumall-nice-select-wrap .edumall-nice-select li.selected:before,
				.elementor-widget-tm-icon-box.edumall-icon-box-style-01 .edumall-box:hover div.tm-button.style-text,
				.elementor-widget-tm-icon-box.edumall-icon-box-style-01 a.tm-button.style-text:hover,
				.tm-image-box.edumall-box:hover div.tm-button.style-text,
				.tm-image-box a.tm-button.style-text:hover";

			$bg_color_selectors = "
				.primary-background-color,
				.link-transition-02:after,
				.wp-block-tag-cloud a:hover,
				.wp-block-calendar #today,
				.edumall-nice-select-wrap .edumall-nice-select li:hover,
				.edumall-progress .progress-bar,
				.edumall-link-animate-border .heading-primary a mark:after,
                .edumall-blog-caption-style-03 .tm-button.style-bottom-line .button-content-wrapper:after,
                .hint--primary:after,
                [data-fp-section-skin='dark'] #fp-nav ul li a span,
                [data-fp-section-skin='dark'] .fp-slidesNav ul li a span,
                .page-scroll-up,
                .top-bar-01 .top-bar-button,
				.tm-social-networks.style-flat-rounded-icon .link:hover,
				.tm-swiper .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,
				.tm-social-networks.style-flat-rounded-icon .link,
				.tm-social-networks.style-solid-rounded-icon .link:hover,
				.portfolio-overlay-group-01.portfolio-overlay-colored-faded .post-overlay,
				.edumall-modern-carousel .slide-tag,
				.edumall-light-gallery .edumall-box .edumall-overlay,
				.edumall-modern-carousel-style-02 .slide-button:after,
				.tm-gradation .item:hover .count,
				.nav-links a:hover,
				.single-post .entry-post-feature.post-quote,
				.entry-portfolio-feature .gallery-item .overlay,
				.widget_calendar #today,
				.page-main-content .search-form .search-submit:hover";

			$bg_color_important_selectors = "
				.primary-background-color-important,
				.lg-progress-bar .lg-progress
				";

			$border_color_selectors = "
				.wp-block-quote,
				.wp-block-quote.has-text-align-right,
				.wp-block-quote.has-text-align-right,
				.edumall-nice-select-wrap.focused .edumall-nice-select-current,
				.edumall-nice-select-wrap .edumall-nice-select-current:hover,
				.page-search-popup .search-field,
				.tm-social-networks.style-solid-rounded-icon .link,
				.tm-popup-video.type-button .video-play,
				.widget_pages .current-menu-item,
				.widget_nav_menu .current-menu-item,
				.insight-core-bmw .current-menu-item
			";

			$border_color_important_selectors = "
				.single-product .woo-single-gallery .edumall-thumbs-swiper .swiper-slide:hover img,
				.single-product .woo-single-gallery .edumall-thumbs-swiper .swiper-slide-thumb-active img,
				.lg-outer .lg-thumb-item.active, .lg-outer .lg-thumb-item:hover
			";

			$border_top_color_selectors = "
				.hint--primary.hint--top-left:before,
                .hint--primary.hint--top-right:before,
                .hint--primary.hint--top:before
			";

			$border_right_color_selectors = "
				.hint--primary.hint--right:before
			";

			$border_bottom_color_selectors = "
				.hint--primary.hint--bottom-left:before,
                .hint--primary.hint--bottom-right:before,
                .hint--primary.hint--bottom:before
			";

			$border_left_color_selectors = "
				.hint--primary.hint--left:before,
                .tm-popup-video.type-button .video-play-icon:before
			";

			$primary_selectors = [
				'color'                      => [ $color_selectors ],
				'background-color'           => [ $bg_color_selectors ],
				'background-color-important' => [ $bg_color_important_selectors ],
				'border-color'               => [ $border_color_selectors ],
				'border-color-important'     => [ $border_color_important_selectors ],
				'border-top-color'           => [ $border_top_color_selectors ],
				'border-right-color'         => [ $border_right_color_selectors ],
				'border-bottom-color'        => [ $border_bottom_color_selectors ],
				'border-left-color'          => [ $border_left_color_selectors ],
			];

			$primary_selectors = apply_filters( 'edumall_custom_css_primary_color_selectors', $primary_selectors );

			$color          = Edumall::setting( 'primary_color' );
			$color_alpha_80 = Edumall_Color::hex2rgba( $color, '0.8' );
			$color_alpha_70 = Edumall_Color::hex2rgba( $color, '0.7' );

			$css = "
				::-moz-selection { color: #fff; background-color: $color }
				::selection { color: #fff; background-color: $color }
				.primary-fill-color { fill: $color }
			";

			foreach ( $primary_selectors as $key => $selectors ) {
				$css_selectors = implode( ',', $selectors );

				if ( ! empty( $css_selectors ) ) {
					$attr_name   = $key;
					$attr_suffix = '';

					if ( strpos( $key, 'important' ) !== false ) {
						$attr_name   = strstr( $key, '-important', true );
						$attr_suffix = '!important';
					}

					$css .= "{$css_selectors} { {$attr_name}: {$color}$attr_suffix; }";
				}
			}

			$css .= "
				.edumall-accordion-style-01 .edumall-accordion .accordion-section.active .accordion-header,
				.edumall-accordion-style-01 .edumall-accordion .accordion-section:hover .accordion-header
				{
					background-color: {$color_alpha_70};
				}";

			$css .= "
				.portfolio-overlay-group-01 .post-overlay
				{
					background-color: {$color_alpha_80};
				}";

			return $css;
		}

		function secondary_color_css() {
			$color          = Edumall::setting( 'secondary_color' );
			$color_alpha_70 = Edumall_Color::hex2rgba( $color, '0.7' );
			$color_alpha_60 = Edumall_Color::hex2rgba( $color, '0.6' );
			$color_alpha_30 = Edumall_Color::hex2rgba( $color, '0.3' );
			$color_alpha_15 = Edumall_Color::hex2rgba( $color, '0.15' );

			// Color.
			$css = "
				.secondary-color,
				.elementor-widget-tm-icon-box.edumall-icon-box-style-01 .tm-icon-box .heading,
				.edumall-blog-zigzag .post-title,
				.edumall-event-grid.style-one-left-featured .featured-event .event-date .event-date--month
				{
					color: {$color};
				}";

			// Color.
			$css = "
				.secondary-color-important
				{
					color: {$color} !important;
				}";

			// Background Color.
			$css .= "
				.secondary-background-color,
				.hint--secondary:after,
				.tm-button.style-flat.button-secondary-lighten:after
				{
					background-color: {$color};
				}";

			// Background Color.
			$css .= "
				.edumall-event-carousel .event-overlay-background
				{
					background-color: {$color_alpha_60};
				}";

			// Background Color.
			$css .= "
				.tm-zoom-meeting .zoom-countdown .countdown-content .text
				{
					color: {$color_alpha_70};
				}";

			// Background Color.
			$css .= "
				.tm-button.style-flat.button-secondary-lighten:before
				{
					background-color: {$color_alpha_30};
				}";

			$third_color = Edumall::THIRD_COLOR;
			$css         .= "
				.tm-button.style-flat.button-secondary-lighten
				{
					color: {$third_color} !important;
				}";

			// Border Top.
			$css .= "
                .hint--secondary.hint--top-left:before,
                .hint--secondary.hint--top-right:before,
                .hint--secondary.hint--top:before
                {
					border-top-color: {$color};
				}";

			// Border Right.
			$css .= "
                .hint--secondary.hint--right:before
                {
					border-right-color: {$color};
				}";

			// Border Bottom.
			$css .= "
                .hint--secondary.hint--bottom-left:before,
                .hint--secondary.hint--bottom-right:before,
                .hint--secondary.hint--bottom:before
                {
					border-bottom-color: {$color};
				}";

			// Border Left.
			$css .= "
                .hint--secondary.hint--left:before
                {
                    border-left-color: {$color};
                }";

			$css .= "
				.secondary-border-color
                {
                    border-color: {$color};
                }
			";

			$css .= "
				.secondary-fill-color
                {
                    fill: {$color};
                }
			";

			return $css;
		}

		function light_gallery_css() {
			$css                    = '';
			$primary_color          = Edumall::setting( 'primary_color' );
			$secondary_color        = Edumall::setting( 'secondary_color' );
			$cutom_background_color = Edumall::setting( 'light_gallery_custom_background' );
			$background             = Edumall::setting( 'light_gallery_background' );

			$tmp = '';

			if ( $background === 'primary' ) {
				$tmp .= "background-color: {$primary_color} !important;";
			} elseif ( $background === 'secondary' ) {
				$tmp .= "background-color: {$secondary_color} !important;";
			} else {
				$tmp .= "background-color: {$cutom_background_color} !important;";
			}

			$css .= ".lg-backdrop { $tmp }";

			return $css;
		}

		function off_canvas_menu_css() {
			$css  = '';
			$type = Edumall::setting( 'navigation_minimal_01_background_type' );
			if ( $type === 'gradient' ) {
				$gradient = Edumall::setting( 'navigation_minimal_01_background_gradient_color' );

				$css .= ".popup-canvas-menu {
				    background-color: {$gradient['color_1']};
					background-image: linear-gradient(138deg, {$gradient['color_1']} 0%, {$gradient['color_2']} 100%);
				}";
			}

			return $css;
		}

		function mobile_menu_css() {
			$css  = '';
			$type = Edumall::setting( 'mobile_menu_background_type' );
			if ( $type === 'gradient' ) {
				$gradient = Edumall::setting( 'mobile_menu_background_gradient_color' );

				$css .= ".page-mobile-main-menu > .inner {
				    background-color: {$gradient['color_1']};
					background-image: linear-gradient(138deg, {$gradient['color_1']} 0%, {$gradient['color_2']} 100%);
				}";
			} else {
				/**
				 * Lazy load image
				 */
				$background = Edumall::setting( 'mobile_menu_background' );

				$background_css = '';

				if ( ! empty( $background['background-color'] ) ) {
					$background_css .= "background-color: {$background['background-color']};";
				}

				if ( ! empty( $background['background-image'] ) ) {
					$background_css .= "background-repeat: {$background['background-repeat']};";
					$background_css .= "background-size: {$background['background-size']};";
					$background_css .= "background-attachment: {$background['background-attachment']};";
					$background_css .= "background-position: {$background['background-position']};";
				}

				if ( ! empty( $background_css ) ) {
					$css .= ".page-mobile-main-menu > .inner  { $background_css }";
				}
			}

			return $css;
		}
	}

	Edumall_Custom_Css::instance()->initialize();
}
