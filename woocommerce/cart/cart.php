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
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();
$cart = WC()->cart;
$cart->calculate_totals();
$total_items = $cart->get_cart_contents_count();
$product_counter = 1;
$payment_gateways = WC()->payment_gateways->get_available_payment_gateways();

if (isset($_GET['Status'])) :
    // Do something.
    include(dirname(__DIR__) . "/checkout/thankyou.php");
    exit;
endif;

if (WC()->cart->is_empty()) :
    // Do something.
    include(dirname(__FILE__) . "/cart-empty.php");
    exit;
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

        <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <div class="woocommerce-cart-form-items">
                <?php if (!$detect->isMobile()) : ?>
                    <div class="woocommerce-cart-form-items-headline">
                        <span>
                            <p>
                                <?php esc_html_e('عنوان', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('مدرس', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('قیمت', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('کد تخفیف', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('تخفیف', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('پرداخت نهایی', 'edumall-child') ?>
                            </p>
                        </span>
                        <span>
                            <p>
                                <?php esc_html_e('حذف', 'edumall-child') ?>
                            </p>
                        </span>
                    </div>
                <?php endif ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :

                    $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    $course = tutor_utils()->product_belongs_with_course($_product->get_id());
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
                            <?php if ($detect->isMobile()) : ?>
                                <div class="woocommerce-cart-form-item-header">
                                <?php endif ?>
                                <div class="product-name <?php echo ($detect->isMobile()) ? '' : 'item-footer-group-desktop' ?>">
                                    <h6>
                                        <?php echo $product_counter; ?>.
                                    </h6>
                                    <a href="<?php echo $product_permalink ?  esc_url($product_permalink) : '#' ?>"><?php echo wp_kses_post($product_name) ?>
                                    </a>

                                    <?php
                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                    // Meta data.
                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                    // Backorder notification.
                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'edumall') . '</p>'));
                                    }
                                    ?>
                                </div>

                                <div class="product-author <?php echo ($detect->isMobile()) ? '' : 'item-footer-group-desktop' ?>">
                                    <p>
                                        <?php echo $author_display_name; ?>
                                    </p>
                                </div>

                                <?php if ($detect->isMobile()) : ?>
                                    <div class="product-remove <?php echo ($detect->isMobile()) ? '' : 'item-footer-group-desktop' ?>">
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
                            <?php endif ?>

                            <?php if ($detect->isMobile()) : ?>
                                <div class="woocommerce-cart-form-item-footer">
                                <?php endif ?>
                                <div class="product-price <?php echo ($detect->isMobile()) ? 'item-footer-group' : 'item-footer-group-desktop' ?>" data-title="<?php esc_attr_e('Price', 'edumall'); ?>">
                                    <?php if ($detect->isMobile()) : ?>
                                        <label><?php esc_html_e('قیمت دوره: ', 'edumall'); ?></label>
                                    <?php endif ?>
                                    <p>
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', $_product->get_price());
                                        ?>
                                        تومان
                                    </p>
                                </div>

                                <?php if (!$detect->isMobile()) : ?>
                                    <div class="product-coupon item-footer-group-desktop">
                                        <p>
                                            ---------
                                        </p>
                                    </div>
                                <?php endif ?>

                                <div class="product-discount <?php echo ($detect->isMobile()) ? 'item-footer-group' : 'item-footer-group-desktop' ?> data-title=" <?php esc_attr_e('Discount', 'edumall'); ?>">
                                    <?php if ($detect->isMobile()) : ?>
                                        <label><?php esc_html_e('تخفیف: ', 'edumall'); ?></label>
                                    <?php endif ?>
                                    <p>
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', $_product->get_price() - $discounted_price_per_unit); // PHPCS: XSS ok.
                                        ?>
                                        تومان
                                    </p>
                                </div>

                                <div class="product-total <?php echo ($detect->isMobile()) ? 'item-footer-group' : 'item-footer-group-desktop' ?>" data-title="<?php esc_attr_e('Total', 'edumall'); ?>">
                                    <?php if ($detect->isMobile()) : ?>
                                        <label><?php esc_html_e('قابل پرداخت: ', 'edumall'); ?></label>
                                    <?php endif ?>
                                    <p>
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal',  $discounted_price_per_unit); // PHPCS: XSS ok.
                                        ?>
                                        تومان
                                    </p>
                                </div>

                                <?php if (!$detect->isMobile()) : ?>
                                    <div class="product-remove <?php echo ($detect->isMobile()) ? '' : 'item-footer-group-desktop' ?>">
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
                                <?php endif ?>
                                <?php if ($detect->isMobile()) : ?>
                                </div>
                            <?php endif ?>
                        </div>
                <?php
                    }
                    $product_counter++;
                endforeach;
                ?>

                <?php if (!$detect->isMobile()) : ?>
                    <div class="woocommerce-cart-form-items-coupon-totals">

                        <div class="woocommerce-cart-form-coupons">
                            <h3>
                                <?php esc_html_e('در صورتی که کد تخفیف دارید، وارد کنید', 'woocommerce'); ?>
                            </h3>
                            <?php if (wc_coupons_enabled()) { ?>
                                <div class="coupon-list">
                                    <?php
                                    foreach (WC()->cart->get_coupons() as $code => $coupon) :
                                        $coupon = new WC_Coupon($coupon);
                                    ?>
                                        <div class="coupon-list-code coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                                            <p><?php echo $coupon->get_code(); ?></p>
                                            <a href="#" class="coupon-list-code-remove" data-coupon-id="<?php echo $coupon->get_code(); ?>">
                                                <?php esc_attr_e('حذف', 'edumall'); ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="coupon">
                                    <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                                    <button type="submit" class="button-coupon" name="apply_coupon_code" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('اعمال', 'woocommerce'); ?></button>
                                    <?php do_action('woocommerce_cart_coupon'); ?>
                                </div>
                            <?php } ?>

                            <?php do_action('woocommerce_cart_actions'); ?>

                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </div>

                        <?php do_action('woocommerce_after_cart_table'); ?>
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
                    </div>
                <?php endif ?>
            </div>

            <?php do_action('woocommerce_cart_contents'); ?>


            <?php do_action('woocommerce_after_cart_contents'); ?>
        </div>

        <?php if ($detect->isMobile()) : ?>
            <div class="woocommerce-cart-form-coupons">
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon">
                        <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                        <button type="submit" class="button-coupon" name="apply_coupon_code" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('اعمال', 'woocommerce'); ?></button>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>

                    <div class="coupon-list">
                        <?php
                        foreach (WC()->cart->get_coupons() as $code => $coupon) :
                            $coupon = new WC_Coupon($coupon);
                        ?>
                            <div class="coupon-list-code coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                                <p><?php echo $coupon->get_code(); ?></p>
                                <a href="#" class="coupon-list-code-remove" data-coupon-id="<?php echo $coupon->get_code(); ?>">
                                    <?php esc_attr_e('حذف', 'edumall'); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>

                <?php do_action('woocommerce_cart_actions'); ?>

                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </div>

            <?php do_action('woocommerce_after_cart_table'); ?>
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
        <?php endif ?>
    </form>
</div>
<?php do_action('woocommerce_before_cart_collaterals'); ?>


<?php

do_action('woocommerce_after_cart');
get_footer();
?>