<?php
/**
 * Template for displaying single live meeting page
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         v.1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

get_tutor_header();

global $post;
$currentPost  = $post;
$zoom_meeting = tutor_zoom_meeting_data( $post->ID );
$meeting_data = $zoom_meeting->data;
?>
	<div class="page-content">

		<?php do_action( 'tutor_zoom/single/before/wrap' ); ?>

		<?php
		$enable_spotlight_mode = tutor_utils()->get_option( 'enable_spotlight_mode' );
		$wrapper_class         = 'tutor-single-lesson-wrap';

		if ( $enable_spotlight_mode ) {
			$wrapper_class .= ' tutor-spotlight-mode';
		}
		?>
		<div class="<?php echo esc_attr( $wrapper_class ); ?>">
			<div class="tutor-lesson-sidebar-wrap">
				<?php Edumall_Single_Lesson::instance()->lessons_sidebar(); ?>
			</div>
			<div id="tutor-single-entry-content"
			     class="tutor-lesson-content tutor-single-entry-content tutor-single-entry-content-<?php the_ID(); ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12">

							<div class="tutor-single-page-top-bar">
								<div class="tutor-topbar-item tutor-top-bar-course-link">
									<?php $course_id = Edumall_Tutor::instance()->get_course_id_by_lessons_id( $post->ID ); ?>
									<a href="<?php echo esc_url( get_the_permalink( $course_id ) ); ?>"
									   class="tutor-topbar-home-btn">
										<i class="fa-regular fa-home"></i><?php esc_html_e( 'Go to course home', 'edumall' ); ?>
									</a>
								</div>
								<div class="tutor-topbar-item tutor-topbar-content-title-wrap">
									<?php
									$video = tutor_utils()->get_video_info( get_the_ID() );

									$play_time = false;
									if ( $video ) {
										$play_time = $video->playtime;
									}

									$lesson_type      = $play_time ? 'video' : 'document';
									$lesson_type_icon = 'video' === $lesson_type ? 'fa-regular fa-play-circle' : 'fa-regular fa-file-alt';
									?>
									<span class="lesson-type-icon">
										<i class="<?php echo esc_attr( $lesson_type_icon ); ?>"></i>
									</span>
									<?php the_title(); ?>
								</div>

								<div class="tutor-topbar-item tutor-topbar-mark-to-done">
									<?php tutor_lesson_mark_complete_html(); ?>
								</div>
							</div>

							<div class="tutor-zoom-meeting-content">
								<?php if ( ! empty( $meeting_data['code'] ) && 3001 === $meeting_data['code'] ) : ?>
									<div class="zoom-meeting-not-exist">
										<h2 class="meeting-title"><?php echo esc_html( $post->post_title ); ?></h2>
										<p><?php echo esc_html( $meeting_data['message'] ); ?></p>
									</div>
								<?php else: ?>
									<?php if ( $zoom_meeting->is_expired ) : ?>
										<div class="tutor-zoom-meeting-expired-msg-wrap">
											<h2 class="meeting-title"><?php echo esc_html( $post->post_title ); ?></h2>
											<div class="msg-expired-section">
												<img
													src="<?php echo TUTOR_ZOOM()->url . 'assets/images/zoom-icon-expired.png'; ?>"
													alt=""/>
												<div>
													<h3><?php esc_html_e( 'The video conference has expired', 'edumall' ); ?></h3>
													<p><?php esc_html_e( 'Please contact your instructor for further information', 'edumall' ); ?></p>
												</div>
											</div>
											<div class="meeting-details-section">
												<p><?php echo $post->post_content; ?></p>
												<div>
													<div>
														<span><?php esc_html_e( 'Meeting Date', 'edumall' ); ?>:</span>
														<p><?php echo $zoom_meeting->start_date; ?></p>
													</div>
													<?php if ( ! empty( $meeting_data['host_email'] ) ): ?>
														<div>
															<span><?php esc_html_e( 'Host Email', 'edumall' ); ?>
																:</span>
															<p><?php echo esc_html( $meeting_data['host_email'] ); ?></p>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php else: ?>
										<?php
										$browser_url  = "https://us04web.zoom.us/wc/join/{$meeting_data['id']}?wpk={$meeting_data['encrypted_password']}";
										$browser_text = __( 'Join in Browser', 'edumall' );

										if ( get_current_user_id() == $post->post_author ) {
											$browser_url  = $meeting_data['start_url'];
											$browser_text = __( 'Start Meeting', 'edumall' );
										}
										?>
										<div class="zoom-meeting-countdown-wrap">
											<div class="tutor-zoom-meeting-countdown"
											     data-timer="<?php echo $zoom_meeting->countdown_date; ?>"
											     data-timezone="<?php echo $zoom_meeting->timezone; ?>">
											</div>
											<div class="tutor-zoom-join-button-wrap">
												<a href="<?php echo esc_url( $browser_url ); ?>" target="_blank"
												   class="tutor-btn tutor-button-block zoom-meeting-join-in-web"><?php echo esc_html( $browser_text ); ?></a>
												<a href="<?php echo esc_url( $meeting_data['join_url'] ); ?>"
												   target="_blank"
												   class="tutor-btn tutor-button-block zoom-meeting-join-in-app"><?php esc_html_e( 'Join in Zoom App', 'edumall' ); ?></a>
											</div>
										</div>
										<div class="zoom-meeting-content-wrap">
											<h2 class="meeting-title"><?php echo $post->post_title; ?></h2>
											<p class="meeting-summary"><?php echo $post->post_content; ?></p>
											<div class="meeting-details">
												<div>
													<span><?php esc_html_e( 'Meeting Date', 'edumall' ); ?></span>
													<p><?php echo $zoom_meeting->start_date; ?></p>
												</div>
												<div>
													<span><?php esc_html_e( 'Meeting ID', 'edumall' ); ?></span>
													<p><?php echo $meeting_data['id']; ?></p>
												</div>
												<div>
													<span><?php esc_html_e( 'Password', 'edumall' ); ?></span>
													<p><?php echo $meeting_data['password']; ?></p>
												</div>
												<div>
													<span><?php esc_html_e( 'Host Email', 'edumall' ); ?></span>
													<p><?php echo $meeting_data['host_email']; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'tutor_zoom/single/after/wrap' ); ?>

	</div>

<?php
get_tutor_footer();
