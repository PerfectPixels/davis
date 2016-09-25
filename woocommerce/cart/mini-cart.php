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

$counter 			= 0;
$empty_cart 		= WC()->cart->is_empty();
$the_cart 			= WC()->cart->get_cart();
$content_cart_count	= WC()->cart->get_cart_contents_count();

$cart_title		= esc_attr( get_theme_mod( 'checkout_cart_title', __( 'Cart Summary', 'davis' ) ) );
$cart_subtitle	= __( sprintf( ngettext( 'You have %d item in your cart', 'You have %d items in your cart', $content_cart_count ), $content_cart_count ), 'davis' );

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<header class="cart-header <?php if ( $empty_cart ){ ?>empty-cart<?php } ?>">
	<h4 data-text="<?php echo $cart_title; ?>"><?php echo $cart_title; ?></h4>
	<h6 data-text="<?php echo $cart_subtitle; ?>"><?php echo $cart_subtitle; ?></h6>
	<ul class="cart-nav">
		<li class="selected anim-delay-1">
			<a href="#cart" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( get_theme_mod( 'checkout_cart_title', __( 'Cart Summary', 'davis' ) ) ); ?>"></a>
		</li>
		<li class="anim-delay-2">
			<a href="#details" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( get_theme_mod( 'checkout_details_title', __( 'Customer Details', 'davis' ) ) ); ?>"></a>
		</li>
		<li class="anim-delay-3">
			<a href="#shipping" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( get_theme_mod( 'checkout_shipping_title', __( 'Shipping & Payment', 'davis' ) ) ); ?>"></a>
		</li>
		<li class="anim-delay-4">
			<a href="#review" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( get_theme_mod( 'checkout_review_title', __( 'Order Review', 'davis' ) ) ); ?>"></a>
		</li>
	</ul>
	<span class="close-cart"></span>
</header>

<section class="cart-container">
	<div class="cart-wrapper">
		<div id="checkout_cart" class="cart-content">
			<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">
			
				<?php if ( ! $empty_cart ) : ?>
			
					<?php
						foreach ( $the_cart as $cart_item_key => $cart_item ) {
							$counter++;
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			
								$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item['product_id'], $cart_item_key );
								$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
								<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> icon-amp animation-delay-<?php echo $counter; ?>">
									
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
					?>
			
				<?php else : ?>
			
					<li class="empty"><?php echo sprintf( __( 'Your shopping cart is empty. Browse our <a href="%s" class="primary-color">shop</a>', 'davis' ), get_permalink( woocommerce_get_page_id( 'shop' ) ) ); ?></li>
			
				<?php endif; ?>
			
			</ul><!-- end product list -->
				
			<?php wp_nonce_field( 'update-order-review', 'checkout_nonce' ); ?>
			
			<?php if ( ! $empty_cart ) : ?>
			
				<p class="total">
					<small><?php _e( 'Subtotal', 'davis' ); ?>:</small>
					<?php echo WC()->cart->get_cart_subtotal(); ?>
				</p>
				
				<?php wp_nonce_field( 'pffwc-nonce' ); ?>
			
			<?php endif; ?>
			
			<?php do_action( 'woocommerce_after_mini_cart' ); ?>
		</div>
	</div>
</section>

<?php if ( ! $empty_cart ) : ?>
	<div class="cart-btn-container">
		<div class="quick-btn">
			<a href="#cart" data-next="#details,icon-details" data-prev="#cart,icon-checkout" class="icon-checkout left black button">
				<span></span>
			</a>
			<a href="#shipping" data-next="#shipping,icon-payment" data-prev="#details,icon-details" class="icon-payment right black button">
				<span></span>
			</a>
			<a href="#review" data-prev="#shipping,icon-payment" data-next="#review,icon-receipt" class="icon-receipt last black button">
				<span></span>
			</a>
			<a href="#" class="icon-shopping-bag-check black button" id="place_order"><?php _e( 'Place Order', 'davis' ); ?></a>
		</div>
		
		<div class="default-btn">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" data-url="<?php echo esc_url( wc_get_checkout_url() ); ?>" data-class="button checkout icon-checkout black" class="button black checkout icon-checkout wc-forward">
				<span><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></span>
			</a>
		
			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
		</div>
	</div>
	
<?php endif; ?>