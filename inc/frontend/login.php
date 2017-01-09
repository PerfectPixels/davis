<?php
/**
* Class for all login/checkout modification
*
* @version 1.0
*/
class PP_Login {

    /**
	 * Construction function
	 *
	 * @since  1.0
	 * @return PP_Login
	 */
	function __construct() {

        // Execute the action only if the user isn't logged in
        if (!is_user_logged_in()) {
            // Logged the user
            add_action( 'wp_ajax_nopriv_ajaxlogin', array( $this, 'ajax_login' ) );
            // Create a registration
            add_action( 'wp_ajax_nopriv_ajaxregistration', array( $this, 'ajax_registration' ) );
        }

        // Lost password
        add_action( 'wp_ajax_nopriv_lost_pass', array( $this, 'lost_pass_callback' ) );
        add_action( 'wp_ajax_lost_pass', array( $this, 'lost_pass_callback' ) );

        // Redirect login
        add_action( 'template_redirect', array( $this, 'login_popup' ) );

        // Remove some actions to the thankyou page
        remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
    	add_filter( 'woocommerce_order_details', 'woocommerce_order_details_table', 10 );

	}

    /**
    * AJAX login
    */
    function ajax_login(){
        // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-login-nonce', 'security' );

        $username = $_POST['email'];

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
    		    	$order = new WC_Order( $order_id );

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
    	  $wp_hasher = new PasswordHash( 8, true );
    	}

    	$hashed = $wp_hasher->HashPassword( $key );

    	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

    	// Send email notification
    	WC()->mailer(); // load email classes
    	do_action( 'woocommerce_reset_password_notification', $user_login, $key );

    	echo json_encode(array('requestPwd'=>true, 'message'=>__('Check your email for the confirmation link', 'davis' )));

    	// return proper result
    	die();
    }

    /**
     * Redirect not logged in users to the login popup
     *
     */
    function login_popup(){
        global $woocommerce_active;

    	if ( $woocommerce_active ) {
    		if ( ! is_user_logged_in() && is_account_page() ) {
    			wp_redirect( home_url() . '?login=true&redirect=' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );
    			exit();
    		}
    	}
    }

    /**
     * Add/Remove some filter from the thank you page
     *
     */
    function remove_action_thankyou(){
    	remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
    	add_filter( 'woocommerce_order_details', 'woocommerce_order_details_table', 10 );
    }

}
