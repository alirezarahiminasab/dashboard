<?php
/**
 * Template for displaying course content
 *
 * @since            v.1.0.0
 *
 * @author           Themeum
 * @url https://themeum.com
 *
 * @package          Edumall/TutorLMS/Templates
 * @theme-since      1.0.0
 * @theme-version    3.0.0
 * @theme-deprecated 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

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
		<?php Edumall_Tutor::instance()->single_course_add_to_cart(); ?>

		<?php tutor_load_template( 'custom.wishlist-button-01' ); ?>
	<?php endif; ?>

	<?php
	if ( tutor_utils()->get_option( 'enable_course_share', false, true, true ) ) {
		tutor_load_template( 'single.course.social_share' );
	}
	?>

</div> <!-- tutor-price-preview-box -->
