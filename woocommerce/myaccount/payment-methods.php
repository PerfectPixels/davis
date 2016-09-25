<?php
/**
 * Payment methods
 *
 * Shows customer payment methods on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/payment-methods.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();

do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>

<?php if ( $has_methods ) : ?>

			<?php foreach ( $saved_methods as $type => $methods ) : ?>
				<?php foreach ( $methods as $method ) : ?>
				
					<table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
						<thead>
							<tr class="payment-method<?php echo ! empty( $method['is_default'] ) ? ' default-payment-method' : '' ?>">	
								<th class="card-details">
									<?php $card_name = esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ); ?>
									<span class="card-icon <?php echo strtolower(str_replace(" ", "-", $card_name )); ?>"></span>
									<span class="card-name"><?php echo $card_name; ?></span>
								</th>
								
								<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
									<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
									
										<?php  if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) {
											do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method );
										} else if ( 'method' === $column_id ) {
											if ( ! empty ( $method['method']['last4'] ) ) : ?>
											
												<span class="ends"><?php _e('Ending', 'davis'); ?></span>
												<small><?php echo esc_html( $method['method']['last4'] ); ?></small>
											
											<?php endif;
										} else if ( 'expires' === $column_id ) { ?>
										
											<span class="ends"><?php _e('Expires', 'davis'); ?></span>
											<small><?php echo esc_html( $method['expires'] ); ?></small>
										
										<?php } else if ( 'actions' === $column_id ) {
											foreach ( $method['actions'] as $key => $action ) {
												echo '<a href="' . esc_url( $action['url'] ) . '" class="button black ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>&nbsp;';
											}
										}
										?>
										
									</th>
								<?php endforeach; ?>
							</tr>							
						</thead>
					</table>
					
				<?php endforeach; ?>
			<?php endforeach; ?>

<?php else : ?>

	<p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e( 'No saved methods found.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>

<a class="button" href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>"><?php esc_html_e( 'Add Payment Method', 'woocommerce' ); ?></a>
