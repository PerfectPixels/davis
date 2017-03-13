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
	'transport'	  => $transport,
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
	'transport'	  => $transport,
	'type'        => 'radio-image',
	'settings'    => 'cart_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'cart_element',
	'default'     => 'style1',
	'priority'    => 10,
	'choices'     => array(
		'style1'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style2'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style3'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'cart_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
// Label
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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
) );

?>