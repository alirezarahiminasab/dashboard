<?php
/**
 * The template for displaying archive of meetings
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom/archive-meetings.php.
 *
 * @author Deepen
 * @since  3.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Edumall_Sidebar::instance()->render( 'left' ); ?>

				<div id="page-main-content" class="page-main-content">

					<?php if ( have_posts() ) : ?>

						<?php
						$wrapper_classes = [
							'edumall-main-post',
							'edumall-grid-wrapper',
							'edumall-zoom-meetings',
							'edumall-animation-zoom-in',
						];

						$lg_columns = Edumall::setting( 'zoom_meeting_archive_lg_columns', 3 );
						$md_columns = Edumall::setting( 'zoom_meeting_archive_md_columns' );
						$sm_columns = Edumall::setting( 'zoom_meeting_archive_sm_columns' );

						$grid_options = [
							'type'          => 'grid',
							'columns'       => $lg_columns,
							'columnsTablet' => $md_columns,
							'columnsMobile' => $sm_columns,
							'gutter'        => 30,
						];
						?>
						<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
						     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
						>
							<div class="edumall-grid">
								<div class="grid-sizer"></div>

								<?php while ( have_posts() ) : the_post(); ?>
									<?php vczapi_get_template_part( 'content', 'meeting' );; ?>
								<?php endwhile; // end of the loop. ?>
							</div>

							<div class="edumall-grid-pagination">
								<?php Edumall_Templates::paging_nav(); ?>
							</div>
						</div>

					<?php endif; ?>
				</div>

				<?php Edumall_Sidebar::instance()->render( 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();
