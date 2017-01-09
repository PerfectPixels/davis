<?php
/**
* Class for all cart/checkout modification
*
* @version 1.0
*/
class PP_Woocommerce {

    /**
	 * Construction function
	 *
	 * @since  1.0
	 * @return PP_Woocommerce
	 */
	function __construct() {

        global $woocommerce_active;

		// Check if Woocomerce plugin is actived
		if ( ! $woocommerce_active ) {
			return false;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'initiate_hooks' ) );

        // Get retina images
        add_action( 'wp_ajax_get_srcset', array( $this, 'pffwc_get_srcset_callback' ) );
        add_action( 'wp_ajax_nopriv_get_srcset', array( $this, 'pffwc_get_srcset_callback' ) );

        // Position the star rating after the price
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );

        // Remove Result count to the archive page - Add new action to use in base.php
        remove_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20 );
        add_filter( 'main_result_count', 'woocommerce_result_count', 20 );

        // Split the loop before shop template
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        add_filter( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20);

        // Remove the a tag around the product
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

        // Change the position of the YITH wishlist button
        add_action( 'woocommerce_after_add_to_cart_button', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 10 );

        // Change the tax_query for last cat pages to only display single variation products

        if ( class_exists( 'JCK_WSSV' ) ) {
        	add_filter( 'pre_get_posts', array( 'pp_Exclude_Variable', 'apply_user_filters' ), 900000 );
        	remove_filter( 'pre_get_posts', array( 'BeRocket_AAPF', 'apply_user_filters' ), 900000 );
        }

	}

    /**
	 * Hooks to all cart actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function initiate_hooks() {

        // Breadcrumbs
        add_action( 'woo_custom_breadcrumb', array( $this, 'pp_woocommerce_breadcrumb' ) );

        // Thumbnail for product archive
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
        add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'pp_template_loop_product_thumbnail' ), 10);

        // Single variation product
        add_action( 'init', array( $this, 'remove_action_single_var' ), 11 );

        // Product title
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        add_action( 'woocommerce_shop_loop_item_title', array( $this, 'custom_woocommerce_template_loop_product_title' ), 10 );

        // Number of columns in product archive
        add_filter('loop_shop_columns', array( $this, 'loop_columns' ));
    }

    /**
    * Function to call the woocommerce breadcrumbs
    */
    function pp_woocommerce_breadcrumb(){
        woocommerce_breadcrumb();
    }

    /**
    * Change the default Woocommerce thumbnail for products archive
    */
    /**
     * WooCommerce Loop Product Thumbs
     **/
    function pp_template_loop_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
    	global $post, $product, $woocommerce;

    	$size = 'shop_catalog';
    	$image_size = wc_get_image_size( 'shop_catalog' );
    	$available_variations = array();
    	$created_variations = array();
    	$terms = get_the_terms($post->ID, 'pa_colors');
    	$product_colors = null;
    	$output = null;
    	$variations_slider = false;

    	if ( is_array( $terms ) ) {
    		foreach ( $terms as $term ) {
    			$product_colors .= $term->slug . ',';
    		}

    		$product_colors = trim( $product_colors, ',' );
    	}

    	// Product variations
    	if ( $product->is_type( 'variable' ) ){ $available_variations = $product->get_available_variations(); }

    	// Image size
    	if ( ! $placeholder_width ){ $placeholder_width = $image_size['width']; }
    	if ( ! $placeholder_height ){ $placeholder_height = $image_size['height']; }

    	// Check if the variations product slider is enabled
    	if ( get_field('variations_slider') === 'yes' || get_field('variations_slider') === 'default' && get_theme_mod('shop_variations_slider', false) ){
    		$variations_slider = true;
    	}

    	if ( sizeof( $available_variations ) > 0 ){

    		if ( $variations_slider ){
    			$output = '<div class="product-slider" data-product_variations="' . htmlspecialchars( json_encode( $available_variations ) ) . '">';
    		}

    		foreach ($available_variations as $variation){
    			// Check if attritube is variations or sizes only
    			$data_counter = 0;
    			$attributes = '?';
    			$data_attr = '';
    			$sales = '';
    			$stock_class = '';
    			$exist = true;
    			$first_attr = current(array_keys( $variation['attributes'] ));
    			$image_ids = get_post_meta( $variation['variation_id'], '_wc_additional_variation_images', true );
    			$image_ids = explode( ',', $image_ids );
    			$product_colors = get_post_meta($variation['variation_id'], '_jck_product_colors', true);
    			$attachment_id = get_post_thumbnail_id( $variation['variation_id'] );
    			$attachment = wp_get_attachment_image_src( $attachment_id, $size );
    			$img_src = wp_get_attachment_image_url( $attachment_id, $size );
    			$img_srcset = wp_get_attachment_image_srcset( $attachment_id, $size );
    			$img_sizes = wp_get_attachment_image_sizes( $attachment_id, $size );

    			// Register the attributes to check against if it already exist
    			if ( array_key_exists( $first_attr, $variation['attributes'] ) ) {
    				$attr = $variation['attributes'][$first_attr];

    				if ( ! in_array($attr, $created_variations, true) && $img_src ) {
    					$exist = false;
    					array_push( $created_variations, $attr );
    				}
    			}

    			// Create all attributes variation for the URL
    			foreach ($variation['attributes'] as $key => $attribute ){
    				$attributes .= $key.'='.$attribute.'&';
    			}

    			// Display all attributes to add them in the data-attr in the html
    			foreach ($variation['attributes'] as $key => $attribute ){
    				$data_counter++;
    				if ( !$variations_slider ){ $attribute = ''; }
    				$data_attr .= ' data-attr-name-' . $data_counter . '="' . $key.'" data-attr-value-' . $data_counter . '="' . $attribute . '"';
    			}

    			$variation_url = get_permalink() . trim($attributes, '&');

    			// Product on sale/out of stock
    			$sales = '<div class="badges">';

    				if ( !$variation['is_in_stock'] == 1 ) {
    					$sales .= '<span class="out-of-stock">' . __( 'Out of stock', 'woocommerce' ) . '</span>';
    					$stock_class = 'data-stock-class="false"';
    				}
    				if ( $product->is_on_sale() && $variation['display_price'] !== $variation['display_regular_price'] ) {
    					$sales .= '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>';
    				}

    			$sales .= '</div>';

    			if ( !$exist && $variation['variation_is_visible'] == 1 && $variation['is_purchasable'] == 1 && $variations_slider ){
    				$output .= '<div>' . $sales . $variation['price_html'];

    				$output .= '<a href="' . $variation_url . '" class="img"' .$stock_class . ' data-colors="'. $product_colors .'" data-variation-id="'.$variation['variation_id'].'" data-product-id="' . $post->ID .'"' . $data_attr . ' data-attr-counter="' . $data_counter . '">' . /* wp_get_attachment_image( $post->ID, $size, $thumb_attr ); */ '<img src="' .esc_url( $img_src ) . '" class="attachment-'.$size.'" srcset="' . esc_attr( $img_srcset ) . '" sizes="' .$img_sizes .'" title="' .$variation['image_title'] . '">';

    				// If it has another variation image
    				if ( count( $image_ids > 0 ) ) {
    					foreach( $image_ids as $id ) {
    						$thumb_attr = array(
    							'class'	=> "additional-img",
    							'alt'	=> get_post_meta( get_post_thumbnail_id( $id ) , '_wp_attachment_image_alt', true),
    							'title'	=> $variation['image_title'],
    						);

    						$output .= wp_get_attachment_image( $id, $size, false, $thumb_attr );
    						continue;
    					}
    				}

    				$output .= '</a></div>';
    			}
    		}

    		if ( $variations_slider ){
    			$output .= '</div>'; // Closing of product-slider
    		}

    		if ( !$variations_slider ){
    			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'" data-variation-id="'.$variation['variation_id'].'" data-product-id="' . $post->ID .'"' . $data_attr . ' data-attr-counter="' . $data_counter . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';
    		}

    	} else {
    		if ( has_post_thumbnail() ) {

    			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';

    		} else {

    			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'"><img class="" src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" /></a>	';

    		}
    	}

    	echo $output;
    }


    /**
     * Remove some action from the Single Variation Product plugin
     *
     */
    function remove_action_single_var(){
    	global $jck_wssv;

    	if( is_admin() ) {

    	    remove_action( 'woocommerce_product_after_variable_attributes',  array( $jck_wssv, 'add_variation_additional_fields' ), 10 );
    	    remove_action( 'woocommerce_save_product_variation', array( $jck_wssv, 'save_product_variation' ), 10 );
    	    remove_action( 'woocommerce_save_product_variation', array( $jck_wssv, 'add_taxonomies_to_variation' ), 10 );

    	} else {

    		remove_action( 'wp_enqueue_scripts', array( $jck_wssv, 'frontend_scripts' ) );
    	    remove_action( 'wp_enqueue_scripts', array( $jck_wssv, 'frontend_styles' ) );
    		remove_action( 'woocommerce_product_query', array( $jck_wssv, 'add_variations_to_product_query' ), 50 );

    	}
    }

    /**
     * Change the loop title
     */

    function custom_woocommerce_template_loop_product_title( $variationTmpl ) {
    	global $product;

    	$attributes = $product->get_attributes();
    	$attr 		= sanitize_title( get_field( 'product_subtitle_by' ) );
    	$attribute	= isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : '';
    	$attribute	= isset( $attributes[ 'pa_' . $attr ] ) ? $attributes[ 'pa_' . $attr ] : '';
    	$by_brand	= '<div class="product-subtitle">';

    	if ( $attribute ){
    		$attribute_name = $attribute['name'];
    		$taxonomy = get_taxonomy( $attribute_name );
    		$archive_link = '';

    		if ( $taxonomy && ! is_wp_error( $taxonomy ) ) {
    			$terms = wp_get_post_terms( $product->id, $attribute_name );

    	        if ( ! empty( $terms ) ) {
    		        foreach ( $terms as $term ) {
    		        	$archive_link .= '<a href="' . get_term_link( $term->slug, $attribute_name ) . '">' . $term->name . '</a>';
    		        }
    	        }

    	    }

    		$by_brand .= '<span class="subtitle-by"><i>' . __('by', 'davis' ) . '</i> ' . $archive_link . '</span>';
    	}

    	// Show number of variations if product has children
    	if ( $variationTmpl !== null ){
    		$by_brand .= $variationTmpl;
    	}

    	$by_brand .= '</div>';

    	echo '<h3><a href="' . get_permalink($product->id) . '">' . get_the_title() . '</a>' . $by_brand . '</h3>';

    }

    /**
     * Change number of products per row
     */
     function loop_columns() {
         $product_per_row = get_theme_mod( 'product_per_row', '4' );

         return $product_per_row;
     }

    /**
    * Retina Ajax call
     */
    function pffwc_get_srcset_callback() {
    	if ( ! wp_verify_nonce( $_POST['nonce'], 'pffwc-nonce') ) {
    		wp_die();
    	}
    	$method = wr2x_getoption( 'method', 'wr2x_advanced', 'Picturefill' );
    	if ( $method == 'Picturefill' ) {
    		$retina_url = wr2x_get_retina_from_url( $_POST['src'] );
    		$retina_url = apply_filters( 'wr2x_img_retina_url', $retina_url );
    		if ( $retina_url != null ) {
    			$retina_url = wr2x_cdn_this( $retina_url );
    			$img_url = wr2x_cdn_this( $_POST['src'] );
    			$img_url  = apply_filters( 'wr2x_img_url', $img_url );
    			echo  "$img_url, $retina_url 2x";
    		} else {
    			echo $_POST['src'];
    		}
    	}
    	wp_die();
    }

}
