<?php
/**
 * The template for displaying shortcode
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom/shortcode/tm-zoom-meeting.php.
 *
 * @author     Thememove
 * @package    Edumall
 * @since      2.0.0
 */

global $zoom_meetings;
?>

<div class="tm-zoom-meeting">
	<div class="zoom-content">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" height="55"
		     class="zoom-shape">
			<path class="zoom-shape-fill" d="M 0 0 L0 100 L100 100 L100 0 Q 50 200 0 0"/>
		</svg>

		<img class="zoom-shape-img shape-img-01" src="<?php echo EDUMALL_THEME_IMAGE_URI . '/shape-three-line.png'; ?>"
		     alt="<?php esc_attr_e( 'Edumall Shape', 'edumall' ); ?>">
		<img class="zoom-shape-img shape-img-02" src="<?php echo EDUMALL_THEME_IMAGE_URI . '/shape-cut-circle.png'; ?>"
		     alt="<?php esc_attr_e( 'Edumall Shape', 'edumall' ); ?>">

		<div class="zoom-main-content">
			<h2 class="zoom-topic"><?php echo esc_html( $zoom_meetings->topic ); ?></h2>
			<div class="zoom-id">
				<span class="label"><?php esc_html_e( 'Meeting ID:', 'edumall' ); ?></span>
				<span class="value primary-color"><?php echo esc_html( $zoom_meetings->id ); ?></span>
			</div>

			<div class="zoom-meta">

				<?php
				if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 8 ) {
					if ( ! empty( $zoom_meetings->occurrences ) ) {
						?>
						<div class="zoom-meta-item zoom-meta-type">
							<span class="meta-label"><?php esc_html_e( 'Type', 'edumall' ); ?></span>
							<span
								class="meta-value"><?php esc_html_e( 'Recurring Meeting', 'edumall' ); ?></span>
						</div>
						<div class="zoom-meta-item zoom-meta-occurrences">
							<span class="meta-label"><?php esc_html_e( 'Occurrences', 'edumall' ); ?></span>
							<span
								class="meta-value"><?php echo count( $zoom_meetings->occurrences ); ?></span>
						</div>

						<div class="zoom-meta-item zoom-meta-next-start-time">
							<span class="meta-label"><?php esc_html_e( 'Next Start Time', 'edumall' ); ?></span>
							<span class="meta-value">
							<?php
							$now               = new DateTime( 'now -1 hour', new DateTimeZone( $zoom_meetings->timezone ) );
							$closest_occurence = false;
							if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 8 && ! empty( $zoom_meetings->occurrences ) ) {
								foreach ( $zoom_meetings->occurrences as $occurrence ) {
									if ( $occurrence->status === "available" ) {
										$start_date = new DateTime( $occurrence->start_time, new DateTimeZone( $zoom_meetings->timezone ) );
										if ( $start_date >= $now ) {
											$closest_occurence = $occurrence->start_time;
											break;
										}

										esc_html_e( 'Meeting has ended !', 'edumall' );
										break;
									}
								}
							}

							if ( $closest_occurence ) {
								echo vczapi_dateConverter( $closest_occurence, $zoom_meetings->timezone, 'F j, Y @ g:i a' );
							} else {
								esc_html_e( 'Meeting has ended !', 'edumall' );
							}
							?>
						</span>
						</div>
						<?php
					} else {
						?>
						<div class="zoom-meta-item zoom-meta-start-time">
							<span class="meta-label"><?php esc_html_e( 'Start Time', 'edumall' ); ?></span>
							<span
								class="meta-value"><?php esc_html_e( 'Meeting has ended !', 'edumall' ); ?></span>
						</div>
						<?php
					}
				} else if ( ! empty( $zoom_meetings->type ) && $zoom_meetings->type === 3 ) {
					?>
					<div class="zoom-meta-item zoom-meta-start-time">
						<span class="meta-label"><?php esc_html_e( 'Start Time', 'edumall' ); ?></span>
						<span
							class="meta-value"><?php esc_html_e( 'This is a meeting with no Fixed Time.', 'edumall' ); ?></span>
					</div>
				<?php } else { ?>
					<div class="zoom-meta-item zoom-meta-start-time">
						<span class="meta-label"><?php esc_html_e( 'Start Time', 'edumall' ); ?></span>
						<span
							class="meta-value"><?php echo vczapi_dateConverter( $zoom_meetings->start_time, $zoom_meetings->timezone, 'F j, Y @ g:i a' ); ?></span>
					</div>
				<?php } ?>

				<div class="zoom-meta-item zoom-meta-timezone">
					<span class="meta-label"><?php esc_html_e( 'Timezone', 'edumall' ); ?></span>
					<span class="meta-value"><?php echo esc_html( $zoom_meetings->timezone ); ?></span>
				</div>
				<?php if ( ! empty( $zoom_meetings->duration ) ) : ?>
					<div class="zoom-meta-item zoom-meta-duration">
						<span class="meta-label"><?php esc_html_e( 'Duration', 'edumall' ); ?></span>
						<span
							class="meta-value"><?php echo esc_html( Edumall_Datetime::convertToHoursMinutes( $zoom_meetings->duration ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $zoom_meetings->start_time ) ): ?>
				<div class="zoom-countdown"
				     data-date="<?php echo Edumall_Datetime::convertCountdownDate( $zoom_meetings->start_time, $zoom_meetings->timezone ); ?>"
				     data-days-text="<?php esc_attr_e( 'Days', 'edumall' ); ?>"
				     data-hours-text="<?php esc_attr_e( 'Hours', 'edumall' ); ?>"
				     data-minutes-text="<?php esc_attr_e( 'Mins', 'edumall' ); ?>"
				     data-seconds-text="<?php esc_attr_e( 'Secs', 'edumall' ); ?>"
				>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="zoom-buttons">
		<?php
		Edumall_Zoom_Meeting::instance()->zoom_shortcode_join_link( $zoom_meetings );
		?>
	</div>
</div>
