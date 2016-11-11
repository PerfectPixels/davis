<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

$product_loop = $woocommerce_loop['loop'];

$is_slider = false;

if ( $product->is_type( 'variable' ) && (get_field('variations_slider') === 'yes' || get_field('variations_slider') === "default" && get_theme_mod('shop_variations_slider', false)) || $single_variation_product ){
	$first_attr = array_shift($attributes);
	$is_slider = true;
}

?>

<?php if ( $is_slider ){ ?>
	<section class="variation-options product-overlay">
		<div class="wrap">
			<div class="container">
				<div class="content">
					<h3><?php _e('Select your options', 'davis' ); ?></h3>

					<table>
						<tbody>
							<?php foreach ( $attributes as $attribute_name => $options ) :
									$product_loop++;
									$arrCounter = 0;
									$product_attributes = $product->get_attributes();
									$attr = sanitize_title( $attribute_name );
									$attribute = isset( $product_attributes[ $attr ] ) ? $product_attributes[ $attr ] : $product_attributes[ 'pa_' . $attr ];

									if ( $attribute['is_taxonomy'] ) {
										$terms = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'slugs' ) );
										$name = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
										$has_slug = true;
									} else {
										$terms = explode(' | ', $attribute['value']);
									} ?>

									<tr class="option" data-attribute_name="attribute_<?php echo $attribute['name']; ?>">
										<td>
											<h4><?php echo wc_attribute_label( $attribute_name ); ?></h4>
											<ul>
												<?php foreach ( $terms as $index => $term ) { ?>

													<?php if ( $attribute['is_taxonomy'] ) {
														$term_name = $name[$arrCounter];
													} else {
														$term_name = $term;
													} ?>

													<li><input type="radio" id="<?php echo $term . $product_loop; ?>" name="<?php echo $attr; ?>" value="<?php echo $term; ?>"><label for="<?php echo $term . $product_loop; ?>"><?php echo $term_name; ?></label></li>
													<?php $arrCounter++;
												} ?>
											</ul>
										</td>
									</tr>
								<?php
							endforeach;?>
						</tbody>
					</table>
					<a href="#" class="button">Confirm</a>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
