<?php

/**
 * Template for displaying course reviews loop
 */

defined('ABSPATH') || exit;
?>
<?php foreach ($reviews as $review) : ?>

	<?php
	$profile_url   = tutor_utils()->profile_url($review->user_id);
	$wrapper_class = 'review-individual-item tutor-review-' . $review->comment_ID;
	$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
	$profile_photo_id    = get_user_meta($review->user_id, '_instructor_profile_pic', true);
	?>
	<div class="swiper-slide <?php echo esc_attr($wrapper_class); ?>">
		<div class="review-header">
			<div class="header">
				<div class="review-avatar">
					<a href="<?php echo esc_url($profile_url); ?>">
						<img src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
					</a>
				</div>
				<div class="tutor-review-user-info">
					<a class="review-name" href="<?php echo esc_url($profile_url); ?>"><?php echo esc_html($review->display_name); ?> </a>
					<?php $review->rating ? Edumall_Templates::render_rating(floatval($review->rating), ['wrapper_class' => 'review-rating']) : ''; ?>
				</div>
			</div>
			<div class="report">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/flag.png' ?>" alt="">
			</div>
		</div>
		<div class="review-body">
			<div class="review-content">
				<?php echo wpautop(stripslashes($review->comment_content)); ?>
			</div>
			<p class="review-date">
				<?php echo sprintf(esc_html__('%s', 'edumall-child'), gmdate("Y/m/d", strtotime($review->comment_date))); ?>
			</p>
		</div>
	</div>
<?php endforeach;
