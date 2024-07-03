<?php
/**
 * The template for displaying content blog list item.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="post-wrapper edumall-box">
	<div class="post-thumbnail-wrapper">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="post-feature post-thumbnail edumall-image">
				<a href="<?php the_permalink(); ?>">
					<?php Edumall_Image::the_post_thumbnail( [ 'size' => '480x302' ] ); ?>
				</a>

				<?php Edumall_Post::instance()->the_category( [
					'classes'    => 'post-overlay-categories',
				] ); ?>
			</div>
		<?php } ?>
	</div>

	<div class="post-caption">
		<?php edumall_load_template( 'blog/loop/title' ); ?>

		<?php edumall_load_template( 'blog/loop/meta' ); ?>

		<?php edumall_load_template( 'blog/loop/excerpt' ); ?>

		<?php edumall_load_template( 'blog/loop/read-more-alt' ); ?>
	</div>
</div>
