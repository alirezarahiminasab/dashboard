<?php
/**
 * Course loop excerpt
 *
 * @since   1.0.0
 * @author  ThemeMove
 * @url https://thememove.com
 *
 * @package Edumall/TutorLMS/Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="course-loop-excerpt course-loop-excerpt-collapse-2-rows">
	<?php
	Edumall_Templates::excerpt( array(
		'limit' => 10,
		'type'  => 'word',
	) );
	?>
</div>
