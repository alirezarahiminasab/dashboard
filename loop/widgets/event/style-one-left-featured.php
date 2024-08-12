<?php
if ( ! isset( $settings ) ) {
	$settings = array();
}
$loop_count        = 0;
$left_box_template = $right_box_template = '';
?>
<?php while ( $edumall_query->have_posts() ) : $edumall_query->the_post(); ?>
	<?php if ( $loop_count === 0 ) : ?>
		<?php ob_start(); ?>
		<div <?php post_class( 'grid-item' ); ?>>
			<div class="edumall-box">
				<div class="event-thumbnail edumall-image">
					<a href="<?php the_permalink(); ?>" class="link-secret">
						<?php \Edumall_Image::the_post_thumbnail( [
							'size' => '570x370',
						] ); ?>
					</a>
				</div>
				<div class="event-info">
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

					<div class="event-caption">
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
		<?php $left_box_template .= ob_get_clean(); ?>
	<?php else: ?>
		<?php ob_start(); ?>
		<div <?php post_class( 'grid-item' ); ?>>
			<div class="edumall-box">
				<div class="event-thumbnail-wrap">
					<div class="event-thumbnail edumall-image">
						<a href="<?php the_permalink(); ?>" class="link-secret">
							<?php \Edumall_Image::the_post_thumbnail( [
								'size' => '170x106',
							] ); ?>
						</a>
					</div>

					<?php
					$time_from = get_post_meta( get_the_ID(), 'tp_event_date_start', true );
					if ( empty( $time_from ) ) {
						$time_from = time();
					}
					$time_from   = strtotime( $time_from );
					$date_format = get_option( 'date_format' );
					?>
					<div class="event-date">
						<?php echo wp_date( $date_format, $time_from ); ?>
					</div>
				</div>

				<div class="event-info">
					<div class="event-caption">
						<h3 class="event-title">
							<a href="<?php the_permalink(); ?>" class="link-secret">
								<?php the_title(); ?>
							</a>
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
		<?php $right_box_template .= ob_get_clean(); ?>
	<?php endif; ?>
	<?php $loop_count++; ?>
<?php endwhile; ?>
<div class="row">
	<div class="col-md-6 featured-event">
		<?php echo '' . $left_box_template; ?>
	</div>
	<div class="col-md-5 col-lg-push-1 normal-events">
		<?php echo '' . $right_box_template; ?>
	</div>
</div>
