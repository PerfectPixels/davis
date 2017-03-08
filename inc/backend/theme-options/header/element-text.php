<?php

global $transport, $primary_color;

Kirki::add_section( 'texts_element', array(
    'title'          => __( 'Texts', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// TEXT 1
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'text_title_1',
	'section'     => 'texts_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Text 1', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Message text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_1',
	'label'    => __( 'Message Text 1', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'textarea',
	'priority' => 10,
	'default'  => __( 'Message 1', 'davis' ),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_1_color',
	'label'    => __( 'Text 1 Font Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'default'   => '#fff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-1',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-1',
			'property' => 'color',
		),
	),
) );
// Box color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_1_bgcolor',
	'label'    => __( 'Text 1 Background Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'default'   => $primary_color,
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-1',
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-1',
			'property' => 'background-color',
		),
	),
) );

// TEXT 2
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'text_title_2',
	'section'     => 'texts_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Text 2', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Message text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_2',
	'label'    => __( 'Message Text 2', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'textarea',
	'priority' => 10,
	'default'   => '#fff',
	'default'  => __( 'Message 2', 'davis' ),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_2_color',
	'label'    => __( 'Text 2 Font Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'default'   => $primary_color,
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-2',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-2',
			'property' => 'color',
		),
	),
) );
// Box color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_2_bgcolor',
	'label'    => __( 'Text 2 Background Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-2',
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-2',
			'property' => 'background-color',
		),
	),
) );

// TEXT 3
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'text_title_3',
	'section'     => 'texts_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Text 3', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Message text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_3',
	'label'    => __( 'Message Text 3', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'textarea',
	'priority' => 10,
	'default'  => __( 'Message 3', 'davis' ),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_3_color',
	'label'    => __( 'Text 3 Font Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'default'   => '#fff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-3',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-3',
			'property' => 'color',
		),
	),
) );
// Box color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'message_text_3_bgcolor',
	'label'    => __( 'Text 3 Background Color', 'davis' ),
	'section'  => 'texts_element',
	'type'     => 'color',
	'priority' => 10,
	'default'   => $primary_color,
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '#message-box-3',
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => '#message-box-3',
			'property' => 'background-color',
		),
	),
) );
?>