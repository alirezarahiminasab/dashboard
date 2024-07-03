<?php
/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.9.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\Input;

$isLoggedIn = is_user_logged_in();

if ( ! $isLoggedIn ) {
	return;
}

$course_id = Input::post( 'course_id', get_the_ID(), Input::TYPE_INT );
$my_rating = tutor_utils()->get_reviews_by_user( 0, 0, 150, false, $course_id, array( 'approved', 'hold' ) );
$is_new    = ! $my_rating || empty( $my_rating->rating ) || empty( $my_rating->comment_content );
$heading   = $is_new ? __( 'Write a review', 'edumall' ) : __( 'Edit review', 'edumall' );

$button_args = [
	'link'        => [
		'url' => '#',
	],
	'text'        => $heading,
	'extra_class' => 'btn-write-course-review',
	'attributes' => [
		'data-edumall-toggle' => 'modal',
		'data-edumall-target' => '#modal-course-review-add',
	]
];
?>

<div class="tutor-course-review-form-wrap">
	<h4 class="tutor-segment-title"><?php echo esc_html( $heading ); ?></h4>

	<?php Edumall_Templates::render_button( $button_args ); ?>
</div>

<?php if ( $isLoggedIn ) : ?>
	<div class="edumall-modal modal-course-review-add" id="modal-course-review-add">
		<div class="modal-overlay"></div>
		<div class="modal-content">
			<div class="button-close-modal"></div>
			<div class="modal-content-wrap">
				<div class="modal-content-inner">
					<div class="modal-content-header">
						<h3 class="modal-title"><?php esc_html_e( 'Write a review', 'edumall' ); ?></h3>
					</div>

					<div class="modal-content-body">
						<form method="post" class="tutor-write-review-form">
							<input type="hidden" name="tutor_course_id" value="<?php echo get_the_ID(); ?>">
							<div class="tutor-write-review-box tutor-star-rating-container">
								<div class="tutor-form-group">
									<div class="tutor-ratings tutor-ratings-lg tutor-ratings-selectable"
									     tutor-ratings-selectable>
										<?php tutor_utils()->star_rating_generator( tutor_utils()->get_rating_value( $my_rating ? $my_rating->rating : 0 ) ); ?>
									</div>
								</div>
								<div class="tutor-form-group">
									<textarea name="review"
									          placeholder="<?php esc_attr_e( 'Write a review', 'edumall' ); ?>"><?php echo stripslashes( $my_rating ? $my_rating->comment_content : '' ); ?></textarea>
								</div>

								<div class="form-response-messages"></div>

								<div class="tutor-form-group">
									<div class="button-group">
										<?php Edumall_Templates::render_button( [
											'link'        => [
												'url' => 'javascript:void(0);',
											],
											'text'        => esc_html__( 'Cancel', 'edumall' ),
											'extra_class' => 'button-grey',
											'attributes'  => [
												'data-edumall-toggle'  => 'modal',
												'data-edumall-target'  => '#modal-course-review-add',
												'data-edumall-dismiss' => '1',
											],
										] ); ?>
										<div class="tm-button-wrapper">
											<button type="submit"
											        class="custom_tutor_submit_review_btn tutor-button tutor-success"><?php esc_html_e( 'Submit Review', 'edumall' ); ?></button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
