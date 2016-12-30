<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

// Get the images style
$product_style = get_theme_mod('product_style', 'thumb');
$page_product_style = get_field('page_images_style');

if ($page_product_style !== 'default'){
    $product_style = $page_product_style;
}

$tn_id = get_post_thumbnail_id( $post->ID );
$use_variation_img = false;

$img = wp_get_attachment_image_src( $tn_id, 'shop_single' );
$width = $img[1];
$height = $img[2];

// Count number of images
$img_nb = sizeof($attachment_ids);
$wrap = 'true';
$nav = 'true';

if ( has_post_thumbnail() ){ $img_nb += 1; }

if ($img_nb < 3) {
    $wrap = 'false';

    if ($img_nb == 0) {
        $nav = 'false';
    }
}

switch ($product_style) {
    case 'thumb':
        $data_slick = '{ "accessibility": true, "fade": true, "asNavFor": "#thumb-slider"  }';
        break;
    case 'carousel':
        $data_slick = '{ "accessibility": true, "centerMode": true, "centerPadding": "5%", "arrows": '.$nav.', "dots": '.$nav.', "infinite": '.$wrap.' }';
        break;
    case 'slideshow':
        $data_slick = '{ "accessibility": true, "fade": true, , "asNavFor": "#thumb-slider" }';
        break;
}
?>

<div id="main-slider" data-slick='<?php echo $data_slick; ?>'>

	<?php
    // Image size
	$size = 'shop_single';
    $slider_output = '';

    // Lightbox enabled?
    if (get_option( 'woocommerce_enable_lightbox' ) == "yes"){ $class = "zoom"; }

    // If product has a featured image
	if ( has_post_thumbnail() ) :

        //Get the Thumbnail URL
        $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
		$image_title = wp_prepare_attachment_for_js(get_post_thumbnail_id($post->ID))['title'];

        $slider_output .= '<div class="item"><a href="' . $src[0] . '" class="' . $class . '" >' . get_the_post_thumbnail( $post->ID, 'shop_single', array('data-image-title'=>$image_title) ) . '</a></div>';

    endif;

    if ( $attachment_ids ) {

        foreach ( $attachment_ids as $attachment_id ) {

            $image_link = wp_get_attachment_url( $attachment_id );
			$image_title = wp_prepare_attachment_for_js($attachment_id)['title'];

            if ( ! $image_link )
                continue;

			$slider_output .= sprintf( '<div class="item"><a href="%s" class="%s">%s</a></div>', wp_get_attachment_url( $attachment_id ), $class, wp_get_attachment_image( $attachment_id, 'shop_single', false, array('data-image-title'=>$image_title) ) );

        }

	}

	echo $slider_output;

	?>

</div>
