<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<div class="comments-wrap">
			<h2 class="comments-title">
				<?php
				$count = get_comments_number();

				printf( esc_html( _n( 'Comment %1$s', 'Comments %1$s', $count, 'edumall' ) ), '<span class="count">(' . $count . ')</span>' );
				?>
			</h2>
			<div class="comment-list-wrap">
				<?php Edumall_Templates::comment_navigation( array( 'container_id' => 'comment-nav-above' ) ); ?>

				<ol class="comment-list">
					<?php
					/**
					 * @see \Edumall_Templates::comment_template()
					 */
					wp_list_comments( array(
						'style'       => 'ol',
						'callback'    => array( 'Edumall_Templates', 'comment_template' ),
						'short_ping'  => true,
						'avatar_size' => Edumall::COMMENT_AVATAR_SIZE,
					) );
					?>
				</ol>

				<?php Edumall_Templates::comment_navigation( array( 'container_id' => 'comment-nav-below' ) ); ?>

			</div>
		</div>
	<?php endif;

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<div class="comments-wrap">
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'edumall' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="comment-form-wrap">
		<?php Edumall_Templates::comment_form(); ?>
	</div>

</div>
