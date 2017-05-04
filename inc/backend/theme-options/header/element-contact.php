<?php

// CONTACT
Kirki::add_section( 'contact_element', array(
    'title'          => __( 'Contact', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Style of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-buttonset',
	'settings'    => 'contact_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'contact_element',
	'default'     => 'icon_label',
	'priority'    => 10,
	'choices'     => array(
		'icon-only'  => esc_attr__( 'Icon Only', 'davis' ),
		'icon_label' => esc_attr__( 'Icon with Label', 'davis' ),
		'label-only' => esc_attr__( 'Label Only', 'davis' ),
	),
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'phone_icon_style',
	'label'       => esc_html__( 'Phone Icon Type', 'davis' ),
	'section'     => 'contact_element',
	'default'     => 'icon-phone-1',
	'priority'    => 10,
	'choices'     => array(
		'icon-phone-1'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-1.svg',
		'icon-phone-2'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-2.svg',
		'icon-phone-3'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-3.svg',
		'icon-phone-4'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-4.svg',
		'icon-phone-5'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-5.svg',
		'icon-phone-6'          => get_template_directory_uri() . '/assets/images/admin/icon-phone-6.svg',
		'icon-phone-1-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-1-outline.svg',
		'icon-phone-2-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-2-outline.svg',
		'icon-phone-3-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-3-outline.svg',
		'icon-phone-4-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-4-outline.svg',
		'icon-phone-5-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-5-outline.svg',
		'icon-phone-6-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-phone-6-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'contact_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'text',
	'settings' => 'phone_label',
	'label'    => __( 'Phone', 'davis' ),
	'section'  => 'contact_element',
	'default'  => '+44(444)-7006332',
	'priority' => 10,
	'js_vars'   => array(
		array(
			'element'  => '.contact-details .phone',
			'function' => 'html',
		),
	),
) );

// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'email_icon_style',
	'label'       => esc_html__( 'Email Icon Type', 'davis' ),
	'section'     => 'contact_element',
	'default'     => 'icon-email-1',
	'priority'    => 10,
	'choices'     => array(
		'icon-email-1'          => get_template_directory_uri() . '/assets/images/admin/icon-email-1.svg',
		'icon-email-2'          => get_template_directory_uri() . '/assets/images/admin/icon-email-2.svg',
		'icon-email-3'          => get_template_directory_uri() . '/assets/images/admin/icon-email-3.svg',
		'icon-email-4'          => get_template_directory_uri() . '/assets/images/admin/icon-email-4.svg',
		'icon-email-1-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-email-1-outline.svg',
		'icon-email-2-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-email-2-outline.svg',
		'icon-email-3-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-email-3-outline.svg',
		'icon-email-4-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-email-4-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'contact_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'text',
	'settings' => 'email_label',
	'label'    => __( 'Email', 'davis' ),
	'section'  => 'contact_element',
	'default'  => 'email@domain.com',
	'priority' => 10,
	'js_vars'   => array(
		array(
			'element'  => '.contact-details .email',
			'function' => 'html',
		),
	),
) );

// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'address_icon_style',
	'label'       => esc_html__( 'Address Icon Type', 'davis' ),
	'section'     => 'contact_element',
	'default'     => 'icon-address-1',
	'priority'    => 10,
	'choices'     => array(
		'icon-address-1'          => get_template_directory_uri() . '/assets/images/admin/icon-address-1.svg',
		'icon-address-2'          => get_template_directory_uri() . '/assets/images/admin/icon-address-2.svg',
		'icon-address-3'          => get_template_directory_uri() . '/assets/images/admin/icon-address-3.svg',
		'icon-address-4'          => get_template_directory_uri() . '/assets/images/admin/icon-address-4.svg',
		'icon-address-5'          => get_template_directory_uri() . '/assets/images/admin/icon-address-5.svg',
		'icon-address-1-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-address-1-outline.svg',
		'icon-address-2-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-address-2-outline.svg',
		'icon-address-3-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-address-3-outline.svg',
		'icon-address-4-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-address-4-outline.svg',
		'icon-address-5-outline'  => get_template_directory_uri() . '/assets/images/admin/icon-address-5-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'contact_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'text',
	'settings' => 'address_label',
	'label'    => __( 'Address', 'davis' ),
	'section'  => 'contact_element',
	'default'  => '1 Address St',
	'priority' => 10,
	'js_vars'   => array(
		array(
			'element'  => '.contact-details .address',
			'function' => 'html',
		),
	),
) );

function pp_element_contact_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'contact_element', array(
		'selector' => 'li.contact-details',
		'container_inclusive' => true,
		'settings' => array( 'contact_style', 'phone_icon_style', 'email_icon_style', 'address_icon_style' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/contact' );
		},
	) );
}
add_action( 'customize_register', 'pp_element_contact_partials' );

