<?php

namespace PP\Extras;

use PP\Setup;

/**
 * Change the loop title
 */

function custom_woocommerce_template_loop_product_title( $variationTmpl ) {
	global $product;

	$attributes = $product->get_attributes();
	$attr 		= sanitize_title( get_field( 'product_subtitle_by' ) );
	$attribute	= isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : '';
	$attribute	= isset( $attributes[ 'pa_' . $attr ] ) ? $attributes[ 'pa_' . $attr ] : '';
	$by_brand	= '<div class="product-subtitle">';

	if ( $attribute ){
		$attribute_name = $attribute['name'];
		$taxonomy = get_taxonomy( $attribute_name );
		$archive_link = '';

		if ( $taxonomy && ! is_wp_error( $taxonomy ) ) {
			$terms = wp_get_post_terms( $product->id, $attribute_name );

	        if ( ! empty( $terms ) ) {
		        foreach ( $terms as $term ) {
		        	$archive_link .= '<a href="' . get_term_link( $term->slug, $attribute_name ) . '">' . $term->name . '</a>';
		        }
	        }

	    }

		$by_brand .= '<span class="subtitle-by"><i>' . __('by', 'davis' ) . '</i> ' . $archive_link . '</span>';
	}

	// Show number of variations if product has children
	if ( $variationTmpl !== null ){
		$by_brand .= $variationTmpl;
	}

	$by_brand .= '</div>';

	echo '<h3>' . get_the_title() . $by_brand . '</h3>';

}

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title',  __NAMESPACE__ . '\\custom_woocommerce_template_loop_product_title', 10 );


/**
 * Add <body> classes
 */
function body_class($classes) {
	// Add page slug if it doesn't exist
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array(basename(get_permalink()), $classes)) {
		  	$classes[] = basename(get_permalink());
		}
	}

	// Add class if sidebar is active
	if (Setup\display_sidebar()) {
		$classes[] = 'sidebar-primary';
	}

	return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');


/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'davis') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Get the wishlists submenu
 */
function get_wishlist_items($type) {
	$lists = '';
	$wishlist_menu = '<ul class="dropdown-menu">';
	$total_items = 0;
	$counter = 0;

	if ( class_exists('WC_Wishlists_wishlist') ) :
		$lists = \WC_Wishlists_User::get_wishlists();

		foreach ( $lists as $list ) {
	  		$items = \WC_Wishlists_Wishlist_Item_Collection::get_items( $list->id );
			$wishlist_items = sizeof($items);
			$counter++;

			$wishlist_menu .= '<li class="animation-delay-'.$counter.'"><a href="' .$list->post->guid.$list->post->ID. '">' .$list->post->post_title. '<span class="wishlist-counter">' .$wishlist_items. '</span></a></li>';

			$total_items += $wishlist_items;
		}

	elseif ( class_exists('YITH_WCWL') ) :

		if ( ! class_exists('YITH_WCWL_Premium') && $type !== 'total_items' ) {
			return;
		}

		$lists = \YITH_WCWL()->get_wishlists();
		$token = false;

		if ( is_user_logged_in() ){
			$token = $list['wishlist_token'];
		}

		foreach ( $lists as $list ) {
	  	$wishlist_items = \YITH_WCWL()->count_products( $token );
			$counter++;
			$wl_name = $list['wishlist_name'];
			$wl_url = '';

			if ($wl_name == '' || $wl_name == null){
				$wl_name = __('Wishlist', 'davis');
			}

			$wishlist_menu .= '<li class="animation-delay-'.$counter.'"><a href="' .$wl_url. '">' .$wl_name. '<span class="wishlist-counter">' .$wishlist_items. '</span></a></li>';

			$total_items += $wishlist_items;
		}
	endif;

	$wishlist_menu .= '</ul>';

	if (empty($lists)){ $wishlist_menu = '' ; }

	if ($type === 'total_items'){
		return $total_items;
	} else {
  	return $wishlist_menu;
	}
}
add_filter('get_wishlist_items', __NAMESPACE__ . '\\get_wishlist_items');

