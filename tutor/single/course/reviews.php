<?php
/**
 * Template for displaying course reviews
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.5
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.3
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\Input;

if ( ! get_tutor_option( 'enable_course_review' ) ) {
	return;
}

global $edumall_course;

$per_page     = tutor_utils()->get_option( 'pagination_per_page', 10 );
$current_page = max( 1, Input::post( 'current_page', 0, Input::TYPE_INT ) );
$offset       = ( $current_page - 1 ) * $per_page;

$current_user_id = get_current_user_id();
$course_id       = Input::post( 'course_id', get_the_ID(), Input::TYPE_INT );
$is_enrolled     = tutor_utils()->is_enrolled( $course_id, $current_user_id );

$reviews       = tutor_utils()->get_course_reviews( $course_id, $offset, $per_page, false, array( 'approved' ), $current_user_id );
$reviews_total = tutor_utils()->get_course_reviews( $course_id, null, null, true, array( 'approved' ), $current_user_id );
$rating        = tutor_utils()->get_course_rating( $course_id );

if ( Input::has( 'course_id' ) ) {
	// It's load more.
	tutor_load_template( 'single.course.reviews-loop', array( 'reviews' => $reviews ) );

	return;
}
?>
<?php do_action( 'tutor_course/single/enrolled/before/reviews' ); ?>

<div class="tutor-single-course-segment tutor-course-reviews-wrap tutor-pagination-wrapper-replaceable">

	<?php if ( ! empty( $reviews ) ) : ?>
		<?php
		$rating = $edumall_course->get_rating();
		?>
		<div class="tutor-course-reviews-average-wrap">
			<h4 class="tutor-segment-title"><?php esc_html_e( 'Student Feedback', 'edumall' ); ?></h4>

			<div class="tutor-course-reviews-average">
				<div class="course-ratings-average-wrap">
					<div class="course-avg-rating primary-color">
						<?php
						echo number_format( $rating->rating_avg, 1 );
						?>
					</div>
					<?php Edumall_Templates::render_rating( $rating->rating_avg, [ 'wrapper_class' => 'course-avg-rating-html' ] ); ?>
					<div
						class="course-avg-rating-total"><?php echo sprintf( esc_html( _n( '%s Rating', '%s Ratings', $rating->rating_count, 'edumall' ) ), '<span>' . $rating->rating_count . '</span>' ); ?></div>
				</div>

				<div class="course-ratings-count-meter-wrap">
					<?php
					foreach ( $rating->count_by_value as $rating_point => $rating_numbers ) {
						$rating_percent = Edumall_Helper::calculate_percentage( $rating_numbers, $rating->rating_count );
						?>
						<div class="course-rating-meter">
							<div class="rating-meter-col">
								<?php Edumall_Templates::render_rating( $rating_point ); ?>
							</div>
							<div class="rating-meter-col rating-meter-bar-wrap">
								<div class="rating-meter-bar">
									<div class="rating-meter-fill-bar"
									     style="<?php echo "width: {$rating_percent}%;"; ?>"></div>
								</div>
							</div>
							<div class="rating-meter-col rating-text-col">
								<?php echo "{$rating_percent}%"; ?>
							</div>
						</div>
					<?php } ?>
				</div>

			</div>
		</div>

		<div class="tutor-course-reviews-list-wrap">
			<h4 class="tutor-segment-title"><?php echo sprintf( esc_html__( 'Reviews %s', 'edumall' ), '<span>(' . $reviews_total . ')</span>' ); ?></h4>

			<div class="tutor-course-reviews-list tutor-pagination-content-appendable">
				<?php tutor_load_template( 'single.course.reviews-loop', array( 'reviews' => $reviews ) ); ?>
			</div>
			<?php
			$pagination_data              = array(
				'total_items' => $reviews_total,
				'per_page'    => $per_page,
				'paged'       => $current_page,
				'layout'      => array(
					'type'           => 'load_more',
					'load_more_text' => __( 'Load More', 'edumall' ),
				),
				'ajax'        => array(
					'action'    => 'tutor_single_course_reviews_load_more',
					'course_id' => $course_id,
				),
			);
			$pagination_template_frontend = tutor()->path . 'templates/dashboard/elements/pagination.php';
			tutor_load_template_from_custom_path( $pagination_template_frontend, $pagination_data );
			?>
		</div>

	<?php endif; ?>

	<?php tutor_load_template( 'single.course.review-form' ); ?>
</div>

<?php do_action( 'tutor_course/single/enrolled/after/reviews' ); ?>
