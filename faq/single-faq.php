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
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
		</div>

		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div class="page-main-content">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'faq/content', 'single-faq' ); ?>

					<?php endwhile; ?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();

