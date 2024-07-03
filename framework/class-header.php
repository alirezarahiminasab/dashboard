<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Header' ) ) {

	class Edumall_Header {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_ajax_edumall_actions', [ $this, 'edumall_actions' ] );
			add_action( 'wp_ajax_nopriv_edumall_actions', [ $this, 'edumall_actions' ] );
		}

		public function edumall_actions() {
			$id     = $_POST['cat_id'];
			$action = $_POST['action'];

			$number_posts = Edumall::setting( 'header_category_menu_number_posts', 6 );

			$query_args = array(
				'post_type'      => Edumall_Tutor::instance()->get_course_type(),
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post_status'    => 'publish',
				'posts_per_page' => $number_posts,
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => Edumall_Tutor::instance()->get_tax_category(),
						'field'    => 'id',
						'terms'    => $id,
					),
				),
			);

			$query    = new WP_Query( $query_args );
			$response = [];
			ob_start();

			if ( $query->have_posts() ) {
				set_query_var( 'edumall_query', $query );
				get_template_part( 'loop/menu/category' );
				wp_reset_postdata();
			} else {
				get_template_part( 'loop/menu/content-none' );
			}

			$template             = ob_get_clean();
			$template             = preg_replace( '~>\s+<~', '><', $template );
			$response['template'] = $template;

			echo json_encode( $response );

			wp_die();
		}

		/**
		 * @return array List header types include id & name.
		 */
		public function get_type() {
			return array(
				'01' => esc_html__( 'Style 01', 'edumall' ),
				'02' => esc_html__( 'Style 02', 'edumall' ),
				'03' => esc_html__( 'Style 03', 'edumall' ),
				'04' => esc_html__( 'Style 04', 'edumall' ),
				'05' => esc_html__( 'Style 05', 'edumall' ),
				'06' => esc_html__( 'Style 06', 'edumall' ),
				'07' => esc_html__( 'Style 07', 'edumall' ),
				'08' => esc_html__( 'Style 08', 'edumall' ),
				'09' => esc_html__( 'Style 09', 'edumall' ),
				'10' => esc_html__( 'Style 10', 'edumall' ),
			);
		}

		/**
		 * @param bool   $default_option Show or hide default select option.
		 * @param string $default_text   Custom text for default option.
		 *
		 * @return array A list of options for select field.
		 */
		public function get_list( $default_option = false, $default_text = '' ) {
			$headers = array(
				'none' => esc_html__( 'Hide', 'edumall' ),
			);

			$headers += $this->get_type();

			if ( $default_option === true ) {
				if ( $default_text === '' ) {
					$default_text = esc_html__( 'Default', 'edumall' );
				}

				$headers = array( '' => $default_text ) + $headers;
			}

			return $headers;
		}

		/**
		 * Get list of button style option for customizer.
		 *
		 * @return array
		 */
		public function get_button_style() {
			return array(
				'flat'         => esc_attr__( 'Flat', 'edumall' ),
				'border'       => esc_attr__( 'Border', 'edumall' ),
				'thick-border' => esc_attr__( 'Thick Border', 'edumall' ),
			);
		}

		public function get_button_kirki_output( $header_style, $header_skin, $hover = false ) {
			$prefix_selector = ".header-{$header_style}.header-{$header_skin} ";

			if ( $hover ) {
				$button_selector    = $prefix_selector . ".header-button:hover";
				$button_bg_selector = $prefix_selector . ".header-button:after";
			} else {
				$button_selector    = $prefix_selector . ".header-button";
				$button_bg_selector = $prefix_selector . ".header-button:before";
			}

			return array(
				array(
					'choice'   => 'color',
					'property' => 'color',
					'element'  => $button_selector,
				),
				array(
					'choice'   => 'border',
					'property' => 'border-color',
					'element'  => $button_selector,
				),
				array(
					'choice'   => 'background',
					'property' => 'background',
					'element'  => $button_bg_selector,
				),
			);
		}

		public function get_search_form_kirki_output( $header_style, $header_skin, $hover = false, $site_scheme = false ) {
			$prefix_selector = ".header-{$header_style}.header-{$header_skin} ";
			$scheme_selector = '';
			$field_selector  = '.search-field';

			if ( $site_scheme ) {
				$scheme_selector = '.edumall-dark-scheme ';
			}

			if ( $hover ) {
				$field_selector .= ':focus';
			}

			$form_selector = $scheme_selector . $prefix_selector . $field_selector;

			return array(
				array(
					'choice'   => 'color',
					'property' => 'color',
					'element'  => $form_selector,
				),
				array(
					'choice'   => 'border',
					'property' => 'border-color',
					'element'  => $form_selector,
				),
				array(
					'choice'   => 'background',
					'property' => 'background',
					'element'  => $form_selector,
				),
			);
		}

		/**
		 * Add classes to the header.
		 *
		 * @var string $class Custom class.
		 */
		public function get_wrapper_class( $class = '' ) {
			$classes = array( 'page-header' );

			$header_type    = Edumall_Global::instance()->get_header_type();
			$header_overlay = Edumall_Global::instance()->get_header_overlay();
			$header_skin    = Edumall_Global::instance()->get_header_skin();

			$classes[] = "header-{$header_type}";
			$classes[] = "header-{$header_skin}";

			if ( '1' === $header_overlay ) {
				$classes[] = 'header-layout-fixed';
			}

			if ( '06' !== $header_type ) {
				$classes[] = 'nav-links-hover-style-01';
			}

			if ( 'dark' === Edumall_Global::instance()->get_site_skin() ) {
				$_sticky_logo = Edumall::setting( 'dark_scheme_header_sticky_logo' );
			} else {
				$_sticky_logo = Edumall::setting( 'header_sticky_logo' );
			}
			$classes[] = "header-sticky-$_sticky_logo-logo";

			if ( ! empty( $class ) ) {
				if ( ! is_array( $class ) ) {
					$class = preg_split( '#\s+#', $class );
				}
				$classes = array_merge( $classes, $class );
			} else {
				// Ensure that we always coerce class to being an array.
				$class = array();
			}

			$classes = apply_filters( 'edumall_header_class', $classes, $class );

			echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
		}

		/**
		 * Print WPML switcher html template.
		 *
		 * @var string $class Custom class.
		 */
		public function print_language_switcher() {
			$header_type = Edumall_Global::instance()->get_header_type();
			$enabled     = Edumall::setting( "header_style_{$header_type}_language_switcher_enable" );

			do_action( 'edumall_before_add_language_selector_header', $header_type, $enabled );

			if ( $enabled !== '1' || ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
				return;
			}
			?>
			<div id="switcher-language-wrapper" class="switcher-language-wrapper">
				<?php do_action( 'wpml_add_language_selector' ); ?>
			</div>
			<?php
		}

		public function print_social_networks( $args = array() ) {
			$header_type   = Edumall_Global::instance()->get_header_type();
			$social_enable = Edumall::setting( "header_style_{$header_type}_social_networks_enable" );

			if ( '1' !== $social_enable ) {
				return;
			}

			$defaults = array(
				'style' => 'icons',
			);

			$args       = wp_parse_args( $args, $defaults );
			$el_classes = 'header-social-networks';

			if ( ! empty( $args['style'] ) ) {
				$el_classes .= " style-{$args['style']}";
			}
			?>
			<div class="<?php echo esc_attr( $el_classes ); ?>">
				<div class="inner">
					<?php
					$defaults = array(
						'tooltip_position' => 'bottom-left',
					);

					if ( 'light' === Edumall_Global::instance()->get_header_skin() || 'dark' === Edumall_Global::instance()->get_site_skin() ) {
						$defaults['tooltip_skin'] = 'white';
					}

					$args = wp_parse_args( $args, $defaults );

					Edumall_Templates::social_icons( $args );
					?>
				</div>
			</div>
			<?php
		}

		public function print_widgets() {
			$header_type = Edumall_Global::instance()->get_header_type();

			$enabled = Edumall::setting( "header_style_{$header_type}_widgets_enable" );
			if ( '1' === $enabled ) {
				edumall_load_template( 'header/components/widgets' );
			}
		}

		public function print_search() {
			$header_type = Edumall_Global::instance()->get_header_type();
			$search_type = Edumall::setting( "header_style_{$header_type}_search_enable" );

			if ( 'inline' === $search_type ) {
				edumall_load_template( 'header/components/search-form' );
			} elseif ( 'popup' === $search_type ) {
				edumall_load_template( 'header/components/search-popup' );
			}
		}

		public function print_notification() {
			$header_type  = Edumall_Global::instance()->get_header_type();
			$component_on = Edumall::setting( "header_style_{$header_type}_notification_enable" );

			if ( ! is_user_logged_in() || '1' !== $component_on ) {
				return;
			}

			if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'notifications' ) ) {
				return;
			}

			edumall_load_template( 'header/components/notification' );
		}

		public function print_category_menu() {
			$header_type     = Edumall_Global::instance()->get_header_type();
			$category_enable = Edumall::setting( "header_style_{$header_type}_category_menu_enable" );

			if ( '1' !== $category_enable ) {
				return;
			}

			edumall_load_template( 'header/components/category-menu' );
		}

		/**
		 * Print login button + register button.
		 * If logged in then print profile & logout instead of.
		 */
		public function print_user_buttons() {
			$header_type     = Edumall_Global::instance()->get_header_type();
			$user_buttons_on = Edumall::setting( "header_style_{$header_type}_login_enable" );

			if ( '1' !== $user_buttons_on ) {
				return;
			}

			edumall_load_template( 'header/components/user-buttons' );
		}

		/**
		 * Other style for user links
		 *
		 * @see Edumall_Header::print_user_buttons()
		 */
		public function print_user_links_box() {
			$header_type     = Edumall_Global::instance()->get_header_type();
			$user_buttons_on = Edumall::setting( "header_style_{$header_type}_login_enable" );

			if ( '1' !== $user_buttons_on ) {
				return;
			}

			edumall_load_template( 'header/components/user-links-box' );
		}

		public function print_user_links_icon() {
			$header_type     = Edumall_Global::instance()->get_header_type();
			$user_buttons_on = Edumall::setting( "header_style_{$header_type}_login_enable" );

			if ( '1' !== $user_buttons_on ) {
				return;
			}

			edumall_load_template( 'header/components/user-links-icon' );
		}

		public function print_contact_info_box() {
			$header_type     = Edumall_Global::instance()->get_header_type();
			$contact_info_on = Edumall::setting( "header_style_{$header_type}_contact_info_enable" );

			if ( '1' !== $contact_info_on ) {
				return;
			}

			edumall_load_template( 'header/components/contact-info-box' );
		}

		public function print_button( $args = array() ) {
			$header_type = Edumall_Global::instance()->get_header_type();

			$button_style        = Edumall::setting( "header_style_{$header_type}_button_style" );
			$button_text         = Edumall::setting( "header_style_{$header_type}_button_text" );
			$button_link         = Edumall::setting( "header_style_{$header_type}_button_link" );
			$button_link_target  = Edumall::setting( "header_style_{$header_type}_button_link_target" );
			$button_link_rel     = Edumall::setting( "header_style_{$header_type}_button_link_rel" );
			$button_classes      = 'tm-button';
			$sticky_button_style = Edumall::setting( "header_sticky_button_style" );

			$icon_class = Edumall::setting( "header_style_{$header_type}_button_icon" );
			$icon_align = 'right';

			if ( $icon_class !== '' ) {
				$button_classes .= ' has-icon icon-right';
			}

			$defaults = array(
				'extra_class' => '',
				'style'       => '',
				'size'        => 'nm',
			);

			$args = wp_parse_args( $args, $defaults );

			if ( $args['extra_class'] !== '' ) {
				$button_classes .= " {$args['extra_class']}";
			}

			$header_button_classes = $button_classes . " tm-button-{$args['size']} header-button";
			$sticky_button_classes = $button_classes . ' tm-button-xs header-sticky-button';

			$header_button_classes .= " style-{$button_style}";
			$sticky_button_classes .= " style-{$sticky_button_style}";
			?>
			<?php if ( $button_link !== '' && $button_text !== '' ) : ?>

				<?php ob_start(); ?>

				<?php if ( $icon_class !== '' && $icon_align === 'right' ) { ?>
					<span class="button-icon">
						<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
					</span>
				<?php } ?>

				<span class="button-text">
					<?php echo esc_html( $button_text ); ?>
				</span>

				<?php if ( $icon_class !== '' && $icon_align === 'right' ) { ?>
					<span class="button-icon">
						<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
					</span>
				<?php } ?>

				<?php $button_content_html = ob_get_clean(); ?>

				<div class="header-buttons">
					<a class="<?php echo esc_attr( $header_button_classes ); ?>"
					   href="<?php echo esc_url( $button_link ); ?>"

						<?php if ( '1' === $button_link_target ) : ?>
							target="_blank"
						<?php endif; ?>

						<?php if ( ! empty ( $button_link_rel ) ) : ?>
							rel="<?php echo esc_attr( $button_link_rel ); ?>"
						<?php endif; ?>
					>
						<?php echo '' . $button_content_html; ?>
					</a>
					<a class="<?php echo esc_attr( $sticky_button_classes ); ?>"
					   href="<?php echo esc_url( $button_link ); ?>"

						<?php if ( '1' === $button_link_target ) : ?>
							target="_blank"
						<?php endif; ?>

						<?php if ( ! empty ( $button_link_rel ) ) : ?>
							rel="<?php echo esc_attr( $button_link_rel ); ?>"
						<?php endif; ?>
					>
						<?php echo '' . $button_content_html; ?>
					</a>
				</div>
			<?php endif;
		}

		public function print_open_mobile_menu_button() {
			edumall_load_template( 'header/components/open-mobile-menu-button' );
		}

		public function print_more_tools_button() {
			edumall_load_template( 'header/components/more-tools-button' );
		}

		public function print_open_canvas_menu_button( $args = array() ) {
			if ( ! has_nav_menu( 'off_canvas' ) ) {
				return;
			}

			$defaults = array(
				'extra_class' => '',
				'style'       => '01',
			);
			$args     = wp_parse_args( $args, $defaults );

			edumall_load_template( 'header/components/open-canvas-menu-button', null, $args );
		}
	}

	Edumall_Header::instance()->initialize();
}