/**
* WooCommerce Update Number of Items in the cart
*/
function pp_ajax_added_to_cart() {
	function pp_refresh_minicart($fragments) {
		global $woocommerce;
		ob_start(); ?>

        <span class="item-counter"><?php echo \WC()->cart->cart_contents_count; ?></span>

		<?php
		$fragments['.cart .item-counter'] = ob_get_clean();

		return $fragments;
	}
	add_filter('add_to_cart_fragments', __NAMESPACE__ . '\\pp_refresh_minicart');
}
add_action('woocommerce_ajax_added_to_cart', __NAMESPACE__ . '\\pp_ajax_added_to_cart');

/**
* Get the updated cart parts
*/
function pp_get_refreshed_fragments($full_cart){
	// Get mini cart
    ob_start();

    \woocommerce_mini_cart();

    $mini_cart = ob_get_clean();

    // Get the total items in the cart
    $items_cart_counter = \WC()->cart->get_cart_contents_count();

    // Return parts of the cart if products are still in it
    if ($items_cart_counter != 0 && !$full_cart){

    	$redirect = false;

	    // Text for the cart item subheadline
	    $cart_subheadline = '<h6>' . __( sprintf(ngettext('You have %d item in your cart', 'You have %d items in your cart', $items_cart_counter), $items_cart_counter), 'davis' ) . '</h6>';

		$fragments = array(
        	'.widget_shopping_cart_content h6' => $cart_subheadline,
			'.widget_shopping_cart .total .amount' => \WC()->cart->get_cart_subtotal(),
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
        'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', \WC()->cart->get_cart_for_session() ? md5( json_encode( \WC()->cart->get_cart_for_session() ) ) : '', \WC()->cart->get_cart_for_session() ),
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
    $threeball_product_values = \WC()->cart->get_cart_item( $cart_item_key );

    // Get the quantity of the item in the cart
    $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

    // Update cart validation
    $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

    // Update the quantity of the item in the cart
    if ( $passed_validation ) {
        \WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
    }

    echo pp_get_refreshed_fragments(false);

    die();

}
add_action('wp_ajax_qty_cart', __NAMESPACE__ . '\\pp_qty_cart');
add_action('wp_ajax_nopriv_qty_cart', __NAMESPACE__ . '\\pp_qty_cart');

/**
* Remove product with AJAX
*/
function pp_product_remove() {

	\WC()->cart->set_quantity( $_POST['item_key'], 0, true );

    echo pp_get_refreshed_fragments(false);

    die();
}
add_action( 'wp_ajax_product_remove', __NAMESPACE__ . '\\pp_product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', __NAMESPACE__ . '\\pp_product_remove' );

/**
* Function to call the woocommerce breadcrumbs
*/
function pp_woocommerce_breadcrumb(){
    woocommerce_breadcrumb();
}
add_action( 'woo_custom_breadcrumb', __NAMESPACE__ . '\\pp_woocommerce_breadcrumb' );

/**
* AJAX login
*/
function ajax_login(){
	$username = $_POST['email'];

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Check if the username is an email
    if (strpos('@', $username) !== false){
	    $username = explode("@",$username);
		$username = $username[0];
    }

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $username;
    $info['user_password'] = $_POST['password'];
    $info['remember'] = $_POST['remember'];

	//$user_signon = wp_signon($info, is_ssl() ? true : false);
    $user_signon = wp_signon( $info );

    if ( is_wp_error($user_signon) ){
    	if (strpos('Invalid username', $user_signon->get_error_message()) !== false){
	        echo json_encode(array('successful'=>false, 'message'=>__( 'We cannot find any account with this email address', 'davis' )));
		} else {
			echo json_encode(array('successful'=>false, 'message'=>__( 'Your password is incorrect', 'davis' )));
		}
    } else {
        echo json_encode(array('successful'=>true, 'message'=>__( 'You are now logged in', 'davis' )));
    }

    die();
}
// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action( 'wp_ajax_nopriv_ajaxlogin', __NAMESPACE__ . '\\ajax_login' );
}

