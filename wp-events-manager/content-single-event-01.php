<?php

/**
 * The Template for displaying content single event.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

defined('ABSPATH') || exit;

$post_type = get_post_type();
// Get the link to the post type archive
$post_type_archive_link = get_post_type_archive_link($post_type);
?>
<div class="single-event-breadcrumb">
	<a class="home" href="<?php echo get_home_url() ?>"><?php echo esc_html__('home', 'edumall-child') ?></a>
	<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
	<a class="archive" href="<?php echo $post_type_archive_link; ?>"><?php echo esc_html__('Events', 'edumall-child') ?></a>
	<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
	<p class="title"><?php echo get_the_title(); ?></p>
</div>

<article id="tp_event-<?php the_ID(); ?>" <?php post_class('tp_single_event'); ?>>
	<?php
	/**
	 * tp_event_before_single_event hook
	 */
	do_action('tp_event_before_single_event');
	?>

	<div class="event-meta-header">
		<div class="entry-thumbnail">
			<?php Edumall_Image::the_post_thumbnail(); ?>
		</div>

		<div class="entry-title">
			<?php wpems_get_template('single/title.php'); ?>
		</div>

		<div class="entry-meta">
			<?php wpems_get_template('single/meta.php'); ?>
		</div>

		<!-- TODO -->
		<!-- Implement calendar and save button -->
		<div class="entry-buttons">
			<a href="#" class="button">
				<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/calendar.png" ?>>
				<p><?php esc_html_e('Add to calendar', 'edumall-child'); ?></p>
			</a>
			<a href="#" class="button">
				<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/archive-tick-transparent.png" ?>>
				<p><?php esc_html_e('Save', 'edumall-child'); ?></p>
			</a>
		</div>
	</div>

	<div class="event-register-box">
		<?php wpems_get_template('single/register.php'); ?>
	</div>

	<div class="event-details-box">
		<?php wpems_get_template('single/more-details.php'); ?>
	</div>

	<div class="event-author-box">
		<?php wpems_get_template('single/author.php'); ?>
	</div>

	<?php wpems_get_template('single/reviews.php'); ?>

	<?php wpems_get_template('single/holders.php'); ?>

	<?php wpems_get_template('single/sessions.php'); ?>

	<?php wpems_get_template('single/frequent-questions.php'); ?>

	<?php wpems_get_template('single/share.php'); ?>

	<?php wpems_get_template('single/other-events.php'); ?>

	</div>

</article>