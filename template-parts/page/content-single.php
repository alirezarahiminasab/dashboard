<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since    1.0.0
 * @version  2.10.1
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

			<div id="page-main-content" class="page-main-content">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php edumall_load_template( 'global/content-rich-snippet' ); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2 class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></h2>

						<?php if ( ! edumall_has_elementor_template( 'single' ) ) : ?>
							<?php
							the_content();

							Edumall_Templates::page_links();
							?>
						<?php endif; ?>
					</article>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				<?php endwhile; ?>

			</div>

			<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

		</div>
	</div>
</div>
