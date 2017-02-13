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

$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$thumbnail_post    = get_post( $post_thumbnail_id );    
$image_title       = $thumbnail_post->post_content;
$quickview         = ( isset($quickview) ? $quickview : false );

$use_variation_img = false;
$size = 'shop_single';
$slider_output = '';
$no_thumb = array('thumb', 'no-thumb', 'carousel');

// Count number of images
$img_nb = sizeof($attachment_ids);
$wrap = 'true';
$nav = 'true';

$class = '';

if ( $quickview ){ $product_style = "quickview"; }

if ( get_option( 'woocommerce_enable_lightbox' ) == "yes"){ $class = "product-zoom"; }

if ( has_post_thumbnail() ){ $img_nb += 1; }

if ($img_nb < 3) {
    $wrap = 'false';

    if ($img_nb < 2) {
        $nav = 'false';
    }
}

switch ($product_style) {
    case 'no-thumb':
        $data_slick = '{ "accessibility": true, "fade": true }';
        break;
    case 'carousel':
        $data_slick = '{ "accessibility": true, "centerMode": true, "centerPadding": "5%", "arrows": '.$nav.', "dots": '.$nav.', "infinite": '.$wrap.' }';
        break;
    case 'slideshow':
        $data_slick = '{ "accessibility": true, "asNavFor": "#thumb-slider" }';
        $size = array(1270, 635);
        break;
    case 'fullwidth':
        $data_slick = '{ "accessibility": true, "centerMode": true, "centerPadding": "0%", "asNavFor": "#thumb-slider", "arrows": false }';
        break;
    case 'quickview':
        $data_slick = '{ "accessibility": true, "arrows": '.$nav.', "dots": '.$nav.' }';
        break;
    default:
        $data_slick = '{ "accessibility": true, "fade": true, "asNavFor": "#thumb-slider"  }';
        break;
}

?>

<?php // Add a container when product image has thumbnails
if ( ! in_array($product_style, $no_thumb) && ! $quickview ) : ?>
    <div class="thumb-image-container">
<?php endif; ?>

<div id="main-slider" class="<?php echo $class; ?>" data-slick='<?php echo $data_slick; ?>' itemscope itemtype="http://schema.org/ImageGallery">

	<?php

    // If product has a featured image
	if ( has_post_thumbnail() ) :
        $slider_output .= '<figure class="item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject"><a href="' . $full_size_image[0] . '" itemprop="contentUrl" data-size="'.$full_size_image[1].'x'.$full_size_image[2].'">' . get_the_post_thumbnail( $post->ID, $size, array( 'data-image-title' => $image_title ) ) . '</a></figure>';
    endif;

    if ( $attachment_ids ) :
        foreach ( $attachment_ids as $attachment_id ) {
            $image_link = wp_get_attachment_url( $attachment_id );
			$image_attr = wp_prepare_attachment_for_js($attachment_id);

            if ( ! $image_link )
                continue;

			$slider_output .= '<figure class="item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject"><a href="' . $image_link . '" itemprop="contentUrl" data-size="'.$image_attr['width'].'x'.$image_attr['height'].'">' . wp_get_attachment_image( $attachment_id, $size, false, array( 'data-image-title' => $image_attr['title'] ) ) . '</a></figure>';
        }
	endif;

	echo $slider_output;

	?>

</div>

<?php // Add thumbnails slider and closing div.thumb-image-container when product image has thumbnails
if ( ! in_array($product_style, $no_thumb) && ! $quickview ) :

    wc_get_template( 'single-product/product-thumbs.php', array(
        'attachment_ids' => $attachment_ids,
        'product_style' => $product_style
    ) ); ?>

    </div>
<?php endif; ?>
