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

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/enrolled/before/instructors' );

global $edumall_course;

$instructors = $edumall_course->get_instructors();
if ( $instructors ) {
	?>
	<div class="tutor-single-course-segment tutor-course-instructors-wrap" id="single-course-ratings">
		<h4 class="tutor-segment-title"><?php esc_html_e( 'Your Instructors', 'edumall' ); ?></h4>
		<?php
		foreach ( $instructors as $instructor ) {
			$profile_url = tutor_utils()->profile_url( $instructor->ID, true );
			?>
			<div class="single-instructor-wrap">
				<div class="instructor-avatar">
					<a href="<?php echo esc_url( $profile_url ); ?>">
						<?php echo edumall_get_avatar( $instructor->ID, 240 ); ?>
					</a>
				</div>
				<div class="tutor-instructor-info">
					<h3 class="instructor-name">
						<?php echo esc_html( $instructor->display_name ); ?>
					</h3>

					<?php if ( ! empty( $instructor->tutor_profile_job_title ) ) : ?>
						<p class="instructor-job"><?php echo esc_html( $instructor->tutor_profile_job_title ); ?></p>
					<?php endif; ?>

					<?php
					$instructor_rating = tutor_utils()->get_instructor_ratings( $instructor->ID );
					?>
					<div class="instructor-ratings">
						<?php
						Edumall_Templates::render_rating( $instructor_rating->rating_avg, [
							'wrapper_class' => 'rating-generated',
						] );
						?>
						<div
							class="instructor-rating-average"><?php echo '<span class="heading-color">' . Edumall_Helper::number_format_nice_float( $instructor_rating->rating_avg ) . '</span>/5'; ?></div>
					</div>

					<div class="instructor-meta">
						<?php
						$total_courses = tutor_utils()->get_course_count_by_instructor( $instructor->ID );
						?>
						<div class="instructor-meta-item instructor-courses">
							<span class="meta-icon"><i class="fa-regular fa-play-circle"></i></span>
							<span class="meta-value">
								<?php printf( esc_html( _n( '%1$s Course', '%1$s Courses', $total_courses, 'edumall' ) ), $total_courses ); ?>
							</span>
						</div>

						<div class="instructor-meta-item instructor-total-reviews">
							<span class="meta-icon"><i class="fa-regular fa-comment-alt"></i></span>
							<span class="meta-value">
								<?php printf( esc_html( _n( '%1$s Review', '%1$s Reviews', $instructor_rating->rating_count, 'edumall' ) ), $instructor_rating->rating_count ); ?>
							</span>
						</div>

						<?php
						$total_students = tutor_utils()->get_total_students_by_instructor( $instructor->ID );
						?>
						<div class="instructor-meta-item instructor-students">
							<span class="meta-icon"><i class="fa-regular fa-user"></i></span>
							<span class="meta-value">
								<?php printf( esc_html( _n( '%1$s Student', '%1$s Students', $total_students, 'edumall' ) ), $total_students ); ?>
							</span>
						</div>
					</div>

					<div class="instructor-bio">
						<?php echo wp_kses_post( $instructor->tutor_profile_bio ); ?>
					</div>

					<a href="<?php echo esc_url( $profile_url ); ?>" class="instructor-profile-url primary-color">
						<span class="fa-regular fa-plus"></span>
						<?php esc_html_e( 'See more', 'edumall' ); ?>
					</a>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}

do_action( 'tutor_course/single/enrolled/after/instructors' );
