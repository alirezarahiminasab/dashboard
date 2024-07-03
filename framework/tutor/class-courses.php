<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Courses' ) ) {
	class Edumall_Courses {
		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			/**
			 * Frontend Dashboard
			 */
			add_action( 'wp_ajax_edumall_delete_dashboard_course', [ $this, 'delete_dashboard_course' ] );

			// Fix Tag Name.
			add_filter( 'register_taxonomy_args', [ $this, 'fix_tax_tag_name' ], 99, 2 );
		}

		/**
		 * Added hook to prevent trash course.
		 *
		 * @see \TUTOR\Course::tutor_delete_dashboard_course()
		 *
		 * @return mixed|void
		 */
		public function delete_dashboard_course() {
			$course_id = intval( sanitize_text_field( $_POST['course_id'] ) );

			/**
			 * Filters whether a post trashing should take place.
			 *
			 * @since 1.2.2
			 *
			 * @param bool|null $trash Whether to go forward with trashing.
			 * @param int       $course_id
			 */
			$check = apply_filters( 'edumall_pre_trash_course', null, $course_id );
			if ( null !== $check ) {
				return $check;
			}

			wp_trash_post( $course_id );
			wp_send_json_success( [ 'element' => 'course' ] );
		}

		public function fix_tax_tag_name( $args, $taxonomy ) {
			if ( $taxonomy === Edumall_Tutor::instance()->get_tax_tag() ) {
				$args['labels']['name'] = _x( 'Course Tags', 'taxonomy general name', 'edumall' );
			}

			return $args;
		}
	}
}
