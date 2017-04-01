<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

global $product;

?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) ); ?>" rel="nofollow" data-product-id="<?php echo $product_id; ?>" data-product-type="<?php echo $product_type; ?>" class="<?php echo pp_get_option( 'wishlist_icon_outline' ) . ' ' . $link_classes; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $label; ?>"></a>