<?php
Kirki::add_section( 'section_checkout', array(
	'title'          => __( 'Checkout' ),
	'description' => __( 'The cart is being cached, make sure you empty the cache after updating any option in this section.', 'davis' ),
	'priority'       => 14,
	'capability'     => 'edit_theme_options',
) );
// Cart Title
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'checkout_cart_title',
	'label'    => __( 'Cart Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Cart Summary', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => 'aside.offcanvas-cart .cart-header h4',
			'function' => 'html',
		),
	)
) );
// Details Title
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_details_title',
	'label'    => __( 'Details Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Customer Details', 'davis' ),
) );
// Details Subtitle
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_details_subtitle',
	'label'    => __( 'Details Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Fill in your details in the form bellow', 'davis' ),
) );
// Shipping Title
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_shipping_title',
	'label'    => __( 'Shipping / Payment Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Shipping & Payment', 'davis' ),
) );
// Shipping Subtitle
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_shipping_subtitle',
	'label'    => __( 'Shipping / Payment Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Select your preferred shipping and payment methods', 'davis' ),
) );
// Review Title
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_review_title',
	'label'    => __( 'Review Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Review Order', 'davis' ),
) );
// Review Subtitle
Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_review_subtitle',
	'label'    => __( 'Review Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Confirm your cart content and the total of your order', 'davis' ),
) );
// Quick Checkout
Kirki::add_field( 'pp_theme', array(
	'settings' => 'quick_checkout',
	'label'    => __( 'Quick Checkout', 'davis' ),
	'description' => __( 'Choose if you want a quick checkout available on all pages instead of the default Woocommerce checkout page. PLEASE NOTE: Quick checkout was not tested with all existing plugins that adds/modifies the checkout process or layout. If you find any issues while using it please disable it.', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Enable', 'davis' ),
		'off' => esc_attr__( 'Disable', 'davis' ),
	),
) );
