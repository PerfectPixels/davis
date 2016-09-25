<?php

namespace PP\Titles;

/**
 * Page titles
 */
function title() {

  if (is_home()) {
  
    if ( get_option( 'page_for_posts', true ) ) {
      return get_the_title( get_option( 'page_for_posts', true ) );
    } else {
      return __('Latest Posts', 'davis' );
    }
    
  } else if ( is_shop() ) {
  
  	return get_theme_mod( 'shop_page_title', __( 'Shop all products', 'davis' ) );
  	
  } else if ( is_product_category() ) {
  
  	return single_cat_title( '', false );
  	
  } else if ( is_archive() ) {
  
    return get_the_archive_title();
    
  } else if ( is_search() ) {
  
    return sprintf( __( 'Search Results for %s', 'davis' ), get_search_query() );
    
  } else if ( is_404() ) {
  
    return __( 'Not Found', 'davis' );
    
  } else {
  
    return get_the_title();
  
  }
  
}
