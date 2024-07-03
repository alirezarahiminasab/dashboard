<?php
/**
 * The template for displaying related posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;

$number_post = Edumall::setting( 'single_post_related_number' );
$results     = Edumall_Post::instance()->get_related_posts( array(
	'post_id'      => get_the_ID(),
	'number_posts' => $number_post,
) );

if ( $results !== false && $results->have_posts() ) : ?>
	<div
		class="related-posts edumall-blog edumall-animation-zoom-in edumall-blog-caption-style-02">
		<h3 class="related-title">
			<?php esc_html_e( 'Related Posts', 'edumall' ); ?>
		</h3>
		<div class="tm-swiper tm-slider v-stretch bullets-v-align-below nav-style-01 pagination-style-01"
		     data-lg-items="auto"
		     data-lg-gutter="30"
		     data-nav="1"
		     data-auto-height="1"
		>
			<div class="swiper-inner">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php while ( $results->have_posts() ) : $results->the_post(); ?>
							<div class="swiper-slide">
								<div <?php post_class( 'related-post-item' ); ?>>
									<div class="post-wrapper edumall-box">
										<?php if ( has_post_thumbnail() ) { ?>
											<div class="post-feature post-thumbnail edumall-image">
												<a href="<?php the_permalink(); ?>">
													<?php Edumall_Image::the_post_thumbnail( array( 'size' => '240x142' ) ); ?>
												</a>
											</div>
										<?php } ?>

										<div class="post-caption">
											<h3 class="post-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>

											<div class="post-meta">
												<div class="inner">
													<?php Edumall_Post::instance()->meta_date_template(); ?>

													<?php Edumall_Post::instance()->meta_view_count_template(); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif;
