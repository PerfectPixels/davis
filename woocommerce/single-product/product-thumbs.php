<?php

global $post, $woocommerce, $product;

$thumb_to_show = 5;
$size = 'shop_catalog';
$thumb_output = '';

// Count number of images
$img_nb = sizeof($attachment_ids);
$longer = '';
$attr = '';

if ( has_post_thumbnail() ){ $img_nb += 1; }

if ($img_nb > $thumb_to_show - 1) {
    $longer = 'scrollable';
}

switch ($product_style) {
    case 'vertical-thumb':
        $attr = '"vertical": true, "verticalSwiping": true,';
        break;
    case 'slideshow':
        $attr = '"variableWidth": true,';
        $thumb_to_show = 8;
        $size = array(120, 120);
        break;
}

if ( $attachment_ids ) { ?>
	<div id="thumb-slider" class="<?php echo $longer; ?>"  data-slick='{ "accessibility": true, "arrows": false, "dots": true, "focusOnSelect": true, <?php echo $attr; ?> "slidesToShow": <?php echo $thumb_to_show; ?>, "slidesToScroll": 1, "asNavFor": "#main-slider" }'>

		<?php

		if ( has_post_thumbnail() ) :
			$thumb_output .= '<div class="thumb">' . get_the_post_thumbnail( $post->ID, $size ) . '</div>';
		endif;


		foreach ( $attachment_ids as $attachment_id ) {
            // Get image meta
			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$thumb_output .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="thumb">%s</div>', wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', $size ) ) ), $attachment_id, $post->ID );
		}

		echo $thumb_output;

		?>

	</div>

<?php } ?>