/**
* AJAX Registration
*/
function ajax_registration(){
	global $wpdb;

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-registration-nonce', 'security' );

    $regemail = $_POST['email'];
	$regpassword = $_POST['password'];
	$order_id = $_POST['order_id'];

	if( $regemail === '' || !$regemail ){
		echo json_encode( array( 'successful' => false, 'message' => __( 'Please enter email address', 'davis' ) ) );
	} else if( $regpassword === '' || !$regpassword ){
		echo json_encode( array( 'successful' => false, 'message' => __( 'Please enter password', 'davis' ) ) );
	} else {
		if ( email_exists( $regemail ) == false ) {
			$user_id = wp_create_user( $regemail, $regpassword, $regemail );

		    //$user_signon = wp_signon(array( 'user_login' => $regusername, 'user_password' => $regpassword, 'remember' => false ), is_ssl() ? true : false);
		    $user_signon = wp_signon( array( 'user_login' => $regemail, 'user_password' => $regpassword, 'remember' => false ) );

		    if ( $order_id != '' ){
		    	$order = new \WC_Order( $order_id );

		    	update_user_meta( $user_id, "billing_first_name", $order->billing_first_name );
		    	update_user_meta( $user_id, "billing_last_name", $order->billing_last_name );
		    	update_user_meta( $user_id, "billing_company", $order->billing_company );
		    	update_user_meta( $user_id, "billing_address_1", $order->billing_address_1 );
		    	update_user_meta( $user_id, "billing_address_2", $order->billing_address_2 );
		    	update_user_meta( $user_id, "billing_city", $order->billing_city );
		    	update_user_meta( $user_id, "billing_postcode", $order->billing_postcode );
		    	update_user_meta( $user_id, "billing_country", $order->billing_country );
		    	update_user_meta( $user_id, "billing_state", $order->billing_state );
		    	update_user_meta( $user_id, "billing_email", $order->billing_email );
		    	update_user_meta( $user_id, "billing_phone", $order->billing_phone );

		    	update_user_meta( $user_id, "shipping_first_name", $order->shipping_first_name );
		    	update_user_meta( $user_id, "shipping_last_name", $order->shipping_last_name );
		    	update_user_meta( $user_id, "shipping_company", $order->shipping_company );
		    	update_user_meta( $user_id, "shipping_address_1", $order->shipping_address_1 );
		    	update_user_meta( $user_id, "shipping_address_2", $order->shipping_address_2 );
		    	update_user_meta( $user_id, "shipping_city", $order->shipping_city );
		    	update_user_meta( $user_id, "shipping_postcode", $order->shipping_postcode );
		    	update_user_meta( $user_id, "shipping_country", $order->shipping_country );
		    	update_user_meta( $user_id, "shipping_state", $order->shipping_state );

			    $wpdb->query( "UPDATE $wpdb->postmeta SET meta_value = $user_id WHERE post_id = $order_id AND meta_key LIKE '_customer_user'" );

		    }

			echo json_encode( array( 'successful' => true, 'message' => __( "Successfully registered! You are now logged in", 'davis' ) ) );
		} else {
			echo json_encode( array( 'successful' => false, 'message' => __( 'Email address already registered', 'davis' ) ) );
		}
	}

	die();
}
// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action( 'wp_ajax_nopriv_ajaxregistration', __NAMESPACE__ . '\\ajax_registration' );
}

