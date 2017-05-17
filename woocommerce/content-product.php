<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $single_variation;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Get the permalink
$url = get_permalink();

// Thumbnail size
$size = 'shop_catalog';

// Get the product style
$product_style = get_theme_mod( 'product_card_style', 'product-style-1' );

// Get the product colors
$product_colors = get_field( 'product_colors', get_the_ID() );

// Product variations
$available_variations = 0;
$variationTmpl 		  = null;

// Check if the variations product slider is enabled
$variations_slider = false;

if ( get_field('variations_slider') === 'yes' || get_field('variations_slider') === 'default' && get_theme_mod('shop_variations_slider', false) ){
	$variations_slider = true;
}

if ( $product->is_type( 'variable' ) ){
	$available_variations = $product->get_available_variations();
	$first_attr = current(array_keys( $available_variations[0]['attributes'] ));
	$variationCount = 0;
	$created_variations = array();

	// Get the variation name
	$variations = str_replace('attribute_', '', $first_attr);
	$variations = str_replace('pa_', '', $variations);

	// Get variation number
	foreach ($available_variations as $variation){
		// Check if attritube is variations or sizes only
		if ( $variations_slider ){
			$exist = true;

			// Register the attributes to check against if it already exist
			if ( array_key_exists( $first_attr, $variation['attributes'] ) ) {
				$attr = $variation['attributes'][$first_attr];

				if ( !in_array($attr, $created_variations, true) ) {
					$variationCount++;
					array_push( $created_variations, $attr );
				}
			}
		} else {
			$attributes = $product->get_attribute( $variation['attributes'] );
		}
	}
}

// If it is a single variation product
$single_variation_product	= false;

if ( $product->get_type() === 'variation' ){
	$variation_id = $product->get_id();
	$product_colors = get_post_meta($variation_id, '_jck_product_colors', true);
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
}

// Extra post classes
$classes = array();

if ( !$variations_slider && ( $product->is_type( 'variable' ) || $product->is_type( 'variable' ) ) ){
	$classes[] = 'product_variation';
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

		<?php if ( $product_style === 'product-style-1' ){
			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

		} ?>

        <?php wc_get_template( 'loop/sale-flash.php', array( 'variation' => $variation ) ); ?>

		<a href="<?php echo $url; ?>" class="img" data-colors="<?php echo $product_colors; ?>" data-variation-id="<?php echo $variation['variation_id']; ?>" data-product-id="<?php echo $post->ID; ?>" <?php echo $data_attr; ?> data-attr-counter="<?php echo $data_counter; ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $product->get_available_variations() ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, $size, $thumb_attr ); ?></a>

		<section class="product-meta">
			<?php

				if ( $product_style === 'product-style-2' ){
					/**
					 * woocommerce_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_product_title - 10
					 */

					 do_action( 'woocommerce_shop_loop_item_title' );
				}

			?>

			<span class="price-rating">
				<?php

				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );

				// Price
				if ( $variation['price_html'] !== '' ){
					echo $variation['price_html'];
				} else {
					if ( $price_html = $product->get_price_html() ) { ?>
						<span class="price"><?php echo $price_html; ?></span>
					<?php }
				}

				?>
			</span>

			<?php
				/**
				 * woocommerce_after_shop_loop_item hook
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 * @hooked pp_variable_add_to_cart - 15
				 */
				do_action( 'woocommerce_after_shop_loop_item', true );
			?>
		</section>

	</li>

<?php } else { ?>

	<li <?php post_class( $classes ); ?>>

		<?php
		/**
		 * woocommerce_before_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		 do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<?php

			if ( $product_style === 'product-style-1' ){

				/**
				 * woocommerce_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */

				 // Show number of variations if product has children
				if ( $product->is_type( 'variable' ) && $variations_slider && $product_style === 'product-style-1' ){
					$variationTmpl = '<span class="variation">' . $variationCount . ' ' . trim($variations, ' ') . '</span>';
				}

				 do_action( 'woocommerce_shop_loop_item_title', $variationTmpl );
			}


			/* @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		<section class="product-meta">
			<?php

				if ( $product_style === 'product-style-2' ){
					/**
					 * woocommerce_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_product_title - 10
					 */

					 do_action( 'woocommerce_shop_loop_item_title' );
				}

			?>

			<span class="price-rating">
				<?php

					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );

				?>
			</span>

			<?php
				/**
				 * woocommerce_after_shop_loop_item hook
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 * @hooked pp_variable_add_to_cart - 15
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
		</section>

	</li>

<?php } ?>
