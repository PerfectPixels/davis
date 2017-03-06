<?php

// Add the Header panel
Kirki::add_panel( 'panel_header', array(
    'priority'    => 11,
    'title'       => __( 'Header', 'davis' ),
) );

foreach ( glob( get_template_directory() . '/inc/backend/theme-options/header/*.php' ) as $filename ){
    include_once $filename;
}



// Transparent header
/*
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'transparent_header',
	'label'    => __( 'Top Page Transparent Header', 'davis' ),
    'description' => __( 'Choose to have a transparent header when at the top page. ( Ideal if you have a slideshow underneath a sticky header )', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Yes', 'davis' ),
		'off' => esc_attr__( 'No', 'davis' ),
	),
) );
// Transparent Header text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'transparent_header_text_color',
	'label'    => __( 'Transparent Header Text Color', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.nav-header.transparent *',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '.nav-header.transparent *',
			'property' => 'color',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'transparent_header',
			'operator' => '==',
			'value'    => true,
		),
	),
) );
*/


?>
