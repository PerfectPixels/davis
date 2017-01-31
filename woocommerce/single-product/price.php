<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if (!isset($in_form)){
	$in_form = false;
}

// Get the images style
$product_style = get_theme_mod('product_style', 'thumb');
$page_product_style = get_field('page_images_style');

if ($page_product_style !== 'default'){
    $product_style = $page_product_style;
}

$product_arr = array('slideshow','fullwidth');

// Add/Remove the quantity and cart button
if ( in_array($product_style, $product_arr) && !$in_form){
	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
} else {
	add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
}

// Remove the empty single_variation_wrap div
if ( in_array($product_style, $product_arr) && $in_form){
	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
}

?>
<div class="single_variation_wrap <?php if ($in_form){ echo 'in-form'; } ?>">
	<?php
		/**
		 * woocommerce_before_single_variation Hook.
		 */
		do_action( 'woocommerce_before_single_variation' );

	?>

	<?php if (in_array($product_style, $product_arr) && !$in_form || !in_array($product_style, $product_arr) && $in_form) : ?>
		<div class="woocommerce-variation regular_price">
			<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

				<?php

					$the_price = $product->get_price_html();

					if ( strpos($the_price, '<del>') !== false ){
						preg_match('/<del>(.*?)<\/del>/s', $the_price, $del);
						preg_match('/<span class="woocommerce-Price-currencySymbol">(.*?)<\/span>/s', $the_price, $cur);
						$the_price = '<ins><span>From </span>' . $cur[1] . $product->get_price() . '</ins><del>Was ' . $del[1] . '</del>';
					}

				?>

				<p class="price"><?php echo $the_price; ?></p>

				<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
				<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
				<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

			</div>
		</div>
	<?php endif; ?>

	<?php
		/**
		 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
		 * @since 2.4.0
		 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
		 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
		 */
		do_action( 'woocommerce_single_variation' );

		/**
		 * woocommerce_after_single_variation Hook.
		 */
		do_action( 'woocommerce_after_single_variation' );
	?>
</div>
