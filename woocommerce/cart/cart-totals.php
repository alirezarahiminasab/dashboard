<?php

/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined('ABSPATH') || exit;
$cart = WC()->cart;
$total_discount = 0;
$subtotal = $cart->get_subtotal();
$cart->calculate_totals();
$order_total = $cart->get_total('edit');

foreach ($cart->get_coupons() as $code => $coupon) :
	// $total_discount += $amount;
	if (is_string($coupon)) {
		$coupon = new WC_Coupon($coupon);
	}

	$discount_amount_html = '';

	$amount               = WC()->cart->get_coupon_discount_amount($coupon->get_code(), WC()->cart->display_cart_ex_tax);
	$total_discount += $amount;
endforeach;
?>


<?php do_action('woocommerce_before_cart_totals'); ?>

<div class="woocommerce-cart-form-totals-info cart_totals <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">
	<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
		<div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
			<p><?php wc_cart_totals_coupon_label($coupon); ?></p>
			<?php wc_cart_totals_coupon_html($coupon); ?>
		</div>
	<?php endforeach; ?>

	<div class="cart-subtotal cart-info-item">
		<p>مجموع خرید:</p>
		<span>
			<p>
				<?php echo $subtotal; ?>
			</p>
			<p>
				تومان
			</p>
		</span>
	</div>

	<input id="create_order_nonce" type="hidden" value="<?php echo wp_create_nonce('create_order_nonce') ?>" />

	<div class="cart-discount-total cart-info-item">
		<p>
			مجموع تخفیف:
		</p>
		<span>
			<p>
				<?php echo $total_discount;	?>
			</p>
			<p>
				تومان
			</p>
		</span>
	</div>

	<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

	<div class="cart-total cart-info-item">
		<p>
			پرداخت نهایی:
		</p>
		<span>
			<p>
				<?php echo $order_total; ?>
			</p>
			<p>
				تومان
			</p>
		</span>
	</div>
</div>

<?php do_action('woocommerce_cart_totals_after_order_total'); ?>

<div class="woocommerce-cart-form-totals-pay">
	<a href="#">پرداخت</a>
</div>

<?php do_action('woocommerce_after_cart_totals'); ?>