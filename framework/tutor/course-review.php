<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Tutor_Course_Review' ) ) {
	class Edumall_Tutor_Course_Review {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_action( 'wp_ajax_edumall_place_rating', [ $this, 'place_rating' ] );

			add_action( 'wp_ajax_edumall_update_review_modal', [ $this, 'update_review_modal' ] );
		}

		/**
		 * Custom ajax for create review.
		 *
		 * @see    \TUTOR\Ajax::tutor_place_rating()
		 * @hooked tutor_before_rating_placed
		 *
		 * Save rating total & rating detail as meta for course.
		 * Used for filtering.
		 */
		public function place_rating() {
			$rating    = sanitize_text_field( tutor_utils()->avalue_dot( 'rating', $_POST ) );
			$course_id = sanitize_text_field( tutor_utils()->avalue_dot( 'course_id', $_POST ) );
			$review    = wp_kses_post( tutor_utils()->avalue_dot( 'review', $_POST ) );

			$result = $this->add_review( $course_id, $rating, $review );

			if ( $result instanceof WP_Error ) {
				wp_send_json_error();
			} else {
				wp_send_json_success( $result );
			}

			exit;
		}

		/**
		 * Custom ajax for updating review.
		 *
		 * @see \TUTOR\Ajax::tutor_update_review_modal()
		 */
		public function update_review_modal() {
			tutor_utils()->checking_nonce();

			$review_id = (int) sanitize_text_field( tutils()->array_get( 'review_id', $_POST ) );
			$rating    = sanitize_text_field( tutor_utils()->avalue_dot( 'rating', $_POST ) );
			$review    = wp_kses_post( tutor_utils()->avalue_dot( 'review', $_POST ) );

			$result = $this->update_review( $review_id, $rating, $review );

			if ( $result instanceof WP_Error ) {
				wp_send_json_error();
			} else {
				wp_send_json_success();
			}
		}

		public function add_review( $course_id, $rating, $review ) {
			global $wpdb;

			if ( empty( $rating ) ) {
				return new WP_Error( 'failed', esc_html__( 'Please select a rating', 'edumall' ) );
			}

			if ( empty( $course_id ) ) {
				return new WP_Error( 'failed', esc_html__( 'Please select a course', 'edumall' ) );
			}

			if ( empty( $review ) ) {
				return new WP_Error( 'failed', esc_html__( 'Please input your review', 'edumall' ) );
			}

			$rating = intval( $rating );
			$rating = min( $rating, 5 );
			$rating = max( $rating, 1 );

			$user_id = get_current_user_id();
			$user    = get_userdata( $user_id );
			$date    = date( 'Y-m-d H:i:s', tutor_time() );

			if ( ! Edumall_Tutor::instance()->has_enrolled_content_access( 'course', $course_id ) ) {
				return new WP_Error( 'failed', esc_html__( 'Access Denied', 'edumall' ) );
			}

			do_action( 'tutor_before_rating_placed' );

			$previous_rating_id = $wpdb->get_var( $wpdb->prepare( "select comment_ID from {$wpdb->comments} WHERE comment_post_ID = %d AND user_id = %d AND comment_type = 'tutor_course_rating' LIMIT 1;", $course_id, $user_id ) );

			$review_ID = $previous_rating_id;
			if ( $previous_rating_id ) {
				$wpdb->update( $wpdb->comments, array( 'comment_content' => esc_sql( $review ) ),
					array( 'comment_ID' => $previous_rating_id )
				);

				$rating_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->commentmeta} WHERE comment_id = %d AND meta_key = 'tutor_rating'; ", $previous_rating_id ) );
				if ( $rating_info ) {
					$wpdb->update( $wpdb->commentmeta, array( 'meta_value' => $rating ), array(
						'comment_id' => $previous_rating_id,
						'meta_key'   => 'tutor_rating',
					) );
				} else {
					$wpdb->insert( $wpdb->commentmeta, array(
						'comment_id' => $previous_rating_id,
						'meta_key'   => 'tutor_rating',
						'meta_value' => $rating,
					) );
				}
			} else {
				$data = array(
					'comment_post_ID'  => esc_sql( $course_id ),
					'comment_approved' => 'approved',
					'comment_type'     => 'tutor_course_rating',
					'comment_date'     => $date,
					'comment_date_gmt' => get_gmt_from_date( $date ),
					'user_id'          => $user_id,
					'comment_author'   => $user->user_login,
					'comment_agent'    => 'TutorLMSPlugin',
				);
				if ( $review ) {
					$data['comment_content'] = $review;
				}

				$wpdb->insert( $wpdb->comments, $data );
				$comment_id = (int) $wpdb->insert_id;
				$review_ID  = $comment_id;

				if ( $comment_id ) {
					$result = $wpdb->insert( $wpdb->commentmeta, array(
						'comment_id' => $comment_id,
						'meta_key'   => 'tutor_rating',
						'meta_value' => $rating,
					) );

					do_action( 'tutor_after_rating_placed', $comment_id );
				}
			}

			/**
			 * Custom code.
			 */
			$this->update_course_rating( $course_id );

			return array(
				'review_id' => $review_ID,
				'review'    => $review,
			);
		}

		public function update_review( $review_id, $rating, $review ) {
			global $wpdb;

			$rating = intval( $rating );
			$rating = min( $rating, 5 );
			$rating = max( $rating, 1 );

			if ( ! Edumall_Tutor::instance()->has_enrolled_content_access( 'review', $review_id ) ) {
				return new WP_Error( 'failed', esc_html__( 'Access Denied', 'edumall' ) );
			}

			// Get post id to add meta.
			$is_exists = $wpdb->get_row( $wpdb->prepare( "SELECT comment_ID, comment_post_ID from {$wpdb->comments} WHERE comment_ID=%d AND comment_type = 'tutor_course_rating' ;", $review_id ) );

			if ( ! empty( $is_exists ) ) {
				$wpdb->update( $wpdb->comments, array( 'comment_content' => $review ),
					array( 'comment_ID' => $review_id )
				);
				$wpdb->update( $wpdb->commentmeta, array( 'meta_value' => $rating ),
					array( 'comment_id' => $review_id, 'meta_key' => 'tutor_rating' )
				);

				$this->update_course_rating( $is_exists->comment_post_ID );

				return true;
			}

			return new WP_Error( 'failed', esc_html__( 'Can\'t update review', 'edumall' ) );
		}

		/**
		 * @param int $post_id
		 */
		public function update_course_rating( $post_id ) {
			/**
			 * Custom code here.
			 * Save meta for post.
			 */
			$course_rating = tutor_utils()->get_course_rating( $post_id );

			/**
			 * Set post meta
			 * Used for sorting.
			 */
			update_post_meta( $post_id, '_course_average_rating', $course_rating->rating_avg );

			/**
			 * Set post term visibility.
			 * Used for filtering.
			 */

			// Remove old rated term.
			$tags           = wp_get_post_terms( $post_id, 'course-visibility' );
			$tags_to_delete = [
				'rated-1',
				'rated-2',
				'rated-3',
				'rated-4',
				'rated-5',
			];
			$tags_to_keep   = [];
			foreach ( $tags as $t ) {
				if ( ! in_array( $t->name, $tags_to_delete ) ) {
					$tags_to_keep[] = $t->name;
				}
			}
			$int_rating_average = round( $course_rating->rating_avg );
			$current_term_rated = 'rated-' . $int_rating_average;

			$tags_to_keep[] = $current_term_rated;

			wp_set_post_terms( $post_id, $tags_to_keep, 'course-visibility', false );
		}
	}
}
