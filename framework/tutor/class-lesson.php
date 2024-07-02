<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Lesson' ) ) {
	class Edumall_Lesson {

		protected $lesson_id       = null;
		protected $video           = null;
		protected $attachments     = null;
		protected $lesson_type     = null;
		protected $sibling_lessons = null;
		protected $prev_lesson     = null;
		protected $next_lesson     = null;
		protected $completed_date  = null;
		protected $is_completed    = null;
		protected $is_preview      = null;

		public function __construct( $id = 0 ) {
			if ( $id ) {
				$this->lesson_id = $id;
			}

			$this->lesson_id = get_the_ID();
		}

		public function get_id() {
			if ( null === $this->lesson_id ) {
				$this->lesson_id = get_the_ID();
			}

			return $this->lesson_id;
		}

		public function get_video() {
			if ( null === $this->video ) {
				$this->video = tutor_utils()->get_video( $this->get_id() );
			}

			return $this->video;
		}

		public function get_attachments() {
			if ( null === $this->attachments ) {
				$this->attachments = tutor_utils()->get_attachments( $this->get_id() );
			}

			return $this->attachments;
		}

		public function get_type() {
			if ( null === $this->lesson_type ) {
				$video      = $this->get_video();
				$post_id    = $this->get_id();
				$video_info = Edumall_Tutor::instance()->get_video_info( $video, $post_id );

				$play_time = false;
				if ( $video_info ) {
					$play_time = $video_info->playtime;
				}

				$this->lesson_type = $play_time ? 'video' : 'document';
			}

			return $this->lesson_type;
		}

		public function get_sibling_lessons() {
			if ( null === $this->sibling_lessons ) {
				$this->sibling_lessons = tutils()->get_course_prev_next_contents_by_id( $this->get_id() );
			}

			return $this->sibling_lessons;
		}

		public function get_next_lesson_id() {
			if ( null === $this->next_lesson ) {
				$sibling_lessons = $this->get_sibling_lessons();

				$this->next_lesson = ! empty( $sibling_lessons->next_id ) ? intval( $sibling_lessons->next_id ) : 0;
			}

			return $this->next_lesson;
		}

		public function get_prev_lesson_id() {
			if ( null === $this->prev_lesson ) {
				$sibling_lessons = $this->get_sibling_lessons();

				$this->prev_lesson = ! empty( $sibling_lessons->previous_id ) ? intval( $sibling_lessons->previous_id ) : 0;
			}

			return $this->prev_lesson;
		}

		public function is_preview() {
			if ( null === $this->is_preview ) {
				$this->is_preview = '1' === get_post_meta( $this->get_id(), '_is_preview', true ) ? true : false;
			}

			return $this->is_preview;
		}

		public function is_completed() {
			if ( null === $this->is_completed ) {
				$this->is_completed = ! empty( $this->get_completed_date() ) ? true : false;
			}

			return $this->is_completed;
		}

		public function get_completed_date() {
			if ( null === $this->completed_date ) {
				$this->completed_date = '';

				$user_id = get_current_user_id();

				if ( $user_id ) {
					$completed_date = get_user_meta( $user_id, '_tutor_completed_lesson_id_' . $this->get_id(), true );
					if ( $completed_date ) {
						$this->completed_date = $completed_date;
					}
				}
			}

			return $this->completed_date;
		}
	}
}

add_action( 'template_redirect', 'edumall_setup_lesson_object' );

function edumall_setup_lesson_object() {
	if ( ! is_singular( 'lesson' ) ) {
		return;
	}

	/**
	 * @var Edumall_Lesson $edumall_lesson
	 */
	global $edumall_lesson;

	$edumall_lesson = new Edumall_Lesson();
}
