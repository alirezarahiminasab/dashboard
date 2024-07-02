<?php

/**
 * Template for displaying courses
 *
 * @since   v.1.0.0
 *
 * @author  Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.5.8
 */

defined('ABSPATH') || exit;

get_header();
?>
<div class="course-archive">
	<?php tutor_load_template('loop/course-archive-header'); ?>
	<?php tutor_load_template('loop/course-archive-items'); ?>
</div>
<?php get_footer();
