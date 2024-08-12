<?php
/**
 * The template for displaying loop post meta.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="post-meta">
	<div class="inner">
		<?php Edumall_Post::instance()->meta_date_template(); ?>
		<?php Edumall_Post::instance()->meta_view_count_template(); ?>
	</div>
</div>
