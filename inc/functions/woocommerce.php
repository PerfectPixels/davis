<?php

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