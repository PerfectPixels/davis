<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account-dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<h2><?php _e('Recent Orders', 'davis'); ?></h2>

<?php

	$current_page    = empty( $current_page ) ? 1 : absint( $current_page );
	$customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array( 
		'numberposts' 	=> 5, 
		'customer' 		=> get_current_user_id(), 
		'page' 			=> $current_page, 
		'paginate' 		=> true 
	) ) );
	
	wc_get_template( 'myaccount/orders.php', array( 
		'current_page' 		=> absint( $current_page ), 
		'customer_orders' 	=> $customer_orders, 
		'has_orders' 		=> 0 < $customer_orders->total,
		'dashboard'			=> 'true'
		
	));
	
?>

<a class="button black view-all-orders" href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>"><?php _e('View all', 'davis'); ?></a>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
?>
