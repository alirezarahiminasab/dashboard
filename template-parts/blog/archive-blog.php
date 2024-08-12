<?php
/**
 * Template part for displaying blog content in home.php, archive.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;

$style   = Edumall::setting( 'blog_archive_style', 'grid' );
$classes = [
	'edumall-main-post',
	'edumall-grid-wrapper',
	'edumall-blog',
	'edumall-animation-zoom-in',
	"edumall-blog-" . $style,
];

$lg_columns = $md_columns = $sm_columns = 1;

$sidebar_status = Edumall_Global::instance()->get_sidebar_status();

// Handle Columns
switch ( $style ) {
	case 'grid':
		$lg_columns = 3;
		$md_columns = 2;
		$sm_columns = 1;
		break;
	case 'grid-wide' :
		$lg_columns = 4;
		$md_columns = 2;
		$sm_columns = 1;
		break;
}

if ( 'none' !== $sidebar_status && in_array( $style, [ 'grid', 'grid-wide' ] ) ) {
	$lg_columns--;
}

$grid_options = [
	'type'          => ( '1' === Edumall::setting( 'blog_archive_masonry' ) ) ? 'masonry' : 'grid',
	'columns'       => $lg_columns,
	'columnsTablet' => $md_columns,
	'columnsMobile' => $sm_columns,
	'gutter'        => 30,
];

$caption_style = Edumall::setting( 'blog_archive_caption_style' );
$classes[]     = 'edumall-blog-caption-style-' . $caption_style;

if ( have_posts() ) : ?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
	>
		<div class="edumall-grid">
			<div class="grid-sizer"></div>

			<?php while ( have_posts() ) : the_post();
				$classes = array( 'grid-item', 'post-item' );
				?>
				<div <?php post_class( implode( ' ', $classes ) ); ?>>
					<?php edumall_load_template( 'blog/content-blog', $style ); ?>
				</div>
			<?php endwhile; ?>
		</div>

		<div class="edumall-grid-pagination">
			<?php Edumall_Templates::paging_nav(); ?>
		</div>
	</div>

<?php else : ?>
	<?php edumall_load_template( 'global/content-none' ); ?>
<?php endif; ?>
