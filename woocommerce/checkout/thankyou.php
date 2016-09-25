<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//$rates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_extra_flat_rates");
//$std = WC()->shipping->load_shipping_methods();

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>
	
		<h1><span><?php _e( 'Something went wrong', 'davis' ); ?></span></h1>

		<h6 class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></h6>

		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
	
		<h1><span><?php _e( 'Thank you!', 'davis' ); ?></span></h1>

		<h6 class="woocommerce-thankyou-order-received">
			<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', sprintf( __( 'Your order #%s has been received', 'woocommerce' ), $order->get_order_number() ), $order ); ?>
		</h6>
		
		<div class="row">
			<section class="col-md-9">
				<div class="row">
					<div id="order-confirmation" class="col-md-12">
						<div class="container">
							<?php echo get_theme_mod( 'confirmation_text', '<p>Check your email shortly for a confirmation and the details of your order. Please keep it for your record.</p><p>We are going to process your order and dispatch it as soon as possible. We’ll send you another email once your order is on its way.</p>' ); ?>
						</div>
					</div>
					
					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' && get_theme_mod( 'display_create_account', true ) && ! is_user_logged_in() ) : ?>
						<div id="create-account" <?php if ( get_theme_mod( 'display_form', false ) ) : ?>class="col-md-6"<?php else : ?>class="col-md-12"<?php endif; ?>>
							<div class="container">
								<h3><?php echo get_theme_mod( 'account_title', 'Create Account' ); ?></h3>
								
								<p><?php echo get_theme_mod( 'account_description', 'Be able to check your order status and have a faster checkout for your future orders.' ); ?></p>
								
								<div class="wrap-form">
									<form method="post" class="register" action="ajaxregistration">
							
										<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
							
											<p class="form-row form-row-wide">
												<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
												<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
											</p>
							
										<?php endif; ?>
							
										<input type="hidden" class="email" name="email" value="<?php echo esc_html( $order->billing_email ); ?>" />
										<input type="hidden" class="order_id" name="order_id" value="<?php echo $order->get_order_number(); ?>" />
							
										<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
							
											<p class="form-row form-row-wide">
												<input type="password" class="input-text password" name="password" id="reg_password" placeholder="<?php _e( 'Password *', 'woocommerce' ); ?>" />
											</p>
							
										<?php endif; ?>
							
										<!-- Spam Trap -->
										<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
							
										<?php do_action( 'woocommerce_register_form' ); ?>
										<?php do_action( 'register_form' ); ?>
							
										<p class="form-row">
											<?php wp_nonce_field( 'ajax-registration-nonce', 'security' ); ?>
											<button name="register" type="submit" data-message="<?php _e( 'Registering', 'davis' ); ?>" class="button submit"><?php _e( 'Register', 'davis' ); ?></button>
										</p>
							
									</form>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'display_form', false ) ) : ?>
						<div id="signup-form" <?php if ( get_theme_mod( 'display_create_account', false ) && !is_user_logged_in() || !is_user_logged_in() ) : ?>class="col-md-6"<?php else : ?>class="col-md-12"<?php endif; ?>>
							<div class="container">
								<h3><?php echo get_theme_mod( 'form_title', 'Exclusive tips and Offers' ); ?></h3>
								
								<p><?php echo get_theme_mod( 'form_description', 'Subscribe to our newsletter to receive occasional offers and tips. Promise we don’t spam.' ); ?></p>
								
							<?php if ( get_theme_mod( 'signup_form', false ) ) :
								echo do_shortcode( '[contact-form-7 id="' . get_theme_mod( 'signup_form' ) . '"]' );
							endif; ?>
							</div>
						</div>
						<div class="clearfix"></div>		
							 
						<?php $related = array();
						
						foreach( $order->get_items() as $item_id => $item ) {
								$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
								
								$related = array_merge( $related, $product->get_related( 30 ) );
								
						} ?>
						
						<?php if ( sizeof( $related ) !== 0 ) : ?>
							
							<div id="recommended-products" class="col-md-12">
	
								<?php $args = apply_filters( 'woocommerce_related_products_args', array(
									'post_type'            => 'product',
									'ignore_sticky_posts'  => 1,
									'no_found_rows'        => 1,
									'posts_per_page'       => $posts_per_page,
									'orderby'              => $orderby,
									'post__in'             => $related,
									'post__not_in'         => array( $product->id )
								) );
								
								$products = new WP_Query( $args );
								
								$woocommerce_loop['columns'] = $columns;
								
								if ( $products->have_posts() ) : ?>
								
									<div class="related products">
								
										<h3><?php _e( 'Recommended Products', 'woocommerce' ); ?></h3>
								
										<?php woocommerce_product_loop_start(); ?>
								
											<?php while ( $products->have_posts() ) : $products->the_post(); ?>
								
												<?php wc_get_template_part( 'content', 'product' ); ?>
								
											<?php endwhile; // end of the loop. ?>
								
										<?php woocommerce_product_loop_end(); ?>
								
									</div>
								
								<?php endif;
								
								wp_reset_postdata(); ?>
							
							</div>
							
						<?php endif; ?>					
						
						<div id="customer-details" class="col-md-12">
							<div class="container">
								<?php wc_get_template( 'order/order-details.php', array( 'order_id' =>  $order->id, 'thankyou' => true ) ); ?>
							</div>
						</div>
					<?php endif; ?>
						
					<?php $id = 1646;
						$post = get_page($id);
						$content = apply_filters('the_content', $post->post_content);
						echo $content; 
					?>
					
					<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
				</div>
			</section>
			
			<aside class="col-md-3">
				<article id="order-summary" class="container">
					<h3><?php _e( 'Order Summary', 'davis' ); ?></h3>
					<ul class="order-summary">
						<?php foreach( $order->get_items() as $item_id => $item ) {
							$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
							$purchase_note = get_post_meta( $product->id, '_purchase_note', true ); ?>
							
							<li>
								<table>
									<tbody>
										<tr>
											<td class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '<span class="x">x</span><span class="number">%s</span>', $item['qty'] ), $item ); ?></td>
											<td class="product-img"><?php echo $product->get_image( 'shop_catalog' ); ?></td>
										</tr>
									</tbody>
								</table>
							</li>
							
						<?php } ?>
					</ul>
					<table id="summary">
						<body>
							<?php if ( get_theme_mod( 'display_order_date', false ) ) : ?>
								<tr class="date">
									<th><?php _e( 'Date', 'woocommerce' ); ?></th>
									<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
								</tr>
							<?php endif; ?>
							<?php if ( $order->payment_method_title && get_theme_mod( 'display_payment_method', false ) ) : ?>
								<tr class="method">
									<th><?php _e( 'Payment Method', 'woocommerce' ); ?></th>
									<td><?php echo $order->payment_method_title; ?></td>
								</tr>
							<?php endif; ?>
							<tr class="grand-total">
								<th><?php _e( 'Grand Total', 'davis' ); ?></th>
								<td><?php echo $order->get_formatted_order_total(); ?></td>
							</tr>
						</body>
					</table>
				</article>
				
				<?php if ( class_exists( 'WC_Social_Checkout' ) ) : ?>
					<article id="share-purchase" class="container">
						<?php do_action( 'woocommerce_share_purchase', $order->id ); ?>
					</article>
				<?php endif; ?>
			</aside>
		</div>

	<?php endif; ?>

<?php else : ?>

		<h1><span><?php _e( 'Thank you!', 'davis' ); ?></span></h1>

		<h6 class="woocommerce-thankyou-order-received">
			<?php _e( 'Your order has been received but cannot be viewed here. Please check your email for the order confirmation or login if you have an account.', 'woocommerce' ); ?>
		</h6>

<?php endif; ?>
