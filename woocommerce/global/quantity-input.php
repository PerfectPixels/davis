<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'is_mobile' ) ) {
	function is_mobile() {
	    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
}

?>

<div class="quantity" <?php if(!is_mobile()){ echo 'data-spinner'; } ?>>

	<?php if(!is_mobile()){ ?>
    <a class="spinner up primary-color-hover" tabindex="-1" role="button">+</a>
	<?php } ?>

	<input type="number" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" />

	<?php if(!is_mobile()){ ?>
    <a class="spinner down primary-color-hover" tabindex="-1" role="button">-</a>
	<?php } ?>
</div>
