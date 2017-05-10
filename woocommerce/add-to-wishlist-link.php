<?php 
// Woocommerce Wishlists Plugin -- WC_Wishlists_Plugin

global $woocommerce_wishlist, $add_to_wishlist_args, $product;

$icon_class = pp_get_option( 'wishlist_icon_outline' );
$tooltip = ' data-toggle="tooltip" data-placement="top" title="Add to Favorites"';

if ( ( $key = array_search( 'button' , $add_to_wishlist_args['btn_class'] ))  !== false ) {
    unset( $add_to_wishlist_args['btn_class'][$key] );
}

?>
<input type="hidden" name="wlid" id="wlid" />
<input type="hidden" name="add-to-wishlist-type" value="<?php echo $product->get_type(); ?>" />
<input type="hidden" name="wl_from_single_product" value="<?php echo is_product() ? '1' : '0'; ?>" />

<?php if (woocommerce_wishlists_get_wishlists_for_product($product->get_id())) :
	$count = 0;
	
	foreach (woocommerce_wishlists_get_wishlists_for_product($product->get_id()) as $list_id) {
		if ($count !== 0){
			$lists .= '/';
		}
		$lists .= get_the_title($list_id);
		$count++;
	}

	$icon_class = pp_get_option( 'wishlist_icon' );
	$tooltip = ' data-toggle="tooltip" data-placement="top" title="'. __('Saved in: ', 'wc_wishlist') . $lists .'"';
	
endif; ?>

<a data-productid="<?php echo $product->get_id(); ?>" data-listid="<?php echo $add_to_wishlist_args['single_id']; ?>" class="<?php echo $icon_class . ' ' . implode(' ', $add_to_wishlist_args['btn_class']); ?>" <?php echo $tooltip; ?>></a>

<?php if ($product->get_type() != 'external') : ?>
	<script type="text/javascript">
		window.woocommerce_wishlist_add_to_wishlist_url = "<?php echo esc_url( add_query_arg(array('add-to-wishlist-itemid' => $product->get_id()), $product->add_to_cart_url()) ); ?>";
	</script>
<?php else : ?>
	<script type="text/javascript">
		window.woocommerce_wishlist_add_to_wishlist_url = "<?php echo esc_url( add_query_arg(array('add-to-wishlist-itemid' => $product->get_id()) ) ); ?>";
	</script>
<?php endif; ?>
