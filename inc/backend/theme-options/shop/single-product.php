<?php

// PRODUCT PAGE
Kirki::add_section( 'section_product_page', array(
	'title'          => __( 'Single Product Page' ),
	'panel'          => 'panel_shop', // Not typically needed.
	'priority'       => 160,
	'capability'     => 'edit_theme_options',
) );
// Product images style
Kirki::add_field( 'pp_theme', array(
	'settings'    => 'product_style',
	'label'       => __( 'Product Images Style', 'davis' ),
	'description' => __( 'Select the way the product is been showcased. (can be overwritten in the product option itself)', 'davis' ),
	'section'     => 'section_product_page',
	'type'        => 'select',
	'default'     => 'thumb',
	'priority'    => 10,
	'choices'     => array(
		'thumb'       => esc_attr__( 'Thumbnails below Summary', 'davis' ),
		'thumb-image' => esc_attr__( 'Thumbnails over Image', 'davis' ),
		'vertical-thumb' => esc_attr__( 'Vertical Thumbnails', 'davis' ),
		'no-thumb' => esc_attr__( 'No Thumbnails', 'davis' ),
		'carousel'    => esc_attr__( 'Carousel', 'davis' ),
		'slideshow'   => esc_attr__( 'Slideshow', 'davis' ),
		'fullwidth'   => esc_attr__( 'Fullwidth', 'davis' ),
	),
) );
// Fullwidth background color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'fullwidth_bgcolor',
	'label'    => __( 'Image container background color', 'davis' ),
	'description'    => __( 'Color used on behind the images.', 'davis' ),
	'section'  => 'section_product_page',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'output' => array(
		array(
			'element'  => array( '.style-fullwidth' ),
			'property' => 'background-color',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'product_style',
			'operator' => '==',
			'value'    => 'fullwidth',
		),
	),
) );
// Product images position
Kirki::add_field( 'pp_theme', array(
	'settings'    => 'product_images_position',
	'label'       => __( 'Product Images Position', 'davis' ),
	'description' => __( 'Select the which side you want the images to be displayed.', 'davis' ),
	'section'     => 'section_product_page',
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
		array(
			'setting'  => 'product_style',
			'operator' => '!=',
			'value'    => 'fullwidth',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'product_page_hr_1',
	'section'     => 'section_product_page',
	'default'     => '<hr>',
	'priority'    => 10,
) );

// Hide Related Product
Kirki::add_field( 'pp_theme', array(
	'settings' => 'hide_related_product',
	'label'    => __( 'Related Product', 'davis' ),
	'section'  => 'section_product_page',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Related Products per row
Kirki::add_field( 'pp_theme', array(
	'settings' => 'related_product_per_page',
	'label'    => __( 'Related Products', 'davis' ),
	'section'  => 'section_product_page',
	'type'     => 'slider',
	'priority' => 10,
	'default'  => get_theme_mod( 'product_per_row', '4' ),
	'choices'     => array(
		'min'  => '3',
		'max'  => '12',
		'step' => '1',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'hide_related_product',
			'operator' => '==',
			'value'    => '1',
		),
	),
) );