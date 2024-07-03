<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Title_Bar' ) ) {

	class Edumall_Title_Bar {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Adds custom classes to the array of body classes.
			add_filter( 'body_class', [ $this, 'body_classes' ] );
		}

		public function body_classes( $classes ) {
			$title_bar = Edumall_Global::instance()->get_title_bar_type();
			$classes[] = "title-bar-{$title_bar}";

			/**
			 * Add class to hide entry title if this title bar has post title also.
			 */
			// Title Bars support heading.
			if ( in_array( $title_bar, [ '01', '02', '06' ], true ) && is_singular() ) {
				$post_type = get_post_type();
				$title     = '';

				switch ( $post_type ) {
					case 'post' :
						$title = Edumall::setting( 'blog_single_title_bar_title' );
						break;
					case 'portfolio' :
						$title = Edumall::setting( 'portfolio_single_title_bar_title' );
						break;
					case 'product' :
						$title = Edumall::setting( 'product_single_title_bar_title' );
						break;
				}

				if ( '' === $title ) {
					$classes[] = 'title-bar-has-post-title';
				}
			}

			return $classes;
		}

		public function get_list( $default_option = false, $default_text = '' ) {
			$options = array(
				'none' => esc_html__( 'Hide', 'edumall' ),
				'01'   => esc_html__( 'Style 01', 'edumall' ),
				'02'   => esc_html__( 'Style 02', 'edumall' ),
				'03'   => esc_html__( 'Style 03', 'edumall' ),
				'04'   => esc_html__( 'Style 04', 'edumall' ),
				'05'   => esc_html__( 'Style 05', 'edumall' ),
				'06'   => esc_html__( 'Style 06', 'edumall' ),
				'07'   => esc_html__( 'Style 07 (Overlay)', 'edumall' ),
				'08'   => esc_html__( 'Style 08 (Search Form)', 'edumall' ),
			);

			if ( $default_option === true ) {
				if ( $default_text === '' ) {
					$default_text = esc_html__( 'Default', 'edumall' );
				}

				$options = array( '' => $default_text ) + $options;
			}

			return $options;
		}

		public function the_wrapper_class() {
			$classes = array( 'page-title-bar' );

			$type = Edumall_Global::instance()->get_title_bar_type();

			$classes[] = "page-title-bar-{$type}";

			echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
		}

		public function render() {
			$type = Edumall_Global::instance()->get_title_bar_type();

			if ( 'none' === $type ) {
				return;
			}

			edumall_load_template( 'title-bar/title-bar', $type );
		}

		public function render_title() {
			$title     = '';
			$title_tag = 'h1';

			if ( Edumall_Portfolio::instance()->is_archive() ) {
				$title = Edumall::setting( 'portfolio_archive_title_bar_title' );
			} elseif ( is_post_type_archive() ) {
				$title = sprintf( esc_html__( 'Archives: %s', 'edumall' ), post_type_archive_title( '', false ) );
			} elseif ( is_home() ) {
				$title = Edumall::setting( 'title_bar_home_title' ) . single_tag_title( '', false );
			} elseif ( is_tag() ) {
				$title = Edumall::setting( 'title_bar_archive_tag_title' ) . single_tag_title( '', false );
			} elseif ( is_author() ) {
				$title = Edumall::setting( 'title_bar_archive_author_title' ) . '<span class="vcard">' . get_the_author() . '</span>';
			} elseif ( is_year() ) {
				$title = Edumall::setting( 'title_bar_archive_year_title' ) . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'edumall' ) );
			} elseif ( is_month() ) {
				$title = Edumall::setting( 'title_bar_archive_month_title' ) . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'edumall' ) );
			} elseif ( is_day() ) {
				$title = Edumall::setting( 'title_bar_archive_day_title' ) . get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'edumall' ) );
			} elseif ( is_search() ) {
				$title = Edumall::setting( 'title_bar_search_title' ) . '"' . get_search_query() . '"';
			} elseif ( is_category() || is_tax() ) {
				$title = Edumall::setting( 'title_bar_archive_category_title' ) . single_cat_title( '', false );
			} elseif ( is_singular() ) {
				$title = Edumall_Helper::get_post_meta( 'page_title_bar_custom_heading', '' );

				if ( '' === $title ) {
					$post_type = get_post_type();
					switch ( $post_type ) {
						case 'post' :
							$title = Edumall::setting( 'blog_single_title_bar_title' );
							break;
						case 'portfolio' :
							$title = Edumall::setting( 'portfolio_single_title_bar_title' );
							break;
					}
				}

				if ( '' === $title ) {
					$title = get_the_title();
				} else {
					$title_tag = 'h2';
				}
			} else {
				$title = get_the_title();
			}

			$title = apply_filters( 'edumall_title_bar_heading_text', $title );
			?>
			<div class="page-title-bar-heading">
				<?php printf( '<%s class="heading">', $title_tag ); ?>
				<?php echo wp_kses( $title, array(
					'span' => [
						'class' => [],
					],
					'br'   => [],
				) ); ?>
				<?php printf( '</%s>', $title_tag ); ?>
			</div>
			<?php
		}
	}

	Edumall_Title_Bar::instance()->initialize();
}
