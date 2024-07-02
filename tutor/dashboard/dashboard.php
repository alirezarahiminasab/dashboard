<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

use Tutor\Models\CourseModel;
use Tutor\Models\WithdrawModel;

defined('ABSPATH') || exit;
?>


<?php
$user_id           = get_current_user_id();
$enrolled_course   = tutor_utils()->get_enrolled_courses_by_user();
$completed_courses = tutor_utils()->get_completed_courses_ids_by_user();
$active_courses    = tutor_utils()->get_active_courses_by_user($user_id);
$menu_state = isset($_GET['menu']) ? sanitize_text_field($_GET['menu']) : '';
$enrolled_course_count  = $enrolled_course ? $enrolled_course->post_count : 0;
$completed_course_count = count($completed_courses);
$active_course_count    = is_object($active_courses) && $active_courses->have_posts() ? $active_courses->post_count : 0;
$instructor_status = boolval(get_user_meta($user_id, '_tutor_instructor_status', true));
// update_user_meta($user_id, '_tutor_instructor_status', false);
global $wp_roles;

$all_roles = $wp_roles->roles;
$editable_roles = apply_filters('editable_roles', $all_roles);
?>

<?php if (current_user_can(tutor()->instructor_role)) : ?>
	<div class="user-menu  <?php echo $menu_state === 'tutor' ? 'active' : '' ?>">
		<?php tutor_load_template("dashboard.user-menu-setting"); ?>
	</div>
	<div class="instructor-menu <?php echo $menu_state !== 'tutor' ? 'active' : '' ?>">
		<?php tutor_load_template("dashboard.instructor-menu-setting"); ?>
	</div>
<?php else : ?>
	<div class="user-menu active">
		<?php tutor_load_template("dashboard.user-menu-setting"); ?>
	</div>
<?php endif; ?>