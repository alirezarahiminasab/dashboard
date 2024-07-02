<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;
$profile_url = apply_filters('edumall_user_profile_url', '');
?>

<div class="students-enrolled">
	<div class="students-enrolled-title">
		<a href="<?php echo esc_url($profile_url); ?>">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
		</a>
		<h3><?php esc_html_e('دوره‌های من', 'edumall-child'); ?></h3>
	</div>

	<div class="students-enrolled-wrap">
		<div class="students-enrolled-links">
			<ul>
				<li>
					<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses'); ?>">
						<?php esc_html_e('Active Courses', 'edumall-child'); ?>
					</a>
				</li>
				<li>
					<a class="active" href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/completed-courses'); ?>">
						<?php esc_html_e('Completed Courses', 'edumall-child'); ?>
					</a>
				</li>
			</ul>
		</div>

		<?php
		$active_courses = tutor_utils()->get_active_courses_by_user();
		$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';
		$completed_courses = 0;

		if ($active_courses && $active_courses->have_posts()) : ?>
			<div class="students-enrolled-courses">
				<?php while ($active_courses->have_posts()) :
					$active_courses->the_post();
					$total_lessons     = tutor_utils()->get_lesson_count_by_course();
					$completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
					$author_id = get_post_field('post_author', get_the_ID());
					$profile_photo_id    = get_user_meta($author_id, '_instructor_profile_pic', true);
					$terms = wp_get_post_terms(get_the_ID(), 'course-category');
					$author = get_userdata($author_id);
					$completed_percent   = tutor_utils()->get_course_completed_percent();

					if ($completed_percent < 100) :
						continue;
					endif;
					$completed_courses++;
				?>
					<a href="<?php the_permalink(); ?>" class="students-enrolled-courses-item tutor-mycourse-<?php the_ID(); ?>">
						<div class="students-enrolled-courses-thumbnail">

							<?php if (has_post_thumbnail()) : ?>
								<?php Edumall_Image::the_post_thumbnail([
									'size' => '327x210',
									'alt'  => get_the_title(),
								]); ?>
							<?php else : ?>
								<?php echo Edumall_Image::build_img_tag([
									'src' => $default_thumbnail_src,
									'alt' => get_the_title(),
								]) ?>
							<?php endif; ?>
						</div>
						<div class="students-enrolled-courses-completed">
							<div class="students-enrolled-courses-completed-icon">
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/check.svg' ?>" alt="">
							</div>
							<div class="students-enrolled-courses-completed-meta">
								<p><?php esc_html_e('تکمیل شده', 'edumall-child'); ?></p>
							</div>
						</div>
						<div class="students-enrolled-courses-content">
							<div class="students-enrolled-courses-content-title">
								<h3><?php the_title(); ?></h3>
							</div>
							<div class="students-enrolled-courses-content-instructor">
								<img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $default_thumbnail_src ?>" alt="">
								<p><?php echo esc_html($author->display_name); ?></p>
							</div>
							<div class="students-enrolled-courses-content-categories">
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/category.svg' ?>" alt="">
								<?php foreach ($terms as $term) : ?>
									<p>

										<?php echo $term->name; ?>
									</p>
								<?php endforeach; ?>
							</div>
						</div>

					</a>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>

		<?php if ($completed_courses === 0) : ?>
			<div class="students-enrolled-courses-empty">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoItemsCourse.png' ?>" alt="">
				<p>
					<?php esc_html_e('دوره‌ای تکمیل شده‌ای ندارید.', 'edumall-child'); ?>
				</p>
			</div>

			<div class="students-enrolled-courses-homepage">
				<a href="<?php echo esc_url(home_url('/')) ?>">
					<?php esc_html_e('صفحه اصلی', 'edumall-child'); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>