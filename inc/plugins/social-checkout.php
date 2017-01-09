<?php

if ( class_exists( 'WC_Social_Checkout' ) ) {

	require_once ABSPATH . 'wp-content/plugins/woocommerce-social-checkout/woocommerce-sc-frontend.php';

	class PP_Social_Checkout_Frontend extends WC_Social_Checkout_Frontend {

		public function __construct() {

			add_action( 'init', array( $this, 'initiate_hooks' ), 10 );

		}

		public function initiate_hooks() {
			global $WC_Social_Checkout_Frontend;

			remove_action( 'woocommerce_thankyou', array( $WC_Social_Checkout_Frontend, 'social_checkout' ), 0 );
			add_action( 'woocommerce_share_purchase', array( $this, 'pp_social_checkout' ), 0 );
		}


		/**
		 * Actually do the business on the checkout thank you page
		 * Invokes hooks to allow each service to do its thing.
		 * @param  int $order_id WooCommerce order ID
		 */
		public function pp_social_checkout( $order_id ) {

			$order      = new WC_Order( $order_id );
			$settings   = WC_Social_Checkout::get_settings();
			$services   = WC_Social_Checkout::get_enabled_services();

			// Do we have an order?
			if ( ! $order ) {
				return;
			}

			// Check whether there's anything for us to do.
			if ( empty ( $services ) ) {
				return;
			}

			$items = apply_filters(
				'woo_sc_order_line_items',
				$order->get_items(),
				$order
			);

			if ( empty( $items ) ) {
				return;
			}

			wc_get_template(
				'sc-share.php', array(
					'settings'  => $settings,
					'services'  => $services,
					'order'     => $order,
					'items'     => $items,
				), ABSPATH . 'wp-content/plugins/woocommerce-social-checkout/templates/', get_template_directory() . '/woocommerce/social-checkout/'
			);
		}

	}

	$pp_social_checkout_frontend = new PP_Social_Checkout_Frontend();

} ?>
