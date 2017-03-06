<?php

Kirki::add_section( 'search_element', array(
    'title'          => __( 'Search', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-image',
	'settings'    => 'search_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'search_element',
	'default'     => 'style1',
	'priority'    => 10,
	'choices'     => array(
		'style1'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style2'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style3'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'search_placeholder',
	'label'    => __( 'Input Pleaceholder', 'davis' ),
	'section'  => 'search_element',
	'default'  => esc_attr__( 'Search here', 'davis' ),
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'toggle',
	'settings' => 'search_cat',
	'label'    => __( 'Category Filter', 'davis' ),
	'section'  => 'search_element',
	'default'  => '1',
	'priority' => 10,
) );
// Ajax Search 
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'ajax_search',
	'label'    => __( 'Ajax Search', 'davis' ),
    'description' => __( 'Enable/Disable the ajax search.', 'davis' ),
	'section'  => 'search_element',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );

?>