<?php
/**
 * The template for displaying archive pages.
 *
 * @link     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package  Edumall
 * @since    1.0.0
 * @version  2.10.1
 */
get_header();
?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div class="page-main-content">
					<?php
					if ( ! edumall_has_elementor_template( 'archive' ) ) {
						$post_type = get_post_type();
						if ( 'portfolio' === $post_type ) {
							edumall_load_template( 'portfolio/archive-portfolio' );
						} elseif ( 'post' === $post_type ) {
							edumall_load_template( 'blog/archive-blog' );
						} else {
							edumall_load_template( 'content' );
						}
					}
					?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php get_footer();
