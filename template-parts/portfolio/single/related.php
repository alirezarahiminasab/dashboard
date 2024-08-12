<?php
$number_post = Edumall::setting( 'portfolio_related_number' );
$results     = Edumall_Portfolio::instance()->get_related_items( array(
	'post_id'      => get_the_ID(),
	'number_posts' => $number_post,
) );
?>
<?php if ( $results !== false && $results->have_posts() ) : ?>
	<div class="related-portfolio portfolio-overlay-group-01 portfolio-overlay-faded">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<h3 class="related-portfolio-title">
						<?php echo Edumall::setting( 'portfolio_related_title' ); ?>
					</h3>

					<div class="tm-swiper tm-slider"
					     data-lg-items="3"
					     data-md-items="2"
					     data-sm-items="1"
					     data-lg-gutter="30"
					     data-nav="1"
					     data-loop="1"
					>
						<div class="swiper-inner">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php while ( $results->have_posts() ) : $results->the_post(); ?>
										<div class="swiper-slide">
											<div class="post-wrapper">
												<a href="<?php the_permalink(); ?>" class="post-permalink">
													<div class="post-thumbnail">
														<?php
														if ( has_post_thumbnail() ) {
															Edumall_Image::the_post_thumbnail( array( 'size' => '480x480' ) );
														} else {
															Edumall_Templates::image_placeholder( 480, 480 );
														}

														get_template_part( 'loop/portfolio/overlay', 'faded' );
														?>
													</div>
												</a>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php endif;
wp_reset_postdata();
