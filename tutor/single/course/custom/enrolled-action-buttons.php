<?php

/**
 * Display action buttons
 *
 * @since   v.1.0.0
 * @author  thememove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;
global $wp_query;

$is_enrolled         = apply_filters('tutor_alter_enroll_status', tutor_utils()->is_enrolled());
$retake_course       = tutor_utils()->can_user_retake_course();
$completed_percent   = tutor_utils()->get_course_completed_percent();
$is_completed_course = tutor_utils()->is_completed_course();
$lesson_url          = tutor_utils()->get_course_first_lesson();
$start_content       = '';

if ($lesson_url) {

	// Button identifier class.
	$button_identifier = 'start-continue-retake-button';
	$button_tag        = $retake_course ? 'button' : 'a';

	if ($retake_course) {
		$button_text = __('Retake This Course', 'edumall-child');
	} elseif ($completed_percent <= 0) {
		$button_text = __('Start Learning', 'edumall-child');
	} else {
		$button_text = __('Continue Learning', 'edumall-child');
	}

	$attributes = '';
	$attributes .= 'a' === $button_tag ? ' href="' . esc_url($lesson_url) . '"' : '';
	$attributes .= $retake_course ? ' disabled="disabled"' : '';

	$start_content = sprintf(
		'<div class="continue-course course-action-btn"><%1$s %2$s data-course_id="%3$s">%4$s</%1$s></div>',
		$button_tag,
		$attributes,
		esc_attr(get_the_ID()),
		$button_text
	);
}
echo apply_filters('tutor_course/single/start/button', $start_content, get_the_ID());
