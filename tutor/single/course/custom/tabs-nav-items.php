<?php
/**
 * Display tabs nav
 *
 * @package         Edumall/TutorLMS/Templates
 * @theme-since     1.0.0
 * @theme-version   3.0.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * @var Edumall_Course $edumall_course
 */
global $edumall_course;

/**
 * @var WP_Query $topics
 */
$topics = $edumall_course->get_topics();

$course_nav_items = apply_filters( 'tutor_course/single/enrolled/nav_items', [
	'questions'     => __( 'Q&A', 'edumall' ),
	'announcements' => __( 'Announcements', 'edumall' ),
] );
?>
<li class="active">
	<a href="#tutor-course-tab-overview"><?php esc_html_e( 'Overview', 'edumall' ); ?></a>
</li>
<?php if ( $topics->have_posts() ): ?>
	<li>
		<a href="#tutor-course-tab-curriculum"><?php esc_html_e( 'Curriculum', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
<?php if ( $edumall_course->is_viewable() && ! empty( $edumall_course->get_attachments() ) ): ?>
	<li>
		<a href="#tutor-course-tab-resources"><?php esc_html_e( 'Resources', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
<?php if ( $edumall_course->is_viewable() ): ?>
	<li>
		<a href="#tutor-course-tab-question-and-answer"><?php esc_html_e( 'Question & Answer', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
<li>
	<a href="#tutor-course-tab-instructors"><?php esc_html_e( 'Instructors', 'edumall' ); ?></a>
</li>
<?php if ( $edumall_course->is_viewable() ): ?>
	<li>
		<a href="#tutor-course-tab-announcements"><?php esc_html_e( 'Announcements', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
<?php if ( $edumall_course->is_viewable() && isset( $course_nav_items['google-classroom-stream'] ) ): ?>
	<li>
		<a href="#tutor-course-tab-google-classroom-stream"><?php echo esc_html( $course_nav_items['google-classroom-stream'] ); ?></a>
	</li>
<?php endif; ?>
<?php if ( $edumall_course->is_enrolled() && class_exists( '\TUTOR_GB\GradeBook' ) ): ?>
	<li>
		<a href="#tutor-course-tab-gradebook"><?php esc_html_e( 'Gradebook', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
<?php if ( $edumall_course->get_reviews() ) : ?>
	<li>
		<a href="#tutor-course-tab-reviews"><?php esc_html_e( 'Reviews', 'edumall' ); ?></a>
	</li>
<?php endif; ?>
