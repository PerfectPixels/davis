<?php
/**
 * Social Checkout thanks page template
 */
?>

<h3><?php
	if ( empty ( $settings['wc_social_checkout_heading'] ) ) {
		echo esc_html ( _e('Happy? Let your friends know!', 'wc_social_checkout') ) ;
	} else {
		echo esc_html ( $settings['wc_social_checkout_heading'] );
	}
?></h3>

<?php if ( count( $items ) <= 5 ) :?>
	<?php foreach ( $items as $cart_item ) :
		if ( isset ( $cart_item['id'] ) ) {
			$id = $cart_item['id'];
		} elseif ( isset ( $cart_item['product_id'] ) ) {
			$id = $cart_item['product_id'];
		} else {
			continue;
		}
		// 2.2 compat
		if ( function_exists( 'wc_get_product' ) ) {
			$product = apply_filters( 'woocommerce_order_item_product', $cart_item->get_product(), $cart_item );
		} else if ( function_exists( 'get_product' ) ) {
			// 2.0 compat
			$product = get_product( $id );
		} else {
			$product = new WC_Product( $id );
		}

		$item            = new stdClass();
		$item->id        = $id;
		$item->image     = $product->get_image();
		$item->title     = $product->get_title();
		$item->permalink = get_permalink($id);
		$item            = apply_filters( 'woo_sc_item', $item, $product, $order );

		woocommerce_get_template(
			'sc-item.php', array(
				'settings'  => $settings,
				'order'  	=> $order,
				'services'  => $services,
				'item'      => $item,
			),
			'woocommerce-social-checkout',
			untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/'
		);
	?>
	<?php endforeach; ?>
<?php else :

	// Use the first product for anything we absolutely need a prodduct for.
	$cart_item = array_shift( $items );

	$item = new stdClass();
	if ( isset( $cart_item['id'] ) ) {
		$item->id = $cart_item['id'];
	} elseif ( isset ( $cart_item['product_id'] ) ) {
		$item->id = $cart_item['product_id'];
	} else {
		$item->id = null;
	}
	if ( function_exists( 'get_product' ) ) {
		$product = apply_filters( 'woocommerce_order_item_product', $cart_item->get_product(), $cart_item );
	} else {
		$product = new WC_Product( $item->id );
	}
	$item->image     = $product->get_image();
	$item->title     = $product->get_title() . _x( ' & more!', 'Displayed when a basket contains many items to indicate that there were more products than shown', 'wc_social_checkout' );
	$item->permalink = get_bloginfo( 'url' );
	$item            = apply_filters( 'woo_sc_item', $item, null, $order );
	woocommerce_get_template(
		'sc-item.php', array(
			'settings'  => $settings,
			'order'  => $order,
			'services'  => $services,
			'item'      => $item,
		),
		'woocommerce-social-checkout',
		untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/'
	);
endif; ?>
