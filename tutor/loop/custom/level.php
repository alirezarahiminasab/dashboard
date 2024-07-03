<?php
/**
 * Course Loop Level
 *
 * @package       Edumall/TutorLMS/Templates
 * @theme-since   2.0.0
 * @theme-version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $edumall_course;

$level = $edumall_course->get_level();

if ( empty( $level ) ) {
	return;
}

$wrapper_class = 'course-loop-badge-level ' . $level;
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?>">
	<span class="badge-text"><?php echo esc_html( $edumall_course->get_level_label() ); ?></span>
</div>
