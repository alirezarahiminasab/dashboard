<?php

/**
 * Template for displaying course reviews loop
 */

defined('ABSPATH') || exit;
?>
<?php foreach ($reviews as $review) : ?>
	<?php
	$profile_url   = tutor_utils()->profile_url($review->user_id, true);
	$wrapper_class = 'review-individual-item tutor-review-' . $review->comment_ID;
	$profile_photo_id    = get_user_meta($review->user_id, '_instructor_profile_pic', true);
	$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
	$first_name = get_user_meta($review->user_id, 'first_name', true);
	$last_name = get_user_meta($review->user_id, 'last_name', true);
	$full_name = trim($first_name . ' ' . $last_name);
	?>
	<div class="<?php echo esc_attr($wrapper_class); ?>">
		<div class="review-header">
			<div class="header">
				<div class="review-avatar">
					<img width="96" height="96" src="<?php echo !empty($profile_photo_id) ? $profile_photo_id : $profile_placeholder ?>" alt="">
				</div>
				<div class="tutor-review-user-info">
					<p><?php echo esc_html($full_name); ?> </p>
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
				<?php
				$bndate = \bn_parsidate::getInstance();
				echo sprintf(esc_html__('%s', 'edumall-child'), $bndate->persian_date("Y/m/d", strtotime($review->comment_date))); ?>
			</p>
		</div>
	</div>
<?php endforeach;
