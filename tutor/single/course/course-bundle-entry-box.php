<?php
/**
 * Template for displaying course info
 *
 * @package TutorLMS/Templates
 * @since   3.4.0
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

// Utility data.
global $is_enrolled;

$is_enrolled        = apply_filters( 'tutor_alter_enroll_status', $is_enrolled );
$lesson_url         = tutor_utils()->get_course_first_lesson();
$is_privileged_user = tutor_utils()->has_user_course_content_access();

$retake_course = tutor_utils()->can_user_retake_course();

$preview_box_classes = 'tutor-price-preview-box';
// Right sidebar meta data.
$sidebar_meta = apply_filters( 'tutor/course/single/sidebar/metadata', array(), get_the_ID() );
?>
<div class="<?php echo esc_attr( $preview_box_classes ); ?>">
	<?php tutor_course_price(); ?>

	<div class="tutor-single-course-meta tutor-meta-top">
		<?php
		do_action( 'edumall_course_single_enroll_box_lead_info_before' );
		?>

		<?php foreach ( $sidebar_meta as $meta_item ): ?>
			<div class="tutor-course-meta">
				<span class="meta-label">
					<i class="meta-icon <?php echo $meta_item['icon_class']; ?>"></i>
					<?php echo esc_html( $meta_item['value'] ); ?>
				</span>
			</div>
		<?php endforeach; ?>

		<?php
		do_action( 'edumall_course_single_enroll_box_lead_info_after' );
		?>
	</div>

	<?php if ( $is_enrolled || $is_privileged_user ) : ?>
		<?php echo apply_filters( 'tutor/course/single/entry-box/is_enrolled', '', get_the_ID() );//phpcs:ignore ?>
	<?php else: ?>
		<?php Edumall_Tutor::instance()->single_course_add_to_cart(); ?>

		<?php tutor_load_template( 'custom.wishlist-button-01' ); ?>
	<?php endif; ?>

	<?php do_action( 'tutor_course/single/entry/after', get_the_ID() ); ?>

	<?php if ( tutor_utils()->get_option( 'enable_course_share', false, true, true ) ) : ?>
		<?php tutor_load_template( 'single.course.social_share' ); ?>
	<?php endif; ?>
</div>
