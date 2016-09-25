<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>

<div class="badges">

	<?php if ( !$product->is_in_stock() && !$product->is_type( 'variable' ) ) : ?>            
		<span class="out-of-stock"><?php _e( 'Out of stock', 'woocommerce' ); ?></span>            
	<?php endif; ?>
	
	<?php if ( $product->is_on_sale() && !$product->is_type( 'variable' ) ) : ?>
		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>	
	<?php endif; ?>

</div>