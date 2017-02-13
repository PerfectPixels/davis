<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $single_variation;

$quickview_enabled = get_theme_mod( 'quickview_enabled', true );

?>


<nav class="buttons">
	<div>
		<?php if ( class_exists( 'WC_Wishlists_Plugin' ) ){ echo WC_Wishlists_Plugin::add_to_wishlist_button(); } ?>

		<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>

		<?php if ( $quickview_enabled ) { ?>
			<a class="icon-eye-line quickview" data-product-id="<?php echo esc_attr( $product->id ); ?>" data-toggle="tooltip" data-placement="top" title="<?php _e('Quickview', 'davis'); ?>"></a>
		<?php } ?>

		<?php
		if ( $product->is_type( 'variable' ) && ( get_field('variations_slider') === 'no' || get_field('variations_slider') === 'default' && !get_theme_mod('shop_variations_slider', false) ) ){
			echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" data-toggle="tooltip" data-placement="top"  title="%s" class="cart_button go-to-page %s"></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_html( $product->add_to_cart_text() ),
					$product->is_purchasable() && $product->is_in_stock() ? 'icon-select-options' : 'icon-select-options'
				),
			$product );
		} else {
			echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" data-toggle="tooltip" data-placement="top"  title="%s" data-stock-text="%s" data-nostock-text="%s" class="cart_button %s product_type_%s"></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					$product->is_purchasable() && $product->is_in_stock() && !$single_variation || $single_variation['is_in_stock'] ? __('Add to Cart', 'davis' ) : __('Out of stock', 'davis' ),
					__('Add to Cart', 'davis' ),
					__('Out of stock', 'davis' ),
					$product->is_purchasable() && $product->is_in_stock() && !$single_variation || $single_variation['is_in_stock'] ? 'icon-shopping-bag-add add_to_cart_button' : 'icon-shopping-bag add_to_cart_button out-of-stock',
					esc_attr( 'simple' ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
		}

		?>
	</div>
</nav>
