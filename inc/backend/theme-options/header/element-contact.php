<?php 

global $transport;

// ACCOUNT
Kirki::add_section( 'contact_element', array(
    'title'          => __( 'Contact', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Stype of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-buttonset',
	'settings'    => 'contact_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'contact_element',
	'default'     => 'icon_label',
	'priority'    => 10,
	'choices'     => array(
		'icon'   	 => esc_attr__( 'Icon Only', 'davis' ),
		'icon_label' => esc_attr__( 'Icon with Label', 'davis' ),
		'label'  	 => esc_attr__( 'Label Only', 'davis' ),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'phone_label',
	'label'    => __( 'Phone', 'davis' ),
	'section'  => 'contact_element',
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'email_label',
	'label'    => __( 'Email', 'davis' ),
	'section'  => 'contact_element',
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'address_label',
	'label'    => __( 'Address', 'davis' ),
	'section'  => 'contact_element',
	'default'     => '',
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'contact_details_label',
	'label'    => __( 'Contact Details', 'davis' ),
	'section'  => 'contact_element',
	'priority' => 10,
) );

?>