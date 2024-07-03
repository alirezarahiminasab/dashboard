<?php
/**
 * Template for displaying course reviews loop
 */

defined( 'ABSPATH' ) || exit;
?>
<?php foreach ( $reviews as $review ) : ?>
	<?php
	$profile_url   = tutor_utils()->profile_url( $review->user_id );
	$wrapper_class = 'tutor-review-individual-item tutor-review-' . $review->comment_ID;
	?>
	<div class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div class="review-header">
			<div class="review-avatar">
				<a href="<?php echo esc_url( $profile_url ); ?>">
					<?php echo edumall_get_avatar( $review->user_id, 52 ); ?>
				</a>
			</div>
			<div class="tutor-review-user-info">
				<h4 class="review-name">
					<a href="<?php echo esc_url( $profile_url ); ?>"><?php echo esc_html( $review->display_name ); ?> </a>
				</h4>
				<p class="review-date">
					<?php echo sprintf( esc_html__( '%s ago', 'edumall' ), human_time_diff( strtotime( $review->comment_date ) ) ); ?>
				</p>
			</div>
		</div>
		<div class="review-body">
			<?php Edumall_Templates::render_rating( $review->rating, [ 'wrapper_class' => 'review-rating' ] ) ?>
			<div class="review-content">
				<?php echo wpautop( stripslashes( $review->comment_content ) ); ?>
			</div>
		</div>
	</div>
<?php endforeach;