/**
* AJAX Lost Password
*/
function lost_pass_callback() {

	global $wpdb, $wp_hasher;

	// First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-forgot-nonce', 'security' );

	$login = trim( $_POST['email'] );

	if ( empty( $login ) ) {

	  echo json_encode(array('successful'=>false, 'message'=>__('Enter an email address', 'davis' )));
	  die();

	} else {
	  // Check on username first, as customers can use emails as usernames.
	  $user_data = get_user_by( 'login', $login );
	}

	// If no user found, check if it login is email and lookup user based on email.
	if ( ! $user_data && is_email( $login ) && apply_filters( 'woocommerce_get_username_from_email', true ) ) {
	  $user_data = get_user_by( 'email', $login );
	}

	do_action( 'lostpassword_post' );

	if ( ! $user_data ) {
	  echo json_encode(array('successful'=>false, 'message'=>__('Invalid email address', 'davis' )));
	  die();
	}

	if ( is_multisite() && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
	  echo json_encode(array('successful'=>false, 'message'=>__('Invalid email address', 'davis' )));
	  die();
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;

	do_action( 'retrieve_password', $user_login );

	$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	if ( ! $allow ) {

	  echo json_encode(array('successful'=>false, 'message'=>__('Password reset is not allowed for this user', 'davis' )));
	  die();

	} elseif ( is_wp_error( $allow ) ) {

	  echo json_encode(array('successful'=>false, 'message'=>$allow->get_error_message()));
	  die();
	}

	$key = wp_generate_password( 20, false );

	do_action( 'retrieve_password_key', $user_login, $key );

	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
	  require_once ABSPATH . 'wp-includes/class-phpass.php';
	  $wp_hasher = new \PasswordHash( 8, true );
	}

	$hashed = $wp_hasher->HashPassword( $key );

	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

	// Send email notification
	\WC()->mailer(); // load email classes
	do_action( 'woocommerce_reset_password_notification', $user_login, $key );

	echo json_encode(array('requestPwd'=>true, 'message'=>__('Check your email for the confirmation link', 'davis' )));

	// return proper result
	die();
}
add_action( 'wp_ajax_nopriv_lost_pass', __NAMESPACE__ . '\\lost_pass_callback' );
add_action( 'wp_ajax_lost_pass', __NAMESPACE__ . '\\lost_pass_callback' );

/**
* Change the default Woocommerce thumbnail for products archive
*/
/**
 * WooCommerce Loop Product Thumbs
 **/
