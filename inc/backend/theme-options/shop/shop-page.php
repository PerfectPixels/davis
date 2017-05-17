<?php

// SHOP PAGE
Kirki::add_section( 'section_shop_page', array(
	'title'          => __( 'Shop Page' ),
	'panel'          => 'panel_shop', // Not typically needed.
	'priority'       => 160,
	'capability'     => 'edit_theme_options',
) );
// Page Title
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'shop_page_title',
	'label'    => __( 'Page Title', 'davis' ),
	'section'  => 'section_shop_page',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Shop all products', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => '.post-type-archive-product .cd-hero-slider h1',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'shop_page_hr_1',
	'section'     => 'section_shop_page',
	'default'     => '<hr>',
	'priority'    => 10,
) );
// Products per row
Kirki::add_field( 'pp_theme', array(
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
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'shop_page_hr_2',
	'section'     => 'section_shop_page',
	'default'     => '<hr>',
	'priority'    => 10,
) );

// Sidebar
Kirki::add_field( 'pp_theme', array(
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
// Last category single variation as product
/*
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
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