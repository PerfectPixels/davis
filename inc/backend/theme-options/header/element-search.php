<?php

global $primary_color;

Kirki::add_section( 'search_element', array(
    'title'          => __( 'Search', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'type'        => 'radio-image',
	'settings'    => 'search_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'search_element',
	'default'     => 'icon-search-1',
	'priority'    => 10,
	'choices'     => array(
		'icon-search-1'   => get_template_directory_uri() . '/assets/images/admin/icon-search-1.svg',
		'icon-search-2'   => get_template_directory_uri() . '/assets/images/admin/icon-search-2.svg',
		'icon-search-3'   => get_template_directory_uri() . '/assets/images/admin/icon-search-3.svg',
		'icon-search-4'   => get_template_directory_uri() . '/assets/images/admin/icon-search-4.svg',
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'search_icon_color',
	'label'    => __( 'Button Icon Color', 'davis' ),
	'section'  => 'search_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#ffffff',
	'js_vars'  => array(
		array(
			'element'  => array( 'li.search-box .product-search button' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'li.search-box .product-search button' ),
			'property' => 'color',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'search_color',
	'label'    => __( 'Button Background Color', 'davis' ),
	'section'  => 'search_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => $primary_color,
	'js_vars'  => array(
		array(
			'element'  => array( 'li.search-box .product-search button' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'li.search-box .product-search button' ),
			'property' => 'background-color',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
    'transport'	  => 'postMessage',
    'type'        => 'slider',
    'settings'    => 'search_box_width',
    'label'       => esc_attr__( 'Width', 'davis' ),
    'section'     => 'search_element',
    'default'     => 20,
    'priority' => 150,
    'choices'     => array(
        'min'  => '15',
        'max'  => '100',
        'step' => '1',
    ),
    'js_vars' => array(
        array(
            'element'  => array( '.search-box' ),
            'property' => 'width',
            'units' => 'vw',
        ),
    ),
    'output' => array(
        array(
            'element'  => array( '.search-box' ),
            'property' => 'width',
            'units' => 'vw',
        ),
    ),
) );
Kirki::add_field( 'pp_theme', array(
	'type'     => 'text',
	'settings' => 'search_placeholder',
	'label'    => __( 'Input Pleaceholder', 'davis' ),
	'section'  => 'search_element',
	'default'  => esc_attr__( 'Search here', 'davis' ),
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'type'     => 'toggle',
	'settings' => 'search_cat',
	'label'    => __( 'Category Filter', 'davis' ),
	'section'  => 'search_element',
	'default'  => '1',
	'priority' => 10,
) );
// Ajax Search 
Kirki::add_field( 'pp_theme', array(
	'settings' => 'ajax_search',
	'label'    => __( 'Ajax Search', 'davis' ),
    'description' => __( 'Enable/Disable the ajax search.', 'davis' ),
	'section'  => 'search_element',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );

?>