function pp_template_loop_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post, $product, $woocommerce;

	$size = 'shop_catalog';
	$image_size = wc_get_image_size( 'shop_catalog' );
	$available_variations = array();
	$created_variations = array();
	$terms = get_the_terms($post->ID, 'pa_colors');
	$product_colors = null;
	$output = null;
	$variations_slider = false;

	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			$product_colors .= $term->slug . ',';
		}

		$product_colors = trim( $product_colors, ',' );
	}

	// Product variations
	if ( $product->is_type( 'variable' ) ){ $available_variations = $product->get_available_variations(); }

	// Image size
	if ( ! $placeholder_width ){ $placeholder_width = $image_size['width']; }
	if ( ! $placeholder_height ){ $placeholder_height = $image_size['height']; }

	// Check if the variations product slider is enabled
	if ( get_field('variations_slider') === 'yes' || get_field('variations_slider') === 'default' && get_theme_mod('shop_variations_slider', false) ){
		$variations_slider = true;
	}

	if ( sizeof( $available_variations ) > 0 ){

		if ( $variations_slider ){
			$output = '<div class="product-slider" data-product_variations="' . htmlspecialchars( json_encode( $available_variations ) ) . '">';
		}

		foreach ($available_variations as $variation){
			// Check if attritube is variations or sizes only
			$data_counter = 0;
			$attributes = '?';
			$data_attr = '';
			$sales = '';
			$stock_class = '';
			$exist = true;
			$first_attr = current(array_keys( $variation['attributes'] ));
			$image_ids = get_post_meta( $variation['variation_id'], '_wc_additional_variation_images', true );
			$image_ids = explode( ',', $image_ids );
			$product_colors = get_post_meta($variation['variation_id'], '_jck_product_colors', true);
			$attachment_id = get_post_thumbnail_id( $variation['variation_id'] );
			$attachment = wp_get_attachment_image_src( $attachment_id, $size );
			$img_src = wp_get_attachment_image_url( $attachment_id, $size );
			$img_srcset = wp_get_attachment_image_srcset( $attachment_id, $size );
			$img_sizes = wp_get_attachment_image_sizes( $attachment_id, $size );

			// Register the attributes to check against if it already exist
			if ( array_key_exists( $first_attr, $variation['attributes'] ) ) {
				$attr = $variation['attributes'][$first_attr];

				if ( ! in_array($attr, $created_variations, true) && $img_src ) {
					$exist = false;
					array_push( $created_variations, $attr );
				}
			}

			// Create all attributes variation for the URL
			foreach ($variation['attributes'] as $key => $attribute ){
				$attributes .= $key.'='.$attribute.'&';
			}

			// Display all attributes to add them in the data-attr in the html
			foreach ($variation['attributes'] as $key => $attribute ){
				$data_counter++;
				if ( !$variations_slider ){ $attribute = ''; }
				$data_attr .= ' data-attr-name-' . $data_counter . '="' . $key.'" data-attr-value-' . $data_counter . '="' . $attribute . '"';
			}

			$variation_url = get_permalink() . trim($attributes, '&');

			// Product on sale/out of stock
			$sales = '<div class="badges">';

				if ( !$variation['is_in_stock'] == 1 ) {
					$sales .= '<span class="out-of-stock">' . __( 'Out of stock', 'woocommerce' ) . '</span>';
					$stock_class = 'data-stock-class="false"';
				}
				if ( $product->is_on_sale() && $variation['display_price'] !== $variation['display_regular_price'] ) {
					$sales .= '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>';
				}

			$sales .= '</div>';

			if ( !$exist && $variation['variation_is_visible'] == 1 && $variation['is_purchasable'] == 1 && $variations_slider ){
				$output .= '<div>' . $sales . $variation['price_html'];

				$output .= '<a href="' . $variation_url . '" class="img"' .$stock_class . ' data-colors="'. $product_colors .'" data-variation-id="'.$variation['variation_id'].'" data-product-id="' . $post->ID .'"' . $data_attr . ' data-attr-counter="' . $data_counter . '">' . /* wp_get_attachment_image( $post->ID, $size, $thumb_attr ); */ '<img src="' .esc_url( $img_src ) . '" class="attachment-'.$size.'" srcset="' . esc_attr( $img_srcset ) . '" sizes="' .$img_sizes .'" title="' .$variation['image_title'] . '">';

				// If it has another variation image
				if ( count( $image_ids > 0 ) ) {
					foreach( $image_ids as $id ) {
						$thumb_attr = array(
							'class'	=> "additional-img",
							'alt'	=> get_post_meta( get_post_thumbnail_id( $id ) , '_wp_attachment_image_alt', true),
							'title'	=> $variation['image_title'],
						);

						$output .= wp_get_attachment_image( $id, $size, false, $thumb_attr );
						continue;
					}
				}

				$output .= '</a></div>';
			}
		}

		if ( $variations_slider ){
			$output .= '</div>'; // Closing of product-slider
		}

		if ( !$variations_slider ){
			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'" data-variation-id="'.$variation['variation_id'].'" data-product-id="' . $post->ID .'"' . $data_attr . ' data-attr-counter="' . $data_counter . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';
		}

	} else {
		if ( has_post_thumbnail() ) {

			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';

		} else {

			$output .= '<a href="' . get_permalink() . '" class="img" data-colors="'. $product_colors .'"><img class="" src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" /></a>	';

		}
	}

	echo $output;
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', __NAMESPACE__ . '\\pp_template_loop_product_thumbnail', 10);


/**
* AJAX add to cart variable
*/
function pp_add_to_cart_variable() {

	ob_start();

	$product_id 		= apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity 			= empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	$variation_id 		= empty( $_POST['variation_id'] ) ? '' : $_POST['variation_id'];
	$variation  		= $_POST['variation'];
	$passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
			wc_add_to_cart_message( $product_id );
		}

		// Return fragments
		pp_get_refreshed_fragments( true );
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
add_action( 'wp_ajax_woocommerce_add_to_cart_variable_rc', __NAMESPACE__ . '\\pp_add_to_cart_variable' );
add_action( 'wp_ajax_nopriv_woocommerce_add_to_cart_variable_rc', __NAMESPACE__ . '\\pp_add_to_cart_variable' );


