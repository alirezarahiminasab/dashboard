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

global $post, $authordata;
global $edumall_course;

use TUTOR_CERT\Certificate;

use CourseExtend\CourseExtend;

$course_extend = new CourseExtend;

if ($edumall_course instanceof Edumall_Course) {
	$benefits = $edumall_course->get_benefits();
} else {
	$benefits = tutor_course_benefits(); // Course bundle.
}

$post_type = get_post_type();
// Get the link to the post type archive
$post_type_archive_link = get_post_type_archive_link($post_type);

$author_id = get_post_field('post_author', get_the_ID());
$author = get_userdata($author_id);
$rating = $edumall_course->get_rating();
$rating_count = $rating->rating_count;
$rating_avg = Edumall_Helper::number_format_nice_float($rating->rating_avg);
$price_type = tutor_utils()->price_type(get_the_ID()); // Get course price type
$price = tutor_utils()->get_raw_course_price(get_the_ID());
$regularPrice = (int)$price->regular_price;
$salePrice = (int)$price->sale_price;
$profile_photo_id    = get_user_meta($author_id, '_instructor_profile_pic', true);
$instructor_story_text    = get_user_meta($author_id, '_instructor_story_text', true);

// $ratePrice = $salePrice / $regularPrice;
$terms = wp_get_post_terms(get_the_ID(), 'course-category');
$feature_image = get_the_post_thumbnail_url(get_the_ID());

$thumbnail_size = '327x210';
$profile_url = tutor_utils()->profile_url($authordata->ID);

$feature_image = get_post_meta(get_the_ID(), '_thumbnail_id', true);
$url           = $feature_image ? wp_get_attachment_url($feature_image) : null;
$bookmark = $course_extend->is_bookmarked(get_the_ID(), get_current_user_id(), 'course');
$course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
	'post_id' => get_the_ID(),
	'size'    => $thumbnail_size,
));
$course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';
$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$duration        = get_post_meta(get_the_ID(), '_course_duration', true);
?>

<div class="tutor-single-course-lead-info">

	<div class="tutor-single-course-breadcrumb">
		<a class="home" href="<?php echo get_home_url() ?>"><?php echo esc_html__('home', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<a class="archive" href="<?php echo $post_type_archive_link; ?>"><?php echo esc_html__('دوره‌ها', 'edumall-child') ?></a>
		<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-left.png' ?>" alt="">
		<p class="title"><?php echo get_the_title(); ?></p>
	</div>

	<?php do_action('tutor_course/single/lead_meta/before'); ?>

	<div class="tutor-course-badges-wrap">
		<div class="cover-image">
			<img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
			<div class="bookmark" data-type="course" data-id="<?php echo get_the_ID() ?>" data-callback="<?php esc_html_e('دوره', 'edumall-child'); ?>">
				<img class="filled <?php echo $bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick-filled.svg' ?>" alt="">
				<img class="empty <?php echo !$bookmark ? 'active' : '' ?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/archive-tick.png' ?>" alt="">
			</div>
		</div>

		<?php do_action('tutor_course/single/title/before'); ?>

		<div class="title">
			<p>
				<?php the_title() ?>
			</p>
		</div>

		<?php do_action('tutor_course/single/title/after'); ?>

		<div class="content">
			<?php the_content() ?>
		</div>
		<div class="tutor">
			<div class="tutor-title">
				<p>
					<?php echo esc_html__('مدرس دوره:', 'edumall-child') ?>
				</p>
			</div>
			<div class="tutor-image">
				<?php if (!empty($instructor_pic)) : ?>
					<img src="<?php echo esc_html($author_pic) ?>" alt="">
				<?php else : ?>
					<img src="<?php echo esc_html($profile_placeholder) ?>" alt="">
				<?php endif; ?>
			</div>
			<div class="tutor-name">
				<a href="<?php echo $profile_url ?>">
					<p>
						<?php echo esc_html($author->display_name); ?>
					</p>
				</a>
			</div>
		</div>
		<div class="rating-students">
			<div class="rating">
				<div class="rating-star">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
				</div>
				<div class="rating-value">
					<p>
						<?php echo $rating_avg; ?>
					</p>
				</div>
				<div class="rating-count">
					<p>
						(<?php echo $rating_count . " " . esc_html__('votes', 'edumall-child') ?>)
					</p>
				</div>
			</div>
			<div class="students">
				<p>
					<?php echo sprintf(esc_html__('%s students', 'edumall-child'), $edumall_course->get_enrolled_users_count()); ?>
				</p>
			</div>
		</div>
	</div>

	<?php tutor_course_benefits_html(); ?>

	<div class="tutor-course-includes-wrap">
		<h4 class="tutor-segment-title">
			<?php echo esc_html(apply_filters('tutor_course_include_title', __('This course includes:', 'edumall-child'))); ?>
		</h4>
		<div class="tutor-course-includes-content">
			<div class="content-box video-duration">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-square.png' ?>" alt="">
				<p>
					<?php
					echo !empty($duration) ? $duration["hours"] : '';
					?>
					<?php echo esc_html__('hours video course', 'edumall-child')  ?>
				</p>
			</div>
			<div class="content-box text-duration">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/document-text.png' ?>" alt="">
				<p>
					<?php echo esc_html__('hours text course', 'edumall-child')  ?>
				</p>
			</div>
			<div class="content-box access">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/timer.png' ?>" alt="">
				<p>
					<?php echo esc_html__('Always access to course', 'edumall-child')  ?>
				</p>
			</div>
			<!-- <div class="content-box has-certificate">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/medal-star.png' ?>" alt="">
				<p>
					<?php
					$certificate = new Certificate(true);
					$has_certificate = $certificate->show_course_has_certificate([], get_the_ID());
					if (!empty($has_certificate[0])) :
						echo esc_html__('provide a valid certificate at the end of the course', 'edumall-child');
					endif;
					?>
				</p>
			</div> -->
		</div>
	</div>

	<?php get_template_part('tutor/single/course/reviews'); ?>

	<?php Edumall_Tutor::instance()->course_prerequisites(); ?>

	<?php get_template_part('tutor/single/course/course-topics'); ?>

	<?php get_template_part('tutor/single/course/instructors'); ?>

	<?php get_template_part('tutor/single/course/more-details'); ?>

	<?php get_template_part('tutor/single/course/frequent-questions'); ?>

	<?php get_template_part('tutor/single/course/other-courses'); ?>

	<?php get_template_part('tutor/single/course/course-action') ?>

	<?php do_action('tutor_course/single/lead_meta/after'); ?>

</div>