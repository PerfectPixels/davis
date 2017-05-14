<?php

$counter 			= 0;
$empty_cart 		= WC()->cart->is_empty();
$the_cart 			= WC()->cart->get_cart();

?>

<ul class="cart_list product_list_widget">

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

        <li class="empty"><?php echo sprintf( __( 'Your shopping cart is empty. Browse our <a href="%s" class="primary-color">shop</a>', 'davis' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?></li>

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
