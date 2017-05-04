<?php

// Move the site identity section
Kirki::add_section( 'title_tagline', array(
    'title'          => __( 'Logo & Site Identity', 'davis' ),
    'panel'          => 'panel_general',
    'priority'       => 10,
) );

// Light logo
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'light_logo',
	'label'    => __( 'Light Logo', 'davis' ),
    'description' => __( 'Make sure you upload a logo that is at least 100 pixels tall.', 'davis' ),
	'section'  => 'title_tagline',
	'type'     => 'upload',
	'priority' => 150,
	'default'  => '',
) );
// Dark logo
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'dark_logo',
	'label'    => __( 'Dark Logo', 'davis' ),
    'description' => __( 'Make sure you upload a logo that is at least 100 pixels tall.', 'davis' ),
	'section'  => 'title_tagline',
	'type'     => 'upload',
	'priority' => 150,
	'default'  => '',
) );
// Width
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'slider',
	'settings'    => 'logo_width',
	'label'       => esc_attr__( 'Logo Width', 'davis' ),
	'section'     => 'title_tagline',
	'default'     => 82,
	'priority' => 150,
	'choices'     => array(
		'min'  => '40',
		'max'  => '200',
		'step' => '1',
	),
	'js_vars' => array(
		array(
			'element'  => array( '.logo a.brand' ),
			'property' => 'width',
			'units' => 'px',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.logo a.brand' ),
			'property' => 'width',
			'units' => 'px',
		),
	),
) );

// Desktop
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'title_tagline_title_1',
	'section'     => 'title_tagline',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Desktop', 'davis' ) . '</h3>',
	'priority'    => 160,
) );
// Logo Position
Kirki::add_field( 'pp_theme', array(
	'settings' => 'logo_position_desktop',
	'label'    => __( 'Logo Position', 'davis' ),
	'section'  => 'title_tagline',
	'type'     => 'select',
	'priority' => 160,
	'default'  => 'left_logo',
	'choices'  => array(
		'left_logo'  => esc_attr__( 'Left', 'davis' ),
		'center_logo' => esc_attr__( 'Center', 'davis' ),
		'center_logo_split_menu' => esc_attr__( 'Center and Split Menu', 'davis' ),
	),
) );

// Tablet
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'title_tagline_title_2',
	'section'     => 'title_tagline',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Tablet', 'davis' ) . '</h3>',
	'priority'    => 160,
) );
// Logo Position
Kirki::add_field( 'pp_theme', array(
	'settings' => 'logo_position_tablet',
	'label'    => __( 'Logo Position', 'davis' ),
	'section'  => 'title_tagline',
	'type'     => 'select',
	'priority' => 160,
	'default'  => 'center_logo_tablet',
	'choices'  => array(
		'left_logo_tablet'  => esc_attr__( 'Left', 'davis' ),
		'center_logo_tablet' => esc_attr__( 'Center', 'davis' ),
	),
) );

// Mobile
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'title_tagline_title_3',
	'section'     => 'title_tagline',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Mobile', 'davis' ) . '</h3>',
	'priority'    => 160,
) );
// Logo Position
Kirki::add_field( 'pp_theme', array(
	'settings' => 'logo_position_mobile',
	'label'    => __( 'Logo Position', 'davis' ),
	'section'  => 'title_tagline',
	'type'     => 'select',
	'priority' => 160,
	'default'  => 'center_logo_mobile',
	'choices'  => array(
		'left_logo_mobile'  => esc_attr__( 'Left', 'davis' ),
		'center_logo_mobile' => esc_attr__( 'Center', 'davis' ),
	),
) );

function pp_site_identity_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'logo', array(
		'selector' => '.brand',
		'container_inclusive' => true,
		'settings' => array( 'light_logo', 'dark_logo' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/logo' );
		},
	) );

}
add_action( 'customize_register', 'pp_site_identity_partials' );
