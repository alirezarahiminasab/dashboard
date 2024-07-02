<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;
$cart = WC()->cart;
$cart->calculate_totals();
$total_items = $cart->get_cart_contents_count();
$product_counter = 1;

do_action('woocommerce_before_cart');

if (WC()->cart->is_empty()) :
	// Do something.
	include(dirname(__FILE__) . "/cart-empty.php");
	return;
endif;
?>
<div class="woocommerce-cart-wrap">
	<div class="woocommerce-cart-title">
		<p>
			سبد خرید
			(<?php echo $total_items ?>)
		</p>
	</div>

	<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

		<?php do_action('woocommerce_before_cart_table'); ?>

		<div class="woocommerce-cart-form-items">
			<?php do_action('woocommerce_before_cart_contents'); ?>

			<?php
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :

				$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
				$course = tutor_utils()->product_belongs_with_course($_product->id);
				$author_id = get_post($course->post_id)->post_author;
				$author_display_name = get_the_author_meta('display_name', $author_id);

				// Get the quantity of the product
				$quantity = $cart_item['quantity'];

				// Get the line total (price after discount)
				$line_total = $cart_item['line_total'];

				// Calculate the discounted price per unit
				$discounted_price_per_unit = $line_total / $quantity;

				$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
					$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
			?>
					<div class="woocommerce-cart-form-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

						<div class="woocommerce-cart-form-item-header">
							<div class="product-name">
								<h6>
									<?php echo $product_counter; ?>.
								</h6>
								<?php
								printf(
									'<h6 class="product-title"> %1$s%2$s%3$s</h6>',
									$product_permalink ? '<a href="' . esc_url($product_permalink) . '">' : '',
									wp_kses_post($product_name),
									$product_permalink ? '</a>' : ''
								);

								do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

								// Meta data.
								echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

								// Backorder notification.
								if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'edumall') . '</p>'));
								}
								?>
							</div>

							<div class="product-author">
								<p>
									<?php echo $author_display_name; ?>
								</p>
							</div>

							<div class="product-remove">
								<?php
								// @codingStandardsIgnoreLine
								echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="%s" title="%s" data-product_id="%s" data-product_sku="%s"><img src="%s"/></a>',
									esc_url(wc_get_cart_remove_url($cart_item_key)),
									esc_attr('tm-button style-bottom-line'),
									esc_attr__('Remove this item', 'edumall'),
									esc_attr($product_id),
									esc_attr($_product->get_sku()),
									esc_html__(get_stylesheet_directory_uri() . '/assets/images/trash-cart.svg')
								), $cart_item_key);
								?>
							</div>
						</div>

						<div class="woocommerce-cart-form-item-footer">
							<div class="product-price item-footer-group" data-title="<?php esc_attr_e('Price', 'edumall'); ?>">
								<label><?php esc_html_e('قیمت دوره: ', 'edumall'); ?></label>
								<p>
									<?php
									echo apply_filters('woocommerce_cart_item_price', $_product->get_price());
									?>
									تومان
								</p>
							</div>

							<div class="product-discount item-footer-group" data-title="<?php esc_attr_e('Discount', 'edumall'); ?>">
								<label><?php esc_html_e('تخفیف: ', 'edumall'); ?></label>
								<p>
									<?php
									echo apply_filters('woocommerce_cart_item_subtotal', $discounted_price_per_unit); // PHPCS: XSS ok.
									?>
									تومان
								</p>
							</div>

							<div class="product-total item-footer-group" data-title="<?php esc_attr_e('Total', 'edumall'); ?>">
								<label><?php esc_html_e('قابل پرداخت: ', 'edumall'); ?></label>
								<p>
									<?php
									echo apply_filters('woocommerce_cart_item_subtotal',  $discounted_price_per_unit); // PHPCS: XSS ok.
									?>
									تومان
								</p>
							</div>
						</div>
					</div>
			<?php
				}
				$product_counter++;
			endforeach;

			do_action('woocommerce_cart_contents');
			?>

			<?php do_action('woocommerce_after_cart_contents'); ?>
		</div>

		<?php do_action('woocommerce_after_cart_table'); ?>

		<div class="woocommerce-cart-form-coupons">
			<?php if (wc_coupons_enabled()) { ?>
				<div class="coupon">
					<label for="coupon_code"><?php esc_html_e('Coupon:', 'edumall'); ?></label>
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('کد تخفیف خود را وارد کنید', 'edumall'); ?>" />

					<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'edumall'); ?>"><?php esc_html_e('اعمال', 'edumall'); ?></button>

					<?php do_action('woocommerce_cart_coupon'); ?>

					<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
				</div>
			<?php } ?>
		</div>
		<?php do_action('woocommerce_before_cart_collaterals'); ?>

		<div class="woocommerce-cart-form-totals">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			include(dirname(__FILE__) . "/cart-totals.php");
			?>
		</div>
	</form>
</div>
<?php do_action('woocommerce_after_cart');
get_footer();

?>