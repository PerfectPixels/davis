<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$empty_cart 		= WC()->cart->is_empty();
$content_cart_count	= WC()->cart->get_cart_contents_count();

$cart_title		= esc_attr( get_theme_mod( 'checkout_cart_title', __( 'Cart Summary', 'davis' ) ) );
$cart_subtitle	= __( sprintf( _n( 'You have %d item in your cart', 'You have %d items in your cart', $content_cart_count, 'davis' ), $content_cart_count ) );

$details_title 	= esc_attr( get_theme_mod( 'checkout_details_title', __( 'Customer Details', 'davis' ) ) );
$shipping_title	= esc_attr( get_theme_mod( 'checkout_shipping_title', __( 'Shipping & Payment', 'davis' ) ) );
$review_title	= esc_attr( get_theme_mod( 'checkout_review_title', __( 'Order Review', 'davis' ) ) );

$cart_icon = str_replace( '-outline', '', get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ) );

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<header class="cart-header <?php if ( $empty_cart ){ ?>empty-cart<?php } ?>">
	<h4><?php echo $cart_title; ?></h4>
	<h6><?php echo $cart_subtitle; ?></h6>
	<ul class="cart-nav">
		<li class="selected anim-delay-1">
			<a href="#cart" data-toggle="tooltip" data-placement="top" title="<?php echo $cart_title; ?>"></a>
		</li>
		<li class="anim-delay-2">
			<a href="#details" data-toggle="tooltip" data-placement="top" title="<?php echo $details_title; ?>"></a>
		</li>
		<li class="anim-delay-3">
			<a href="#shipping" data-toggle="tooltip" data-placement="top" title="<?php echo $shipping_title; ?>"></a>
		</li>
		<li class="anim-delay-4">
			<a href="#review" data-toggle="tooltip" data-placement="top" title="<?php echo $review_title; ?>"></a>
		</li>
	</ul>
	<span class="close-cart"></span>
</header>

<section class="cart-container">
	<div class="cart-wrapper">
		<div id="checkout_cart" class="cart-content">
			<?php get_template_part( 'woocommerce/cart/cart-content' ); ?>
		</div>
	</div>
</section>

<?php if ( ! $empty_cart ) : ?>
	<div class="cart-btn-container">
		<div class="quick-btn">
			<a href="#cart" class="<?php echo $cart_icon; ?> left black button" data-cart="#details,icon-details,<?php echo $details_title; ?>" data-details="#cart,<?php echo $cart_icon; ?>,<?php echo $cart_title; ?>">
				<span><?php echo $cart_title; ?></span>
			</a>
			<a href="#shipping" class="icon-payment right black button" data-shipping="#details,icon-details,<?php echo $details_title; ?>" data-details="#shipping,icon-payment,<?php echo $shipping_title; ?>">
				<span><?php echo $shipping_title; ?></span>
			</a>
			<a href="#review" class="icon-receipt last black button" data-shipping="#review,icon-receipt,<?php echo $review_title; ?>" data-review="#shipping,icon-payment,<?php echo $shipping_title; ?>">
				<span><?php echo $review_title; ?></span>
			</a>
			<a href="#" class="<?php echo $cart_icon . '-checkout'; ?> black button" id="place_order"><?php _e( 'Place Order', 'davis' ); ?></a>
		</div>

		<div class="default-btn">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" data-url="<?php echo esc_url( wc_get_checkout_url() ); ?>" data-class="button checkout <?php echo $cart_icon . '-checkout'; ?> black" class="button black checkout <?php echo $cart_icon . '-checkout'; ?> wc-forward">
				<span><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></span>
			</a>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
		</div>
	</div>

<?php endif; ?>
