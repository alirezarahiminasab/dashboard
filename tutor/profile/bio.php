<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.8.10
 */


defined('ABSPATH') || exit;

use Detection\MobileDetect;
use CourseExtend\CourseExtend;

$detect = new MobileDetect();
$profile_user_id = $get_user->ID;

$enrolled_course   = tutor_utils()->get_enrolled_courses_by_user($profile_user_id);
$completed_courses = tutor_utils()->get_completed_courses_ids_by_user($profile_user_id);

$enrolled_course_count  = $enrolled_course ? $enrolled_course->post_count : 0;
$completed_course_count = count($completed_courses);
$active_course_count    = $enrolled_course_count - $completed_course_count;
?>

<?php
$display_name = $get_user->display_name;
$phone_number = get_user_meta($profile_user_id, 'phone_number', true);
$instructor_story_text    = get_user_meta($profile_user_id, '_instructor_story_text', true);
$placeholder  = __('________', 'edumall-child');

$instructor_video = CourseExtend::get_instructor_video_story($profile_user_id)['result'] ? CourseExtend::get_instructor_video_story($profile_user_id)['url'] : '';

?>
<div class="tutor-dashboard-content-bio">
	<h3 class="bio-title"><?php esc_html_e('روایت مربی', 'edumall-child'); ?></h3>
	<?php if ($detect->isMobile()) : ?>
		<div class="profile-reel-video">
			<video src="<?php echo !empty($instructor_video) ? $instructor_video : '#' ?>"></video>
			<img class="profile-reel-play" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/play-circle.png' ?>" alt="">
		</div>
	<?php endif; ?>
	<div class="profile-bio-description">
		<p><?php echo  $instructor_story_text ? $instructor_story_text : $placeholder; ?></p>
	</div>
</div>