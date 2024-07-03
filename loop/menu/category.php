<ul class="children course-list">
	<?php while ( $edumall_query->have_posts() ) :
		$edumall_query->the_post();

		$course_id = get_the_ID();
		$classes   = [ 'course-item grid-item' ];
		?>
		<li <?php post_class( implode( ' ', $classes ) ); ?>>
			<a href="<?php the_permalink(); ?>" class="course-wrapper course-permalink link-secret edumall-box">
				<div class="course-thumbnail edumall-image">
					<?php if ( has_post_thumbnail() ) { ?>
						<?php Edumall_Image::the_post_thumbnail( array( 'size' => '52x40' ) ); ?>
					<?php } else { ?>
						<?php Edumall_Templates::image_placeholder( 52, 40 ); ?>
					<?php } ?>
				</div>

				<div class="course-caption">
					<h2 class="course-title"><?php the_title(); ?></h2>

					<div class="course-loop-price">
						<div class="course-price">
							<?php Edumall_Tutor::instance()->get_the_price_html(); ?>
						</div>
					</div>
				</div>
			</a>
		</li>
	<?php endwhile; ?>
</ul>
