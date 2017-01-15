<?php
/**
* Class for all cart/checkout modification
*
* @version 1.0
*/
class PP_Cart {

    /**
	 * Construction function
	 *
	 * @since  1.0
	 * @return PP_Cart
	 */
	function __construct() {

        global $woocommerce_active;

		// Check if Woocomerce plugin is actived
		if ( ! $woocommerce_active ) {
			return false;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'initiate_hooks' ) );

		// Define all ajax cart functions
		add_filter('add_to_cart_fragments', array( $this, 'pp_refresh_minicart' ));

        add_action('wp_ajax_qty_cart', array( $this, 'pp_qty_cart' ));
        add_action('wp_ajax_nopriv_qty_cart', array( $this, 'pp_qty_cart' ));

        add_action( 'wp_ajax_product_remove', array( $this, 'pp_product_remove' ));
        add_action( 'wp_ajax_nopriv_product_remove', array( $this, 'pp_product_remove' ));

        add_action( 'wp_ajax_woocommerce_add_to_cart_variable_rc', array( $this, 'pp_add_to_cart_variable' ));
        add_action( 'wp_ajax_nopriv_woocommerce_add_to_cart_variable_rc', array( $this, 'pp_add_to_cart_variable' ));

        add_action( 'wp_ajax_calculate_shipping', array( $this, 'pp_calculate_shipping' ));
        add_action( 'wp_ajax_nopriv_calculate_shipping', array( $this, 'pp_calculate_shipping' ));
	}

    /**
	 * Hooks to all cart actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function initiate_hooks() {

        // Return the variables for the shop page
        add_action( 'woocommerce_after_shop_loop_item', array( $this, 'pp_variable_add_to_cart' ), 15 );

        // Change cart action when on checkout page
        remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'update_cart_action' ), 20 );
        add_action( 'wp_loaded', array( $this, 'pp_update_cart_action' ), 20 );

        // Change input labels to placeholder on checkout page
        add_filter('woocommerce_checkout_fields', array( $this, 'custom_wc_checkout_fields_no_label' ));

        // Remove the colon for the Free shipping
        add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'remove_local_pickup_free_label' ), 10, 2 );

        // Split the payment template and the review order
        add_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
        add_filter( 'woocommerce_checkout_order_payment', 'woocommerce_checkout_payment', 20 );

        // Redirect to checkout if cart is not empty
        add_action('template_redirect', array( $this, 'redirection_to_checkout' ));
    }

    /**
     * Update the item count for the cart icon
     *
     * @since 1.0
     *
     * @param array $fragments
     *
     * @return array
     */
	function pp_refresh_minicart($fragments) {
		global $woocommerce;
		ob_start(); ?>

        <span class="item-counter"><?php echo WC()->cart->cart_contents_count; ?></span>

		<?php
		$fragments['.cart .item-counter'] = ob_get_clean();

		return $fragments;
	}

    /**
    * Get the updated cart parts
    */
    function pp_get_refreshed_fragments($full_cart){
    	// Get mini cart
        ob_start();

        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        // Get the total items in the cart
        $items_cart_counter = WC()->cart->get_cart_contents_count();

        // Return parts of the cart if products are still in it
        if ($items_cart_counter != 0 && !$full_cart){

        	$redirect = false;

    	    // Text for the cart item subheadline
    	    $cart_subheadline = '<h6>' . __( sprintf( _n('You have %d item in your cart', 'You have %d items in your cart', $items_cart_counter, 'davis'), $items_cart_counter) ) . '</h6>';

    		$fragments = array(
            	'.widget_shopping_cart_content h6' => $cart_subheadline,
    			'.widget_shopping_cart .total .amount' => WC()->cart->get_cart_subtotal(),
    			'.cart .item-counter' => '<span class="item-counter">' . $items_cart_counter . '</span>'
    		);

        } else {

        	$redirect = home_url();

    	    $fragments = array(
            	'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
    			'.cart .item-counter' => '<span class="item-counter">' . $items_cart_counter . '</span>'
    		);

        }

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', $fragments ),
            'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() ),
            'redirect'		=> $redirect
        );

        wp_send_json( $data );
    }

    /**
    * Update the cart quantity with AJAX
    */
    function pp_qty_cart() {
        // Set item key as the hash found in input.qty's name
        $cart_item_key = $_POST['hash'];

        // Get the array of values owned by the product we're updating
        $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

        // Get the quantity of the item in the cart
        $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

        // Update cart validation
        $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

        // Update the quantity of the item in the cart
        if ( $passed_validation ) {
            WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
        }

        echo $this->pp_get_refreshed_fragments(false);

        die();

    }


    /**
    * Remove product with AJAX
    */
    function pp_product_remove() {

    	WC()->cart->set_quantity( $_POST['item_key'], 0, true );

        echo $this->pp_get_refreshed_fragments(false);

        die();
    }


    /**
    * AJAX add to cart variable
    */
    function pp_add_to_cart_variable() {

    	ob_start();

    	$product_id 		= apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
    	$quantity 			= empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
    	$variation_id 		= empty( $_POST['variation_id'] ) ? '' : $_POST['variation_id'];
    	$variation  		= empty( $_POST['variation'] ) ? '' : $_POST['variation'];
    	$passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

    	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
    		apply_filters('add_to_cart_fragments', array());

    		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
    			wc_add_to_cart_message( $product_id );
    		}

    		// Return fragments
    		$this->pp_get_refreshed_fragments( true );
    	} else {
    		$this->json_headers();

    		// If there was an error adding to the cart, redirect to the product page to show any errors
    		$data = array(
    			'error' => true,
    			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
    			);
    		echo json_encode( $data );
    	}
    	die();
    }


    /**
    * Output all the available variables
    */
    function pp_variable_add_to_cart($single_variation_product) {
        global $product;

        if ( !$product->is_type( 'variable' ) ){
            return false;
        }

        /*
    if ($product->variation_id){
    	    $product = get_product($product->parent->id);
    	    $single_variation_product = true;
        }
    */

        // Enqueue variation scripts
        wp_enqueue_script( 'wc-add-to-cart-variation' );

        // Get Available variations?
        $get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

        // Load the template
        wc_get_template( 'loop/variable.php', array(
            'available_variations' => $get_variations ? $product->get_available_variations() : false,
            'attributes'         => $product->get_variation_attributes(),
            'selected_attributes' => $product->get_variation_default_attributes(),
            'single_variation_product' => $single_variation_product
        ) );
    }


    /**
    * Ajax action to update the shipping methods
    */
    function pp_calculate_shipping() {
    	try {
          WC()->shipping->reset_shipping();

          $country  = wc_clean( $_POST['calc_shipping_country'] );
          $state    = wc_clean( isset( $_POST['calc_shipping_state'] ) ? $_POST['calc_shipping_state'] : '' );
          $postcode = wc_clean( isset( $_POST['calc_shipping_postcode'] ) ? $_POST['calc_shipping_postcode'] : '' );
          $city     = wc_clean( isset( $_POST['calc_shipping_city'] ) ? $_POST['calc_shipping_city'] : '' );
          $postcode = apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ? $postcode : '';
          $city     = apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ? $city : '';

          if ( $postcode && ! WC_Validation::is_postcode( $postcode, $country ) ) {
            throw new Exception( __( 'Please enter a valid postcode/ZIP.', 'woocommerce' ) );
          } elseif ( $postcode ) {
            $postcode = wc_format_postcode( $postcode, $country );
          }

          if ( $country ) {
            WC()->customer->set_location( $country, $state, $postcode, $city );
            WC()->customer->set_shipping_location( $country, $state, $postcode, $city );
          } else {
            WC()->customer->set_to_base();
            WC()->customer->set_shipping_to_base();
          }

          WC()->customer->calculated_shipping( true );

          echo do_action( 'woocommerce_calculated_shipping' );

        } catch ( Exception $e ) {
          if ( ! empty( $e ) ) {
            echo $e->getMessage();
          }
        }
    }


    /**
    * Change update cart action if on checkout page
    */
    function pp_update_cart_action() {

    	// Add Discount
    	if ( ! empty( $_POST['apply_coupon'] ) && ! empty( $_POST['coupon_code'] ) ) {
    		WC()->cart->add_discount( sanitize_text_field( $_POST['coupon_code'] ) );
    	}

    	// Remove Coupon Codes
    	elseif ( isset( $_GET['remove_coupon'] ) ) {
    		WC()->cart->remove_coupon( wc_clean( $_GET['remove_coupon'] ) );
    	}

    	// Remove from cart
    	elseif ( ! empty( $_GET['remove_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
    		$cart_item_key = sanitize_text_field( $_GET['remove_item'] );

    		if ( $cart_item = WC()->cart->get_cart_item( $cart_item_key ) ) {
    			WC()->cart->remove_cart_item( $cart_item_key );

    			$product = wc_get_product( $cart_item['product_id'] );

    			$item_removed_title = apply_filters( 'woocommerce_cart_item_removed_title', $product ? $product->get_title() : __( 'Item', 'woocommerce' ), $cart_item );

    			// Don't show undo link if removed item is out of stock.
    			if ( $product->is_in_stock() && $product->has_enough_stock( $cart_item['quantity'] ) ) {
    				$undo = WC()->cart->get_undo_url( $cart_item_key );
    				wc_add_notice( sprintf( __( '%s removed. %sUndo?%s', 'woocommerce' ), $item_removed_title, '<a href="' . esc_url( $undo ) . '">', '</a>' ) );
    			} else {
    				wc_add_notice( sprintf( __( '%s removed.', 'woocommerce' ), $item_removed_title ) );
    			}
    		}

    		$referer  = wp_get_referer() ? remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart' ), add_query_arg( 'removed_item', '1', WC()->cart->get_checkout_url() ) ) : WC()->cart->get_checkout_url();
    		wp_safe_redirect( $referer );
    		exit;
    	}

    	// Undo Cart Item
    	elseif ( ! empty( $_GET['undo_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
    		$cart_item_key = sanitize_text_field( $_GET['undo_item'] );

    		WC()->cart->restore_cart_item( $cart_item_key );

    		$referer  = wp_get_referer() ? remove_query_arg( array( 'undo_item', '_wpnonce' ), WC()->cart->get_checkout_url() ) : WC()->cart->get_checkout_url();
    		wp_safe_redirect( $referer );
    		exit;
    	}

    	// Update Cart - checks apply_coupon too because they are in the same form
    	if ( ( ! empty( $_POST['apply_coupon'] ) || ! empty( $_POST['update_cart'] ) || ! empty( $_POST['proceed'] ) ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-cart' ) ) {

    		$cart_updated = false;
    		$cart_totals  = isset( $_POST['cart'] ) ? $_POST['cart'] : '';

    		if ( ! WC()->cart->is_empty() && is_array( $cart_totals ) ) {
    			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

    				$_product = $values['data'];

    				// Skip product if no updated quantity was posted
    				if ( ! isset( $cart_totals[ $cart_item_key ] ) || ! isset( $cart_totals[ $cart_item_key ]['qty'] ) ) {
    					continue;
    				}

    				// Sanitize
    				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( "/[^0-9.]/", '', $cart_totals[ $cart_item_key ]['qty'] ) ), $cart_item_key );

    				if ( '' === $quantity || $quantity == $values['quantity'] )
    					continue;

    				// Update cart validation
    				$passed_validation 	= apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

    				// is_sold_individually
    				if ( $_product->is_sold_individually() && $quantity > 1 ) {
    					wc_add_notice( sprintf( __( 'You can only have 1 %s in your cart.', 'woocommerce' ), $_product->get_title() ), 'error' );
    					$passed_validation = false;
    				}

    				if ( $passed_validation ) {
    					WC()->cart->set_quantity( $cart_item_key, $quantity, false );
    					$cart_updated = true;
    				}

    			}
    		}

    		// Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable
    		$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', $cart_updated );

    		if ( $cart_updated ) {
    			// Recalc our totals
    			WC()->cart->calculate_totals();
    		}

    		// Check from where the form has been submitted
    		if ( strrpos($_POST['_wp_http_referer'],'cart') !== false ){
    			$referer_url = WC()->cart->get_cart_url();
    		} else {
    			$referer_url = WC()->cart->get_checkout_url();
    		}

    		if ( ! empty( $_POST['proceed'] ) ) {
    			wp_safe_redirect( WC()->cart->get_checkout_url() );
    			exit;
    		} elseif ( $cart_updated ) {

    			wc_add_notice( __( 'Cart updated.', 'woocommerce' ) );
    			$referer = remove_query_arg( 'remove_coupon', ( wp_get_referer() ? wp_get_referer() : $referer_url ) );
    			wp_safe_redirect( $referer );
    			exit;
    		}
    	}
    }


    /**
    * Add placeholder input fields instead of labels on checkout page
    */
    function custom_wc_checkout_fields_no_label($fields) {
        // loop by category
        foreach ($fields as $category => $value) {
            // loop by fields
            foreach ($fields[$category] as $field => $property) {
                // Add placeholder if none
                if ( ! isset( $fields[$category][$field]['placeholder'] ) ){
    	            $fields[$category][$field]['placeholder'] = $fields[$category][$field]['label'] . ( isset( $fields[$category][$field]['required'] ) ? '*' : '' );
    			}
            }
        }
         return $fields;
    }


    /**
     * Remove (free) and the semicolon on the shipping methods
     */
    function remove_local_pickup_free_label($label, $method){
        // Add the price at 0 for free shipping
        if ( strpos($method->id, 'free_shipping') !== false ) {
            $label .= '<span class="amount">' . get_woocommerce_currency_symbol() . '0</span>';
        }
        // Remove colon
        $label = str_replace(": ",'',$label);

    	return $label;
    }


    /**
     * Redirect to checkout if cart is not empty
     */
    function redirection_to_checkout(){
    	global $wp, $woocommerce, $woocommerce_active;

    	$quick_checkout = get_theme_mod('quick_checkout', true);

    	if ( $woocommerce_active ) {

    	    if ( is_cart() ){
    	    	wp_safe_redirect( get_home_url() . '#cart' );
    	    }

    	    if ( is_checkout() && $quick_checkout == true && empty( $_GET['ajax_request'] ) && ! is_wc_endpoint_url() ){
    	    	if ( WC()->cart->cart_contents_count !== 0 ){
    			    if ( ! empty( $_GET['wc_paypal_express_clear_session'] ) ) {
    					do_action( 'wp', array( 'WC_PayPal_Express', 'cancel_express_checkout' ) );
    				}
    				wp_safe_redirect( get_home_url() . '#checkout' );
    				exit;
    			} else {
    				wp_safe_redirect( get_home_url() . '#cart' );
    				exit;
    			}
    	    }

    	}
    }

}
