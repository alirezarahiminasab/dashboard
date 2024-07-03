<?php
defined( 'ABSPATH' ) || exit;

/**
 * Custom functions, filters, actions for WooCommerce cart page.
 */
if ( ! class_exists( 'Edumall_Woo_Cart' ) ) {
	class Edumall_Woo_Cart {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Check for empty-cart get param to clear the cart.
			add_action( 'init', [ $this, 'woocommerce_clear_cart_url' ] );

			/**
			 * Edit cart empty messages.
			 *
			 * Used filter instead action because last item removed ignore empty messages.
			 */
			/*remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
			add_action( 'woocommerce_cart_is_empty', array( $this, 'change_empty_cart_messages' ), 10 );*/
			add_filter( 'wc_empty_cart_message', [ $this, 'change_empty_cart_messages' ] );
		}

		public function change_empty_cart_messages( $message ) {
			?>
			<div class="empty-cart-messages">
				<div class="empty-cart-icon">
					<?php echo \Edumall_Helper::get_file_contents( EDUMALL_THEME_DIR . '/assets/svg/empty-cart.svg' ); ?>
				</div>
				<h2 class="empty-cart-heading"><?php esc_html_e( 'Your cart is currently empty.', 'edumall' ); ?></h2>
				<p class="empty-cart-text"><?php esc_html_e( 'You may check out all the available products and buy some in the shop.', 'edumall' ); ?></p>
			</div>
			<?php
		}

		public function woocommerce_clear_cart_url() {
			global $woocommerce;

			if ( isset( $_GET['empty-cart'] ) ) {
				$woocommerce->cart->empty_cart();
			}
		}
	}
}
