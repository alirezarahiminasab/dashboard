<?php
defined('ABSPATH') || exit;

if (!class_exists('Edumall_Single_Course')) {
	class Edumall_Single_Course
	{

		protected static $instance = null;

		public static function instance()
		{
			if (null === self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize()
		{
			add_filter('body_class', [$this, 'body_class']);

			add_action('save_post', array($this, 'save_custom_fields'));

			add_filter('edumall/tutor_course/contents/lesson/title', [
				$this,
				'mark_lesson_title_preview',
			], 10, 2);

			add_action('tutor_save_course_after', [$this, 'sync_course_duration'], 10, 2);

			/**
			 * This hook only working with Classic Editor.
			 */
			add_filter('wp_dropdown_users_args', [$this, 'add_instructor_to_author_dropdown'], 10, 2);

			add_filter('wp_insert_post_data', [$this, 'fix_post_author'], 9999, 2);
		}

		public function body_class($classes)
		{
			if (Edumall_Tutor::instance()->is_single_course()) {
				$style     = Edumall::setting('single_course_layout');
				$classes[] = "single-course-{$style}";

				$student_must_login_to_view_course = tutor_utils()->get_option('student_must_login_to_view_course');
				if ($student_must_login_to_view_course && !is_user_logged_in()) {
					$classes[] = 'required-login';
				}
			}

			return $classes;
		}

		/**
		 * @param $title
		 * @param $post_id
		 *
		 * @return string
		 *
		 * Mark lesson title preview from this method
		 * @see \TUTOR_CP\CoursePreview::mark_lesson_title_preview()
		 */
		public function mark_lesson_title_preview($title, $post_id)
		{
			$is_preview = (bool) get_post_meta($post_id, '_is_preview', true);
			$icon = get_stylesheet_directory_uri() . "/assets/images/play.svg";
			if ($is_preview) {
				$newTitle = '<span class="lesson-preview-title"></span><span class="lesson-preview-icon"><a class="button btn-lesson-preview" href="' . get_the_permalink($post_id) . '">' . esc_html__('Preview', 'edumall-child') . '</a></span>';
			} else {
				$newTitle = '<span class="lesson-preview-title"></span><span class="lesson-preview-icon"><img src="' . $icon . '" alt=""><p>شروع کنید</p></span>';
			}
			return $newTitle;
		}

		/**
		 * Tutor save course duration as array serialize.
		 * So we need add extra meta key of duration to filterable.
		 * Convert duration to seconds.
		 */
		public function sync_course_duration($post_ID, $post)
		{
			$course_duration_seconds = 0;

			// Course Duration.
			if (!empty($_POST['course_duration'])) {
				$duration = $_POST['course_duration'];

				$hours = intval($duration['hours']);

				if ($hours > 0) {
					$course_duration_seconds += $hours * HOUR_IN_SECONDS;
				}

				$minutes = intval($duration['minutes']);

				if ($minutes > 0) {
					$course_duration_seconds += $minutes * MINUTE_IN_SECONDS;
				}

				$seconds = intval($duration['seconds']);

				if ($seconds > 0) {
					$course_duration_seconds += $seconds;
				}
			}

			update_post_meta($post_ID, '_course_duration_in_seconds', $course_duration_seconds);
		}

		public function add_instructor_to_author_dropdown($query_args, $r)
		{
			$screen = get_current_screen();

			$user  = wp_get_current_user();
			$roles = (array) $user->roles;

			/**
			 * Only allows administrator or editor assign course author.
			 */
			$allowed_roles = ['administrator', 'editor'];

			if ($screen->post_type == 'courses' && count(array_intersect($roles, $allowed_roles)) > 0) :
				// Add instructors.
				$query_args['role__in'] = array_merge($query_args['role__in'], array(tutor()->instructor_role));

				// Unset default role
				unset($query_args['who']);
			endif;

			return $query_args;
		}

		/**
		 * Fix administrator can not assign course for an instructor
		 *
		 * @see tutor_add_gutenberg_author()
		 *
		 * @param array $data
		 * @param array $postarr
		 *
		 * @return array
		 */
		public function fix_post_author($data = array(), $postarr = array())
		{
			$courses_post_type = tutor()->course_post_type;
			$post_type         = $postarr['post_type'];

			if ($courses_post_type === $post_type) {
				if (isset($_REQUEST['post_author_override'])) {
					$data['post_author'] = intval($_REQUEST['post_author_override']);
				} else {
					global $wpdb;
					$post_ID     = (int) tutor_utils()->avalue_dot('ID', $postarr);
					$post_author = (int) $wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID = {$post_ID} ");

					if ($post_author > 0) {
						$data['post_author'] = $post_author;
					} else {
						$data['post_author'] = get_current_user_id();
					}
				}
			}

			return $data;
		}
	}
}
