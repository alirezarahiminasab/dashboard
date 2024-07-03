<?php
/**
 * Template for displaying page title section on category page.
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

if ( ! Edumall_Tutor::instance()->is_category() || '1' !== Edumall::setting( 'course_category_page_heading' ) ) {
	return;
}

$queried_object = get_queried_object();
?>
<div class="row row-page-title">
	<div class="col-md-12">
		<h3 class="archive-section-heading">
			<?php printf( esc_html__( 'All %s Courses', 'edumall' ), '<mark>' . esc_html( $queried_object->name ) . '</mark>' ); ?>
		</h3>
	</div>
</div>