/**
* Output all the available variables
*/
function pp_variable_add_to_cart($single_variation_product) {
    global $product;

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
add_filter( 'pp_variable_add_to_cart', __NAMESPACE__ . '\\pp_variable_add_to_cart', 10 );


/**
* Ajax action to update the shipping methods
*/
function pp_calculate_shipping() {
	try {
      \WC()->shipping->reset_shipping();

      $country  = wc_clean( $_POST['calc_shipping_country'] );
      $state    = wc_clean( isset( $_POST['calc_shipping_state'] ) ? $_POST['calc_shipping_state'] : '' );
      $postcode = apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ? wc_clean( $_POST['calc_shipping_postcode'] ) : '';
      $city     = apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ? wc_clean( $_POST['calc_shipping_city'] ) : '';

      if ( $postcode && ! WC_Validation::is_postcode( $postcode, $country ) ) {
        throw new Exception( __( 'Please enter a valid postcode/ZIP.', 'woocommerce' ) );
      } elseif ( $postcode ) {
        $postcode = wc_format_postcode( $postcode, $country );
      }

      if ( $country ) {
        \WC()->customer->set_location( $country, $state, $postcode, $city );
        \WC()->customer->set_shipping_location( $country, $state, $postcode, $city );
      } else {
        \WC()->customer->set_to_base();
        \WC()->customer->set_shipping_to_base();
      }

      \WC()->customer->calculated_shipping( true );

      echo do_action( 'woocommerce_calculated_shipping' );

    } catch ( Exception $e ) {
      if ( ! empty( $e ) ) {
        echo $e->getMessage();
      }
    }
}
add_action( 'wp_ajax_calculate_shipping', __NAMESPACE__ . '\\pp_calculate_shipping' );
add_action( 'wp_ajax_nopriv_calculate_shipping', __NAMESPACE__ . '\\pp_calculate_shipping' );


/**
* Change update cart action if on checkout page
*/
function pp_update_cart_action(){

	// Add Discount
	if ( ! empty( $_POST['apply_coupon'] ) && ! empty( $_POST['coupon_code'] ) ) {
		\WC()->cart->add_discount( sanitize_text_field( $_POST['coupon_code'] ) );
	}

	// Remove Coupon Codes
	elseif ( isset( $_GET['remove_coupon'] ) ) {
		\WC()->cart->remove_coupon( wc_clean( $_GET['remove_coupon'] ) );
	}

	// Remove from cart
	elseif ( ! empty( $_GET['remove_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
		$cart_item_key = sanitize_text_field( $_GET['remove_item'] );

		if ( $cart_item = \WC()->cart->get_cart_item( $cart_item_key ) ) {
			\WC()->cart->remove_cart_item( $cart_item_key );

			$product = wc_get_product( $cart_item['product_id'] );

			$item_removed_title = apply_filters( 'woocommerce_cart_item_removed_title', $product ? $product->get_title() : __( 'Item', 'woocommerce' ), $cart_item );

			// Don't show undo link if removed item is out of stock.
			if ( $product->is_in_stock() && $product->has_enough_stock( $cart_item['quantity'] ) ) {
				$undo = \WC()->cart->get_undo_url( $cart_item_key );
				wc_add_notice( sprintf( __( '%s removed. %sUndo?%s', 'woocommerce' ), $item_removed_title, '<a href="' . esc_url( $undo ) . '">', '</a>' ) );
			} else {
				wc_add_notice( sprintf( __( '%s removed.', 'woocommerce' ), $item_removed_title ) );
			}
		}

		$referer  = wp_get_referer() ? remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart' ), add_query_arg( 'removed_item', '1', \WC()->cart->get_checkout_url() ) ) : \WC()->cart->get_checkout_url();
		wp_safe_redirect( $referer );
		exit;
	}

	// Undo Cart Item
	elseif ( ! empty( $_GET['undo_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
		$cart_item_key = sanitize_text_field( $_GET['undo_item'] );

		\WC()->cart->restore_cart_item( $cart_item_key );

		$referer  = wp_get_referer() ? remove_query_arg( array( 'undo_item', '_wpnonce' ), \WC()->cart->get_checkout_url() ) : \WC()->cart->get_checkout_url();
		wp_safe_redirect( $referer );
		exit;
	}

	// Update Cart - checks apply_coupon too because they are in the same form
	if ( ( ! empty( $_POST['apply_coupon'] ) || ! empty( $_POST['update_cart'] ) || ! empty( $_POST['proceed'] ) ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-cart' ) ) {

		$cart_updated = false;
		$cart_totals  = isset( $_POST['cart'] ) ? $_POST['cart'] : '';

		if ( ! \WC()->cart->is_empty() && is_array( $cart_totals ) ) {
			foreach ( \WC()->cart->get_cart() as $cart_item_key => $values ) {

				$_product = $values['data'];

				// Skip product if no updated quantity was posted
				if ( ! isset( $cart_totals[ $cart_item_key ] ) || ! isset( $cart_totals[ $cart_item_key ]['qty'] ) ) {
					continue;
				}

				// Sanitize
				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( "/[^0-9\.]/", '', $cart_totals[ $cart_item_key ]['qty'] ) ), $cart_item_key );

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
					\WC()->cart->set_quantity( $cart_item_key, $quantity, false );
					$cart_updated = true;
				}

			}
		}

		// Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable
		$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', $cart_updated );

		if ( $cart_updated ) {
			// Recalc our totals
			\WC()->cart->calculate_totals();
		}

		// Check from where the form has been submitted
		if ( strrpos($_POST['_wp_http_referer'],'cart') !== false ){
			$referer_url = \WC()->cart->get_cart_url();
		} else {
			$referer_url = \WC()->cart->get_checkout_url();
		}

		if ( ! empty( $_POST['proceed'] ) ) {
			wp_safe_redirect( \WC()->cart->get_checkout_url() );
			exit;
		} elseif ( $cart_updated ) {

			wc_add_notice( __( 'Cart updated.', 'woocommerce' ) );
			$referer = remove_query_arg( 'remove_coupon', ( wp_get_referer() ? wp_get_referer() : $referer_url ) );
			wp_safe_redirect( $referer );
			exit;
		}
	}
}
remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'update_cart_action' ), 20 );
add_action( 'wp_loaded', __NAMESPACE__ . '\\pp_update_cart_action' , 20 );


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
add_filter('woocommerce_checkout_fields', __NAMESPACE__ . '\\custom_wc_checkout_fields_no_label');


/**
 * Remove (free) and the semicolon on the shipping methods
 */
function remove_local_pickup_free_label($full_label, $method){
    $full_label = str_replace(" (Free)",'<span class="amount">' . get_woocommerce_currency_symbol() . '0</span>',$full_label);
    $full_label = str_replace(": ",'',$full_label);

	return $full_label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', __NAMESPACE__ . '\\remove_local_pickup_free_label', 10, 2 );


/**
 * Split the payment template and the review order
 */
add_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_filter( 'woocommerce_checkout_order_payment', 'woocommerce_checkout_payment', 20 );


/**
 * Split the loop before shop template
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_filter( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20);


/**
 * Remove the a tag around the product
 */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);


/**
 * Change the tax_query for last cat pages to only display single variation products
 */
if ( class_exists( 'JCK_WSSV' ) ) {
	add_filter( 'pre_get_posts', array( 'pp_Exclude_Variable', 'apply_user_filters' ), 900000 );
	remove_filter( 'pre_get_posts', array( 'BeRocket_AAPF', 'apply_user_filters' ), 900000 );
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
	    	if ( \WC()->cart->cart_contents_count !== 0 ){
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
add_action('template_redirect', __NAMESPACE__ . '\\redirection_to_checkout');


/**
* Retina Ajax call
 */
function pffwc_get_srcset_callback() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'pffwc-nonce') ) {
		wp_die();
	}
	$method = wr2x_getoption( 'method', 'wr2x_advanced', 'Picturefill' );
	if ( $method == 'Picturefill' ) {
		$retina_url = wr2x_get_retina_from_url( $_POST['src'] );
		$retina_url = apply_filters( 'wr2x_img_retina_url', $retina_url );
		if ( $retina_url != null ) {
			$retina_url = wr2x_cdn_this( $retina_url );
			$img_url = wr2x_cdn_this( $_POST['src'] );
			$img_url  = apply_filters( 'wr2x_img_url', $img_url );
			echo  "$img_url, $retina_url 2x";
		} else {
			echo $_POST['src'];
		}
	}
	wp_die();
}
add_action( 'wp_ajax_get_srcset', __NAMESPACE__ . '\\pffwc_get_srcset_callback' );
add_action( 'wp_ajax_nopriv_get_srcset', __NAMESPACE__ . '\\pffwc_get_srcset_callback' );


