<?php
/**
 * Functions for the cart.
 *
 * @package Davis
 */

 /**
  * Get a coupon value.
  *
  * @access public
  * @param string $coupon
  */
 function pp_cart_totals_coupon_html( $coupon ) {
     if ( is_string( $coupon ) ) {
         $coupon = new WC_Coupon( $coupon );
     }

     $value  = array();

     if ( $amount = WC()->cart->get_coupon_discount_amount( $coupon->code, WC()->cart->display_cart_ex_tax ) ) {
         $discount_html = wc_price( $amount );
     } else {
         $discount_html = '';
     }

     $value[] = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_html, $coupon );

     if ( $coupon->enable_free_shipping() ) {
         $value[] = __( 'Free shipping', 'woocommerce' );
     }

     // get rid of empty array elements
     $value = array_filter( $value );
     $value = implode( ', ', $value ) . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', urlencode( $coupon->code ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="pp-remove-coupon" data-coupon="' . esc_attr( $coupon->code ) . '"></a>';

     echo apply_filters( 'woocommerce_cart_totals_coupon_html', $value, $coupon );
 }

 /**
  * Check if is quick checkout is enable on the checkout page
  *
  * @access public
  * @param boolean
  */
function is_quick_checkout(){
    global $woocommerce;

    $quick_checkout = get_theme_mod('quick_checkout', true);

    if ( is_checkout() && $quick_checkout == true ){
        return true;
    } else {
        return false;
    }

}

 /**
  * Check if should redirect the checkout page
  *
  * @access public
  * @param boolean
  */
function is_checkout_redirect(){
    if ( is_quick_checkout() && empty( $_GET['ajax_request'] ) && ! is_wc_endpoint_url() ){
        return true;
    } else {
        return false;
    }

}
