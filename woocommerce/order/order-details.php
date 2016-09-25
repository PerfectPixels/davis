<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
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

if ( empty($order) ){
	$order = wc_get_order( $order_id );
}

$item_count = $order->get_item_count();

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>

<?php if ( empty($thankyou) ) : ?>

	<?php if ( empty($dashboard) ) : ?>
		<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
	<?php endif; ?>
	
	<table class="shop_table shop_table_responsive my_account_orders order_details">
	
		<thead>
			<tr class="order">	
				<th class="order-status">
					<?php $status =  wc_get_order_status_name( $order->get_status() ); ?>
					<span class="<?php echo strtolower(str_replace(" ", "-",$status)); ?>"><?php echo $status; ?></span>
				</th>
				<th class="order-date">
					<span><?php _e('Order Placed', 'davis'); ?></span>
					<small><time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time></small>
				</th>
				<th class="order-total">
					<span><?php _e('Total', 'davis'); ?></span>
					<small><?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); ?></small>
				</th>
				<th class="order-number">
					<span><?php echo _x( 'Order #', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?></span>
					<small>
						<?php
							$actions = array(
								'view'   => array(
									'url'  => $order->get_view_order_url(),
									'name' => __( 'Order Details', 'woocommerce' )
								),
								'pay'    => array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay Order', 'woocommerce' )
								),
								'cancel' => array(
									'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
									'name' => __( 'Cancel Order', 'woocommerce' )
								)
							);

							if ( ! $order->needs_payment() ) {
								unset( $actions['pay'] );
							}

							if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								unset( $actions['cancel'] );
							}

							if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="primary-color ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
						?>	
					</small>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach( $order->get_items() as $item_id => $item ) {
					$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
	
					wc_get_template( 'order/order-details-item.php', array(
						'order'			     => $order,
						'item_id'		     => $item_id,
						'item'			     => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'	     => $product ? get_post_meta( $product->id, '_purchase_note', true ) : '',
						'product'	         => $product,
					) );
				}
			?>
			<?php do_action( 'woocommerce_order_items_table', $order ); ?>
		</tbody>
		
		<?php if ( empty($dashboard) ) : ?>
			<tfoot>
				<?php
					foreach ( $order->get_order_item_totals() as $key => $total ) {
						?>
						<tr>
							<th colspan="2" scope="row"><?php echo $total['label']; ?></th>
							<td colspan="2"><?php echo $total['value']; ?></td>
						</tr>
						<?php
					}
				?>
			</tfoot>
		<?php endif; ?>
		
	</table>

<?php endif; ?>

<?php if ( empty($dashboard) ) : ?>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	
	<?php if ( $show_customer_details ) : ?>
		<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
	<?php endif; ?>
	
<?php endif; ?>
