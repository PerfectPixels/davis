<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$product_per_row = '';

$product_per_row = 'display-' . get_theme_mod( 'product_per_row', '4' ) . '-per-row';


?>

<ul class="products <?php echo $product_per_row; ?> <?php echo get_theme_mod( 'product_card_style', 'product-style-1' ); ?> <?php if ( get_theme_mod( 'hide_product_details', false ) == false ){ ?>hide-details<?php } ?>">
