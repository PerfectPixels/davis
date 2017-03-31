<?php

// ACCOUNT
Kirki::add_section( 'account_element', array(
    'title'          => __( 'Account', 'davis' ),
    'description'	 => __( 'Elements', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Type of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-buttonset',
	'settings'    => 'account_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'account_element',
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
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'account_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'account_element',
	'default'     => 'icon-user-1',
	'priority'    => 10,
	'choices'     => array(
		'icon-user-1'           => get_template_directory_uri() . '/assets/images/admin/icon-user-1.svg',
		'icon-user-2'           => get_template_directory_uri() . '/assets/images/admin/icon-user-2.svg',
		'icon-user-3'           => get_template_directory_uri() . '/assets/images/admin/icon-user-3.svg',
		'icon-user-4'           => get_template_directory_uri() . '/assets/images/admin/icon-user-4.svg',
		'icon-user-5'           => get_template_directory_uri() . '/assets/images/admin/icon-user-5.svg',
		'icon-user-1-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-user-1-outline.svg',
		'icon-user-2-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-user-2-outline.svg',
		'icon-user-3-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-user-3-outline.svg',
		'icon-user-4-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-user-4-outline.svg',
		'icon-user-5-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-user-5-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'account_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
// Label when logged in
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
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
			'value'    => 'icon-only',
		),
	),
	'js_vars'   => array(
		array(
			'element'  => '.logged-in .action-button.account a span',
			'function' => 'html',
		),
	)
) );
// Label when logged out
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
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
			'value'    => 'icon-only',
		),
	),
	'js_vars'   => array(
		array(
			'element'  => 'body:not(.logged-in) .action-button.account a span',
			'function' => 'html',
		),
	)
) );

function pp_element_account_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'account_element', array(
		'selector' => 'li.action-button.account',
		'container_inclusive' => true,
		'settings' => array( 'account_style', 'account_icon_style' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/account' );
		},
	) );
}
add_action( 'customize_register', 'pp_element_account_partials' );

?>