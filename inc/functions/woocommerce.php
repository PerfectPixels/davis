<?php

if ( ! function_exists( 'wc_version_check' ) ) {

  /**
    * Check minimum version
    *
    * @access public
    * @param string $version
    * @return boolean
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
      'selected_attributes'  => $product->get_default_attributes(),
      'quickview'            => true
    ) );
  }

}


if ( ! function_exists( 'pp_return_template_part' ) ) {

	/**
	 * Return the template part rather than print it
	 *
	 * @param string $template_name
	 * @param array $args
	 * @return object $var
	 */
	function pp_return_template_part( $template_name, $args = null ) {
		ob_start();
		wc_get_template( $template_name, $args );
		$var = ob_get_contents();
		ob_end_clean();

		return $var;
	}

}


if ( ! function_exists( 'pp_is_product_new' ) ) {

	/**
	 * Return true if product meets the required
	 *
	 * @param object $product
	 * @return boolean
	 */
	function pp_is_product_new( $product ) {
		$product_date = get_the_time ( 'Y-m-d' );
		$product_date_stamp = strtotime ( $product_date );
		$duration = get_theme_mod( 'product_new_duration', 7 );

		if ((time () - (60 * 60 * 24 * $duration)) < $product_date_stamp) {
			return true;
		} else {
			return false;
		}
	}

}