<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$attachment_ids = $product->get_gallery_attachment_ids();

// Get the images style
$product_style = get_theme_mod('product_style', 'thumb');
$page_product_style = get_field('page_images_style');

if ($page_product_style !== 'default'){
    $product_style = $page_product_style;
}

?>

<?php

	wc_get_template( 'single-product/images-styles/' . $product_style . '.php', array(
        'attachment_ids' => $attachment_ids,
    ) );

?>
