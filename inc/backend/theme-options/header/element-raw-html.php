<?php

Kirki::add_section( 'raw_html_element', array(
    'title'          => __( 'Raw HTML', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// RAW HTML 1
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'html_title_1',
	'section'     => 'raw_html_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Raw HTML 1', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'textarea',
	'settings' => 'raw_html_1',
	'label'    => __( 'HTML 1 Content', 'davis' ),
	'section'  => 'raw_html_element',
	'default'  => esc_attr__( 'You can insert any HTML or Shortcode here. Styling issues might appear, add custom CSS targeting the class raw-html-1.', 'davis' ),
	'priority' => 10,
) );

// RAW HTML 2
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'html_title_2',
	'section'     => 'raw_html_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Raw HTML 2', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'textarea',
	'settings' => 'raw_html_2',
	'label'    => __( 'HTML 2 Content', 'davis' ),
	'section'  => 'raw_html_element',
	'default'  => esc_attr__( 'You can insert any HTML or Shortcode here. Styling issues might appear, add custom CSS targeting the class raw-html-2.', 'davis' ),
	'priority' => 10,
) );

function pp_element_raw_html_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'html_1_element', array(
		'selector' => '#raw-html-1',
		'container_inclusive' => true,
		'settings' => array( 'raw_html_1' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/html-1' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'html_2_element', array(
		'selector' => '#raw-html-2',
		'container_inclusive' => true,
		'settings' => array( 'raw_html_2' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/html-2' );
		},
	) );
}
add_action( 'customize_register', 'pp_element_raw_html_partials' );

?>