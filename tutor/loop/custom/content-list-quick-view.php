<?php
/**
 * Course quick view
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

$benefits = $edumall_course->get_benefits();

if ( empty( $benefits ) ) {
	return;
}

$unique_id = $edumall_course->get_unique_id();
?>
<div id="<?php echo 'quick-view-' . $unique_id; ?>" class="course-loop-quick-view">
	<?php tutor_load_template( 'loop.custom.benefits' ); ?>
</div>
