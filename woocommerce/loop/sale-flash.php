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

global $post, $product  ;

$product_new = get_theme_mod( 'product_new_enabled', true );

?>

<div class="badges">
	
	<?php if ( ( ! isset($variation) && $product->is_on_sale() && ! $product->is_type( 'variable' ) ) || ( isset($variation) && $product->is_on_sale() && $variation['display_price'] !== $variation['display_regular_price'] ) ) { ?>
		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . get_theme_mod( 'product_sale_txt', 'Sale!' ) . '</span>', $post, $product ); ?>
	<?php } ?>

	<?php if ( ! isset($full) )  { ?>
        <?php if ( $product->is_featured() )  { ?>
            <span class="featured"><?php echo get_theme_mod( 'product_featured_txt', 'Hot' ); ?></span>
        <?php } ?>

        <?php if ( $product_new && pp_is_product_new( $product ) )  { ?>
            <span class="new"><?php echo get_theme_mod( 'product_new_txt', 'New' ); ?></span>
        <?php } ?>
    <?php } ?>

</div>

<?php if ( ( ! isset($variation) && ! $product->is_in_stock() && ! $product->is_type( 'variable' ) ) || ( isset($variation) && ! $variation['is_in_stock'] ) ) { ?>
    <span class="out-of-stock"><?php _e( 'Out of stock', 'woocommerce' ); ?></span>
<?php } ?>