/**
 * Get a coupon value.
 *
 * @access public
 * @param string $coupon
 */
function pp_cart_totals_coupon_html( $coupon ) {
    if ( is_string( $coupon ) ) {
        $coupon = new \WC_Coupon( $coupon );
    }

    $value  = array();

    if ( $amount = \WC()->cart->get_coupon_discount_amount( $coupon->code, \WC()->cart->display_cart_ex_tax ) ) {
        $discount_html = wc_price( $amount );
    } else {
        $discount_html = '';
    }

    $value[] = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_html, $coupon );

    if ( $coupon->enable_free_shipping() ) {
        $value[] = __( 'Free shipping', 'woocommerce' );
    }

    // get rid of empty array elements
    $value = array_filter( $value );
    $value = implode( ', ', $value ) . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', urlencode( $coupon->code ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="pp-remove-coupon" data-coupon="' . esc_attr( $coupon->code ) . '"></a>';

    echo apply_filters( 'woocommerce_cart_totals_coupon_html', $value, $coupon );
}


/**
 * Remove some action from the Single Variation Product plugin
 *
 */
function remove_action_single_var(){
	global $jck_wssv;

	if( is_admin() ) {

	    remove_action( 'woocommerce_product_after_variable_attributes',  array( $jck_wssv, 'add_variation_additional_fields' ), 10 );
	    remove_action( 'woocommerce_save_product_variation', array( $jck_wssv, 'save_product_variation' ), 10 );
	    remove_action( 'woocommerce_save_product_variation', array( $jck_wssv, 'add_taxonomies_to_variation' ), 10 );

	} else {

		remove_action( 'wp_enqueue_scripts', array( $jck_wssv, 'frontend_scripts' ) );
	    remove_action( 'wp_enqueue_scripts', array( $jck_wssv, 'frontend_styles' ) );
		remove_action( 'woocommerce_product_query', array( $jck_wssv, 'add_variations_to_product_query' ), 50 );

	}
}

