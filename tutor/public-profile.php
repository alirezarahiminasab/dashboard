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
 * @theme-since   3.1.0
 * @theme-version 3.1.0
 */

defined('ABSPATH') || exit;

get_header();

global $wp_query;

$user_name = sanitize_text_field(get_query_var(Edumall_Tutor::PROFILE_QUERY_VAR));
$sub_page  = sanitize_text_field(get_query_var('profile_sub_page'));
$get_user  = tutor_utils()->get_user_by_login($user_name);
$user_id = $get_user->ID;
$instructor_profession    = get_user_meta($user_id, '_instructor_profession', true);
$profile_photo_id    = get_user_meta($user_id, '_instructor_profile_pic', true);
$instructor_tags = get_user_meta($user_id, '_instructor_tags', true);
$total_students = tutor_utils()->get_total_students_by_instructor($user_id);
$my_courses     = tutor_utils()->get_courses_by_instructor($user_id);
$my_course_count = count($my_courses);
$profile_placeholder = Edumall_Helper::placeholder_avatar_src();

if (empty($get_user)) {
	return;
}

$event_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = '" . $user_id . "' AND post_type = 'tp_event' AND post_status = 'publish'");

global $wp_query;

$profile_sub_page = '';
if (isset($wp_query->query_vars['profile_sub_page']) && $wp_query->query_vars['profile_sub_page']) {
	$profile_sub_page = $wp_query->query_vars['profile_sub_page'];
}

$bookmark = $course_extend->is_bookmarked(get_the_ID(), $user_id, 'instructor');
?>
<div class="page-content">
	<div class="tutor-dashboard-header-wrap">
		<div class="tutor-dashboard-header">
			<div class="tutor-dashboard-breadcrumb">
				<a class="item" href="<?php echo get_home_url() ?>"><?php echo esc_html__('home', 'edumall-child') ?></a>
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left-white.png' ?>" alt="">
				<a class="item" href="#"><?php echo esc_html__('Instructors', 'edumall-child') ?></a>
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left-white.png' ?>" alt="">
				<p class="item"><?php echo esc_html($get_user->display_name); ?></p>
			</div>
			<div class="tutor-dashboard-user-meta">
				<div class="avatar-courses-wrap">
					<div class="avatar">
						<img width="96" height="96" src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
					</div>
					<div class="instructor-stats">
						<div class="item">
							<p class="count"><?php echo $my_course_count ?></p>
							<p class="name"><?php esc_html_e('دوره', 'edumall-child'); ?></p>
						</div>
						<div class="item">
							<p class="count"><?php echo $event_count ?></p>
							<p class="name"><?php esc_html_e('رویداد', 'edumall-child'); ?></p>
						</div>
						<div class="item">
							<p class="count"><?php echo $total_students ?></p>
							<p class="name"><?php esc_html_e('دانشجو', 'edumall-child'); ?></p>
						</div>
					</div>
				</div>
				<div class="user-profile-info">
					<p class="display-name">
						<?php echo esc_html($get_user->display_name); ?>
					</p>

					<p class="job-title">
						<?php echo esc_html($instructor_profession); ?>
					</p>

					<?php if (user_can($user_id, tutor()->instructor_role)) : ?>
						<?php
						$instructor_rating       = tutils()->get_instructor_ratings($get_user->ID);
						$instructor_rating_count = sprintf(
							_n('%s rating', '%s ratings', $instructor_rating->rating_count, 'edumall-child'),
							number_format_i18n($instructor_rating->rating_count)
						);
						?>
						<div class="tutor-dashboard-ratings">
							<?php Edumall_Templates::render_rating($instructor_rating->rating_avg) ?>
							<p class="rating-average"><?php echo "5/" . esc_html(number_format($instructor_rating->rating_avg, 0)); ?></p>
						</div>
					<?php endif; ?>

					<div class="hash-tags">
						<?php if (!empty($instructor_tags)) : ?>
							<?php foreach ($instructor_tags as $tag) : ?>
								<p># <?php echo $tag ?></p>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<!-- TODO -->
			<!-- Implement buttons -->
			<div class="tutor-dashboard-buttons">
				<div class="like">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/heart-white.png' ?>" alt="">
					<p class="name"><?php esc_html_e('پسند کردن', 'edumall-child'); ?></p>
				</div>
				<div class="bookmark" data-type="instructor" data-id="<?php echo $user_id ?>" data-callback="<?php esc_html_e('مربی', 'edumall-child'); ?>">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-transparent.png' ?>" alt="">
					<p>
						<?php echo $bookmark ? esc_html('حذف از نشان شده ها', 'edumall-child') : esc_html('نشان کردن', 'edumall-child') ?>
					</p>
				</div>
			</div>

			<?php Edumall_Header::instance()->print_open_canvas_menu_button(); ?>
		</div>
	</div>
	<div class="tutor-dashboard-content">
		<?php
		if ($sub_page) {
			tutor_load_template('profile.' . $sub_page, compact('get_user'));
		} else {
			tutor_load_template('profile.bio', compact('get_user'));
		}
		?>

		<?php
		tutor_load_template('profile.reviews', array('user_id' => $user_id));
		?>

		<?php
		tutor_load_template('profile.events', array('user_id' => $user_id));
		?>

		<?php
		tutor_load_template('profile.courses', array('user_id' => $user_id));
		?>

		<?php
		tutor_load_template('profile.posts', array('user_id' => $user_id));
		?>

		<?php
		tutor_load_template('profile.ads');
		?>

		<?php
		tutor_load_template('profile.forum');
		?>
	</div>
</div>
<?php
get_footer();
