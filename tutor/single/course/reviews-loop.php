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
	?>
	<div class="<?php echo esc_attr($wrapper_class); ?>">
		<div class="review-header">
			<div class="header">
				<div class="review-avatar">
					<a href="<?php echo esc_url($profile_url); ?>">
						<?php echo edumall_get_avatar($review->user_id, 52); ?>
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
				<?php
				$bndate = \bn_parsidate::getInstance();
				echo sprintf(esc_html__('%s', 'edumall-child'), $bndate->persian_date("Y/m/d", strtotime($review->comment_date))); ?>
			</p>
		</div>
	</div>
<?php endforeach;
