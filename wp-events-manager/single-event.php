<?php
/**
 * The Template for displaying single events page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php
$style = Edumall::setting( 'single_event_style' );

if ( in_array( $style, [ '02' ], true ) ) {
	wpems_get_template_part( 'single/content-hero', $style );
}
?>

	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div class="page-main-content">
					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php wpems_get_template_part( 'content-single-event', $style ); ?>
						<?php endwhile; ?>

						<?php the_posts_navigation(); ?>

					<?php else : ?>
						<?php edumall_load_template( 'global/content-none' ); ?>
					<?php endif; ?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php get_footer();
