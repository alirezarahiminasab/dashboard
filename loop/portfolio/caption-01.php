<div class="post-info">
	<h3 class="post-title">
		<a href="<?php Edumall_Portfolio::instance()->the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>

	<?php if ( 'yes' === $settings['show_caption_category'] ) : ?>
		<?php Edumall_Portfolio::instance()->the_categories(); ?>
	<?php endif; ?>

	<?php if ( 'yes' === $settings['show_caption_excerpt'] ) : ?>
		<?php
		if ( empty( $settings['excerpt_length'] ) ) {
			$settings['excerpt_length'] = 10;
		}
		?>
		<div class="portfolio-excerpt">
			<?php Edumall_Templates::excerpt( array(
				'limit' => $settings['excerpt_length'],
				'type'  => 'word',
			) ); ?>
		</div>
	<?php endif; ?>
</div>
