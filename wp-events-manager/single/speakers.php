<?php
/**
 * Template part for displaying our speakers block on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/speakers.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined( 'ABSPATH' ) || exit;

$speakers_on = Edumall::setting( 'single_event_speaker_enable' );

if ( '1' !== $speakers_on ) {
	return;
}

$speakers = Edumall_Event::instance()->get_the_speakers();

if ( empty( $speakers ) ) {
	return;
}

$speaker_description = Edumall::setting( 'single_event_speaker_text' );
?>
<div class="entry-speakers border-section">
	<h3 class="entry-event-heading entry-event-heading-speakers"><?php esc_html_e( 'Our Speakers', 'edumall' ); ?></h3>
	<div class="tm-swiper tm-slider event-speakers-slider"
	     data-lg-items="5"
	     data-md-items="3"
	     data-sm-items="2"
	     data-lg-gutter="30"
	>
		<div class="swiper-inner">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php foreach ( $speakers as $speaker ) : ?>
						<?php
						$term_thumbnail_id = get_term_meta( $speaker->term_id, 'thumbnail_id', true );
						?>
						<div class="swiper-slide">
							<div class="speaker-item">
								<?php if ( $term_thumbnail_id ) : ?>
									<div class="speaker-thumbnail">
										<?php Edumall_Image::the_attachment_by_id( [
											'id'   => $term_thumbnail_id,
											'size' => '170x170',
										] ); ?>
									</div>
								<?php endif; ?>
								<h6 class="speaker-name"><?php echo esc_html( $speaker->name ); ?></h6>
								<div
									class="speaker-description"><?php echo esc_html( $speaker->description ); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ( ! empty( $speaker_description ) ) : ?>
		<div class="event-speakers-description">
			<?php echo esc_html( $speaker_description ); ?>
		</div>
	<?php endif; ?>
</div>
