<?php
/**
 * Template for displaying course benefits
 *
 * @since   v.1.0.0
 *
 * @author  Themeum
 * @url https://themeum.com
 *
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

if ( $edumall_course instanceof Edumall_Course ) {
	$benefits = $edumall_course->get_benefits();
} else {
	$benefits = tutor_course_benefits(); // Course bundle.
}

if ( empty( $benefits ) ) {
	return;
}

do_action( 'tutor_course/single/before/benefits' );
?>

<div class="tutor-single-course-segment tutor-course-benefits-wrap">
	<h4 class="tutor-segment-title">
		<?php echo esc_html( apply_filters( 'tutor_course_benefit_title', __( 'Learning Objectives', 'edumall' ) ) ); ?>
	</h4>
	<div class="tutor-course-benefits-content">
		<div class="tutor-course-benefits-items">
			<?php foreach ( $benefits as $benefit ) : ?>
				<div class="tutor-course-benefit-item">
					<div class="benefit-content">
						<span class="benefit-icon" area-hidden="true"></span>
						<span class="benefit-text"><?php Edumall_Helper::e( $benefit ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php do_action( 'tutor_course/single/after/benefits' ); ?>

