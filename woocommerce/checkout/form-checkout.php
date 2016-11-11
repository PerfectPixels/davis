<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

if ( in_array( 'paypal-express-checkout' ,get_body_class() ) ) {
	$paypal_checkout = true;
} else {
	$paypal_checkout = false;
}

$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );
$the_cart = WC()->cart->get_cart();

?>

<div id="checkout-container">

	<?php woocommerce_shipping_calculator(); ?>

	<?php if ( $paypal_checkout ){ ?>
		<div class="woocommerce-info"><?php _e('Your are using Paypal Checkout - Please double check your details before placing your order.', 'davis' ); ?></div>
	<?php } ?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout customer-details-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<div id="checkout_details" class="col-md-4">

			<header>
				<h4><?php echo esc_attr( get_theme_mod( 'checkout_details_title', __( 'Customer Details', 'davis' ) ) ); ?></h4>
				<h6><?php echo esc_attr( get_theme_mod( 'checkout_details_subtitle', __('Fill in your details in the form bellow', 'davis' ) ) ); ?></h6>
			</header>

			<?php  wc_print_notices(); ?>

			<?php if ( !is_user_logged_in() && !$paypal_checkout ) {

				$redirect = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>

				<div class="panel-group" id="accordion-customer-details" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading-login-customer">
							<div class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-customer-details" href="#collapse-login-customer" aria-expanded="false" aria-controls="collapse-login-customer">
									<?php _e('Returning customer? ', 'davis' ); ?>
									<span class="primary-color"><?php _e('Click here to login', 'davis' ); ?></span>
								</a>
							</div>
						</div>
						<div id="collapse-login-customer" class="panel-collapse collapse form" role="tabpanel" aria-labelledby="heading-login-customer" style="height:0;">
							<div class="panel-body" id="loginform" action="ajaxlogin">
								<input type="text" class="email" tabindex="1" autocapitalize="off" autocorrect="off" placeholder="<?php _e( 'Email Address', 'woocommerce' ); ?>*">
								<input type="password" id="login-password-checkout" class="password" tabindex="2" autocapitalize="off" autocorrect="off"  placeholder="<?php _e( 'Password', 'woocommerce' ); ?>*">
								<a tabindex="4" data-message="Please wait" class="button black submit submit-login"><?php _e( 'Login', 'woocommerce' ); ?></button>
						        <a href="<?php echo wp_lostpassword_url( $get_checkout_url ); ?>" class="lost" ><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
						        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
								<input type="hidden" name="redirect_to" value="<?php echo $redirect; ?>">
							</div>
						</div>
					</div>

					<?php if ( class_exists( 'WC_Social_Login' ) ){ ?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading-login-social">
								<div class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-customer-details" href="#collapse-login-social" aria-expanded="false" aria-controls="collapse-login-social">
										<?php _e('Login/Register with Social Media', 'davis' ); ?>
									</a>
								</div>
							</div>
							<div id="collapse-login-social" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-login-social" style="height:0;">
								<div class="panel-body">
									<?php echo do_shortcode('[woocommerce_social_login_buttons return_url="'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] .'"]'); ?>
									<small><?php _e('We would never post anything without your permission.', 'davis' ); ?></small>
								</div>
							</div>
						</div>
					<?php } ?>

					<div id="customer-details-form">
						<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

							<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

							<div id="customer_details">
								<div>
									<?php do_action( 'woocommerce_checkout_billing' ); ?>
								</div>

								<div>
									<?php do_action( 'woocommerce_checkout_shipping' ); ?>
								</div>
							</div>

							<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

						<?php endif; ?>
					</div>
				</div>
			<?php } else { ?>
				<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div id="customer_details">
						<div>
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>

						<div>
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>
			<?php } ?>

			<?php wp_nonce_field( 'update-order-review' ); ?>

		</div>

		<div id="checkout_shipping" class="col-md-4">

			<header>
				<h4><?php echo esc_attr( get_theme_mod( 'checkout_shipping_title', __('Shipping & Payment', 'davis' ) ) ); ?></h4>
				<h6><?php echo esc_attr( get_theme_mod( 'checkout_shipping_subtitle', __('Select your preferred shipping and payment methods', 'davis' ) ) ); ?></h6>
			</header>

			<h5><?php _e('Shipping Method', 'davis' ); ?></h5>

			<div id="shipping_method_container" class="shipping_select">
				<?php wc_get_template( 'cart/cart-totals.php' ); ?>
			</div>

			<?php if ( !$paypal_checkout ){ ?>
				<h5><?php _e('Payment Method', 'davis' ); ?></h5>
			<?php } ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_payment' ); ?>
			</div>

		</div>

		<div id="checkout_review" class="col-md-4">

			<header>
				<h4><?php echo esc_attr( get_theme_mod( 'checkout_review_title', __('Review Order', 'davis' ) ) ); ?></h4>
				<h6><?php echo esc_attr( get_theme_mod( 'checkout_review_subtitle', __('Confirm your cart content and the total of your order', 'davis' ) ) ); ?></h6>
			</header>

			<?php do_action( 'woocommerce_before_cart_table' ); ?>


			<ul class="cart_list checkout-cart">

				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				foreach ( $the_cart as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

						$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
						$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item['product_id'], $cart_item_key );
						$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
						<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> icon-amp">

							<table>
								<tbody>
									<tr>
										<td>
											<div class="item-cart-list">
												<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
													<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
												</a>
												<div class="item-details">
													<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="title"><?php echo $product_name; ?></a>
													<?php echo WC()->cart->get_item_data( $cart_item ); ?>
													<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', $product_price, $cart_item, $cart_item_key ); ?>
													<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input( array(
																'input_name'  => "cart[{$cart_item_key}][qty]",
																'input_value' => $cart_item['quantity'],
																'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
																'min_value'   => '0'
															), $_product, false );
														}
														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
													?>
												</div>
											</div>
										</td>
										<td>
										<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
											'<a href="%s" class="remove icon-bin" title="%s" data-product_id="%s" data-product_sku="%s"></a>',
											esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
											__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										), $cart_item_key );
										?>
										</td>
										<td>
										<span class="price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span>
										</td>
									</tr>
								</tbody>
							</table>
						</li>
						<?php
					}
				}

				do_action( 'woocommerce_cart_contents' );

				?>

				</ul>

				<!-- <input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" /> -->

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<a href="javascript:void();" class="showcoupon"><?php _e( 'Have a discount voucher or gift code?', 'woocommerce' ); ?></a>
					<div id="coupons">
						<div class="checkout_coupon">
							<table class="coupon">
								<tbody>
									<tr>
										<td>
											<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
										</td>
										<td>
											<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />
										</td>
									</tr>
								</tbody>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</table>
						</div>

						<?php do_action( 'woocommerce_after_cart_table' ); ?>
					</div>
				<?php } ?>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>

			<?php do_action( 'woocommerce_after_cart' ); ?>


			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review_price" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			<div class="place-order col-md-12">

				<noscript>
					<?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
					<br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
				</noscript>

				<?php wc_get_template( 'checkout/terms.php' ); ?>

				<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

				<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order" />' ); ?>

				<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

				<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>

			</div>

		</div>

	</form>

</div>
