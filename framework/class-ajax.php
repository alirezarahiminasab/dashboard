<?php
/**
 * AJAX Event Handlers for frontend
 * Using instead of wp_ajax to avoid some wrong conditions like is_admin()
 *
 * @see \WC_AJAX
 */

defined( 'ABSPATH' ) || exit;

class Edumall_AJAX {
	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
		add_action( 'template_redirect', array( __CLASS__, 'do_ajax' ), 0 );
	}

	/**
	 * Get Ajax Endpoint.
	 *
	 * @param string $request Optional.
	 *
	 * @return string
	 */
	public static function get_endpoint( $request = '' ) {
		return esc_url_raw( apply_filters( 'edumall/ajax/get_endpoint', add_query_arg( 'edumall-ajax', $request, remove_query_arg( array(
			'remove_item',
			'add-to-cart',
			'added-to-cart',
			'order_again',
			'_wpnonce',
		), home_url( '/', 'relative' ) ) ), $request ) );
	}

	/**
	 * Set WC AJAX constant and headers.
	 */
	public static function define_ajax() {
		// phpcs:disable
		if ( ! empty( $_GET['edumall-ajax'] ) ) {
			edumall_maybe_define_constant( 'DOING_AJAX', true );
			edumall_maybe_define_constant( 'WC_DOING_AJAX', true );
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON.
			}
			$GLOBALS['wpdb']->hide_errors();
		}
		// phpcs:enable
	}

	/**
	 * Send headers for Ajax Requests.
	 */
	private static function send_ajax_headers() {
		if ( ! headers_sent() ) {
			send_origin_headers();
			send_nosniff_header();
			wc_nocache_headers();
			header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
			header( 'X-Robots-Tag: noindex' );
			status_header( 200 );
		} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			headers_sent( $file, $line );
			trigger_error( "send_ajax_headers cannot set headers - headers already sent by {$file} on line {$line}", E_USER_NOTICE ); // @codingStandardsIgnoreLine
		}
	}

	/**
	 * Check for Ajax request and fire action.
	 */
	public static function do_ajax() {
		global $wp_query;

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! empty( $_GET['edumall-ajax'] ) ) {
			$wp_query->set( 'edumall-ajax', sanitize_text_field( wp_unslash( $_GET['edumall-ajax'] ) ) );
		}

		$action = $wp_query->get( 'edumall-ajax' );

		if ( $action ) {
			self::send_ajax_headers();
			$action = sanitize_text_field( $action );
			do_action( 'edumall_ajax_' . $action );
			wp_die();
		}
		// phpcs:enable
	}
}

Edumall_AJAX::init();
