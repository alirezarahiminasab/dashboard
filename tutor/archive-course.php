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

use Detection\MobileDetect;

$detect = new MobileDetect();

get_header();
?>
<div class="course-archive">
	<?php if ($detect->isMobile()) :
		tutor_load_template('loop/course-archive-header');
		tutor_load_template('loop/course-archive-items');
	else :
		tutor_load_template('loop/course-archive-desktop');
	endif ?>
</div>
<?php get_footer();
