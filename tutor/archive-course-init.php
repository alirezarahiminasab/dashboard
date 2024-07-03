<?php
/**
 * @hook   tutor_course/archive/before_loop
 *
 * @hooked Edumall_Archive_Course::render_filter_bar()
 * @see    Edumall_Archive_Course::render_filter_bar()
 *
 * @theme-version 3.8.0
 */
$is_shortcode = ! empty( $the_query );
if ( ! $is_shortcode ) {
	do_action( 'tutor_course/archive/before_loop' );
}
?>

<?php if ( ( isset( $the_query ) && $the_query->have_posts() ) || have_posts() ) : ?>

	<?php
	global $edumall_course;
	$edumall_course_clone = $edumall_course;
	?>

	<?php tutor_course_loop_start(); ?>

	<?php while ( isset( $the_query ) ? $the_query->have_posts() : have_posts() ) : ?>
		<?php isset( $the_query ) ? $the_query->the_post() : the_post(); ?>
		<?php
		/***
		 * Setup course object.
		 */
		$edumall_course = new Edumall_Course();
		?>
		<?php
		/**
		 * Usage Idea, you may keep a loop within a wrap, such as bootstrap col
		 *
		 * @hook   tutor_course/archive/before_loop_course
		 *
		 * @hooked tutor_course_loop_before_content
		 * @see    tutor_course_loop_before_content()
		 */
		do_action( 'tutor_course/archive/before_loop_course' );
		?>

		<?php tutor_load_template( 'loop.course' ); ?>

		<?php
		/**
		 * Usage Idea, If you start any div before course loop, you can end it here, such as </div>
		 *
		 * @hook   tutor_course/archive/after_loop_course
		 *
		 * @hooked tutor_course_loop_after_content
		 * @see    tutor_course_loop_after_content()
		 */
		do_action( 'tutor_course/archive/after_loop_course' );
		?>
	<?php endwhile; ?>

	<?php tutor_course_loop_end(); ?>

	<?php
	/**
	 * Reset course object.
	 */
	$edumall_course = $edumall_course_clone;
	?>

	<?php tutor_course_archive_pagination(); ?>
<?php endif; ?>

<?php
if ( ! $is_shortcode ) {
	do_action( 'tutor_course/archive/after_loop' );
}
