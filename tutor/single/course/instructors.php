<?php

/**
 * Template for displaying course instructors/ instructor
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;

$instructors = tutor_utils()->get_instructors_by_course(get_the_ID());
$instructor = $instructors[0];
$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$instructor_story_text    = get_user_meta($instructor->ID, '_instructor_story_text', true);
$instructor_profession    = get_user_meta($instructor->ID, '_instructor_profession', true);
$profile_photo_id    = get_user_meta($instructor->ID, '_instructor_profile_pic', true);
if ($instructor) {
?>
	<div class="tutor-course-instructors-wrap" id="single-course-ratings">
		<h4 class="tutor-segment-title"><?php esc_html_e('مدرس دوره', 'edumall-child'); ?></h4>
		<?php
		$profile_url = tutor_utils()->profile_url($instructor->ID);
		?>
		<div class="single-instructor-wrap">
			<div class="instructor-avatar-meta">
				<div class="instructor-avatar">
					<img width="240" src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
				</div>
				<div class="instructor-meta">
					<h3 class="instructor-name">
						<?php echo esc_html($instructor->display_name); ?>
					</h3>

					<?php if (!empty($instructor_profession)) : ?>
						<p class="instructor-job"><?php echo esc_html($instructor_profession); ?></p>
					<?php endif; ?>

					<?php
					$total_courses = tutor_utils()->get_course_count_by_instructor($instructor->ID);
					$total_students = tutor_utils()->get_total_students_by_instructor($instructor->ID);
					?>
					<div class="instructor-meta-item instructor-students-courses">
						<p class="meta-value">
							<?php echo esc_html(sprintf(_n('%s Course', '%s Courses', $total_courses, 'edumall-child'), $total_courses)); ?>
						</p>
						<p>
							|
						</p>
						<p class="meta-value">
							<?php echo esc_html(sprintf(_n('%s Student', '%s Students', $total_students, 'edumall-child'), $total_students)); ?>
						</p>
					</div>
				</div>
			</div>

			<div class="instructor-bio">
				<p>
					<?php echo wp_kses_post($instructor_story_text); ?>
				</p>
			</div>

			<a href="<?php echo esc_url($profile_url); ?>" class="instructor-profile-url primary-color">
				<?php esc_html_e('See instructor profile and courses', 'edumall-child'); ?>
			</a>
		</div>
	</div>
<?php
}

do_action('tutor_course/single/enrolled/after/instructors');
