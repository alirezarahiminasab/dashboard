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
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-feature post-thumbnail edumall-image">
			<a href="<?php the_permalink(); ?>">
				<?php Edumall_Image::the_post_thumbnail( [ 'size' => '770x400' ] ); ?>
			</a>

			<?php Edumall_Post::instance()->the_category( [
				'classes'    => 'post-overlay-categories',
			] ); ?>
		</div>
	<?php } ?>

	<div class="post-caption">
		<?php edumall_load_template( 'blog/loop/meta-alt' ); ?>

		<?php edumall_load_template( 'blog/loop/title' ); ?>

		<?php edumall_load_template( 'blog/loop/excerpt-long' ); ?>

		<div class="post-footer">
			<?php edumall_load_template( 'blog/loop/read-more' ); ?>

			<?php Edumall_Post::instance()->loop_share(); ?>
		</div>
	</div>
</div>
