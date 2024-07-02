<?php
/**
 * Course Loop Slide Start
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

$unique_id = $edumall_course->get_unique_id();
?>
<div <?php post_class( 'swiper-slide' ); ?>>
	<div class="course-loop-wrapper edumall-box edumall-tooltip"
	     data-tooltip="<?php echo esc_attr( 'quick-view-' . $unique_id ); ?>">
