<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}

global $edumall_course;

while ( $edumall_query->have_posts() ) : $edumall_query->the_post(); ?>
	<?php
	/***
	 * Setup course object.
	 */
	$edumall_course = new Edumall_Course();

	tutor_load_template( 'loop.loop-before-content' );
	tutor_load_template( 'loop.custom.content-course-' . $settings['style'] );
	tutor_load_template( 'loop.loop-after-content' );
	?>
<?php endwhile; ?>
