<?php

global $transport;

// ACCOUNT
Kirki::add_section( 'cart_element', array(
    'title'          => __( 'Cart', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Style of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-buttonset',
	'settings'    => 'cart_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'cart_element',
	'default'     => 'icon',
	'priority'    => 10,
	'choices'     => array(
		'icon-only'   	 => esc_attr__( 'Icon Only', 'davis' ),
		'icon-label' => esc_attr__( 'Icon with Label', 'davis' ),
		'label-only'  	 => esc_attr__( 'Label Only', 'davis' ),
	),
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'cart_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'cart_element',
	'default'     => 'icon-shopping-bag',
	'priority'    => 10,
	'choices'     => array(
		'icon-shopping-bag'                 => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag.svg',
		'icon-shopping-bag-2'               => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag-2.svg',
		'icon-shopping-bag-3'               => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag-3.svg',
		'icon-shopping-basket'              => get_template_directory_uri() . '/assets/images/admin/icon-shopping-basket.svg',
		'icon-shopping-basket-2'            => get_template_directory_uri() . '/assets/images/admin/icon-shopping-basket-2.svg',
		'icon-shopping-cart'                => get_template_directory_uri() . '/assets/images/admin/icon-shopping-cart.svg',
		'icon-shopping-cart-2'              => get_template_directory_uri() . '/assets/images/admin/icon-shopping-cart-2.svg',
		'icon-shopping-bag-outline'         => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag-outline.svg',
		'icon-shopping-bag-2-outline'       => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag-2-outline.svg',
		'icon-shopping-bag-3-outline'       => get_template_directory_uri() . '/assets/images/admin/icon-shopping-bag-3-outline.svg',
		'icon-shopping-basket-outline'      => get_template_directory_uri() . '/assets/images/admin/icon-shopping-basket-outline.svg',
		'icon-shopping-basket-2-outline'    => get_template_directory_uri() . '/assets/images/admin/icon-shopping-basket-2-outline.svg',
		'icon-shopping-cart-outline'        => get_template_directory_uri() . '/assets/images/admin/icon-shopping-cart-outline.svg',
		'icon-shopping-cart-2-outline'      => get_template_directory_uri() . '/assets/images/admin/icon-shopping-cart-2-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'cart_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
    'js_vars'  => array(
        array(
            'element'  => array( '.offcanvas-cart.empty .cart-container .cart-wrapper .empty' ),
            'function' => 'css',
            'property' => 'background-image',
            'value_pattern'   => 'url(' . get_stylesheet_directory_uri() . '/assets/images/admin/$-outline.svg)',
        ),
    ),
    'output' => array(
        array(
            'element'  => array( '.offcanvas-cart.empty .cart-container .cart-wrapper .empty' ),
            'property' => 'background-image',
            'value_pattern'   => 'url(' . get_stylesheet_directory_uri() . '/assets/images/admin/$-outline.svg)',
        ),
    ),
) );
// Label
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'text',
	'settings' => 'cart_label',
	'label'    => __( 'Label', 'davis' ),
	'section'  => 'cart_element',
	'default'  => esc_attr__( 'Cart', 'davis' ),
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'cart_style',
			'operator' => '!=',
			'value'    => 'icon-only',
		),
	),
    'js_vars'   => array(
        array(
            'element'  => '.action-button.cart a span',
            'function' => 'html',
        ),
    )
) );

function pp_element_cart_partials( WP_Customize_Manager $wp_customize ) {
    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'cart_element', array(
        'selector' => 'li.action-button.cart',
        'container_inclusive' => true,
        'settings' => array( 'cart_style', 'cart_icon_style' ),
        'render_callback' => function() {
            return get_template_part( 'template-parts/header/elements/cart' );
        },
    ) );
}
add_action( 'customize_register', 'pp_element_cart_partials' );
