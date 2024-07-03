<?php
/**
 * Template for displaying price
 *
 * @since   v.1.0.0
 *
 * @author  Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

$is_purchasable = tutor_utils()->is_course_purchasable();
$price          = apply_filters( 'get_tutor_course_price', null, get_the_ID() );
?>
<?php if ( $is_purchasable && $price ) : ?>
	<div class="tutor-price">
		<?php
		echo '' . $price;
		$badge_format = esc_html__( '%s off', 'edumall' );
		$badge_text   = Edumall_Tutor::instance()->get_course_price_badge_text( get_the_ID(), $badge_format );
		if ( ! empty( $badge_text ) ) {
			echo '<span class="course-price-badge onsale">' . $badge_text . '</span>';
		}
		?>
	</div>
<?php else : ?>
	<div class="tutor-price course-free">
		<?php esc_html_e( 'Free', 'edumall' ); ?>
	</div>
<?php
endif;
