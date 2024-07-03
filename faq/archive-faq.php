<?php
/**
 * The template for displaying all single faq
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Edumall
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
	<div id="page-content" class="page-content">
		<div class="faq-page-title-wrap">
			<div class="container">
				<?php
				if ( Edumall_FAQ::instance()->is_taxonomy() ) {
					$archive_title = single_cat_title( '', false ); // XSS OK.
				} else {
					$archive_title = __( 'FAQs', 'edumall' ); // XSS OK.
				}
				$archive_title = apply_filters( 'edumall_faq_archive_page_title', $archive_title );
				?>
				<h1 class="entry-title"><?php echo esc_html( $archive_title ); ?></h1>
			</div>
		</div>
		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div class="page-main-content">
					<?php if ( have_posts() ) : ?>

						<?php get_template_part( 'faq/loop/loop', 'start' ); ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'faq/content', 'faq' ); ?>
						<?php endwhile; ?>

						<?php get_template_part( 'faq/loop/loop', 'end' ); ?>

						<div class="edumall-grid-pagination">
							<?php Edumall_Templates::paging_nav(); ?>
						</div>

					<?php else : ?>
						<?php edumall_load_template( 'global/content-none' ); ?>
					<?php endif; ?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();

