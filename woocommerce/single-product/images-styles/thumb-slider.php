<?php

global $post, $woocommerce, $product;

$use_variation_img = false; 

if ( $attachment_ids ) { ?>
                
    <div class="product_thumbs">
		<div class="product_thumbs_inner"> 
			<div id="thumb-slider" class="slider doubleSlider-2 owl-carousel">
				
				<?php
				
				$size = 'shop_catalog';
				$available_variations = array();
				$thumb_output = '';
				
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
						
						if ( $variation['variation_is_visible'] == 1 && $variation['is_purchasable'] == 1 ){
							$thumb_output .= '<div class="thumb" data-variation-id="'.$variation['variation_id'].'"' . $data_attr . '><img src="' .esc_url( $img_src ) . '" class="attachment-'.$size.'" srcset="' . esc_attr( $img_srcset ) . '" sizes="' .$img_sizes .'" title="' .$variation['image_title'] . '"></div>';
						}
					}
					
				} else {
													
					if ( has_post_thumbnail() ) :
						$thumb_output .= '<div class="thumb"><div itemprop="image">' . get_the_post_thumbnail( $post->ID, 'shop_catalog' ) . '</div></div>';
					endif;
													
					foreach ( $attachment_ids as $attachment_id ) {
					
						$classes = array( 'zoom' );
			
						$image_link = wp_get_attachment_url( $attachment_id );
			
						if ( ! $image_link )
							continue;
			
						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );
						
						$thumb_output .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="thumb">%s</div>', $image ), $attachment_id, $post->ID, $image_class );
						
					}
				}		
				
				echo $thumb_output;					
				
				?>
			
			</div>
		</div><!--.product_thumbs-inner-->
	</div><!--.product_thumbs-->

<?php } ?>