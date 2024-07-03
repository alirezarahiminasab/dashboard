<?php
/**
 * Template for displaying single quiz
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         v.1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_tutor_header();

$course    = tutor_utils()->get_course_by_quiz( get_the_ID() );
$course_id = $course->ID;
?>
	<div class="page-content">

		<?php do_action( 'tutor_quiz/single/before/wrap' ); ?>

		<?php
		$enable_spotlight_mode = tutor_utils()->get_option( 'enable_spotlight_mode' );
		$wrapper_class         = 'tutor-single-lesson-wrap tutor-course-single-content-wraper';

		if ( $enable_spotlight_mode ) {
			$wrapper_class .= ' tutor-spotlight-mode';
		}
		?>
		<div class="<?php echo esc_attr( $wrapper_class ); ?>">
			<div class="tutor-lesson-sidebar-wrap">
				<?php Edumall_Single_Lesson::instance()->lessons_sidebar(); ?>
			</div>
			<div id="tutor-single-entry-content" class="tutor-quiz-single-entry-wrap tutor-single-entry-content">
				<input type="hidden" name="tutor_quiz_id" id="tutor_quiz_id" value="<?php the_ID(); ?>">

				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<?php tutor_load_template( 'single.common.header', array( 'course_id' => $course_id ) ); ?>

							<div class="tutor-quiz-single-wrap">
								<input type="hidden" name="tutor_quiz_id" id="tutor_quiz_id" value="<?php the_ID(); ?>">

								<?php
								if ( $course ) {
									tutor_single_quiz_top();
									tutor_single_quiz_body();
								} else {
									tutor_single_quiz_no_course_belongs();
								}
								?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'tutor_quiz/single/after/wrap' ); ?>

	</div>
<?php

get_tutor_footer();
