<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Single_Lesson' ) ) {
	class Edumall_Single_Lesson {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'body_class', [ $this, 'body_class' ] );

			add_filter( 'edumall_title_bar_type', [ $this, 'setup_title_bar' ] );

			add_filter( 'insight_core_breadcrumb_single_before', [
				$this,
				'add_breadcrumb_course_link_for_lessons',
			], 99, 3 );

			// Disable archive link for lessons.
			add_filter( 'register_post_type_args', [ $this, 'remove_archive_link' ], 11, 2 );

			add_filter( 'post_type_link', [ $this, 'fix_single_lessons_slug' ], 10, 2 );

			add_filter( 'tutor_lesson/single/complete_form', [ $this, 'hide_complete_form_for_unenrolled_users' ] );
		}

		/**
		 * @param $output
		 *
		 * @return string
		 *
		 * @since 2.9.6
		 */
		public function hide_complete_form_for_unenrolled_users( $output ) {
			global $post;

			$lesson_id = $post->ID;
			$course_id = tutor_utils()->get_course_id_by( 'lesson', $lesson_id );

			$is_public = get_post_meta( $course_id, '_tutor_is_public_course', true );

			if ( 'yes' !== $is_public && ! tutor_utils()->is_enrolled( $course_id ) ) {
				return '';
			}

			return $output;
		}

		/**
		 * Fix single lessons url
		 *
		 * @param     $post_link
		 * @param int $id
		 *
		 * @return string
		 *
		 * @see     \TUTOR\Rewrite_Rules::add_rewrite_rules();
		 * @see     \TUTOR\Rewrite_Rules::change_lesson_single_url();
		 * @see     \TUTOR_ASSIGNMENTS\Assignments::change_assignment_single_url();
		 *
		 * @since   2.8.0
		 * @version 3.7.1
		 */
		public function fix_single_lessons_slug( $post_link, $id = 0 ) {
			$post = get_post( $id );

			global $wpdb;

			$course_base_slug = 'sample-course';
			$course_post_type = tutor()->course_post_type;

			if ( is_object( $post ) ) {
				if ( Edumall_Tutor::instance()->is_course_lesson_type( $post->post_type ) ) {
					/**
					 * Fix Here:
					 * We should get post id instead of get meta of lesson types.
					 */
					/*$course_id = get_post_meta( $post->ID, '_tutor_course_id_for_assignments', true );*/
					$course_id             = Edumall_Tutor::instance()->get_course_id_by_lessons_id( $post->ID );
					$course_base_permalink = tutor_utils()->get_option( 'course_permalink_base', 'courses' );

					switch ( $post->post_type ) {
						case Edumall_Tutor::instance()->get_quiz_type():
							$lesson_base_permalink = tutor_utils()->get_option( 'quiz_permalink_base', 'quizzes' );
							break;
						case Edumall_Tutor::instance()->get_assignment_type():
							$lesson_base_permalink = tutor_utils()->get_option( 'assignment_permalink_base', 'assignments' );;
							break;
						case Edumall_Tutor::instance()->get_zoom_meeting_type():
							$lesson_base_permalink = 'zoom-lessons';
							break;
						case Edumall_Tutor::instance()->get_google_meet_type():
							$lesson_base_permalink = 'meet-lessons';
							break;
						default:
							$lesson_base_permalink = tutor_utils()->get_option( 'lesson_permalink_base', 'lessons' );
							break;
					}

					if ( $course_id ) {
						$course = $wpdb->get_row( "SELECT {$wpdb->posts}.post_name from {$wpdb->posts} where ID = {$course_id} " );
						if ( $course ) {
							$course_base_slug = $course->post_name;
						}

						return home_url( "/{$course_base_permalink}/{$course_base_slug}/{$lesson_base_permalink}/" . $post->post_name . '/' );
					} else {
						return home_url( "/{$course_base_permalink}/sample-course/{$lesson_base_permalink}/" . $post->post_name . '/' );
					}
				}
			}

			return $post_link;
		}

		public function body_class( $classes ) {
			if ( Edumall_Tutor::instance()->is_single_lessons() ) {
				$enable_spotlight_mode = tutor_utils()->get_option( 'enable_spotlight_mode' );

				if ( '1' === $enable_spotlight_mode ) {
					$classes [] = 'lesson-spotlight-mode';
				}
			}

			return $classes;
		}

		public function setup_title_bar( $type ) {
			if ( Edumall_Tutor::instance()->is_single_lessons() ) {
				return '05';
			}

			return $type;
		}

		public function remove_archive_link( $args, $post_type ) {
			if ( Edumall_Tutor::instance()->is_course_lesson_type( $post_type ) ) {
				$args['has_archive'] = false;
			}

			return $args;
		}

		/**
		 * Improvement breadcrumb links.
		 *
		 * @param $breadcrumb_arr
		 * @param $post
		 * @param $args
		 *
		 * @return array
		 */
		public function add_breadcrumb_course_link_for_lessons( $breadcrumb_arr, $post, $args ) {
			$post_type = $post->post_type;

			$course_id = 0;

			if ( in_array( $post_type, Edumall_Tutor::instance()->get_course_lesson_types(), true ) ) {
				$course_id = Edumall_Tutor::instance()->get_course_id_by_lessons_id( $post->ID );
			}

			if ( $course_id ) {
				$course_object = get_post_type_object( Edumall_Tutor::instance()->get_course_type() );

				if ( $course_object && $course_object->has_archive ) {
					$breadcrumb_arr[] = array(
						'title' => sprintf( $args['post_type_label'], $course_object->label ),
						'link'  => get_post_type_archive_link( $course_object->name ),
					);
				}

				$course = get_post( $course_id );
				if ( $course ) {
					$breadcrumb_arr [] = [
						'title' => sprintf( $args['attachment_label'], $course->post_title ),
						'link'  => get_permalink( $course->ID ),
					];
				}

				$lesson_object = get_post_type_object( $post_type );

				$breadcrumb_arr [] = [
					'title' => sprintf( $args['post_type_label'], $lesson_object->label ),
					'link'  => '',
				];
			}

			return $breadcrumb_arr;
		}

		/**
		 * Re-add function for back compatible with old Tutor LMS
		 *
		 * @param bool $echo
		 *
		 * @return mixed
		 * @see tutor_course_single_sidebar()
		 *
		 */
		public function lessons_sidebar( $echo = true ) {
			ob_start();
			tutor_load_template( 'single.lesson.lesson_sidebar' );
			$output = apply_filters( 'tutor_lesson/single/lesson_sidebar', ob_get_clean() );

			if ( $echo ) {
				echo tutor_kses_html( $output );
			}

			return $output;
		}
	}
}
