<?php
/**
 * Template for displaying course info
 *
 * @package TutorLMS/Templates
 * @since   3.4.0
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Use other template to display entry box for course bundle.
 */
if ( 'course-bundle' === get_post_type() ) {
	tutor_load_template( 'single.course.course-bundle-entry-box' );

	return;
}

global $edumall_course;

$is_administrator      = current_user_can( 'administrator' );
$is_instructor         = tutor_utils()->is_instructor_of_this_course();
$course_content_access = (bool) get_tutor_option( 'course_content_access_for_ia' );

$retake_course = tutor_utils()->can_user_retake_course();

$preview_box_classes = 'tutor-price-preview-box';

if ( '01' === Edumall::setting( 'single_course_layout' ) ) {
	if ( $edumall_course->has_video() || has_post_thumbnail() ) {
		$preview_box_classes .= ' box-has-media';
	}
}
?>
<div class="<?php echo esc_attr( $preview_box_classes ); ?>">
	<?php if ( '01' === Edumall::setting( 'single_course_layout' ) ) : ?>
		<div class="tutor-price-box-thumbnail">
			<?php
			if ( $edumall_course->has_video() ) {
				tutor_course_video();
			} else {
				Edumall_Image::the_post_thumbnail( [ 'size' => '340x200' ] );
			}
			?>
		</div>

		<?php do_action( 'tutor_course/single/enroll_box/after_thumbnail' ); ?>
	<?php endif; ?>

	<?php tutor_course_price(); ?>

	<?php tutor_load_template( 'single.course.custom.enroll-box-lead-info' ); ?>

	<?php tutor_course_material_includes_html(); ?>

	<?php if ( '02' !== Edumall::setting( 'single_course_layout' ) ): ?>
		<div class="tutor-lead-info-btn-group">
			<?php do_action( 'tutor_course/single/actions_btn_group/before' ); ?>

			<?php if ( $edumall_course->is_enrolled() ) : ?>
				<?php tutor_load_template( 'single.course.custom.enrolled-action-buttons' ); ?>
			<?php elseif ( $course_content_access && ( $is_administrator || $is_instructor ) ) : ?>
				<?php tutor_load_template( 'single.course.custom.continue-lesson-button' ); ?>

				<?php tutor_load_template( 'custom.wishlist-button-01' ); ?>
			<?php else: ?>
				<?php Edumall_Tutor::instance()->single_course_add_to_cart(); ?>

				<?php tutor_load_template( 'custom.wishlist-button-01' ); ?>
			<?php endif; ?>

			<?php do_action( 'tutor_course/single/actions_btn_group/after' ); ?>
		</div>
	<?php endif; ?>

	<?php do_action( 'tutor_course/single/entry/after', get_the_ID() ); ?>

	<?php if ( tutor_utils()->get_option( 'enable_course_share', false, true, true ) ) : ?>
		<?php tutor_load_template( 'single.course.social_share' ); ?>
	<?php endif; ?>
</div>
