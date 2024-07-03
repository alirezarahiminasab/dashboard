<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Edumall
 * @since    1.0.0
 * @version  3.5.7
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="page-content" class="page-content">
	<div class="container">
		<div class="row">

			<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

			<div class="page-main-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					if ( '1' !== Edumall::setting( 'single_post_title_enable' ) ) {
						edumall_load_template( 'global/content-rich-snippet' );
					}
					?>
					<?php if ( ! edumall_has_elementor_template( 'single' ) ) : ?>
						<?php edumall_load_template( 'blog/single/style', 'standard' ); ?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>

			<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

		</div>
	</div>
</div>
