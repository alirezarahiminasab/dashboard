<?php
defined('ABSPATH') || exit;

if (!class_exists('Edumall_WP_Widget_Product_Sorting')) {
	class Edumall_WP_Widget_Product_Sorting extends Edumall_WC_Widget_Base
	{

		public function __construct()
		{
			$this->widget_id          = 'edumall-wp-widget-product-sorting';
			$this->widget_cssclass    = 'edumall-wp-widget-product-sorting';
			$this->widget_name        = esc_html__('[Edumall] Product Sorting', 'edumall-child');
			$this->widget_description = esc_html__('Display a sorting list to sort products in your store.', 'edumall-child');
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__('Sort by', 'edumall-child'),
					'label' => esc_html__('Title', 'edumall-child'),
				),
			);

			parent::__construct();
		}

		public function widget($args, $instance)
		{
			if (!woocommerce_products_will_display()) {
				return;
			}

			$orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

			$show_default_orderby = 'menu_order' === apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

			$catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array(
				'menu_order' => esc_html__('Default', 'edumall-child'),
				'popularity' => esc_html__('Popularity', 'edumall-child'),
				'rating'     => esc_html__('Average rating', 'edumall-child'),
				'date'       => esc_html__('Newness', 'edumall-child'),
				'price'      => esc_html__('Price: low to high', 'edumall-child'),
				'price-desc' => esc_html__('Price: high to low', 'edumall-child'),
			));

			if (!$show_default_orderby) {
				unset($catalog_orderby_options['menu_order']);
			}

			if (get_option('woocommerce_enable_review_rating') === 'no') {
				unset($catalog_orderby_options['rating']);
			}

			$this->widget_start($args, $instance);
?>
			<ul class="order-by">
				<?php foreach ($catalog_orderby_options as $id => $name) : ?>
					<?php

					$link = $this->get_current_page_url();

					$link = add_query_arg('orderby', $id, $link);

					?>
					<li <?php if (selected($orderby, $id, false)) { ?> class="selected-order" <?php } ?>>
						<a href="<?php echo esc_url($link); ?>" data-order="<?php echo esc_attr($id); ?>"><?php echo esc_html($name); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
<?php
			$this->widget_end($args);
		}
	}
}
