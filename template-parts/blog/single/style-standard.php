<?php
/**
 * Template part for displaying single post for standard style.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

defined( 'ABSPATH' ) || exit;

$sidebar_status = Edumall_Global::instance()->get_sidebar_status();
?>
<?php if ( 'none' === $sidebar_status ) : ?>
	<div
		class="entry-header <?php echo '1' === Edumall::setting( 'single_post_feature_enable' ) ? 'featured-on' : 'featured-off'; ?>">
		<?php Edumall_Post::instance()->entry_categories(); ?>

		<?php if ( '1' === Edumall::setting( 'single_post_title_enable' ) ) : ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php endif; ?>

		<?php edumall_load_template( 'blog/single/meta' ); ?>

		<div class="entry-header-featured">
			<?php Edumall_Post::instance()->entry_feature(); ?>
		</div>
	</div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-wrapper' ); ?>>

	<h2 class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></h2>

	<?php if ( 'none' !== $sidebar_status ) : ?>
		<div
			class="entry-header <?php echo '1' === Edumall::setting( 'single_post_feature_enable' ) ? 'featured-on' : 'featured-off'; ?>">
			<div class="entry-header-featured">
				<?php Edumall_Post::instance()->entry_feature(); ?>

				<?php Edumall_Post::instance()->entry_categories(); ?>
			</div>

			<?php edumall_load_template( 'blog/single/meta' ); ?>

			<?php if ( '1' === Edumall::setting( 'single_post_title_enable' ) ) : ?>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content( sprintf( /* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'edumall' ), array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ) );

		Edumall_Templates::page_links();
		?>
	</div>

	<div class="entry-footer">
		<div class="row row-xs-center">
			<div class="col-md-6">
				<?php Edumall_Post::instance()->entry_tags(); ?>
			</div>
			<div class="col-md-6">
				<?php Edumall_Post::instance()->entry_share(); ?>
			</div>
		</div>
	</div>

	<?php
	$author_desc = get_the_author_meta( 'description' );
	if ( '1' === Edumall::setting( 'single_post_author_box_enable' ) && ! empty( $author_desc ) ) {
		Edumall_Templates::post_author();
	}

	if ( '1' === Edumall::setting( 'single_post_pagination_enable' ) ) {
		Edumall_Post::instance()->nav_page_links();
	}

	if ( Edumall::setting( 'single_post_related_enable' ) ) {
		edumall_load_template( 'blog/single/related' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( '1' === Edumall::setting( 'single_post_comment_enable' ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
	?>
</article>
