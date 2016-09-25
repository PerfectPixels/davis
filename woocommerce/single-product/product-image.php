<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */
        
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$attachment_ids = $product->get_gallery_attachment_ids();
$img_template = 'default';

?>

<?php
				
	wc_get_template( 'single-product/images-styles/' . $img_template . '.php', array(
        'attachment_ids' => $attachment_ids,
    ) );

?>
