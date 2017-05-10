<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// Get the images style
$product_style = get_theme_mod('product_style', 'thumb');
$page_product_style = get_field('page_images_style');

if ($page_product_style !== 'default'){
    $product_style = $page_product_style;
}

$attribute_keys = array_keys( $attributes );
$quickview      = ( isset($quickview) ? $quickview : false );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">

	<?php if ( ( $product_style === 'slideshow' || $product_style === 'fullwidth' ) && ! $quickview ) :
		wc_get_template( 'single-product/price.php', array(
			'in_form' => false
		));
	endif; ?>

	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<tr>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<td class="value">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );

								$text = rtrim( str_replace( 'pa_', '', sanitize_title( $attribute_name ) ), 's' );
								$select_text = 'Select ' . $text;

								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'show_option_none' => __( $select_text, 'woocommerce' ) ) );
							?>
						</td>
			        <?php endforeach;?>
				</tr>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php wc_get_template( 'single-product/price.php', array(
			'in_form' 	 => true,
			'quickview' => $quickview
		)); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
