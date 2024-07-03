<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Course' ) ) {
	class Edumall_Course {

		protected $course_id              = null;
		protected $unique_id              = null;
		protected $enrolled               = null;
		protected $is_viewable            = null;
		protected $reviews                = null;
		protected $rating                 = null;
		protected $instructors            = null;
		protected $topics                 = null;
		protected $attachments            = null;
		protected $announcements          = null;
		protected $lesson_count           = null;
		protected $completed_lesson_count = null;
		protected $enrolled_users_count   = null;
		protected $video                  = null;
		protected $benefits               = null;
		protected $material               = null;
		protected $requirements           = null;
		protected $target_audience        = null;
		protected $is_wishlisted          = null;
		protected $is_purchasable         = null;
		protected $price_type             = null;
		protected $regular_price          = null;
		protected $sale_price             = null;
		protected $product                = null;
		protected $product_id             = null;
		protected $is_on_sale             = null;
		protected $on_sale_text           = null;
		protected $is_featured            = null;
		protected $is_public              = null;
		protected $is_completed           = null;
		protected $level                  = null;
		protected $visibility_terms       = null;
		protected $has_classroom_stream   = null;
		protected $prerequisites          = null;

		public function __construct( $id = 0 ) {
			if ( $id ) {
				$this->course_id = $id;
			}

			$this->course_id = get_the_ID();
		}

		public function get_name() {
			return get_the_title();
		}

		public function get_id() {
			if ( null === $this->course_id ) {
				$this->course_id = get_the_ID();
			}

			return $this->course_id;
		}

		public function get_unique_id() {
			if ( null === $this->unique_id ) {
				$id = $this->get_id();

				$this->unique_id = uniqid( "course-{$id}-" );
			}

			return $this->unique_id;
		}

		public function get_video() {
			if ( null === $this->video ) {
				$this->video = tutor_utils()->get_video();
			}

			return $this->video;
		}

		/**
		 * Check if the course has video
		 *
		 * @return bool
		 */
		public function has_video() {
			$video = $this->get_video();

			if ( empty( $video ) || ! isset( $video['source'] ) || '-1' === $video['source'] ) {
				return false;
			}

			return true;
		}

		public function get_topics() {
			if ( null === $this->topics ) {
				$this->topics = tutor_utils()->get_topics();
			}

			return $this->topics;
		}

		public function get_attachments() {
			if ( null === $this->attachments ) {
				$this->attachments = tutor_utils()->get_attachments();
			}

			return $this->attachments;
		}

		public function get_announcements() {
			if ( null === $this->announcements ) {
				$announcements     = [];
				$get_announcements = tutor_utils()->get_announcements();

				if ( ! empty( $get_announcements ) ) {
					foreach ( $get_announcements as $announcement ) {
						$announcements[] = [
							'title'       => $announcement->post_title,
							'content'     => tutor_utils()->announcement_content( wpautop( stripslashes( $announcement->post_content ) ) ),
							'author'      => $announcement->display_name,
							'posted_by'   => sprintf( esc_html__( 'Posted by %s', 'edumall' ), $announcement->display_name ),
							'posted_date' => sprintf( esc_html__( '%s ago', 'edumall' ), human_time_diff( strtotime( $announcement->post_date ) ) ),
						];
					}
				}

				$this->announcements = $announcements;
			}

			return $this->announcements;
		}

		public function is_enrolled() {
			if ( $this->get_enrolled() ) {
				return true;
			}

			return false;
		}

		/**
		 * Check if current user can view hidden section of course.
		 * Admin, Course Owner, Enrolled User
		 *
		 * @return bool
		 */
		public function is_viewable() {
			if ( null === $this->is_viewable ) {
				if ( $this->is_enrolled() ) {
					return $this->is_viewable = true;
				}

				$is_administrator      = current_user_can( 'administrator' );
				$is_author             = tutor_utils()->is_instructor_of_this_course();
				$course_content_access = (bool) get_tutor_option( 'course_content_access_for_ia' );

				if ( ( $is_administrator || $is_author ) && $course_content_access ) {
					return $this->is_viewable = true;
				}

				return $this->is_viewable = false;
			}

			return $this->is_viewable;
		}

		public function get_enrolled() {
			if ( null === $this->enrolled ) {
				$this->enrolled = tutor_utils()->is_enrolled();
			}

			return $this->enrolled;
		}

		public function get_reviews() {
			if ( null === $this->reviews ) {
				$this->reviews = false;
				if ( ! get_tutor_option( 'disable_course_review' ) ) {
					$reviews = tutor_utils()->get_course_reviews($course_id = 0, $start = 0, $limit = 1);

					if ( is_array( $reviews ) && count( $reviews ) ) {
						$this->reviews = $reviews;
					}
				}
			}

			return $this->reviews;
		}

		public function get_rating() {
			if ( null === $this->rating ) {
				//$this->rating = tutor_utils()->get_course_rating();
				/**
				 * Use alternate function to fix bug with rating count.
				 *
				 * @since 2.7.3
				 */
				$this->rating = Edumall_Tutor::instance()->get_course_rating();
			}

			return $this->rating;
		}

		public function get_instructors() {
			if ( null === $this->instructors ) {
				$this->instructors = tutor_utils()->get_instructors_by_course();
			}

			return $this->instructors;
		}

		public function get_lesson_count() {
			if ( null === $this->lesson_count ) {
				$this->lesson_count = tutor_utils()->get_lesson_count_by_course();
			}

			return $this->lesson_count;
		}

		public function get_completed_lesson_count() {
			if ( null === $this->completed_lesson_count ) {
				$this->completed_lesson_count = tutor_utils()->get_completed_lesson_count_by_course( $this->get_id() );
			}

			return $this->completed_lesson_count;
		}

		public function get_enrolled_users_count() {
			if ( null === $this->enrolled_users_count ) {
				$this->enrolled_users_count = tutor_utils()->count_enrolled_users_by_course();
			}

			return $this->enrolled_users_count;
		}

		public function get_benefits() {
			if ( null === $this->benefits ) {
				$this->benefits = tutor_course_benefits();
			}

			return $this->benefits;
		}

		public function get_material_includes() {
			if ( null === $this->material ) {
				$this->material = tutor_course_material_includes();
			}

			return $this->material;
		}

		public function get_requirements() {
			if ( null === $this->requirements ) {
				$this->requirements = tutor_course_requirements();
			}

			return $this->requirements;
		}

		public function get_target_audience() {
			if ( null === $this->target_audience ) {
				$this->target_audience = tutor_course_target_audience();
			}

			return $this->target_audience;
		}

		public function get_level() {
			if ( null === $this->level ) {
				$this->level = get_post_meta( $this->get_id(), '_tutor_course_level', true );
			}

			return $this->level;
		}

		public function get_level_label() {
			$level = $this->get_level();

			if ( $level ) {
				return tutor_utils()->course_levels( $level );
			}

			return '';
		}

		public function get_price_type() {
			if ( null === $this->price_type ) {
				$this->price_type = tutor_utils()->price_type();
			}

			return $this->price_type;
		}

		public function get_regular_price() {
			if ( null === $this->regular_price ) {
				if ( $this->is_purchasable() ) {
					$product = $this->get_product();

					if ( $product instanceof WC_Product ) {
						$this->regular_price = $product->get_regular_price();
					} elseif ( $product instanceof EDD_Download ) {
						$this->regular_price = $product->get_price();
					} else {
						$this->regular_price = 0;
					}
				} else {
					$this->regular_price = 0;
				}
			}

			return $this->regular_price;
		}

		public function get_sale_price() {
			if ( null === $this->sale_price ) {
				if ( $this->is_purchasable() ) {
					$product = $this->get_product();

					if ( $product instanceof WC_Product ) {
						$this->sale_price = $product->get_sale_price();
					} elseif ( $product instanceof EDD_Download ) {
						// @todo need working more. Edd not support sale price.
						$this->sale_price = '';
					} else {
						$this->sale_price = '';
					}
				} else {
					$this->sale_price = '';
				}
			}

			return $this->sale_price;
		}

		public function get_product_id() {
			if ( null === $this->product_id ) {
				$this->product_id = tutor_utils()->get_course_product_id();
			}

			return $this->product_id;
		}

		public function get_product() {
			if ( null === $this->product ) {
				$sell_by = apply_filters( 'tutor_course_sell_by', null );

				switch ( $sell_by ) {
					case 'woocommerce' :
						$this->product = wc_get_product( $this->get_product_id() );
						break;
					case 'edd' :
						$this->product = new EDD_Download( $this->get_product_id() );
						break;
					default :
						$this->product = false;
						break;
				}

			}

			return $this->product;
		}

		public function is_on_sale() {
			if ( null === $this->is_on_sale ) {
				$product = $this->get_product();
				$sell_by = apply_filters( 'tutor_course_sell_by', null );

				if ( $product && 'woocommerce' === $sell_by ) {
					$this->is_on_sale = $product->is_on_sale();
				} else {
					$this->is_on_sale = false;
				}
			}

			return $this->is_on_sale;
		}

		public function on_sale_text( $format = '-%s' ) {
			if ( null === $this->on_sale_text ) {
				$badge_text = '';

				$is_purchasable = $this->is_purchasable();
				$price          = apply_filters( 'get_tutor_course_price', null, get_the_ID() );

				if ( $is_purchasable && $price ) {
					if ( tutor_utils()->has_wc() ) {
						if ( $this->is_on_sale() ) {
							$product = $this->get_product();
							if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
								$_regular_price = $product->get_regular_price();
								$_sale_price    = $product->get_sale_price();

								$percentage = round( ( ( $_regular_price - $_sale_price ) / $_regular_price ) * 100 );

								$badge_text = sprintf( $format, "{$percentage}%" );
							} else {
								$badge_text = esc_html__( 'Sale Off', 'edumall' );
							}
						}
					}
					//@todo Sale flash need support EDD too.
				}

				$this->on_sale_text = $badge_text;
			}

			return $this->on_sale_text;
		}

		public function is_purchasable() {
			if ( null === $this->is_purchasable ) {
				$this->is_purchasable = tutor_utils()->is_course_purchasable();
			}

			return $this->is_purchasable;
		}

		public function is_wishlisted() {
			if ( null === $this->is_wishlisted ) {
				$this->is_wishlisted = tutor_utils()->is_wishlisted();
			}

			return $this->is_wishlisted;
		}

		/**
		 * @return array|WP_Term[] empty array or array of WP_Term object
		 */
		public function get_visibility_terms() {
			if ( null === $this->visibility_terms ) {
				$terms = get_the_terms( $this->get_id(), 'course-visibility' );

				$this->visibility_terms = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms : array();
			}

			return $this->visibility_terms;
		}

		public function is_featured() {
			if ( null === $this->is_featured ) {
				$this->is_featured = false;

				$visibility_terms = $this->get_visibility_terms();

				if ( ! empty( $visibility_terms ) ) {
					foreach ( $visibility_terms as $term ) {
						if ( 'featured' === $term->name ) {
							$this->is_featured = true;
							break;
						}
					}
				}
			}

			return $this->is_featured;
		}

		public function is_public() {
			if ( null === $this->is_public ) {
				$this->is_public = false;

				$enabled = get_post_meta( $this->get_id(), '_tutor_is_public_course', true );

				if ( 'yes' === $enabled ) {
					$this->is_public = true;
				}
			}

			return $this->is_public;
		}

		public function is_completed() {
			if ( null === $this->is_completed ) {
				$this->is_completed = tutor_utils()->is_completed_course( $this->get_id() );
			}

			return $this->is_completed;
		}

		public function has_classroom_stream() {
			if ( null === $this->has_classroom_stream ) {
				$value = get_post_meta( $this->get_id(), 'tutor_gc_enable_classroom_stream', true );

				$this->has_classroom_stream = ( ! empty( $value ) && 'yes' === $value ) ? true : false;
			}

			return $this->has_classroom_stream;
		}

		public function get_prerequisites() {
			if ( null === $this->prerequisites ) {
				$list = [];

				if ( class_exists( 'TUTOR_PREREQUISITES\init' ) ) {
					$prerequisites = maybe_unserialize( get_post_meta( $this->get_id(), '_tutor_course_prerequisites_ids', true ) );

					if ( ! empty( $prerequisites ) ) {
						$list = $prerequisites;
					}
				}

				$this->prerequisites = $list;
			}

			return $this->prerequisites;
		}
	}
}

add_action( 'template_redirect', 'edumall_setup_course_object' );

function edumall_setup_course_object() {
	if ( ! is_singular( 'courses' ) && ! is_singular( 'lesson' ) ) {
		return;
	}

	/**
	 * @var Edumall_Course $edumall_course
	 */
	global $edumall_course;

	$edumall_course = new Edumall_Course();
}
