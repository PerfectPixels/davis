<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$attachment_ids = $product->get_gallery_attachment_ids();
$images_pos = 'right';

// Change the position of the price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

// Get the images style
$product_style = get_theme_mod('product_style', 'thumb');
$page_product_style = get_field('page_images_style');

if ($page_product_style !== 'default'){
    $product_style = $page_product_style;
}

// Change the Summary elements position if it is the slideshow style
if ($product_style === 'slideshow'){
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}

if ($product_style !== 'slideshow' && $product_style !== 'fullwidth'){
	// Get the images position
	$images_pos = get_theme_mod('product_images_position', 'right');
	$page_images_position = get_field('page_product_images_position');

	if ($page_images_position !== 'default'){
	    $images_pos = $page_images_position;
	}
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ){
	 	echo get_the_password_form();
	 	return;
	}
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container style-<?php echo $product_style; ?> images-<?php echo $images_pos; ?>">

		<?php if ($images_pos === 'left'){
			/**
			 * woocommerce_before_single_product_summary hook.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		} ?>

		<div class="summary entry-summary">

			<section>
				<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>

				<?php if ($product_style === 'thumb'){

					wc_get_template( 'single-product/product-thumbs.php', array(
				        'attachment_ids' => $attachment_ids,
				    ) );

				} ?>

			</section>
		</div><!-- .summary -->

		<?php if ($images_pos === 'right'){
			/**
			 * woocommerce_before_single_product_summary hook.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		} ?>


		<?php if ($product_style === 'slideshow'){
			// Add the meta details
			wc_get_template( 'single-product/meta.php', array(
				'attachment_ids' => $attachment_ids,
			) );
		} ?>

	</div>

	<?php if ( class_exists( 'WC_Product_Reviews_Pro' ) ){ ?>
	  <div id="comments">
	<?php } ?>

		<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>

	<?php if ( class_exists( 'WC_Product_Reviews_Pro' ) ){ ?>
	  </div>
  <?php } ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
