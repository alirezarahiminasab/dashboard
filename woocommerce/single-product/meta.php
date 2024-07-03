<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @package       WooCommerce\Templates
 * @version       3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="entry-product-meta product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<div class="sku_wrapper meta-item">
			<label class="meta-label"><?php esc_html_e( 'SKU:', 'edumall' ); ?></label>
			<div class="meta-content">
				<span class="sku">
					<?php if ( $sku = $product->get_sku() ) : ?>
						<?php Edumall_Helper::e( $sku ); ?>
					<?php else: ?>
						<?php esc_html_e( 'N/A', 'edumall' ); ?>
					<?php endif; ?>
				</span>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( '1' === Edumall::setting( 'single_product_categories_enable' ) ) : ?>
		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="entry-product-categories meta-item"><label class="meta-label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'edumall' ) . '</label><div class="meta-content">', '</div></div>' ); ?>
	<?php endif; ?>

	<?php if ( '1' === Edumall::setting( 'single_product_tags_enable' ) ) : ?>
		<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="tagged_as meta-item"><label class="meta-label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'edumall' ) . '</label><div class="meta-content">', '</div></div>' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
