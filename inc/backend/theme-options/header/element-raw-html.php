<?php

Kirki::add_section( 'raw_html_element', array(
    'title'          => __( 'Raw HTML', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// RAW HTML 1
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'html_title_1',
	'section'     => 'raw_html_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Raw HTML 1', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'type'     => 'textarea',
	'settings' => 'raw_html_1',
	'label'    => __( 'HTML 1 Content', 'davis' ),
	'section'  => 'raw_html_element',
	'default'  => esc_attr__( 'You can insert any HTML or Shortcode here.', 'davis' ),
	'priority' => 10,
) );

// RAW HTML 2
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'html_title_2',
	'section'     => 'raw_html_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Raw HTML 2', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'type'     => 'textarea',
	'settings' => 'raw_html_2',
	'label'    => __( 'HTML 2 Content', 'davis' ),
	'section'  => 'raw_html_element',
	'default'  => esc_attr__( 'You can insert any HTML or Shortcode here.', 'davis' ),
	'priority' => 10,
) );

?>