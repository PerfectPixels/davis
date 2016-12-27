<?php

global $post, $woocommerce, $product;

$tn_id = get_post_thumbnail_id( $post->ID );
$use_variation_img = false;

$img = wp_get_attachment_image_src( $tn_id, 'shop_single' );
$width = $img[1];
$height = $img[2];

// Count number of images
$img_nb = sizeof($attachment_ids);
$wrap = 'true';
$nav = 'true';

if ($img_nb < 3) {
    $wrap = 'false';

    if ($img_nb == 0) {
        $nav = 'false';
    }
}

// Get the images position
$images_pos = get_theme_mod('product_images_position', 'right');
$page_images_position = get_field('page_product_images_position');

if ($page_images_position !== 'default'){
    $images_pos = $page_images_position;
}


?>
<?php // TODO: Counting the number of images. If has less than 3, do not wrapAround. If has only 1, do not show next/prev/dots buttons.  ?>

<div id="main-slider" class="images"  data-flickity='{ "accessibility": true, "prevNextButtons": <?php echo $nav; ?>, "pageDots": <?php echo $nav; ?>, "resize": true, "wrapAround": <?php echo $wrap; ?>, "cellAlign": "<?php echo $images_pos; ?>" }'>

	<?php
    // Image size
	$size = 'shop_single';
    // Lightbox enabled?
    if (get_option( 'woocommerce_enable_lightbox' ) == "yes"){ $class = "zoom"; }

    // If product has a featured image
	if ( has_post_thumbnail() ) :

        //Get the Thumbnail URL
        $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );

        $slider_output = '<div class="item"><a href="' . $src[0] . '" class="' . $class . '" >' . get_the_post_thumbnail( $post->ID, 'shop_single' ) . '</a></div>';

    endif;

    if ( $attachment_ids ) {

        foreach ( $attachment_ids as $attachment_id ) {

            $image_link = wp_get_attachment_url( $attachment_id );

            if ( ! $image_link )
                continue;

			$slider_output .= sprintf( '<div class="item"><a href="%s" class="%s">%s</a></div>', wp_get_attachment_url( $attachment_id ), $class, wp_get_attachment_image( $attachment_id, 'shop_single' ) );

        }

	}

	echo $slider_output;

	?>

</div>
