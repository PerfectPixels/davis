<?php

if ( ! function_exists( 'wc_version_check' ) ) {

  /**
    * Check minimum version
    *
    * @access public
    * @param string $version
    */
  function wc_version_check( $version = '2.7' ) {
    if ( function_exists( 'is_woocommerce_active' ) && is_woocommerce_active() ) {
      global $woocommerce;
      
      if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
        return true;
      }

    }
    return false;
  }

}

if ( ! function_exists( 'pp_variable_add_to_cart_quickview' ) ) {

  /**
   * Output the variable product add to cart area.
   *
   * @subpackage  Product
   */
  function pp_variable_add_to_cart_quickview() {
    global $product;

    // Enqueue variation scripts
    wp_enqueue_script( 'wc-add-to-cart-variation' );

    // Get Available variations?
    $get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

    // Load the template
    wc_get_template( 'single-product/add-to-cart/variable.php', array(
      'available_variations' => $get_variations ? $product->get_available_variations() : false,
      'attributes'           => $product->get_variation_attributes(),
      'selected_attributes'  => $product->get_variation_default_attributes(),
      'quickview'            => true
    ) );
  }

}
