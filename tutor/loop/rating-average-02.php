<?php
/**
 * A single course loop rating with detail average.
 *
 * @since   v.1.0.0
 * @author  themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

$course_rating = $edumall_course->get_rating();
$rating_count  = intval( $course_rating->rating_count );
?>
<div class="course-loop-rating-average-02">
	<div
		class="course-rating-average"><?php echo '<span class="rating-average">' . Edumall_Helper::number_format_nice_float( $course_rating->rating_avg ) . '</span><span class="rating-total">/5</span>'; ?></div>
	<?php if ( $rating_count === 0 ) : ?>
		<?php Edumall_Templates::render_rating( $course_rating->rating_avg, [
			'style' => '02',
		] ); ?>
	<?php else : ?>
		<?php Edumall_Templates::render_rating( $course_rating->rating_avg ); ?>
	<?php endif; ?>
</div>
