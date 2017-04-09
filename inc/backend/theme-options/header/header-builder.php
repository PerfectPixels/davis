<?php

global $header_options;

// Add the Header panel
Kirki::add_section( 'header_builder', array(
    'title'          => __( 'Header Builder', 'davis' ),
    'panel'          => 'panel_header', // Not typically needed.
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
) );

// Desktop Top Bar
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_1',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Tob Bar | Desktop', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Desktop Top Bar - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'top_bar_left_area',
	'label'       => __( 'Top Bar Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => array('text_1'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Desktop Top Bar - Center Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'top_bar_center_area',
	'label'       => __( 'Top Bar Center Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Desktop Top Bar - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'top_bar_right_area',
	'label'       => __( 'Top Bar Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => array('account', 'cart'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );

// Desktop Main Header
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_2',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Main Header | Desktop', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Desktop Main Header - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'main_header_left_area',
	'label'       => __( 'Main Header Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => array('main_menu'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Desktop Main Header - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'main_header_right_area',
	'label'       => __( 'Main Header Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );

// Desktop Bottom Header
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_3',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Bottom Header | Desktop', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Desktop Bottom Header - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'bottom_header_left_area',
	'label'       => __( 'Bottom Header Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Desktop Bottom Header - Center Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'bottom_header_center_area',
	'label'       => __( 'Bottom Header Center Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Desktop Bottom Header - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'bottom_header_right_area',
	'label'       => __( 'Bottom Header Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );


// Tablet Top Bar
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_4',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Tob Bar | Tablet', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Tablet Top Bar - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'tablet_top_bar_left_area',
	'label'       => __( 'Tablet Top Bar Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => array('text_1'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Tablet Top Bar - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'tablet_top_bar_right_area',
	'label'       => __( 'Tablet Top Bar Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => array('account', 'cart'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );

// Tablet Main Header
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_5',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Main Header | Tablet', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Tablet Main Header - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'tablet_main_header_left_area',
	'label'       => __( 'Tablet Main Header Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Tablet Main Header - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'tablet_main_header_right_area',
	'label'       => __( 'Tablet Main Header Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );


// Mobile Top Bar
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_6',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Tob Bar | Mobile', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Mobile Top Bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'mobile_top_bar_area',
	'label'       => __( 'Mobile Top Bar Left Area', 'davis' ),
	'section'     => 'header_builder',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Mobile Main Header
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_7',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Main Header | Mobile', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Mobile Main Header - Left Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'mobile_main_header_left_area',
	'label'       => __( 'Mobile Main Header Left Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );
// Mobile Main Header - Right Area
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'mobile_main_header_right_area',
	'label'       => __( 'Mobile Main Header Right Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );

// Mobile Bottom Bar
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'header_builder_title_8',
	'section'     => 'header_builder',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Bottom Bar | Mobile', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Mobile Bottom Bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'mobile_bottom_bar_area',
	'label'       => __( 'Mobile Bottom Bar Area', 'davis' ),
	'section'     => 'header_builder',
	'default'     => '',
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );


function pp_header_builder_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'top_bar_builder', array(
		'selector' => '.navbar-top',
		'container_inclusive' => true,
		'settings' => array( 'top_bar_left_area', 'top_bar_center_area', 'top_bar_right_area', 'tablet_top_bar_left_area', 'tablet_top_bar_right_area', 'mobile_top_bar_area' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/top-bar' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'main_header_builder', array(
		'selector' => '.nav-header ',
		'container_inclusive' => true,
		'settings' => array( 'main_header_left_area', 'main_header_right_area', 'tablet_main_header_left_area', 'tablet_main_header_right_area', 'mobile_main_header_left_area', 'mobile_main_header_right_area' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/navigation' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'bottom_header_builder', array(
		'selector' => 'header.bottom',
		'container_inclusive' => true,
		'settings' => array( 'bottom_header_left_area', 'bottom_header_center_area', 'bottom_header_right_area' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/bottom-header' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'bottom_bar_builder', array(
		'selector' => '.navbar-mobile-bottom',
		'container_inclusive' => true,
		'settings' => array( 'mobile_bottom_bar_area' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/bottom-bar' );
		},
	) );
}
add_action( 'customize_register', 'pp_header_builder_partials' );