<?php
/**
 * Course loop badges
 *
 * @since   1.0.0
 * @author  ThemeMove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

$purchasable = tutor_utils()->is_course_purchasable();
?>
<div class="course-loop-badges">
	<?php if ( $edumall_course->is_featured() ) : ?>
		<div class="tutor-course-badge hot"><?php esc_html_e( 'Featured', 'edumall' ); ?></div>
	<?php endif; ?>

	<?php if ( ! $purchasable ) : ?>
		<div class="tutor-course-badge free"><?php esc_html_e( 'Free', 'edumall' ); ?></div>
	<?php endif; ?>

	<?php if ( ! empty( $edumall_course->on_sale_text() ) ) : ?>
		<div class="tutor-course-badge onsale"><?php echo $edumall_course->on_sale_text(); ?></div>
	<?php endif; ?>
</div>
