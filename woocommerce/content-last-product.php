<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use PP\Extras;

global $product, $single_variation;

// Check if it has children
$term = get_queried_object();
$children = get_term_children( $term->term_id, 'product_cat' );

// Extra post classes
$classes = array();

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Product variations
$available_variations = 0;
if ($product->is_type( 'variable' )){
	$available_variations = $product->get_available_variations();
}

// Get the permalink
$url = get_permalink();

// Thumbnail size
$size = 'shop_catalog';

// Get the product colors
$product_colors = get_field( 'product_colors', get_the_ID() );

// If it is a single variation product
if ( $product->variation_id ){
	$variation_id = $product->variation_id;
	$product_colors = get_post_meta($product->variation_id, '_jck_product_colors', true);
    $product = wc_get_product($product->parent->id);
    $available_variations = $product->get_available_variations();
    $single_variation_product = true;
    
    foreach ($available_variations as $variation){
		if ( $variation['variation_id'] === $variation_id ){
			$variation = $variation;
			$single_variation = $variation;
			
			break;
		}
	}
} else {
	$single_variation_product = false;
}

?>

<?php if ( $single_variation_product ) {

	// Check if attritube is variations or sizes only
	$data_counter = 0;
	$attributes = '?';
	$data_attr = '';
	$thumb_attr ='';
	
	if ($variation['image_link']){
		$thumb_attr = array(
			'src'	=> $variation['image_link'],
			'class'	=> "attachment-$size",
			'alt'	=> $variation['image_alt'],
		);
	}
	
	// Display all attributes to add them in the data-attr in the html
	foreach ($variation['attributes'] as $key => $attribute ){
		$data_counter++;
		$data_attr .= ' data-attr-name-' . $data_counter . '="' . $key.'" data-attr-value-' . $data_counter . '="' . $attribute . '"';
	} ?>
	
	
	<li <?php post_class( $classes ); ?>>
	
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<?php 
			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );		

		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		
		?>
		
		<div class="badges">
		
			<?php if ( ! $variation['is_in_stock'] ) { ?>            
				<span class="out-of-stock"><?php _e( 'Out of stock', 'woocommerce' ); ?></span>            
			<?php } ?>
			<?php if ( $product->is_on_sale() && $variation['display_price'] !== $variation['display_regular_price'] ) { 
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
			} ?>
		
		</div>
	
		<a href="<?php echo $url; ?>" class="img" data-colors="<?php echo $product_colors; ?>" data-variation-id="<?php echo $variation['variation_id']; ?>" data-product-id="<?php echo $post->ID; ?>" <?php echo $data_attr; ?> data-attr-counter="<?php echo $data_counter; ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $product->get_available_variations() ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, $size, $thumb_attr ); ?></a>
		
		<div class="product-meta">
			<?php
			
				// Price
				if ( $variation['price_html'] !== '' ){
					echo $variation['price_html'];
				} else {
					if ( $price_html = $product->get_price_html() ) { ?>
						<span class="price"><?php echo $price_html; ?></span>
					<?php } 	
				}
	
				/**
				 * woocommerce_after_shop_loop_item hook
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item' );
				
				if ( $product->is_type( 'variable' ) ){
					Extras\tomo_variable_add_to_cart( true );
				}
				
			?>
		</div>
		
	</li>
	
<?php }  else { ?>
	
	<li <?php post_class( $classes ); ?>>

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
		<?php
		
			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
			
			
			/* @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		
		<div class="product-meta">	
			<?php	
		
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
				
		
				/**
				 * woocommerce_after_shop_loop_item hook
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item' );
				
				if ($product->variation_id){
					Extras\tomo_variable_add_to_cart();
				}
		
			?>
		</div>
	
	</li>
	
<?php } ?>
