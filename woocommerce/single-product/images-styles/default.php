<?php

global $post, $woocommerce, $product;

$tn_id = get_post_thumbnail_id( $post->ID );
$use_variation_img = false;

$img = wp_get_attachment_image_src( $tn_id, 'shop_single' );
$width = $img[1];
$height = $img[2];

?>

<div class="images gbtr_images">
                   
    <div id="main-slider" class="slider product_images owl-carousel doubleSlider-1">
    
    	<?php
    	
    	$size = 'shop_single';
		$available_variations = array();
								
		// Product variations
		if ( $product->is_type( 'variable' ) ){ $available_variations = $product->get_available_variations(); }
		
		if ( $use_variation_img === true && sizeof($available_variations) > 0 ){
	
			foreach ($available_variations as $variation){	
				// Check if attritube is variations or sizes only
				$data_attr = '';
				$exist = true;
				$first_attr = current(array_keys( $variation['attributes'] ));
				$attachment_id = get_post_thumbnail_id( $variation['variation_id'] );
				$attachment = wp_get_attachment_image_src( $attachment_id, $size );
				$img_src = wp_get_attachment_image_url( $attachment_id, $size );
				$img_srcset = wp_get_attachment_image_srcset( $attachment_id, $size );
				$img_sizes = wp_get_attachment_image_sizes( $attachment_id, $size );		
				
				// Display all attributes to add them in the data-attr in the html
				foreach ($variation['attributes'] as $key => $attribute ){
					$data_attr .= ' data-' . $key . '="' . $attribute . '"';
				}
				
				if (get_option( 'woocommerce_enable_lightbox' ) == "yes") {
					$class = ' zoom';
				}
				
				if ( $variation['variation_is_visible'] == 1 && $variation['is_purchasable'] == 1 ){
					$slider_output .= '<div class="item" data-variation-id="'.$variation['variation_id'].'"' . $data_attr . '><a href="' . wp_get_attachment_url( $attachment_id ) . '" class="fresco' . $class . '" data-fresco-group="product-gallery" data-fresco-options="fit: \'width\'"><span><img src="' .esc_url( $img_src ) . '" class="attachment-'.$size.'" srcset="' . esc_attr( $img_srcset ) . '" sizes="' .$img_sizes .'" title="' .$variation['image_title'] . '"></span></a></div>';
				}
			}
			
		} else {
											
			if ( has_post_thumbnail() ) :
        
                //Get the Thumbnail URL
                $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
                    
                $attachment_count   = count( get_children( array( 'post_parent' => $post->ID, 'post_mime_type' => 'image', 'post_type' => 'attachment' ) ) );
                
                if (get_option( 'woocommerce_enable_lightbox' ) == "yes") :
                    $class = "fresco zoom";
                endif;
                
                $slider_output = '<div class="item"><a href="' . $src[0] . '" class="' . $class . '" data-fresco-group="product-gallery" data-fresco-options="fit: \'width\'"><span itemprop="image">' . get_the_post_thumbnail( $post->ID, 'shop_single' ) . '</span></a></div>';
            
            endif;

            if ( $attachment_ids ) {						
                
                foreach ( $attachment_ids as $attachment_id ) {
                
                    if (get_option( 'woocommerce_enable_lightbox' ) == "yes") :
                        $class = " zoom";
                    endif;
        
                    $image_link = wp_get_attachment_url( $attachment_id );
        
                    if ( ! $image_link )
                        continue;
        
                    $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
                    $image_title = esc_attr( get_the_title( $attachment_id ) );

					$slider_output .= sprintf( '<div class="item"><a href="%s" class="fresco%s" data-fresco-group="product-gallery" data-fresco-options="fit: \'width\'"><span>%s</span><span class="theretailer_zoom"></span></a></div>', wp_get_attachment_url( $attachment_id ), $class, wp_get_attachment_image( $attachment_id, 'shop_single' ) );
					
                }
                
			}
    
		}		
		
		echo $slider_output;
			
		?>
    
    </div>

</div>