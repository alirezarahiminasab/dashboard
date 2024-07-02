<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;
?>

<h3><?php esc_html_e('Active Course', 'edumall-child'); ?></h3>

<div class="tutor-dashboard-content-inner">
	<div class="tutor-dashboard-inline-links">
		<ul>
			<li>
				<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses'); ?>">
					<?php esc_html_e('All Courses', 'edumall-child'); ?>
				</a>
			</li>
			<li class="active">
				<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/active-courses'); ?>">
					<?php esc_html_e('Active Courses', 'edumall-child'); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/completed-courses'); ?>">
					<?php esc_html_e('Completed Courses', 'edumall-child'); ?>
				</a>
			</li>
		</ul>
	</div>

	<?php
	$active_courses = tutor_utils()->get_active_courses_by_user();

	if ($active_courses && $active_courses->have_posts()) : ?>
		<div class="dashboard-enrolled-courses edumall-animation-zoom-in">
			<?php while ($active_courses->have_posts()) :
				$active_courses->the_post();

				$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
			?>
				<a href="<?php the_permalink(); ?>" class="edumall-box link-secret tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
					<div class="edumall-image tutor-mycourse-thumbnail">
						<?php Edumall_Image::the_post_thumbnail([
							'size' => '480x295',
						]); ?>
					</div>
					<div class="tutor-mycourse-content">
						<?php Edumall_Templates::render_rating($avg_rating, [
							'style'         => '03',
							'wrapper_class' => 'tutor-mycourse-rating',
						]); ?>

						<h3 class="course-title"><?php the_title(); ?></h3>

						<div class="tutor-meta tutor-course-metadata">
							<?php
							$total_lessons     = tutor_utils()->get_lesson_count_by_course();
							$completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
							?>
							<ul>
								<li>
									<?php
									esc_html_e('Total Lessons:', 'edumall-child');
									echo "<span>$total_lessons</span>";
									?>
								</li>
								<li>
									<?php
									esc_html_e('Completed Lessons:', 'edumall-child');
									echo "<span>$completed_lessons / $total_lessons</span>";
									?>
								</li>
							</ul>
						</div>
						<?php tutor_course_completing_progress_bar(); ?>
					</div>

				</a>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<div class="dashboard-enrolled-courses-empty">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/NoItemsCourse.png' ?>" alt="">
			<p>
				<?php esc_html_e('You are not enrolled in any courses at this moment.', 'edumall-child'); ?>
			</p>
		</div>
	<?php endif; ?>
</div>