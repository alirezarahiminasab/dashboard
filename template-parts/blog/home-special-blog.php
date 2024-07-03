<?php
/**
 * Template part for displaying special blog layout for home.php
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;
?>

	<div class="home-blog-section popular-articles">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="archive-section-heading"><?php printf( esc_html__( 'Popular %sArticles%s', 'edumall' ), '<mark>', '</mark>' ); ?></h3>
					<div class="home-blog-section-content">
						<div
							class="tm-swiper tm-slider v-stretch nav-style-01 edumall-blog edumall-animation-zoom-in edumall-blog-caption-style-02"
							data-lg-items="auto"
							data-lg-gutter="0"
							data-nav="1"
							data-loop="1"
						>
							<div class="swiper-inner">
								<div class="swiper-container">
									<div class="swiper-wrapper">
										<?php while ( have_posts() ) : the_post(); ?>
											<?php
											$classes = array( 'swiper-slide', 'post-item' );
											?>
											<div <?php post_class( implode( ' ', $classes ) ); ?>>
												<?php edumall_load_template( 'blog/content-blog' ); ?>
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
	</div>

<?php edumall_load_template( 'blog/category-post-blocks' );
