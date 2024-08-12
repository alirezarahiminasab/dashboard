<?php

/**
 * Template for displaying lead info
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();

$post_type = get_post_type();
// Get the link to the post type archive
$post_type_archive_link = get_post_type_archive_link($post_type);

?>
<div class="single-course">

	<div class="single-course-breadcrumb">
		<a class="home" href="<?php echo get_home_url() ?>"><?php echo esc_html__('home', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<a class="archive" href="<?php echo $post_type_archive_link; ?>"><?php echo esc_html__('دوره‌ها', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<p class="title"><?php echo get_the_title(); ?></p>
	</div>

	<?php do_action('tutor_course/single/lead_meta/before'); ?>

	<div class="single-course-wrap">

		<?php get_template_part('tutor/single/course/meta'); ?>

		<?php get_template_part('tutor/single/course/course-benefits'); ?>

		<?php if ($detect->isMobile()) : ?>
			<?php get_template_part('tutor/single/course/course-includes'); ?>
		<?php endif; ?>

		<?php get_template_part('tutor/single/course/reviews'); ?>

		<?php get_template_part('tutor/single/course/course-prerequisites'); ?>

		<?php get_template_part('tutor/single/course/course-topics'); ?>

		<?php get_template_part('tutor/single/course/instructors'); ?>

		<?php get_template_part('tutor/single/course/more-details'); ?>

		<?php get_template_part('tutor/single/course/frequent-questions'); ?>

		<?php get_template_part('tutor/single/course/other-courses'); ?>

		<?php if ($detect->isMobile()) : ?>
			<?php get_template_part('tutor/single/course/course-action') ?>
		<?php endif; ?>

		<?php if (!$detect->isMobile()) : ?>
			<?php get_template_part('tutor/single/course/course-action-desktop') ?>
		<?php endif; ?>

		<?php do_action('tutor_course/single/lead_meta/after'); ?>
	</div>
</div>