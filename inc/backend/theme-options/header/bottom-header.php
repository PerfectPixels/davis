<?php

// BOTTOM HEADER
Kirki::add_section( 'bottom_header', array(
    'title'          => __( 'Bottom Header', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 4,
) );
// Height
Kirki::add_field( 'pp_theme', array(
	'type'        => 'slider',
	'settings'    => 'bottom_header_height',
	'label'       => esc_attr__( 'Height', 'davis' ),
	'section'     => 'bottom_header',
	'default'     => 45,
	'choices'     => array(
		'min'  => '40',
		'max'  => '200',
		'step' => '1',
	),
) );
// Bottom Header color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'bottom_header_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#ffffff',
	'js_vars'  => array(
		array(
			'element'  => array( '.header-bottom' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.header-bottom' ),
			'property' => 'background-color',
		),
	),
) );
// Bottom Header text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'bottom_header_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'js_vars' => array(
		array(
			'element'  => '.header-bottom *',
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => '.header-bottom *',
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
			'element'  => array( 'body .header-bottom a:hover', 'body .header-bottom a:hover span' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'body .header-bottom a:hover', 'body .header-bottom a:hover span' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>