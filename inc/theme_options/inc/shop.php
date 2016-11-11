<?php

// Add the Shop panel
TC_Kirki::add_panel( 'panel_shop', array(
    'priority'    => 10,
    'title'       => __( 'Shop', 'davis' ),
) );

// SHOP PAGE
TC_Kirki::add_section( 'section_shop_page', array(
    'title'          => __( 'Shop Page' ),
    'panel'          => 'panel_shop', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Page Title
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'shop_page_title',
	'label'    => __( 'Page Title', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Shop all products', 'davis' ),
) );
// Products per row
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'product_per_row',
	'label'    => __( 'Products per row', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'slider',
	'priority' => 10,
	'default'  => 4,
	'choices'     => array(
		'min'  => '3',
		'max'  => '6',
		'step' => '1',
	),
) );
// Sidebar
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'shop_sidebar',
	'label'    => __( 'Shop Sidebar', 'davis' ),
    'description' => __( 'Choose if you want to display the sidebar on the product page and select the type.', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'no',
	'choices'  => array(
		'no' 		=> esc_attr__( 'No Sidebar', 'davis' ),
		'sidebar' 	=> esc_attr__( 'Default Sidebar', 'davis' ),
		'offcanvas'	=> esc_attr__( 'Off-canvas Sidebar', 'davis' ),
	),
) );
// Product card style
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'product_card_style',
	'label'    => __( 'Product Card Style', 'davis' ),
    'description' => __( 'Choose between the different product design style.', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'radio-image',
	'priority' => 10,
	'default'  => 'product-style-1',
	'choices'     => array(
		'product-style-1'   => get_template_directory_uri() . '/assets/images/admin/product1.png',
		'product-style-2'   => get_template_directory_uri() . '/assets/images/admin/product2.png',
	),
) );
// Hide Product details
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'hide_product_details',
	'label'    => __( 'Product Details', 'davis' ),
    'description' => __( 'Choose if you want to create a clean style by only displaying the product. The details are display only on hover.', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Variations Slider
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'shop_variations_slider',
	'label'    => __( 'Variations Slider', 'davis' ),
    'description' => __( 'Choose if you want to display the product variations as a slider on the shop pages.', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Enable', 'davis' ),
		'off' => esc_attr__( 'Disable', 'davis' ),
	),
) );
// Last category single variation as product
/*
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'single_variation_product',
	'label'    => __( 'Single Variation Product', 'davis' ),
    'description' => __( 'Separate the variations as single standalone products on category pages without subcategories. This is ideal for customers to have the variations slider on the top categories and see all variations at glance when filtering down.', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Enable', 'davis' ),
		'off' => esc_attr__( 'Disable', 'davis' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'shop_variations_slider',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
*/

// PRODUCT PAGE
TC_Kirki::add_section( 'section_product_page', array(
    'title'          => __( 'Product Page' ),
    'panel'          => 'panel_shop', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Product images style
Kirki::add_field( 'pp_theme', array(
	'settings'    => 'product_style',
	'label'       => __( 'Product Images Style', 'davis' ),
	'description' => __( 'Select the way the product is been showcased. (can be overwritten in the product option itself)', 'davis' ),
	'section'  => 'section_product_page',
	'type'        => 'select',
	'default'     => 'thumb',
	'priority'    => 10,
	'choices'     => array(
		'thumb' => esc_attr__( 'Thumbnails', 'davis' ),
		'carousel' => esc_attr__( 'Carousel', 'davis' ),
		'slideshow' => esc_attr__( 'Fullwidth Slideshow', 'davis' ),
	),
) );
// Product images position
Kirki::add_field( 'pp_theme', array(
	'settings'    => 'product_images_position',
	'label'       => __( 'Product Images Position', 'davis' ),
	'description' => __( 'Select the which side you want the images to be displayed.', 'davis' ),
	'section'  => 'section_product_page',
	'type'        => 'select',
	'default'     => 'right',
	'priority'    => 10,
	'choices'     => array(
		'left' => esc_attr__( 'Left', 'davis' ),
		'right' => esc_attr__( 'Right', 'davis' ),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'product_style',
			'operator' => '!=',
			'value'    => 'slideshow',
		),
	),
) );

// CHECKOUT
TC_Kirki::add_section( 'section_checkout', array(
    'title'          => __( 'Checkout' ),
    'description' => __( 'The cart is being cached, make sure you empty the cache after updating any option in this section.', 'davis' ),
    'panel'          => 'panel_shop', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Cart Title
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_cart_title',
	'label'    => __( 'Cart Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Cart Summary', 'davis' ),
) );
// Details Title
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_details_title',
	'label'    => __( 'Details Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Customer Details', 'davis' ),
) );
// Details Subtitle
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_details_subtitle',
	'label'    => __( 'Details Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Fill in your details in the form bellow', 'davis' ),
) );
// Shipping Title
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_shipping_title',
	'label'    => __( 'Shipping / Payment Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Shipping & Payment', 'davis' ),
) );
// Shipping Subtitle
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_shipping_subtitle',
	'label'    => __( 'Shipping / Payment Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Select your preferred shipping and payment methods', 'davis' ),
) );
// Review Title
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_review_title',
	'label'    => __( 'Review Title', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Review Order', 'davis' ),
) );
// Review Subtitle
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'checkout_review_subtitle',
	'label'    => __( 'Review Subtitle', 'davis' ),
	'section'  => 'section_checkout',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Confirm your cart content and the total of your order', 'davis' ),
) );
// Quick Checkout
TC_Kirki::add_field( 'pp_theme', array(
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

?>
