<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}
?>
<div class="modern-grid">
	<?php while ( $edumall_query->have_posts() ) : $edumall_query->the_post(); ?>
		<div class="grid-item">
			<a href="<?php the_permalink(); ?>" class="edumall-box link-secret">
				<div class="event-caption">
					<div class="left-box">
						<?php $location = get_post_meta( get_the_ID(), \Edumall_Event::POST_META_SHORT_LOCATION, true ); ?>
						<?php if ( $location ): ?>
							<div class="event-location">
								<span class="fa-regular fa-map-marker-alt"></span>
								<?php echo esc_html( $location ); ?>
							</div>
						<?php endif; ?>

						<h3 class="event-title"><?php the_title(); ?></h3>
					</div>

					<div class="right-box">
						<?php
						$time_from = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
						if ( empty( $time_from ) ) {
							$time_from = time();
						}
						$time_from = strtotime( $time_from );
						$day       = wp_date( 'd', $time_from );
						$month     = wp_date( 'M', $time_from );
						?>
						<div class="event-date">
							<div class="event-date--day"><?php echo esc_html( $day ); ?></div>
							<div class="event-date--month"><?php echo esc_html( $month ); ?></div>
						</div>

						<?php \Edumall_Templates::render_button( [
							'text'        => esc_html__( 'Get ticket', 'edumall' ),
							'size'        => 'xs',
							'extra_class' => 'event-get-ticket',
						] ); ?>
					</div>
				</div>
			</a>
		</div>
	<?php endwhile; ?>
</div>