add_action( 'init', __NAMESPACE__ . '\\remove_action_single_var', 11 );


/**
 * Get product review children comment count
 *
 */
function wc_product_reviews_pro_get_children_comment_count( $comment_id ) {

	global $wpdb;

	$count = $wpdb->get_var( $wpdb->prepare( "
	  SELECT COUNT(comment_ID) FROM $wpdb->comments
	  WHERE comment_parent = %d
	  AND comment_approved = '1'
	  AND comment_type = 'contribution_comment'
	", $comment_id ) );

	return intval( $count );
}

// Check page URL
function URL_has( $url_part ){
	$url = $_SERVER['REQUEST_URI'];

	 return strpos( $url, $url_part );
}


/**
 * Add/Remove some filter from the thank you page
 *
 */
function remove_action_thankyou(){
	remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
	add_filter( 'woocommerce_order_details', 'woocommerce_order_details_table', 10 );
}

add_action( 'init', __NAMESPACE__ . '\\remove_action_thankyou', 10 );


/**
 * Redirect not logged in users to the login popup
 *
 */
function login_popup(){
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		if ( ! is_user_logged_in() && is_account_page() ) {
			wp_redirect( home_url() . '?login=true&redirect=' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );
			exit();
		}
	}
}

add_action( 'template_redirect', __NAMESPACE__ . '\\login_popup' );


/**
 * Change number of products per row
 */
if ( ! function_exists('loop_columns') ) {
	function loop_columns() {
		$product_per_row = get_theme_mod( 'product_per_row', '4' );

		return $product_per_row;
	}
}

add_filter('loop_shop_columns', __NAMESPACE__ . '\\loop_columns');


/**
 * Position the star rating after the price
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );


/**
 * Remove Result count to the archive page - Add new action to use in base.php
 */
remove_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20 );
add_filter( 'main_result_count', 'woocommerce_result_count', 20 );


// Change the position of the YITH wishlist button
add_action( 'woocommerce_after_add_to_cart_button', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 10 );

?>
