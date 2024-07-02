<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}
?>
<div class="modern-grid">
	<?php while ( $edumall_query->have_posts() ) : $edumall_query->the_post(); ?>
		<div <?php post_class( 'grid-item' ); ?>>
			<div class="edumall-box">
				<div class="event-thumbnail edumall-image">
					<a href="<?php the_permalink(); ?>" class="link-secret">
						<?php \Edumall_Image::the_post_thumbnail( [
							'size' => '250x300',
						] ); ?>
					</a>
				</div>
				<div class="event-info">
					<div class="event-caption">
						<?php
						$time_from = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
						if ( empty( $time_from ) ) {
							$time_from = time();
						}
						$time_from   = strtotime( $time_from );
						$date_format = get_option( 'date_format' );
						$date_string = wp_date( $date_format, $time_from );
						?>
						<div class="event-date">
							<?php echo esc_html( $date_string ); ?>
						</div>

						<h3 class="event-title">
							<a href="<?php the_permalink(); ?>" class="link-secret"><?php the_title(); ?></a>
						</h3>

						<?php $location = get_post_meta( get_the_ID(), \Edumall_Event::POST_META_SHORT_LOCATION, true ); ?>
						<?php if ( $location ): ?>
							<div class="event-location">
								<span class="far fa-map-marker-alt"></span>
								<?php echo esc_html( $location ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>
