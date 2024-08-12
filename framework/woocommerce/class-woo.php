<?php
defined('ABSPATH') || exit;

/**
 * Custom functions, filters, actions for WooCommerce.
 */
if (!class_exists('Edumall_Woo')) {
	class Edumall_Woo extends Edumall_Post_Type
	{

		protected static $instance = null;
		const SIDEBAR_FILTERS        = 'shop_filters';
		const MINIMUM_PLUGIN_VERSION = '4.0.2';

		public static $product_image_size_width  = '';
		public static $product_image_size_height = '';
		public static $product_image_crop        = true;

		public static function instance()
		{
			if (null === self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize()
		{
			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/shop-layout-switcher.php';
			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/quick-view.php';
			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/checkout.php';
			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/my-account.php';
			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/cart.php';

			// Do nothing if Woo plugin not activated.
			if (!$this->is_activated()) {
				return;
			}

			require_once EDUMALL_FRAMEWORK_DIR . '/woocommerce/ajax-handlers.php';

			Edumall_Shop_Layout_Switcher::instance()->initialize();
			Edumall_Woo_Quick_View::instance()->initialize();
			Edumall_Woo_Cart::instance()->initialize();
			Edumall_Woo_Checkout::instance()->initialize();
			Edumall_Woo_My_Account::instance()->initialize();

			add_filter('edumall_user_profile_url', [$this, 'update_profile_url']);
			add_filter('edumall_user_profile_text', [$this, 'update_profile_text']);

			// Register widget areas.
			add_action('widgets_init', [$this, 'register_sidebars']);

			// Different style for sidebar.
			add_filter('edumall_page_sidebar_class', [$this, 'sidebar_class']);

			// Custom sidebar width.
			add_filter('edumall_one_sidebar_width', [$this, 'one_sidebar_width']);

			// Custom sidebar offset.
			add_filter('edumall_one_sidebar_offset', [$this, 'one_sidebar_offset']);

			// Add inner sidebar in main sidebar.
			add_action('edumall_page_sidebar_after_content', [$this, 'add_shop_sidebar_filter'], 10, 2);

			add_filter('edumall_title_bar_heading_text', [$this, 'archive_title_bar_heading']);

			add_filter('edumall_title_bar_heading_text', [$this, 'single_title_bar_heading']);

			add_filter('woocommerce_widget_get_current_page_url', [
				$this,
				'add_shop_layout_preset_for_layered_widgets',
			], 10, 2);

			add_filter('edumall_custom_css_primary_color_selectors', [$this, 'custom_css']);

			add_filter('woocommerce_add_to_cart_fragments', array($this, 'header_add_to_cart_fragment'));

			/**
			 * Move regular price before sale price.
			 */
			add_filter('formatted_woocommerce_price', [$this, 'formatted_woocommerce_price'], 10, 5);

			add_filter('woocommerce_get_price_html', [$this, 'simple_product_price_html'], 100, 2);
			add_filter('woocommerce_variation_sale_price_html', [$this, 'product_price_html'], 10, 2);
			add_filter('woocommerce_variation_price_html', [$this, 'product_price_html'], 10, 2);
			add_filter('woocommerce_variable_sale_price_html', [$this, 'product_minmax_price_html'], 10, 2);
			add_filter('woocommerce_variable_price_html', [$this, 'product_minmax_price_html'], 10, 2);

			add_action('wp_head', array($this, 'wp_init'));

			// Move nav count to link.
			add_filter('woocommerce_layered_nav_term_html', array(
				$this,
				'move_layered_nav_count_inside_link',
			), 10, 4);

			/**
			 * Begin hooks for shop archive.
			 */

			// Remove category from product list.
			remove_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');

			add_filter('woocommerce_get_star_rating_html', array($this, 'change_star_rating_html'), 10, 3);

			add_filter('woocommerce_catalog_orderby', array($this, 'custom_product_sorting'));

			add_filter('loop_shop_per_page', array($this, 'loop_shop_per_page'), 20);

			add_filter('woocommerce_pagination_args', array($this, 'override_pagination_args'));

			// Remove thumbnail & sale flash. then use custom.
			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash');
			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');

			if ('list' !== Edumall_Shop_Layout_Switcher::instance()->get_layout()) {
				// Move price before title.
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
				add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
			}

			/*add_action( 'woocommerce_before_shop_loop_item_title', array(
				$this,
				'template_loop_product_category',
			), 20 );*/

			// Hide star rating.
			//remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

			// Add link to the product title of loop.
			remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
			add_action('woocommerce_shop_loop_item_title', array(
				$this,
				'template_loop_product_title',
			), 10);
			/**
			 * End hooks for shop archive.
			 */

			/**
			 * Begin hooks for single product.
			 */
			add_filter('woocommerce_output_related_products_args', array($this, 'related_products_args'));

			// Move product rating after product price.
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
			add_action('woocommerce_single_product_summary', array($this, 'template_single_review_rating'), 5);
			add_action('edumall_template_before_product_single_rating', [
				$this,
				'add_custom_attribute_beside_rating',
			]);

			// Add sharing list.
			add_action('woocommerce_share', array($this, 'entry_sharing'));

			// Change review avatar size.
			add_filter('woocommerce_review_gravatar_size', array($this, 'woocommerce_review_gravatar_size'));

			// Check old version installed.
			if (defined('WOOSCP_VERSION') || (defined('WOOSC_VERSION') && version_compare(WOOSC_VERSION, self::MINIMUM_PLUGIN_VERSION, '<'))) {
				add_action('admin_notices', [$this, 'admin_notice_minimum_compare_plugin_version']);
			}

			// Hide default smart compare & smart wishlist button.
			add_filter('woosw_button_position_archive', '__return_zero_string');
			add_filter('woosw_button_position_single', '__return_zero_string');
			add_filter('woosc_button_position_archive', '__return_false');
			add_filter('woosc_button_position_single', '__return_false');

			add_action('woocommerce_before_add_to_cart_button', array(
				$this,
				'add_begin_wrapper_button_template',
			), 0);
			// Add compare & wishlist button again.
			add_action('woocommerce_after_add_to_cart_button', array($this, 'get_wishlist_button_template'));
			add_action('woocommerce_after_add_to_cart_button', array($this, 'get_compare_button_template'));
			add_action('woocommerce_after_add_to_cart_button', array(
				$this,
				'add_end_wrapper_button_template',
			), 9999);

			// Change compare button color on popup.
			add_filter('woosc_bar_btn_color_default', array($this, 'change_compare_button_color'));

			// Add div tag wrapper quantity.
			add_action('woocommerce_before_add_to_cart_quantity', array($this, 'add_quantity_open_wrapper'));
			add_action('woocommerce_after_add_to_cart_quantity', array($this, 'add_quantity_close_wrapper'));

			/**
			 * End hooks for single product.
			 */

			/**
			 * Begin ajax requests.
			 */
			// Load more for widget Product.
			add_action('wp_ajax_product_infinite_load', array($this, 'product_infinite_load'));
			add_action('wp_ajax_nopriv_product_infinite_load', array($this, 'product_infinite_load'));
			/**
			 * End ajax requests.
			 */

			add_action('after_switch_theme', array($this, 'change_product_image_size'), 2);
			add_action('after_setup_theme', array($this, 'modify_theme_support'), 10);

			// Fix Cart fragments issue with WC 7.8.0
			add_action('wp_enqueue_scripts', array($this, 'enqueue_wc_cart_fragments'), 99);
		}

		/**
		 * Check woocommerce plugin active
		 *
		 * @return boolean true if plugin activated
		 */
		function is_activated()
		{
			if (class_exists('WooCommerce')) {
				return true;
			}

			return false;
		}

		/* Fix Cart fragments issue with WC 7.8.0 */
		function enqueue_wc_cart_fragments()
		{
			wp_enqueue_script('wc-cart-fragments');
		}

		public function update_profile_url()
		{
			return wc_get_page_permalink('myaccount');
		}

		public function update_profile_text()
		{
			return esc_html__('My Account', 'edumall-child');
		}

		public function archive_title_bar_heading($text)
		{
			if ($this->is_product_archive()) {
				$text = Edumall::setting('product_archive_title_bar_title');
			}

			return $text;
		}

		public function single_title_bar_heading($text)
		{
			if (is_product()) {
				$text = Edumall_Helper::get_post_meta('page_title_bar_custom_heading', '');

				if ('' === $text) {
					$text = Edumall::setting('product_single_title_bar_title');
				}

				if ('' === $text) {
					$text = get_the_title();
				}
			}

			return $text;
		}

		public function register_sidebars()
		{
			$default_args = Edumall_Sidebar::instance()->get_default_sidebar_args();

			register_sidebar(array_merge($default_args, [
				'id'          => 'shop_filters',
				'name'        => esc_html__('Shop Top Filters', 'edumall-child'),
				'description' => esc_html__('This sidebar displays above products list on shop catalog pages.', 'edumall-child'),
			]));

			register_sidebar(array_merge($default_args, [
				'id'          => 'shop_sidebar_filters',
				'name'        => esc_html__('Shop Sidebar Filters', 'edumall-child'),
				'description' => esc_html__('This sidebar displays below Sidebar 1 on shop catalog pages.', 'edumall-child'),
			]));

			register_sidebar(array_merge($default_args, [
				'id'          => 'shop_sidebar',
				'name'        => esc_html__('Shop Sidebar', 'edumall-child'),
				'description' => esc_html__('Add widgets displays on shop catalog pages.', 'edumall-child'),
			]));

			register_sidebar(array_merge($default_args, [
				'id'          => 'single_shop_sidebar',
				'name'        => esc_html__('Single Shop Sidebar', 'edumall-child'),
				'description' => esc_html__('Add widgets displays on single product pages.', 'edumall-child'),
			]));
		}

		public function add_shop_sidebar_filter($name, $is_first_sidebar)
		{
			if (!$is_first_sidebar || !$this->is_product_archive()) {
				return;
			}
?>
			<div class="archive-sidebar-filter">
				<p class="archive-sidebar-filter-heading heading"><?php esc_html_e('Filter by', 'edumall-child'); ?></p>
				<?php Edumall_Sidebar::instance()->generated_sidebar('shop_sidebar_filters'); ?>
			</div>
		<?php
		}

		public function add_shop_layout_preset_for_layered_widgets($link, $widget)
		{
			// Shop layout preset.
			if (isset($_GET['shop_archive_preset'])) {
				$link = add_query_arg('shop_archive_preset', wc_clean(wp_unslash($_GET['shop_archive_preset'])), $link);
			}

			return $link;
		}

		public function sidebar_class($class)
		{
			if ($this->is_woocommerce_page()) {
				$class[] = 'style-02';
			}

			return $class;
		}

		public function one_sidebar_width($width)
		{
			if (Edumall_Woo::instance()->is_product_archive()) {
				$new_width = Edumall::setting('product_archive_single_sidebar_width');
			} elseif (is_singular('product')) {
				$new_width = Edumall::setting('product_page_single_sidebar_width');
			}

			// Use isset instead of empty avoid skip value 0.
			if (isset($new_width) && '' !== $new_width) {
				return $new_width;
			}

			return $width;
		}

		public function one_sidebar_offset($offset)
		{
			if (Edumall_Woo::instance()->is_product_archive()) {
				$new_offset = Edumall::setting('product_archive_single_sidebar_offset');
			} elseif (is_singular('product')) {
				$new_offset = Edumall::setting('product_page_single_sidebar_offset');
			}

			// Use isset instead of empty avoid skip value 0.
			if (isset($new_offset) && '' !== $new_offset) {
				return $new_offset;
			}

			return $offset;
		}

		public function custom_css($selectors)
		{
			$selectors['color'][] = "
				form.isw-swatches.isw-swatches--in-single .isw-swatch--isw_text .isw-term.isw-enabled:hover,
				form.isw-swatches.isw-swatches--in-single .isw-swatch--isw_text .isw-term.isw-selected,
				.wishlist-btn.style-02 a:hover,
				.compare-btn.style-02 a:hover,
				.order-by .selected-order a,
				.edumall-product-price-filter .current-state,
				.cart-collaterals .order-total .amount,
				.woocommerce-mini-cart__empty-message .empty-basket,
				.woocommerce .cart_list.product_list_widget a:hover,
				.woocommerce .cart.shop_table td.product-name a:hover,
				.woocommerce ul.product_list_widget li .product-title:hover,
				.entry-product-meta a:hover,
				.edumall-product .woocommerce-loop-product__title a:hover,
				.edumall-product .loop-product__category a:hover,
				.popup-product-quick-view .product_title a:hover,
				.woocommerce .wc_payment_methods .payment-selected .payment_title,
				.woocommerce .wc_payment_methods .payment_title:hover,
				.woocommerce-MyAccount-content .woocommerce-Address-title a,
				.woosw-area.woosw-area .woosw-inner .woosw-content .woosw-content-mid table.woosw-content-items .woosw-content-item .woosw-content-item--title a:hover,
				.woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-items table thead tr th a:hover,
				.woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-items .button,
				.woocommerce nav.woocommerce-pagination ul li a:hover
			";

			$selectors['background-color'][] = "
				.woocommerce-notice,
				.wishlist-btn.style-01 a:hover,
				.compare-btn.style-01 a:hover,
				.edumall-product.style-grid .quick-view-icon:hover,
				.edumall-product.style-grid .woocommerce_loop_add_to_cart_wrap a:hover,
				.woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-items .button:hover,
				.woocommerce nav.woocommerce-pagination ul li span.current,
				.woocommerce-info, .woocommerce-message,
				.woocommerce-MyAccount-navigation .is-active a,
				.woocommerce-MyAccount-navigation a:hover,
				.edumall-wp-widget-product-layered-nav ul.show-display-check-list .chosen > a:before,
				.edumall-wp-widget-product-categories-layered-nav ul.show-display-check-list .chosen > a:before
			";

			$selectors['border-color'][] = "
				form.isw-swatches.isw-swatches--in-single .isw-swatch--isw_text .isw-term.isw-selected,
				.wishlist-btn.style-01 a:hover,
				.compare-btn.style-01 a:hover,
				.edumall-wp-widget-product-layered-nav ul.show-display-check-list a:hover:before,
				.edumall-wp-widget-product-categories-layered-nav ul.show-display-check-list a:hover:before,
				body.woocommerce-cart table.cart td.actions .coupon .input-text:focus,
				.woocommerce.single-product div.product .images .thumbnails .item img:hover
			";

			$selectors['border-bottom-color'][] = "
				.mini-cart .widget_shopping_cart_content,
				.single-product .woocommerce-tabs li.active
			";

			return $selectors;
		}

		/**
		 * Add span tag wrap around decimal separator
		 *
		 * @param $formatted_price
		 * @param $price
		 * @param $number_decimals
		 * @param $decimals_separator
		 * @param $thousand_separator
		 *
		 * @return mixed|string
		 */
		public function formatted_woocommerce_price($formatted_price, $price, $number_decimals, $decimals_separator, $thousand_separator)
		{
			if ($number_decimals > 0 && !empty($decimals_separator)) {
				$origin_price = str_replace($decimals_separator, '<span class="decimals-separator">' . $decimals_separator, $formatted_price);
				$origin_price .= '</span>';

				return $origin_price;
			}

			return $formatted_price;
		}

		function custom_price_html($price_amt, $regular_price, $sale_price)
		{
			$html_price = '';

			if ($price_amt == $sale_price) {
				$html_price .= '<ins>' . wc_price($sale_price) . '</ins>';
				$html_price .= '<del>' . wc_price($regular_price) . '</del>';
			} else if ($price_amt == $regular_price) {
				$html_price .= '<ins>' . wc_price($regular_price) . '</ins>';
			}

			$html_price = '<p class="price">' . $html_price . '</p>';

			return $html_price;
		}

		/**
		 * @param            $price
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		public function simple_product_price_html($price, $product)
		{
			if ($product->is_type('simple')) {
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();
				$price_amt     = $product->get_price();

				return $this->custom_price_html($price_amt, $regular_price, $sale_price);
			} else {
				return $price;
			}
		}

		public function product_price_html($price, $variation)
		{
			$variation_id = $variation->variation_id;
			//creating the product object
			$variable_product = new WC_Product($variation_id);

			$regular_price = $variable_product->get_regular_price();
			$sale_price    = $variable_product->get_sale_price();
			$price_amt     = $variable_product->get_price();

			return $this->custom_price_html($price_amt, $regular_price, $sale_price);
		}

		/**
		 * @param                     $price
		 * @param WC_Product_Variable $product
		 *
		 * @return string
		 */
		public function product_minmax_price_html($price, $product)
		{
			$variation_min_price         = $product->get_variation_price('min', true);
			$variation_max_price         = $product->get_variation_price('max', true);
			$variation_min_regular_price = $product->get_variation_regular_price('min', true);
			$variation_max_regular_price = $product->get_variation_regular_price('max', true);

			if (($variation_min_price == $variation_min_regular_price) && ($variation_max_price == $variation_max_regular_price)) {
				$html_min_max_price = $price;
			} else {
				$html_price         = '<p class="price">';
				$html_price         .= '<ins>' . wc_price($variation_min_price) . '-' . wc_price($variation_max_price) . '</ins>';
				$html_price         .= '<del>' . wc_price($variation_min_regular_price) . '-' . wc_price($variation_max_regular_price) . '</del>';
				$html_min_max_price = $html_price;
			}

			return $html_min_max_price;
		}

		public function add_quantity_open_wrapper()
		{
		?>
			<div class="quantity-button-wrapper">
				<label><?php esc_html_e('Quantity', 'edumall-child'); ?></label>
			<?php
		}

		public function add_quantity_close_wrapper()
		{
			global $product;

			echo wc_get_stock_html($product); // WPCS: XSS ok.
			?>
			</div>
			<?php
		}

		function entry_sharing()
		{
			if ('1' === Edumall::setting('single_product_sharing_enable') && class_exists('InsightCore')) :
				$social_sharing = Edumall::setting('social_sharing_item_enable');
				if (!empty($social_sharing)) {
			?>
					<div class="entry-product-share">
						<div class="inner">
							<?php Edumall_Templates::get_sharing_list([
								'brand_color' => true,
							]); ?>
						</div>
					</div>
			<?php
				}
			endif;
		}

		/*
		 * Change woocommerce product image size on first time switch to this theme.
		 */
		public function change_product_image_size()
		{
			global $pagenow;

			if (!isset($_GET['activated']) || $pagenow != 'themes.php') {
				return;
			}

			$count = get_option('edumall_switch_theme_count');

			// Do it for first time.
			if (!$count || $count < 2) {
				// Update single image width
				//update_option( 'woocommerce_single_image_width', 760 );

				// Update thumbnail image width.
				update_option('woocommerce_thumbnail_image_width', 480);

				// Update thumbnail cropping ratio.
				update_option('woocommerce_thumbnail_cropping', 'custom');
				update_option('woocommerce_thumbnail_cropping_custom_width', 4);
				update_option('woocommerce_thumbnail_cropping_custom_height', 5);
			}
		}

		/**
		 * Modify image width theme support.
		 */
		function modify_theme_support()
		{
			/*$theme_support                          = get_theme_support( 'woocommerce' );
			$theme_support                          = is_array( $theme_support ) ? $theme_support[0] : array();
			$theme_support['single_image_width']    = 760;
			$theme_support['thumbnail_image_width'] = 400;

			remove_theme_support( 'woocommerce' );*/
			add_theme_support('woocommerce');
		}

		/**
		 * Returns true if on a page which uses WooCommerce templates exclude single product (cart and checkout are standard pages with shortcodes and which are also included)
		 *
		 * @access public
		 * @return bool
		 */
		function is_woocommerce_page_without_product()
		{
			if (function_exists('is_shop') && is_shop()) {
				return true;
			}

			if (function_exists('is_product_taxonomy') && is_product_taxonomy()) {
				return true;
			}

			if (is_post_type_archive('product')) {
				return true;
			}

			$the_id = get_the_ID();

			if ($the_id !== false) {
				$woocommerce_keys = array(
					'woocommerce_shop_page_id',
					'woocommerce_terms_page_id',
					'woocommerce_cart_page_id',
					'woocommerce_checkout_page_id',
					'woocommerce_myaccount_page_id',
					'woocommerce_logout_page_id',
				);

				foreach ($woocommerce_keys as $wc_page_id) {
					if ($the_id == get_option($wc_page_id, 0)) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
		 *
		 * @access public
		 * @return bool
		 */
		function is_woocommerce_page()
		{
			if (function_exists('is_woocommerce') && is_woocommerce()) {
				return true;
			}

			$woocommerce_keys = array(
				'woocommerce_shop_page_id',
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_myaccount_page_id',
				'woocommerce_logout_page_id',
			);

			foreach ($woocommerce_keys as $wc_page_id) {
				if (get_the_ID() == get_option($wc_page_id, 0) && 0 !== get_the_ID()) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Returns true if on a archive product pages.
		 *
		 * @access public
		 * @return bool
		 */
		function is_product_archive()
		{
			if (is_post_type_archive('product') || (function_exists('is_product_taxonomy') && is_product_taxonomy())) {
				return true;
			}

			return false;
		}

		public function template_single_review_rating()
		{
			?>
			<div class="entry-meta-review-rating">
				<div class="inner">
					<?php do_action('edumall_template_before_product_single_rating'); ?>

					<?php
					if (function_exists('woocommerce_template_single_rating')) {
						woocommerce_template_single_rating();
					}
					?>
				</div>
			</div>
		<?php
		}

		/**
		 * Get list of custom attributes used for customize.
		 */
		public function get_custom_attributes_list()
		{
			$results = [
				'' => esc_html__('None', 'edumall-child'),
			];

			if (is_admin() && $this->is_activated()) {
				$attributes = wc_get_attribute_taxonomies();

				if (!empty($attributes)) {
					foreach ($attributes as $attribute) {
						$results[$attribute->attribute_name] = $attribute->attribute_label;
					}
				}
			}

			return $results;
		}

		public function add_custom_attribute_beside_rating()
		{
			$attribute_name = Edumall::setting('single_product_custom_attribute');

			if (empty($attribute_name)) {
				return;
			}

			global $product;

			$attribute_value = $product->get_attribute($attribute_name);

			if (empty($attribute_value)) {
				return;
			}
		?>
			<div class="entry-product-custom-attribute">
				<?php if ('1' === Edumall::setting('single_product_custom_attribute_label')) : ?>
					<span class="custom-attribute-name">
						<?php
						$attribute_id   = wc_attribute_taxonomy_id_by_name($attribute_name);
						$attribute_info = wc_get_attribute($attribute_id);

						echo esc_html($attribute_info->name . ': ');
						?>
					</span>
				<?php endif; ?>

				<span class="custom-attribute-value primary-color"><?php echo esc_html($attribute_value); ?></span>
			</div>
		<?php
		}

		/**
		 * Custom product title instead of default product title
		 *
		 * @see woocommerce_template_loop_product_title()
		 */
		public function template_loop_product_title()
		{
		?>
			<h2 class="woocommerce-loop-product__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php
		}

		public function template_loop_product_category()
		{
			global $product;

			$cats = $product->get_category_ids();

			if (!empty($cats)) {
			?>
				<div class="loop-product__category">
					<?php
					$first_cat = $cats[0];
					$cat       = get_term_by('id', $first_cat, 'product_cat');

					if ($cat instanceof \WP_Term) {
						$link = get_term_link($cat);
						echo '<a href="' . esc_url($link) . '">' . $cat->name . '</a>';
					}
					?>
				</div>
			<?php
			}
		}

		function loop_shop_per_page()
		{
			if (isset($_GET['shop_archive_preset']) && in_array($_GET['shop_archive_preset'], [
				'left-sidebar',
				'right-sidebar',
			])) {
				// Hard set post per page. because override preset settings run after init hook.
				$number = 16;
			} else {
				$number = Edumall::setting('shop_archive_number_item');
			}

			return isset($_GET['product_per_page']) ? wc_clean($_GET['product_per_page']) : $number;
		}

		function override_pagination_args($args)
		{
			$args['prev_text'] = Edumall_Templates::get_pagination_prev_text();
			$args['next_text'] = Edumall_Templates::get_pagination_next_text();

			return $args;
		}

		function woocommerce_review_gravatar_size()
		{
			return Edumall::COMMENT_AVATAR_SIZE;
		}

		function wp_init()
		{
			$tabs_display = Edumall::setting('single_product_tabs_style');

			if ('list' === $tabs_display) {
				remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
				add_action('woocommerce_after_single_product_summary', array(
					$this,
					'output_product_data_tabs_as_list',
				), 10);
			}

			/**
			 * Move Up-sell section below page content.
			 */
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			if (Edumall::setting('single_product_up_sells_enable') === '1') {
				add_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 15);
			}

			/**
			 * Move Related section below page content.
			 */
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			if (Edumall::setting('single_product_related_enable') === '1') {
				add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 15);
			}

			// Remove Cross Sells from default position at Cart. Then add them back UNDER the Cart Table.
			remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
			if (Edumall::setting('shopping_cart_cross_sells_enable') === '1') {
				add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
			}

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			// @hooked wc_print_notices - 10
			add_action('woocommerce_before_shop_loop', [$this, 'add_shop_action_begin_wrapper'], 15);
			// @hooked woocommerce_result_count - 20
			remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

			add_action('woocommerce_before_shop_loop', [
				$this,
				'woocommerce_result_count',
			], 20); // Use custom function.

			add_action('woocommerce_before_shop_loop', [$this, 'add_shop_action_right_toolbar_begin_wrapper'], 25);

			/**
			 * Change order template priority 30 -> 40.
			 */
			remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

			if ('1' === Edumall::setting('shop_archive_sorting')) {
				add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 40);
			}

			if ('1' === Edumall::setting('shop_archive_filtering') && is_active_sidebar(self::SIDEBAR_FILTERS)) {
				add_action('woocommerce_before_shop_loop', [
					$this,
					'add_shop_action_right_toolbar_filter_button',
				], 40);
			}

			add_action('woocommerce_before_shop_loop', [$this, 'add_shop_action_right_toolbar_end_wrapper'], 50);

			if ('1' === Edumall::setting('shop_archive_filtering')) {
				add_action('woocommerce_before_shop_loop', [$this, 'add_shop_action_filter_widgets'], 60);
			}

			add_action('woocommerce_before_shop_loop', [$this, 'add_shop_action_end_wrapper'], 70);
		}

		public function related_products_args($args)
		{
			$number = Edumall::setting('product_related_number');

			$args['posts_per_page'] = $number;

			return $args;
		}

		public function output_product_data_tabs_as_list()
		{
			$product_tabs = apply_filters('woocommerce_product_tabs', array());

			if (!empty($product_tabs)) : ?>
				<div class="entry-product-tab-list">
					<?php foreach ($product_tabs as $key => $product_tab) : ?>
						<div class="entry-product-tab-list-item">
							<?php
							if (isset($product_tab['callback'])) {
								call_user_func($product_tab['callback'], $key, $product_tab);
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif;
		}

		/**
		 * Output the result count text (Showing x - x of x results).
		 */
		function woocommerce_result_count()
		{
			/*if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
				return;
			}*/
			$args = array(
				'total'    => wc_get_loop_prop('total'),
				'per_page' => wc_get_loop_prop('per_page'),
				'current'  => wc_get_loop_prop('current_page'),
			);

			wc_get_template('loop/result-count.php', $args);
		}

		public function change_star_rating_html($rating_html, $rating, $count)
		{
			$rating_html = Edumall_Templates::render_rating($rating, ['echo' => false]);

			return $rating_html;
		}

		/**
		 * Change text of select options.
		 *
		 * @param $sorting_options
		 *
		 * @return mixed
		 */
		public function custom_product_sorting($sorting_options)
		{
			if (isset($sorting_options['menu_order'])) {
				$sorting_options['menu_order'] = esc_html__('Default', 'edumall-child');
			}

			if (isset($sorting_options['popularity'])) {
				$sorting_options['popularity'] = esc_html__('Popularity', 'edumall-child');
			}

			if (isset($sorting_options['rating'])) {
				$sorting_options['rating'] = esc_html__('Average rating', 'edumall-child');
			}

			if (isset($sorting_options['date'])) {
				$sorting_options['date'] = esc_html__('Latest', 'edumall-child');
			}

			if (isset($sorting_options['price'])) {
				$sorting_options['price'] = esc_html__('Price: low to high', 'edumall-child');
			}

			if (isset($sorting_options['price-desc'])) {
				$sorting_options['price-desc'] = esc_html__('Price: high to low', 'edumall-child');
			}

			return $sorting_options;
		}

		public function get_shop_base_url()
		{
			if (defined('SHOP_IS_ON_FRONT')) {
				$link = home_url();
			} elseif (is_shop()) {
				$link = get_permalink(wc_get_page_id('shop'));
			} elseif (is_product_category()) {
				$link = get_term_link(get_query_var('product_cat'), 'product_cat');
			} elseif (is_product_tag()) {
				$link = get_term_link(get_query_var('product_tag'), 'product_tag');
			} else {
				$queried_object = get_queried_object();
				$link           = get_term_link($queried_object->slug, $queried_object->taxonomy);
			}

			return $link;
		}

		public function add_shop_action_filter_widgets()
		{
			$filtering_enable = Edumall::setting('shop_archive_filtering');

			if ('1' === $filtering_enable && is_active_sidebar(self::SIDEBAR_FILTERS)) {
			?>
				<div id="archive-top-filter-widgets" class="col-md-12 archive-top-filter-widgets">
					<div class="inner">
						<div class="archive-top-filter-content">
							<?php dynamic_sidebar(self::SIDEBAR_FILTERS); ?>
						</div>

						<?php
						$has_filters = isset($_GET['filtering']) ? true : false;

						if ($has_filters) {
							$reset_link = $this->get_shop_base_url();

							Edumall_Templates::render_button([
								'wrapper_class' => 'btn-reset-filters',
								'extra_class'   => 'button-white',
								'text'          => esc_html__('Clear filters', 'edumall-child'),
								'link'          => [
									'url' => $reset_link,
								],
								'icon'          => 'far fa-times',
								'size'          => 'xs',
							]);
						}
						?>
					</div>
				</div>
			<?php
			}
		}

		public function add_shop_action_right_toolbar_filter_button()
		{
			Edumall_Templates::render_button([
				'wrapper_class' => 'btn-toggle-shop-filters',
				'extra_class'   => 'btn-toggle-archive-top-filters button-grey',
				'text'          => esc_html__('Filters', 'edumall-child'),
				'link'          => [
					'url' => 'javascript:void(0)',
				],
				'icon'          => 'fal fa-filter',
				'id'            => 'btn-toggle-archive-top-filters',
			]);
		}

		public function add_shop_action_begin_wrapper()
		{
			echo '<div class="archive-filter-bars row row-xs-center">';
		}

		public function add_shop_action_end_wrapper()
		{
			echo '</div>';
		}

		public function add_shop_action_right_toolbar_begin_wrapper()
		{
			echo '<div class="archive-filter-bar archive-filter-bar-right col-md-6"><div class="inner">';
		}

		public function add_shop_action_right_toolbar_end_wrapper()
		{
			echo '</div></div>';
		}

		/**
		 * Ensure cart contents update when products are added to the cart via AJAX
		 * ========================================================================
		 *
		 * @param $fragments
		 *
		 * @return mixed
		 */
		function header_add_to_cart_fragment($fragments)
		{
			ob_start();
			$cart_html = $this->get_mini_cart();
			echo '' . $cart_html;
			$fragments['.mini-cart__button'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Get mini cart HTML
		 * ==================
		 *
		 * @return string
		 */
		function get_mini_cart()
		{
			global $woocommerce;
			$cart_url = '/cart';
			if (isset($woocommerce)) {
				$cart_url = wc_get_cart_url();
			}

			if (empty(WC()->cart)) {
				return '';
			}

			$cart_html = '';
			$qty       = WC()->cart->get_cart_contents_count();
			$cart_html .= '<a href="' . esc_url($cart_url) . '" class="mini-cart__button header-icon" title="' . esc_attr__('View your shopping cart', 'edumall-child') . '">';
			$cart_html .= '<span class="mini-cart-icon" data-count="' . $qty . '"></span>';
			$cart_html .= '</a>';

			return $cart_html;
		}

		function render_mini_cart()
		{
			$header_type = Edumall_Global::instance()->get_header_type();

			$enabled = Edumall::setting("header_style_{$header_type}_cart_enable");

			if ($this->is_activated() && in_array($enabled, array('1', 'hide_on_empty'))) {
				$classes = 'mini-cart';
				if ($enabled === 'hide_on_empty') {
					$classes .= ' hide-on-empty';
				}

				if ('03' === $header_type) {
					$classes .= ' style-svg';
				} else {
					$classes .= ' style-normal';
				}
			?>
				<div id="mini-cart" class="<?php echo esc_attr($classes); ?>">
					<?php echo '' . $this->get_mini_cart(); ?>
					<div class="widget_shopping_cart_content"></div>
				</div>
			<?php }
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		function get_percentage_price($product = null)
		{
			if (!$product) {
				global $product;
			}

			if ($product->is_type('simple') || $product->is_type('external')) {
				$_regular_price = $product->get_regular_price();
				$_sale_price    = $product->get_sale_price();

				$percentage = round((($_regular_price - $_sale_price) / $_regular_price) * 100);

				return "-{$percentage}%";
			} else {
				return esc_html__('Sale !', 'edumall-child');
			}
		}

		function get_wishlist_button_template($args = array())
		{
			if ((Edumall::setting('shop_archive_wishlist') !== '1') || !class_exists('WPCleverWoosw')) {
				return;
			}

			global $product;
			$product_id = $product->get_id();

			$defaults = array(
				'show_tooltip'     => true,
				'tooltip_position' => 'top',
				'tooltip_skin'     => 'primary',
				'style'            => '02',
			);
			$args     = wp_parse_args($args, $defaults);

			$_wrapper_classes = "product-action wishlist-btn style-{$args['style']}";

			if ($args['show_tooltip'] === true) {
				$_wrapper_classes .= ' hint--bounce';
				$_wrapper_classes .= " hint--{$args['tooltip_position']}";
				$_wrapper_classes .= " hint--{$args['tooltip_skin']}";
			}
			?>
			<div class="<?php echo esc_attr($_wrapper_classes); ?>" aria-label="<?php esc_attr_e('Add to wishlist', 'edumall-child') ?>">
				<?php echo do_shortcode('[woosw id="' . $product_id . '" type="link"]'); ?>
			</div>
		<?php
		}

		function get_compare_button_template($args = array())
		{
			if (Edumall::setting('shop_archive_compare') !== '1' || wp_is_mobile() || !class_exists('WPCleverWoosc')) {
				return;
			}

			global $product;
			$product_id = $product->get_id();

			$defaults = array(
				'show_tooltip'     => true,
				'tooltip_position' => 'top',
				'tooltip_skin'     => 'primary',
				'style'            => '02',
			);
			$args     = wp_parse_args($args, $defaults);

			$_wrapper_classes = "product-action compare-btn style-{$args['style']}";

			if ($args['show_tooltip'] === true) {
				$_wrapper_classes .= ' hint--bounce';
				$_wrapper_classes .= " hint--{$args['tooltip_position']}";
				$_wrapper_classes .= " hint--{$args['tooltip_skin']}";
			}
		?>
			<div class="<?php echo esc_attr($_wrapper_classes); ?>" aria-label="<?php esc_attr_e('Compare', 'edumall-child') ?>">
				<?php echo do_shortcode('[woosc id="' . $product_id . '" type="link"]'); ?>
			</div>
<?php
		}

		public function change_compare_button_color()
		{
			$primary_color = Edumall::setting('primary_color');

			return $primary_color;
		}

		public function product_infinite_load()
		{
			$source = isset($_POST['source']) ? $_POST['source'] : '';

			if ('current_query' === $source) {
				$query_vars                = $_POST['query_vars'];
				$query_vars['paged']       = $_POST['paged'];
				$query_vars['nopaging']    = false;
				$query_vars['post_status'] = 'publish';

				$edumall_query = new WP_Query($query_vars);
			} else {
				$query_args = array(
					'post_type'      => $_POST['post_type'],
					'posts_per_page' => $_POST['posts_per_page'],
					'orderby'        => $_POST['orderby'],
					'order'          => $_POST['order'],
					'paged'          => $_POST['paged'],
					'post_status'    => 'publish',
				);

				if (!empty($_POST['extra_taxonomy'])) {
					$query_args = $this->build_extra_terms_query($query_args, $_POST['extra_taxonomy']);
				}

				$edumall_query = new WP_Query($query_args);
			}

			$response = array(
				'max_num_pages' => $edumall_query->max_num_pages,
				'found_posts'   => $edumall_query->found_posts,
				'count'         => $edumall_query->post_count,
			);

			ob_start();

			if ($edumall_query->have_posts()) :

				while ($edumall_query->have_posts()) : $edumall_query->the_post();
					wc_get_template_part('content', 'product');
				endwhile;

				wp_reset_postdata();

			endif;

			$template = ob_get_contents();
			ob_clean();

			$response['template'] = $template;

			echo json_encode($response);

			wp_die();
		}

		function get_product_image($args = array())
		{
			$defaults = array(
				'extra_class' => '',
			);

			$args = wp_parse_args($args, $defaults);

			// Calculate product loop image size.
			if (self::$product_image_size_width === '') {
				$width = 400;

				$shop_layout = Edumall::setting('shop_archive_layout');
				if ('wide' === $shop_layout) {
					$width = 540;
				}

				$cropping = get_option('woocommerce_thumbnail_cropping');
				$height   = $width;

				if ($cropping === 'custom') {
					$ratio_w = get_option('woocommerce_thumbnail_cropping_custom_width');
					$ratio_h = get_option('woocommerce_thumbnail_cropping_custom_height');

					$height = ($width * $ratio_h) / $ratio_w;
					$height = (int) $height;
				} elseif ($cropping === 'uncropped') {
					self::$product_image_crop = false;
					$height                   = 9999;
				}

				self::$product_image_size_width  = $width;
				self::$product_image_size_height = $height;
			}

			$image_args = array(
				'id'     => $args['id'],
				'size'   => 'custom',
				'width'  => self::$product_image_size_width,
				'height' => self::$product_image_size_height,
				'crop'   => self::$product_image_crop,
			);

			if ($args['extra_class'] !== '') {
				$image_args['class'] = $args['extra_class'];
			}

			Edumall_Image::the_attachment_by_id($image_args);
		}

		function move_layered_nav_count_inside_link($term_html, $term, $link, $count)
		{
			if ($count > 0) {
				$term_html = str_replace('</a>', '', $term_html);

				$find    = '</span>';
				$replace = '</span></a>';
				$pos     = strrpos($term_html, $find);

				if ($pos !== false) {
					$term_html = substr_replace($term_html, $replace, $pos, strlen($find));
				}
			}

			return $term_html;
		}

		public function get_single_product_style()
		{
			$style = Edumall_Helper::get_post_meta('single_product_layout_style');

			if (empty($style)) {
				$style = Edumall::setting('single_product_layout_style');
			}

			return $style;
		}

		/**
		 * @param WC_Product $product Check if product is in best selling list.
		 *
		 * @return bool
		 */
		public function is_product_best_seller($product)
		{
			$product_id       = $product->get_id();
			$best_selling_ids = $this->get_best_selling_products();

			if (in_array($product_id, $best_selling_ids)) {
				return true;
			}

			return false;
		}

		public function get_best_selling_products()
		{
			$transient_name = 'edumall-product-best-selling-ids';

			$products = get_transient($transient_name);

			if (false === $products) {
				$number = Edumall::setting('shop_badge_best_seller_number');

				$args = [
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'no_found_rows'  => true,
					'posts_per_page' => $number,
					'meta_query'     => array(
						array(
							'key'     => 'total_sales',
							'value'   => '0',
							'compare' => '>',
						),
					),
					'meta_key'       => 'total_sales',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
				];

				$query = new WP_Query($args);

				$products = [];

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();

						$products[] = get_the_ID();
					}

					wp_reset_postdata();
				}

				set_transient($transient_name, $products, DAY_IN_SECONDS);
			}

			return $products;
		}

		/**
		 * Check if product is a tutor product.
		 *
		 * @param mixed int|WC_Product $product
		 *
		 * @return bool
		 */
		public function is_tutor_product($product = null)
		{
			if (null === $product) {
				global $product;
			}

			$product_id = $product;

			if ($product instanceof WC_Product) {
				$product_id = $product->get_id();
			}

			$is_tutor = get_post_meta($product_id, '_tutor_product', true);

			if ('yes' === $is_tutor) {
				return true;
			}

			return false;
		}

		/**
		 * Check product is added to cart
		 *
		 * @param $product_id
		 *
		 * @since   2.0.0
		 * @version 2.0.0
		 *
		 * @return bool
		 */
		public function is_product_in_cart($product_id)
		{
			if (!empty(WC()->cart) && !WC()->cart->is_empty()) {
				// Loop though cart items.
				foreach (WC()->cart->get_cart() as $cart_item) :
					// Handling also variable products and their products variations.
					$cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);

					if (in_array($product_id, $cart_item_ids)) {
						return true;
					}
				endforeach;
			}

			return false;
		}

		public function add_begin_wrapper_button_template()
		{
			echo '<div class="entry-product-actions">';
		}

		public function add_end_wrapper_button_template()
		{
			echo '</div>';
		}

		/**
		 * Alt function to get image of product with custom size
		 *
		 * @see    WC_Product::get_image()
		 *
		 * @param WC_Product $product
		 * @param string     $size
		 *
		 * @return string $image HTML img tag
		 * @since  2.7.3
		 */
		public function get_product_image_alt($product, $size = 'thumbnail')
		{
			$image = '';
			if ($product->get_image_id()) {
				$image = Edumall_Image::get_attachment_by_id([
					'id'   => $product->get_image_id(),
					'size' => $size,
				]);
			} elseif ($product->get_parent_id()) {
				$parent_product = wc_get_product($product->get_parent_id());
				if ($parent_product) {
					$image = Edumall_Image::get_attachment_by_id([
						'id'   => $parent_product->get_image_id(),
						'size' => $size,
					]);
				}
			}

			if (!$image) {
				$image = wc_placeholder_img($size);
			}

			return $image;
		}

		public function admin_notice_minimum_compare_plugin_version()
		{
			edumall_notice_required_plugin_version('WPC Smart Compare for WooCommerce', '4.0.1');
		}
	}

	Edumall_Woo::instance()->initialize();
}
