<?php 

// ACCOUNT
Kirki::add_section( 'account_element', array(
    'title'          => __( 'Account', 'davis' ),
    'description'	 => __( 'Elements', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Stype of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-buttonset',
	'settings'    => 'account_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'account_element',
	'default'     => 'icon',
	'priority'    => 10,
	'choices'     => array(
		'icon'   	 => esc_attr__( 'Icon Only', 'davis' ),
		'icon_label' => esc_attr__( 'Icon with Label', 'davis' ),
		'label'  	 => esc_attr__( 'Label Only', 'davis' ),
	),
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-image',
	'settings'    => 'account_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'account_element',
	'default'     => 'style1',
	'priority'    => 10,
	'choices'     => array(
		'style1'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style2'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'style3'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'account_style',
			'operator' => '!=',
			'value'    => 'label',
		),
	),
) );
// Label when logged in
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'account_in_label',
	'label'    => __( 'Logged In Label', 'davis' ),
	'section'  => 'account_element',
	'default'  => esc_attr__( 'My Account', 'davis' ),
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'account_style',
			'operator' => '!=',
			'value'    => 'icon',
		),
	),
) );
// Label when logged out
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'account_out_label',
	'label'    => __( 'Logged Out Label', 'davis' ),
	'section'  => 'account_element',
	'default'  => esc_attr__( 'Login', 'davis' ),
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'account_style',
			'operator' => '!=',
			'value'    => 'icon',
		),
	),
) );

?>