<?php
/**
 * Template part for displaying comment help block on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/comment-help.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

$comment_help_title = Edumall::setting( 'single_event_comment_help_title' );
$comment_help_desc  = Edumall::setting( 'single_event_comment_help_desc' );
$comment_help_email = Edumall::setting( 'single_event_comment_help_email' );
?>
<?php if ( ! empty( $comment_help_title ) ) : ?>
	<p class="heading comment-help-heading"><?php echo esc_html( $comment_help_title ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $comment_help_desc ) ) : ?>
	<p class="comment-help-description"><?php echo esc_html( $comment_help_desc ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $comment_help_email ) ) : ?>
	<p class="comment-help-email">
		<a href="mailto:<?php echo esc_url( $comment_help_email ) ?>"
		   class="link-transition-01"><?php echo esc_html( $comment_help_email ); ?></a>
	</p>
<?php endif;
