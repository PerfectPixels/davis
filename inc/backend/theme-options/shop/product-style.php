<?php

// SHOP PAGE
Kirki::add_section( 'section_product_style', array(
	'title'          => __( 'Product Style' ),
	'panel'          => 'panel_shop', // Not typically needed.
	'priority'       => 160,
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_style_title_1',
	'section'     => 'section_product_style',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Card Styling', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Product card style
Kirki::add_field( 'pp_theme', array(
	'settings' => 'product_card_style',
	'label'    => __( 'Product Card Style', 'davis' ),
	'description' => __( 'Choose between the different product design style.', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'radio-image',
	'priority' => 10,
	'default'  => 'product-style-1',
	'choices'     => array(
		'product-style-1'   => get_template_directory_uri() . '/assets/images/admin/product1.png',
		'product-style-2'   => get_template_directory_uri() . '/assets/images/admin/product2.png',
	),
) );
// Hide Product details
Kirki::add_field( 'pp_theme', array(
	'settings' => 'hide_product_details',
	'label'    => __( 'Product Details', 'davis' ),
	'description' => __( 'Choose if you want to display the product details on hover only.', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Variations Slider
Kirki::add_field( 'pp_theme', array(
	'settings' => 'shop_variations_slider',
	'label'    => __( 'Variations Slider', 'davis' ),
	'description' => __( 'Choose if you want to display the product variations as a slider on the shop pages.', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Enable', 'davis' ),
		'off' => esc_attr__( 'Disable', 'davis' ),
	),
) );

Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_style_title_2',
	'section'     => 'section_product_style',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Quickview', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Quickview
Kirki::add_field( 'pp_theme', array(
	'settings' => 'quickview_enabled',
	'label'    => __( 'Enable Quickview', 'davis' ),
	'description' => __( 'Enable Quickview will display a icon in the product details to open a modal.', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Enable', 'davis' ),
		'off' => esc_attr__( 'Disable', 'davis' ),
	),
) );
// Quickview Layout
Kirki::add_field( 'pp_theme', array(
	'settings' => 'quickview_layout',
	'label'    => __( 'Quickview Layout', 'davis' ),
	'description' => __( 'Choose the way you want the image to be displayed.', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'left',
	'choices'  => array(
		'left'  => esc_attr__( 'Image on the left', 'davis' ),
		'top' => esc_attr__( 'Image at the top', 'davis' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'quickview_enabled',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_style_title_3',
	'section'     => 'section_product_style',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Badges', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Featured Text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'product_featured_txt',
	'label'    => __( 'Featured badge text', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Hot', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => '.badges span.featured',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'featured_badge_color',
	'label'    => __( 'Featured badge Color', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#e89748',
	'js_vars' => array(
		array(
			'element'  => array( '.badges span.featured' ),
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.badges span.featured' ),
			'property' => 'background-color',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_style_hr_1',
	'section'     => 'section_product_style',
	'default'     => '<hr>',
	'priority'    => 10,
) );

// New badge
Kirki::add_field( 'pp_theme', array(
	'type'        => 'toggle',
	'settings'    => 'product_new_enabled',
	'label'       => __( 'Enable New Product Badge', 'davis' ),
	'section'     => 'section_product_style',
	'default'     => '1',
	'priority'    => 10,
) );
// New badge time
Kirki::add_field( 'pp_theme', array(
	'settings' => 'product_new_duration',
	'label'    => __( 'New badge duration', 'davis' ),
	'description'    => __( 'Choose how many days a product remains as "new"', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'slider',
	'priority' => 10,
	'default'  => 7,
	'choices'     => array(
		'min'  => '1',
		'max'  => '90',
		'step' => '1',
	),
) );
// New badge Text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'product_new_txt',
	'label'    => __( 'New badge text', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'New', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => '.badges span.new',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'new_badge_color',
	'label'    => __( 'New Badge Color', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#669bc9',
	'js_vars' => array(
		array(
			'element'  => array( '.badges span.new' ),
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.badges span.new' ),
			'property' => 'background-color',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_style_hr_2',
	'section'     => 'section_product_style',
	'default'     => '<hr>',
	'priority'    => 10,
) );

// Sale Text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'product_sale_txt',
	'label'    => __( 'Sale badge text', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Sale!', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => '.badges span.onsale',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'sale_badge_color',
	'label'    => __( 'Sale Badge Color', 'davis' ),
	'section'  => 'section_product_style',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#93af76',
	'js_vars' => array(
		array(
			'element'  => array( '.badges span.onsale' ),
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.badges span.onsale' ),
			'property' => 'background-color',
		),
	),
) );