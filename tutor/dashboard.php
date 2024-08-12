<?php

/**
 * Template for displaying student Public Profile
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.2.2
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();

$is_by_short_code = isset($is_shortcode) && $is_shortcode === true;
if (!$is_by_short_code && !defined('OTLMS_VERSION')) {
	get_header();
}

global $wp_query;
global $wp;

$current_url = trailingslashit(home_url(add_query_arg(array(), $wp->request)));
$dashboard_pattern = '/(?:(dashboard\/[a-z0-9]{0,}\/)(*FAIL)|dashboard\/?$)/';
$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['tutor_dashboard_page']) && $wp_query->query_vars['tutor_dashboard_page']) {
	$dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}

/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['tutor_dashboard_sub_page']) && $wp_query->query_vars['tutor_dashboard_sub_page']) {
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_sub_page'];
	if ($dashboard_page_slug) {
		$dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
	}
}
$menu_state = isset($_GET['menu']) ? sanitize_text_field($_GET['menu']) : '';
$user_id                   = get_current_user_id();
$user                      = get_user_by('ID', $user_id);
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$full_name = trim($first_name . ' ' . $last_name);
$enable_profile_completion = tutils()->get_option('enable_profile_completion');
$profile_url  = tutor_utils()->get_tutor_dashboard_page_permalink();

$total_course_arg = array(
	'author' => get_current_user_id(),
	'post_type' => 'courses',
	'posts_per_page' => -1, // Get all posts
	'fields' => 'ids' // We only need the IDs to count
);

$total_courses = new WP_Query($total_course_arg);
$total_hours = 0;

foreach ($total_courses->posts as $course) :
	$duration        = get_post_meta($course, '_course_duration', true);
	$durationHours   = intval(tutor_utils()->avalue_dot('hours', $duration));
	$total_hours += $durationHours;
endforeach;

$total_event_arg = array(
	'author' => get_current_user_id(),
	'post_type' => 'tp_event',
	'posts_per_page' => -1, // Get all posts
	'fields' => 'ids' // We only need the IDs to count
);

$total_events = new WP_Query($total_event_arg);

$enrolled_course   = tutor_utils()->get_enrolled_courses_by_user();
$completed_courses = tutor_utils()->get_completed_courses_ids_by_user();
$active_courses    = tutor_utils()->get_active_courses_by_user($user_id);

$total_courses_enrolled_hours = 0;

if (!empty($enrolled_course->posts)) :
	foreach ($enrolled_course->posts as $course) :
		$duration        = get_post_meta($course->id, '_course_duration', true);
		$durationHours   = intval(tutor_utils()->avalue_dot('hours', $duration));
		$total_courses_enrolled_hours += $durationHours;
	endforeach;
endif;

$enrolled_course_count  = $enrolled_course ? $enrolled_course->post_count : 0;
$completed_course_count = count($completed_courses);
$active_course_count    = is_object($active_courses) && $active_courses->have_posts() ? $active_courses->post_count : 0;
$profile_photo_id    = get_user_meta($user_id, '_instructor_profile_pic', true);
$username    = get_user_meta($user_id, '_instructor_username', true);
$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';
$instructor_status = boolval(get_user_meta($user_id, '_tutor_instructor_status', true));
?>
<div class="user-dashboard">
	<?php if (!$detect->isMobile()) : ?>
		<div class="user-dashboard-transition"></div>
		<div class="user-dashboard-transition user-dashboard-transition--2"></div>
		<div class="user-dashboard-transition user-dashboard-transition--3"></div>
		<div class="user-dashboard-transition user-dashboard-transition--4"></div>
	<?php endif ?>
	<?php if (!$detect->isMobile()) : ?>
		<div class="user-dashboard-desktop-right">
		<?php endif; ?>
		<?php if (!$dashboard_page_name || !$detect->isMobile()) : ?>
			<div class="user-dashboard-header-wrap">
				<div class="tutor-dashboard-header <?php echo ($menu_state !== 'tutor') && !$detect->isMobile() && (current_user_can(tutor()->instructor_role) || $instructor_status) ? "tutor-dashboard-header-desktop" : '' ?>">
					<?php if ((current_user_can(tutor()->instructor_role) || $instructor_status) && $detect->isMobile()) : ?>
						<div class="tutor-dashboard-header-switch">
							<div class="switch-container <?php echo $menu_state === 'tutor' ? '' : 'active' ?>" data-userType='instructor'>
								<a href="#">
									<?php esc_html_e('پروفایل تدریس', 'edumall-child'); ?>
								</a>
							</div>
							<div class="switch-container <?php echo $menu_state === 'tutor' ?  'active' : '' ?>" data-userType='user'>
								<a href="#">
									<?php esc_html_e('پروفایل یادگیری', 'edumall-child'); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>

					<div class="tutor-header-user-info">
						<div class="tutor-dashboard-header-avatar">
							<img class="profile-picture" src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $default_thumbnail_src ?>" alt="">
						</div>
						<div class="tutor-dashboard-header-info">
							<h4 class="tutor-dashboard-header-display-name">
								<?php echo esc_html($full_name); ?>
							</h4>
							<p class="tutor-dashboard-header-display-name">
								<?php echo esc_html($username); ?>
							</p>
						</div>
					</div>

					<?php if (current_user_can(tutor()->instructor_role) || $instructor_status) : ?>
						<div class="tutor-dashboard-header-held <?php echo $menu_state !== 'tutor' ? 'active' : '' ?>">
							<div class="meta-box course-created">
								<h4>
									<?php echo $total_courses->found_posts ?>
								</h4>
								<p>
									<?php esc_html_e('دوره‌ ساخته‌ام', 'edumall-child'); ?>
								</p>
							</div>
							<span class="separator"></span>
							<!-- TODO -->
							<!-- Implement enrolled events -->
							<div class="meta-box event-created">
								<h4>
									<?php echo $total_events->found_posts ?>
								</h4>
								<p>
									<?php esc_html_e('رویداد برگزار کرده‌ام', 'edumall-child'); ?>
								</p>
							</div>
							<span class="separator"></span>
							<!-- TODO -->
							<!-- Implement hours complemented -->
							<div class="meta-box course-hours">
								<h4>
									<?php echo $total_hours ?>
								</h4>
								<p>
									<?php esc_html_e('ساعت آموزش تولید کرده‌ام', 'edumall-child'); ?>
								</p>
							</div>
						</div>
					<?php endif; ?>

					<div class="tutor-dashboard-header-enrollment <?php echo $menu_state === 'tutor' ? 'active' : '' ?>">
						<div class="meta-box course-enroll">
							<h4>
								<?php echo $enrolled_course_count ?>
							</h4>
							<p>
								<?php esc_html_e('دوره خریده‌ام', 'edumall-child'); ?>
							</p>
						</div>
						<span class="separator"></span>
						<!-- TODO -->
						<!-- Implement enrolled events -->
						<div class="meta-box event-enroll">
							<h4>
								<?php echo 0 ?>
							</h4>
							<p>
								<?php esc_html_e('رویداد ثبت‌نام کرده‌ام', 'edumall-child'); ?>
							</p>
						</div>
						<span class="separator"></span>
						<!-- TODO -->
						<!-- Implement hours complemented -->
						<div class="meta-box learning-hours">
							<h4>
								<?php echo $total_courses_enrolled_hours ?>
							</h4>
							<p>
								<?php esc_html_e('ساعت آموزش دیده‌ام', 'edumall-child'); ?>
							</p>
						</div>
					</div>


					<?php Edumall_Header::instance()->print_open_canvas_menu_button(); ?>
				</div>
			</div>
		<?php endif ?>

		<?php tutor_load_template("dashboard.ads"); ?>

		<?php if (!$detect->isMobile()) : ?>
			<div class="user-dashboard-button">
				<a class="user-dashboard-button-learning <?php echo $menu_state !== 'tutor' ? 'active' : '' ?>" href="<?php echo $profile_url . '?menu=tutor' ?>">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/profile-learning-icon-desktop.svg' ?>" alt="">
					<p>
						<?php esc_html_e('پروفایل یادگیری', 'edumall-child'); ?>
					</p>
				</a>
				<?php if (current_user_can(tutor()->instructor_role) || $instructor_status) : ?>
					<a class="user-dashboard-button-teaching <?php echo $menu_state === 'tutor' ? 'active' : '' ?>" href="<?php echo $profile_url ?>">
						<img src=" <?php echo get_stylesheet_directory_uri() . '/assets/images/profile-icon-desktop.svg' ?>" alt="">
						<p>
							<?php esc_html_e('پروفایل تدریس', 'edumall-child'); ?>
						</p>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="user-dashboard-main-content">
			<?php do_action('tutor_dashboard/notification_area'); ?>


			<div class="user-dashboard-menus">

				<?php
				if ($dashboard_page_name && $detect->isMobile()) {
					do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
					/**
					 * Load dashboard template part from other location
					 *
					 * this filter is basically added for adding templates from respective addons
					 *
					 * @since version 1.9.3
					 */
					$other_location      = '';
					$from_other_location = apply_filters('load_dashboard_template_part_from_other_location', $other_location);
					if ('' !== $from_other_location) {
						$from_other_location = trailingslashit($from_other_location);
					}
					if ('' === $from_other_location) {
						tutor_load_template("dashboard." . $dashboard_page_name);
					} else {
						//load template from other location full abspath.
						include_once $from_other_location;
					}

					do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
				} else {
					tutor_load_template("dashboard.dashboard");
				}
				?>
			</div>
		</div>

		<?php if (!$detect->isMobile()) : ?>
		</div>
	<?php endif; ?>


	<?php if (!$detect->isMobile()) : ?>
		<div class="user-dashboard-desktop-left">
			<?php
			if ($dashboard_page_name) {
				do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
				/**
				 * Load dashboard template part from other location
				 *
				 * this filter is basically added for adding templates from respective addons
				 *
				 * @since version 1.9.3
				 */
				$other_location      = '';
				$from_other_location = apply_filters('load_dashboard_template_part_from_other_location', $other_location);
				if ('' !== $from_other_location) {
					$from_other_location = trailingslashit($from_other_location);
				}
				if ('' === $from_other_location) {
					tutor_load_template("dashboard." . $dashboard_page_name);
				} else {
					//load template from other location full abspath.
					include_once $from_other_location;
				}

				do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
			}
			?>
		</div>
	<?php endif; ?>
</div>
<?php
if (!$is_by_short_code && !defined('OTLMS_VERSION')) {
	get_footer();
}
