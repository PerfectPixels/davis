<?php 

global $transport;

// ACCOUNT
Kirki::add_section( 'wishlist_element', array(
    'title'          => __( 'Wishlist', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Stype of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-buttonset',
	'settings'    => 'wishlist_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'wishlist_element',
	'default'     => 'icon_label',
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
	'settings'    => 'wishlist_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'wishlist_element',
	'default'     => 'style1',
	'priority'    => 10,
	'choices'     => array(
		'style1'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style2'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style3'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'wishlist_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
// Label when logged in
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'wishlist_label',
	'label'    => __( 'Label', 'davis' ),
	'section'  => 'wishlist_element',
	'default'  => esc_attr__( 'Favorites', 'davis' ),
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'wishlist_style',
			'operator' => '!=',
			'value'    => 'icon-only',
		),
	),
) );

?>