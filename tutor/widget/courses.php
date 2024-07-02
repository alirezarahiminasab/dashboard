<?php
/**
 * The template for displaying Tutor Course Widget
 *
 * @package       Tutor/Tempaltes
 * @version       1.3.1
 *
 * @theme-since   2.8.8
 * @theme-version 2.8.8
 */

defined( 'ABSPATH' ) || exit;

if ( have_posts() ) :
	global $edumall_course;
	$edumall_course_clone = $edumall_course;
	while ( have_posts() ) : the_post();
		/**
		 * Setup course object.
		 */
		$edumall_course = new Edumall_Course();
		?>
		<div class="<?php echo tutor_widget_course_loop_classes(); ?>">
			<?php tutor_load_template( 'loop.course' ); ?>
		</div>
	<?php
	endwhile;
	/**
	 * Reset course object.
	 */
	$edumall_course = $edumall_course_clone;
endif;
