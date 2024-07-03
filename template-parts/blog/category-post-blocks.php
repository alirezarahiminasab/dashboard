<?php
/**
 * Template part for displaying post blocks by category below main post layout for home.php
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;

$post_block_on = Edumall::setting( 'blog_archive_post_by_cat_block_on' );

if ( '1' !== $post_block_on ) {
	return;
}

$cat_ids = Edumall::setting( 'blog_archive_post_by_cat_ids' );

if ( ! empty( $cat_ids ) ) {
	$cat_ids = array_map( 'intval', $cat_ids );

	$popular_categories = get_terms( [
		'taxonomy'   => 'category',
		'hide_empty' => false,
		'include'    => $cat_ids,
	] );
} else {
	$popular_categories = get_terms( [
		'taxonomy'   => 'category',
		'hide_empty' => false,
		'parent'     => 0,
	] );
}

if ( empty( $popular_categories ) || is_wp_error( $popular_categories ) ) {
	return;
}

$number_posts = Edumall::setting( 'blog_archive_post_by_cat_number' );
?>

<?php foreach ( $popular_categories as $key => $category ): ?>
	<?php
	$cat_link = get_term_link( $category );

	$posts = get_posts( [
		'numberposts' => $number_posts,
		'category'    => $category->term_id,
	] );

	if ( empty( $posts ) ) {
		continue;
	}
	?>
	<div class="home-blog-section home-blog-by-cat-section">
		<div class="container">
			<div class="row">
				<div class="section-col-heading">
					<h3 class="archive-section-heading"><?php printf( esc_html__( '%s Articles', 'edumall' ), $category->name ); ?></h3>

					<?php
					Edumall_Templates::render_button( [
						'link'          => [
							'url' => $cat_link,
						],
						'text'          => esc_html__( 'View all', 'edumall' ),
						'icon'          => 'fa-light fa-long-arrow-right',
						'icon_align'    => 'right',
						'size'          => 'xs',
						'wrapper_class' => 'cat-detail-link',
						'style'         => 'text',
					] );
					?>
				</div>
				<div class="section-col-content">
					<div class="home-blog-section-content">
						<div
							class="tm-swiper tm-slider v-stretch bullets-v-align-below nav-style-01 pagination-style-01 edumall-blog edumall-animation-zoom-in edumall-blog-carousel-01"
							data-lg-items="auto"
							data-lg-gutter="0"
							data-nav="1"
							data-pagination="1"
							data-loop="1"
						>
							<div class="swiper-inner">
								<div class="swiper-container">
									<div class="swiper-wrapper">
										<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
											<?php
											$classes = array( 'swiper-slide', 'post-item' );
											?>
											<div <?php post_class( implode( ' ', $classes ) ); ?>>
												<?php edumall_load_template( 'blog/content-blog', 'slide' ); ?>
											</div>
										<?php endforeach; ?>
										<?php wp_reset_postdata(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach;
