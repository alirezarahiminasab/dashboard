<?php

/**
 * Display loop thumbnail
 *
 * @since   v.1.0.0
 * @author  themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

$course_thumb_image_size  = apply_filters( 'edumall_course_thumb_image_size', '480x304' );
?>

<div class="course-thumbnail edumall-image">
	<a href="<?php the_permalink(); ?>">
		<?php Edumall_Image::the_post_thumbnail( [ 'size' => $course_thumb_image_size ] ); ?>
	</a>
</div>
