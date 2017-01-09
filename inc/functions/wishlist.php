<?php
/**
 * Functions for the wishlist.
 *
 * @package Davis
 */

 /**
  * Get the wishlists submenu
  *
  * @access public
  * @param array
  */
  function get_wishlist_items($type) {
      $lists = '';
      $wishlist_menu = '<ul class="dropdown-menu">';
      $total_items = 0;
      $counter = 0;

      if ( class_exists('WC_Wishlists_wishlist') ) :
          $lists = WC_Wishlists_User::get_wishlists();

          foreach ( $lists as $list ) {
              $items = WC_Wishlists_Wishlist_Item_Collection::get_items( $list->id );
              $wishlist_items = sizeof($items);
              $counter++;

              $wishlist_menu .= '<li class="animation-delay-'.$counter.'"><a href="' .$list->post->guid.$list->post->ID. '">' .$list->post->post_title. '<span class="wishlist-counter">' .$wishlist_items. '</span></a></li>';

              $total_items += $wishlist_items;
          }

      elseif ( class_exists('YITH_WCWL') ) :

          if ( ! class_exists('YITH_WCWL_Premium') && $type !== 'total_items' ) {
              return;
          }

          $lists = YITH_WCWL()->get_wishlists();
          $token = false;

          foreach ( $lists as $list ) {

              if ( is_user_logged_in() ){
                  $token = $list['wishlist_token'];
              }

              $wishlist_items = YITH_WCWL()->count_products( $token );
              $counter++;
              $wl_name = $list['wishlist_name'];
              $wl_url = '';

              if ($wl_name == '' || $wl_name == null){
                  $wl_name = __('Wishlist', 'davis');
              }

              $wishlist_menu .= '<li class="animation-delay-'.$counter.'"><a href="' .$wl_url. '">' .$wl_name. '<span class="wishlist-counter">' .$wishlist_items. '</span></a></li>';

              $total_items += $wishlist_items;
          }
      endif;

      $wishlist_menu .= '</ul>';

      if (empty($lists)){ $wishlist_menu = '' ; }

      if ($type === 'total_items'){
          return $total_items;
      } else {
           return $wishlist_menu;
      }
  }
  add_filter('get_wishlist_items', 'get_wishlist_items' );
