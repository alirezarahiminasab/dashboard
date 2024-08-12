<?php

/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
?>
<div class="woocommerce-cart-empty">
	<div class="woocommerce-cart-empty-title">
		<p>
			سبد خرید
		</p>
	</div>
	<div class="woocommerce-cart-empty-content">
		<div class="woocommerce-cart-empty-content-header">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/empty-cart.svg' ?>" alt="">
			<p>
				سبد خرید شما خالی‌ست!
			</p>
		</div>
		<div class="woocommerce-cart-empty-content-footer">
			<a class="" href="<?php echo esc_url(site_url('/')); ?>">
				صفحه اصلی
			</a>
		</div>
	</div>
</div>
<?php
get_footer();
?>