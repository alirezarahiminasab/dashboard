<?php
defined('ABSPATH') || exit;

if (!class_exists('Edumall_Course_User')) {
	class Edumall_Course_User
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
			add_filter('edumall_user_profile_url', [$this, 'update_profile_url'], 20);
			add_filter('edumall_user_profile_text', [$this, 'update_profile_text'], 20);

			add_action('tutor_after_enroll', [$this, 'update_instructor_meta_total_students'], 10, 2);
			add_action('tutor_after_enroll', [$this, 'update_course_meta_total_enrolls'], 10, 2);

			add_action('wp_footer', [$this, 'add_popup_instructor_registration']);

			add_action('wp_ajax_nopriv_edumall_instructor_register', [$this, 'instructor_register']);

			add_action('wp_ajax_edumall_apply_instructor', [$this, 'apply_instructor']);
			add_action('wp_ajax_nopriv_edumall_apply_instructor', [$this, 'apply_instructor']);

			// Add job title to setting tab in Dashboard.
			add_action('tutor_profile_update_after', [$this, 'add_job_title_setting']);

			add_filter('tutor_dashboard/nav_items/settings/nav_items', [$this, 'add_user_preferences_tab']);

			add_action('template_redirect', [$this, 'update_user_preferences']);
			add_filter('edumall_site_skin', [$this, 'setup_site_skin_for_user'], 99);

			add_filter('tutor_enroll_required_login_class', [$this, 'change_css_class_open_login']);
		}

		public function change_css_class_open_login($css_class)
		{
			return 'open-popup-login';
		}

		public function add_user_preferences_tab($nav_items)
		{
			$custom_site_skin = Edumall::setting('allows_user_custom_site_skin');

			if ('1' === $custom_site_skin) {
				$nav_items['preferences'] = [
					'url'   => tutor_utils()->get_tutor_dashboard_page_permalink('settings/preferences'),
					'title' => __('Preferences', 'edumall-child'),
					'role'  => false,
				];
			}

			return $nav_items;
		}

		public function update_user_preferences()
		{
			if (tutils()->array_get('edumall_action', $_POST) !== 'edumall_user_preferences') {
				return;
			}

			$user_id = get_current_user_id();

			// Checking nonce.
			tutor_utils()->checking_nonce();

			do_action('edumall_user_preferences_update_before', $user_id);

			$site_skin = sanitize_text_field(tutor_utils()->input_old('site_skin'));

			update_user_meta($user_id, 'site_skin', $site_skin);

			do_action('edumall_user_preferences_update_after', $user_id);

			wp_redirect(wp_get_raw_referer());
			die();
		}

		public function setup_site_skin_for_user($site_skin)
		{
			$user_id = get_current_user_id();

			if ('1' === Edumall::setting('allows_user_custom_site_skin') && $user_id) {
				$custom_site_skin = get_user_meta($user_id, 'site_skin', true);

				if ('' !== $custom_site_skin) {
					$site_skin = $custom_site_skin;
				}
			}

			return $site_skin;
		}

		public function update_profile_url()
		{
			return tutor_utils()->get_tutor_dashboard_page_permalink();
		}

		public function update_profile_text()
		{
			return esc_html__('Dashboard', 'edumall-child');
		}

		public function add_job_title_setting($user_id)
		{
			$job_title = sanitize_text_field(tutor_utils()->input_old('tutor_profile_job_title'));

			update_user_meta($user_id, '_tutor_profile_job_title', $job_title);
		}

		public function add_popup_instructor_registration()
		{
			tutor_load_template('global.popup-instructor-registration');
		}

		public function instructor_register()
		{
			if (!check_ajax_referer('instructor_register', 'instructor_register_nonce')) {
				wp_die();
			}

			/**
			 * Return array to prevent user login.
			 * For eg: array = [
			 *   'success'  => false,
			 *   'messages' => 'Some messages',
			 * ]
			 *
			 * @since 2.5.0
			 */
			$result = apply_filters('edumall_pre_instructor_register', null);

			if (null !== $result) {
				echo json_encode($result);
				wp_die();
			}

			$fullname   = $_POST['fullname'];
			$user_login = $_POST['username'];
			$email      = $_POST['email'];
			$password   = $_POST['password'];

			// Remove all illegal characters from email.
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);

			$response = [
				'success'  => false,
				'messages' => esc_html__('Username/Email address is existing', 'edumall-child'),
			];

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$response = [
					'success'  => false,
					'messages' => esc_html__('A valid email address is required', 'edumall-child'),
				];
			} else {
				$userdata = [
					'first_name' => $fullname,
					'user_login' => $user_login,
					'user_email' => $email,
					'user_pass'  => $password,
				];

				$user_id = wp_insert_user($userdata);

				if (!is_wp_error($user_id)) {
					update_user_meta($user_id, '_is_tutor_instructor', tutor_time());

					$register_immediately = get_tutor_option('instructor_register_immediately');

					/**
					 * @since 2.7.4
					 */
					$register_immediately = apply_filters('edumall_tutor_become_instructor_immediately', $register_immediately);

					if (1 == $register_immediately || 'on' === $register_immediately) {
						/**
						 * @see \TUTOR\Instructor::instructor_approval_action()
						 */
						do_action('tutor_before_approved_instructor', $user_id);

						update_user_meta($user_id, '_tutor_instructor_status', 'approved');
						update_user_meta($user_id, '_tutor_instructor_approved', tutor_time());

						$instructor = new \WP_User($user_id);
						$instructor->add_role(tutor()->instructor_role);

						do_action('tutor_after_approved_instructor', $user_id);
					} else {
						update_user_meta($user_id, '_tutor_instructor_status', apply_filters('tutor_initial_instructor_status', 'pending'));
					}

					do_action('tutor_new_instructor_after', $user_id);

					$creds                  = array();
					$creds['user_login']    = $user_login;
					$creds['user_email']    = $email;
					$creds['user_password'] = $password;
					$creds['remember']      = true;
					$user                   = wp_signon($creds, false);

					$response = [
						'success'  => true,
						'messages' => esc_html__('Congratulations, register successful, Redirecting...', 'edumall-child'),
						'redirect' => true,
					];
				}
			}

			echo wp_json_encode($response);

			wp_die();
		}

		public function apply_instructor()
		{
			if (!check_ajax_referer('apply_instructor', 'apply_instructor_nonce')) {
				wp_die();
			}

			$response = $this->do_apply_instructor();

			echo wp_json_encode($response);

			wp_die();
		}

		public function do_apply_instructor()
		{
			$user_id = get_current_user_id();

			if ($user_id) {
				if (tutor_utils()->is_instructor()) {
					$response = [
						'success'  => 0,
						'messages' => esc_html__('Already applied for instructor!', 'edumall-child'),
					];
				} else {
					update_user_meta($user_id, '_is_tutor_instructor', tutor_time());

					$register_immediately = get_tutor_option('instructor_register_immediately');

					/**
					 * @since 2.7.4
					 */
					$register_immediately = apply_filters('edumall_tutor_become_instructor_immediately', $register_immediately);

					if (1 == $register_immediately || 'on' === $register_immediately) {
						/**
						 * @see \TUTOR\Instructor::instructor_approval_action()
						 */
						do_action('tutor_before_approved_instructor', $user_id);

						update_user_meta($user_id, '_tutor_instructor_status', 'approved');
						update_user_meta($user_id, '_tutor_instructor_approved', tutor_time());

						$instructor = new \WP_User($user_id);
						$instructor->add_role(tutor()->instructor_role);

						do_action('tutor_after_approved_instructor', $user_id);

						$response = [
							'success'  => 1,
							'messages' => esc_html__('Congratulations, You are Instructor.', 'edumall-child'),
						];
					} else {
						update_user_meta($user_id, '_tutor_instructor_status', apply_filters('tutor_initial_instructor_status', 'pending'));

						$response = [
							'success'  => 1,
							'messages' => esc_html__('Your request is sent successfully.', 'edumall-child'),
						];
					}

					do_action('tutor_new_instructor_after', $user_id);
				}
			} else {
				$response = [
					'success'  => 0,
					'messages' => esc_html__('Permission denied!', 'edumall-child'),
				];
			}

			return $response;
		}

		/**
		 * Update total students for all instructors of enrolled course.
		 *
		 * @param $course_id
		 * @param $isEnrolled
		 */
		public function update_instructor_meta_total_students($course_id, $isEnrolled)
		{
			// Get all instructors of the course.
			$instructors = tutor_utils()->get_instructors_by_course($course_id);

			if (empty($instructors)) {
				return;
			}

			foreach ($instructors as $instructor) {
				// Then update instructor meta total students.
				$total_students = Edumall_Tutor::instance()->get_total_student_enrollments_by_instructor($instructor->ID);

				update_user_meta($instructor->ID, '_tutor_total_students', $total_students);
			}
		}

		public function update_course_meta_total_enrolls($course_id, $isEnrolled)
		{
			$total_enrolls = tutor_utils()->count_enrolled_users_by_course($course_id);

			update_post_meta($course_id, '_course_total_enrolls', $total_enrolls);
		}
	}
}
