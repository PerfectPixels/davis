<?php

global $transport, $primary_color;

// BOTTOM HEADER
Kirki::add_section( 'bottom_header', array(
    'title'          => __( 'Bottom Header', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 4,
) );
// Height
Kirki::add_field( 'pp_theme', array(
    'transport'	  => 'postMessage',
	'type'        => 'slider',
	'settings'    => 'bottom_header_height',
	'label'       => esc_attr__( 'Height', 'davis' ),
	'section'     => 'bottom_header',
	'default'     => 40,
	'choices'     => array(
		'min'  => '40',
		'max'  => '200',
		'step' => '1',
	),
    'js_vars'  => array(
        array(
            'element'  => array( '.navbar-bottom' ),
            'function' => 'css',
            'property' => 'height',
            'suffix'   => 'px',
        ),
    ),
    'output' => array(
        array(
            'element'  => array( '.navbar-bottom' ),
            'property' => 'height',
            'suffix'   => 'px',
        ),
    ),
) );
// Bottom Header color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_header_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#ffffff',
	'js_vars'  => array(
		array(
			'element'  => array( '.navbar-bottom' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom' ),
			'property' => 'background-color',
		),
	),
) );
// Bottom Header text color
Kirki::add_field( 'pp_theme', array(
    'transport'	  => 'postMessage',
	'settings' => 'bottom_header_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'js_vars' => array(
		array(
			'element'  => '.navbar-bottom *',
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => '.navbar-bottom *',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Header hover text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'bottom_header_hover_text_color',
	'label'    => __( 'Hover Text Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'js_vars' => array(
		array(
			'element'  => array( 'body .navbar-bottom a:hover', 'body .navbar-bottom a:hover span' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'body .navbar-bottom a:hover', 'body .navbar-bottom a:hover span' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>