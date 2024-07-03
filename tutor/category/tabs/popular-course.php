<?php
/**
 * Template for displaying popular course tab
 *
 * @since   1.0.0
 *
 * @author  ThemeMove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @var WP_Query $popular_courses
 */
$popular_courses = Edumall_Tutor::instance()->get_popular_courses_by_current_tax();

if ( empty( $popular_courses ) ) {
	return;
}
?>

<?php
global $edumall_course;
$edumall_course_clone = $edumall_course;
?>

<?php tutor_load_template( 'loop.custom.loop-carousel-start' ); ?>

<?php while ( $popular_courses->have_posts() ) : $popular_courses->the_post(); ?>
	<?php
	/**
	 * Setup course object.
	 */
	$edumall_course = new Edumall_Course();
	?>

	<?php tutor_load_template( 'loop.custom.loop-before-slide-content' ); ?>
	<?php tutor_load_template( 'loop.custom.content-course-carousel-02' ); ?>
	<?php tutor_load_template( 'loop.custom.loop-after-slide-content' ); ?>

<?php endwhile; ?>
<?php wp_reset_postdata(); ?>

<?php
/**
 * Reset course object.
 */
$edumall_course = $edumall_course_clone;
?>

<?php tutor_load_template( 'loop.custom.loop-carousel-end' ); ?>
