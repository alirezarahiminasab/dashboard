<?php
/**
 * The template for displaying all single posts.
 *
 * @link     https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package  Edumall
 * @since    1.0.0
 * @version  2.10.1
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

			<div class="page-main-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php edumall_load_template( 'global/content-rich-snippet' ); ?>

					<?php if ( ! edumall_has_elementor_template( 'single' ) ) : ?>
						<?php the_content(); ?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>

			<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

		</div>
	</div>
</div>
