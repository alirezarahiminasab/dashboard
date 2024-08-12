<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}
$loop_count        = 0;
$left_box_template = $right_box_template = '';
?>
<?php while ( $edumall_query->have_posts() ) : $edumall_query->the_post(); ?>
	<?php if ( $loop_count === 0 ) : ?>
		<div <?php post_class( 'grid-item featured-post' ); ?>>
			<div class="edumall-box">
				<div class="post-thumbnail-wrap">
					<div class="post-feature post-thumbnail edumall-image">
						<?php \Edumall_Image::the_post_thumbnail( [
							'size' => '800x800',
						] ); ?>
					</div>
				</div>
				<div class="post-info">
					<?php Edumall_Post::instance()->the_category(); ?>

					<h3 class="post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				</div>
			</div>
		</div>
	<?php else: ?>
		<div <?php post_class( 'grid-item normal-post' ); ?>>
			<div class="edumall-box">
				<div class="post-thumbnail-wrap">
					<div class="post-feature post-thumbnail edumall-image">
						<a href="<?php the_permalink(); ?>" class="link-secret">
							<?php \Edumall_Image::the_post_thumbnail( [
								'size' => '480x298',
							] ); ?>
						</a>
					</div>
				</div>
				<div class="post-info">
					<?php Edumall_Post::instance()->the_category(); ?>

					<h3 class="post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php $loop_count++; ?>
<?php endwhile; ?>
