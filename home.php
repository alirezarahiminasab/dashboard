<?php
/**
 * The home latest posts template.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */
get_header();
?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div class="page-main-content">
					<?php
					$special_layout_on = Edumall::setting( 'blog_archive_special_layout' );

					if ( '1' === $special_layout_on ) {
						edumall_load_template( 'blog/home-special-blog' );
					} else {
						edumall_load_template( 'blog/archive-blog' );
					}
					?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();
