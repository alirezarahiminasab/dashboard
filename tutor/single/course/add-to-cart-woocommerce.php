<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.2.0
 */

defined('ABSPATH') || exit;

$product_id = tutor_utils()->get_course_product_id();
$product    = wc_get_product($product_id);
$price = tutor_utils()->get_raw_course_price(get_the_ID());
$regularPrice = (int)$price->regular_price;
$salePrice = (int)$price->sale_price;
$product_id = tutor_utils()->get_course_product_id(get_the_ID());

if ($product) {
?>

	<div class="tutor-course-purchase-box">
		<?php if (tutor_utils()->is_course_added_to_cart($product_id, true)) : ?>
			<div class="view-cart-button">
				<a href="<?php echo get_permalink(get_page_by_path('cart')); ?>">
					<?php esc_html_e('View Cart', 'edumall-child'); ?>
				</a>
			</div>
		<?php else : ?>
			<form class="buy-now" action="<?php echo esc_url(apply_filters('tutor_course_add_to_cart_form_action', get_permalink(get_the_ID()))); ?>" method="post" enctype='multipart/form-data'>

				<input type="hidden" name="product_id" value="<?php echo $product_id ?>">
				<input type="hidden" name="cart_url" value="<?php echo get_permalink(get_page_by_path('cart')); ?>">

				<?php do_action('tutor_before_add_to_cart_button'); ?>

				<?php
				$notification_settings = [
					'image' => '',
					'title' => get_the_title(),
				];

				if (has_post_thumbnail()) {
					$thumbnail_id = get_post_thumbnail_id();

					$notification_settings['image'] = Edumall_Image::get_attachment_url_by_id([
						'id'   => $thumbnail_id,
						'size' => '80x80',
					]);
				}
				?>

				<div class="buy-now-button" data-notification="<?php echo esc_attr(wp_json_encode($notification_settings)); ?>">
					<a href="#" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="buy-now-button-add-to-cart alt">
						<?php esc_html_e('خرید دوره', 'edumall-child'); ?>
					</a>
				</div>

				<div class="buy-now-price">
					<div class="buy-now-price-wrap">
						<?php if ($salePrice) : ?>
							<div class="buy-now-price-wrap-sale">
								<p class="value"><?php echo number_format($salePrice);  ?></p>
								<p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
							</div>
							<div class="buy-now-price-wrap-regular sale">
								<p class="value"><?php echo number_format($regularPrice)  ?></p>
								<p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
							</div>
						<?php else : ?>
							<div class="buy-now-price-wrap-regular">
								<p class="value"><?php echo number_format($regularPrice);  ?></p>
								<p class="currency"><?php echo esc_html__('Toman', 'edumall-child'); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php do_action('tutor_after_add_to_cart_button'); ?>

			</form>
		<?php endif; ?>
	</div>

<?php } else { ?>
	<p class="tutor-alert-warning">
		<?php esc_html_e('Please make sure that your product exists and valid for this course', 'edumall-child'); ?>
	</p>
<?php
}
