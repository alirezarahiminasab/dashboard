<?php

/**
 * Template part for displaying event meta on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/meta.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined('ABSPATH') || exit;

$author_id = get_post_field('post_author', get_the_ID());
$author_reviews       = tutor_utils()->get_reviews_by_instructor($author_id);


?>
<?php foreach ($author_reviews->results as $review) : ?>
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
					<?php Edumall_Templates::render_rating($review->rating, ['wrapper_class' => 'review-rating']) ?>
				</div>
			</div>
			<p class="review-date">
				<?php echo sprintf(esc_html__('%s', 'edumall-child'), gmdate("Y/m/d", strtotime($review->comment_date))); ?>
			</p>
		</div>
		<div class="review-body">
			<div class="review-content">
				<?php echo wpautop(stripslashes($review->comment_content)); ?>
			</div>
		</div>
	</div>
<?php endforeach;
