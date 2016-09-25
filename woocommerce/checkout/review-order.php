<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PP\Extras;

?>
<section class="shop_table woocommerce-checkout-review-order-table">
	<div class="cart-total plus">
		<span class="label"><?php _e( 'Cart Total', 'woocommerce' ); ?></span>
		<span class="price"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
	<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> minus">
		<span class="label"><?php _e( 'Coupon', 'woocommerce' ); ?></span>
		<span class="price"><?php Extras\tomo_cart_totals_coupon_html( $coupon ); ?></span>
	</div>
	<?php endforeach; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
	<div class="fee plus">
		<span class="label"><?php echo esc_html( $fee->name ); ?></span>
		<span class="price"><?php wc_cart_totals_fee_html( $fee ); ?></span>
	</div>
	<?php endforeach; ?>

	<?php if ( wc_tax_enabled() && WC()->cart->tax_display_cart === 'excl' ) : ?>
		<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
			<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?> plus">
				<span class="label"><?php echo esc_html( $tax->label ); ?></span>
				<span class="price"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
			</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="tax-total plus">
				<span class="label"><?php echo esc_html( WC()->coundivies->tax_or_vat() ); ?></span>
				<span class="price"><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<div class="shipping-total plus">
		<span class="label"><?php _e( 'Shipping Total', 'woocommerce' ); ?></span>
		<span class="price"><?php echo str_replace( "Free!", "£0", WC()->cart->get_cart_shipping_total() ); ?></span>
	</div>

	<div class="order-total equal">
		<span class="label"><?php _e( 'Total', 'woocommerce' ); ?></span>
		<span class="price"><?php wc_cart_totals_order_total_html(); ?></span>
	</div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</section>