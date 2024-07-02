<?php
while ( $edumall_query->have_posts() ) :
	$edumall_query->the_post();
	$classes = array( 'portfolio-item grid-item' );
	?>
	<div <?php post_class( implode( ' ', $classes ) ); ?>>
		<div class="post-wrapper edumall-box">
			<div class="post-thumbnail-wrapper edumall-image">
				<a href="<?php Edumall_Portfolio::instance()->the_permalink(); ?>"
				   class="post-permalink link-secret">
					<div class="post-thumbnail">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php $size = Edumall_Image::elementor_parse_image_size( $settings, '480x9999' ); ?>
							<?php Edumall_Image::the_post_thumbnail( array( 'size' => $size ) ); ?>
						<?php } else { ?>
							<?php Edumall_Templates::image_placeholder( 480, 480 ); ?>
						<?php } ?>
					</div>

					<?php if ( ! empty( $settings['overlay_style'] ) ) : ?>
						<?php get_template_part( 'loop/portfolio/overlay', $settings['overlay_style'] ); ?>
					<?php endif; ?>
				</a>
			</div>

			<?php if ( 'yes' === $settings['show_caption'] ) : ?>
				<?php get_template_part( 'loop/portfolio/caption', $settings['caption_style'] ); ?>
			<?php endif; ?>

		</div>
	</div>
<?php endwhile; ?>
