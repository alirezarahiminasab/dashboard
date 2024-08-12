<?php

/**
 * Template for displaying single course
 *
 * @author        Themeum
 * @url https://themeum.com
 *
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.7.7
 */

defined('ABSPATH') || exit;

global $edumall_course;

use Detection\MobileDetect;

$detect = new MobileDetect();
$topics    = $edumall_course->get_topics();
$topics_count = count($topics->posts);
$topic_count = 1;
$course_id = get_the_ID();
?>

<?php do_action('tutor_course/single/before/topics'); ?>

<?php if ($topics->have_posts()) { ?>
	<div class="single-course-topics single-course-item">
		<?php if (!$detect->isMobile()) : ?>
			<div class="single-course-desktop">
			<?php endif; ?>
			<div class="single-course-topics-header">
				<div class="single-course-topics-header-left">
					<h4 class="single-segment-title"><?php esc_html_e('سرفصل های دوره', 'edumall-child'); ?></h4>
				</div>

				<div class="single-course-topics-header-right">
					<?php $tutor_lesson_count = $edumall_course->get_lesson_count();	?>

					<p class="total-topics"> <?php echo $topics_count . ' ' . esc_html__('Topics', 'edumall-child')  ?> </p>
					<p>
						|
					</p>
					<p class="total-lessons"><?php echo $tutor_lesson_count . ' ' . esc_html__('Lessons', 'edumall-child') ?></p>
				</div>
			</div>

			<div class="single-course-topics-contents">
				<?php

				$index = 0;

				if ($topics->have_posts()) :
					while ($topics->have_posts()) :
						$topics->the_post();
						$topic_summery = get_the_content();
						$index++;
						$lesson_count = 1;

						$topic_wrap_class = 'single-course-topics-contents-item';
						$title_wrap_class = 'single-course-topics-contents-item-title';

						if ($index == 1) {
							$topic_wrap_class .= ' topic-active';
						}

						if (!empty($topic_summery)) {
							$title_wrap_class .= ' has-summery';
						}
				?>
						<div class="<?php echo esc_attr($topic_wrap_class); ?>">
							<div class="<?php echo esc_attr($title_wrap_class); ?>">
								<h4>
									<?php echo $topic_count . '. '; ?>
									<?php the_title(); ?>
								</h4>
								<img class="arrow-up" src='<?php echo get_stylesheet_directory_uri() . "/assets/images/arrow-up.png" ?>'>
								<img class="arrow-down" src='<?php echo get_stylesheet_directory_uri() . "/assets/images/arrow-down-black.png" ?>'>
							</div>

							<div class="single-course-topics-contents-item-lessons">
								<?php
								$lessons = tutor_utils()->get_course_contents_by_topic(get_the_ID(), -1);

								if ($lessons->have_posts()) :
									while ($lessons->have_posts()) :
										$lessons->the_post();
										global $post;

										$video = tutor_utils()->get_video_info();

										$words_count = mb_split('[^\x{0600}-\x{06FF}]', strip_tags(get_the_content()));
										$avgerage_read = ceil(count($words_count) / 200);

										$play_time = false;
										if (!empty($video->source_video_id)) {

											$play_time = $video->runtime;

											// Build the formatted time string
											$timeString = '';

											if ($play_time["hours"] > 0) {
												$timeString .= $play_time["hours"] . ' ' . esc_html__('ساعت', 'edumall-child');
											}

											if ($play_time["minutes"] > 0) {
												$timeString .= ($timeString != '' ? ' ' . esc_html__('and', 'edumall-child') . ' ' : '') . $play_time["minutes"]  . ' ' . esc_html__('دقیقه', 'edumall-child');
											}

											if ($play_time["seconds"] > 0) {
												$timeString .= ($timeString != '' ? ' ' . esc_html__('and', 'edumall-child') . ' ' : '') . $play_time["seconds"]  . ' ' . esc_html__('ثانیه', 'edumall-child');
											}
										}

										$lesson_icon = $play_time ? '/assets/images/video-square-course.png' : '/assets/images/document-text-course.png';

										if ($post->post_type === 'tutor_quiz') {
											$lesson_icon = 'far fa-question-circle';
										}
										if ($post->post_type === 'tutor_assignments') {
											$lesson_icon = 'far fa-file-edit';
										}
								?>

										<div class="single-course-lesson">
											<?php
											$lesson_title = '';

											if ($edumall_course->is_enrolled() || (get_post_meta($course_id, '_tutor_is_public_course', true) === 'yes' && !tutor_utils()->is_course_purchasable($course_id))) {

												$lesson_title .= "<div class='title'>";
												$lesson_title .= "<p>" . $topic_count . '.' . $lesson_count . '</p> ';
												$lesson_title .= "<a href='" . get_the_permalink() . "'> " . get_the_title() . " </a>";
												$lesson_title .= "</div>";
											} else {
												$lesson_title .= "<div class='title'>";
												$lesson_title .= "<div class='right'>";
												$lesson_title .= "<p>" . $topic_count . '.' . $lesson_count . '</p> ';
												$lesson_title .= "<p>" . get_the_title() . " </p>";
												$lesson_title .= "</div>";
												$lesson_title .= "<div class='left'>";
												$lesson_title .= "<img src='" . get_stylesheet_directory_uri() . "/assets/images/lock.png' alt='lock-icon'>";
												$lesson_title .= "</div>";
												$lesson_title .= "</div>";

												/**
												 * Can't remove plugin filter.
												 * Then used theme hook instead of.
												 */
												//echo apply_filters( 'tutor_course/contents/lesson/title', $lesson_title, get_the_ID() );
												// echo apply_filters('edumall/tutor_course/contents/lesson/title', $lesson_title, get_the_ID());
											}

											$lesson_title .= "<div class='duration'>";
											$lesson_title .= "<img src='" . get_stylesheet_directory_uri() . $lesson_icon . "'>";
											$lesson_title .= $play_time ? "<p>$timeString</p>" : "<p>$avgerage_read " . esc_html__('دقیقه', 'edumall-child') . "</p>";
											$lesson_title .= "</div>";

											$countdown = '';
											if ($post->post_type === 'tutor_zoom_meeting') {
												$lesson_title = '<i class="far fa-users"></i>';

												$zoom_meeting = tutor_zoom_meeting_data($post->ID);
												$countdown    = '<div class="tutor-zoom-lesson-countdown tutor-lesson-duration" data-timer="' . $zoom_meeting->countdown_date . '" data-timezone="' . $zoom_meeting->timezone . '"></div>';
											}

											echo '' . $lesson_title;

											?>
										</div>

								<?php
										$lesson_count++;
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</div>
				<?php
						$topic_count++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			<?php if (!$detect->isMobile()) : ?>
			</div>
		<?php endif; ?>
	</div>
<?php } ?>

<?php do_action('tutor_course/single/after/topics'); ?>