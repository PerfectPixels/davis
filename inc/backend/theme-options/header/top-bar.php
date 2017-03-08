<?php

global $transport, $primary_color;

// TOP BAR
Kirki::add_section( 'top_bar', array(
    'title'          => __( 'Top Bar', 'davis' ),
    'description'	 => __( 'Layout', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 2,
) );
// Show/Hide top bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'display_top_bar',
	'label'    => __( 'Display Top Bar', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );
// Fixed top bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'fixed_top_bar',
	'label'    => __( 'Sticky Top Bar', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Top Bar color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'top_bar_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'js_vars'   => array(
		array(
			'element'  => array( '.navbar-top', '.navbar-top ul.sub-menu', '.navbar-top .dropdown-hover .dropdown-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-top', '.navbar-top ul.sub-menu', '.navbar-top .dropdown-hover .dropdown-menu' ),
			'property' => 'background-color',
		),
	),
) );
// Top Bar text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'top_bar_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#ffffff',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'js_vars' => array(
		array(
			'element'  => '.navbar-top *',
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top .menu-item-has-children > a:before', '.navbar-top .menu-item-has-children > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => '.navbar-top *',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top .menu-item-has-children > a:before', '.navbar-top .menu-item-has-children > a:after' ),
			'property' => 'background-color',
		),
	),
) );
// Top Bar hover text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'top_bar_hover_text_color',
	'label'    => __( 'Hover Text Color', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( 'body .navbar-top a:hover', 'body .navbar-top a:hover span' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( 'body .navbar-top ul.sub-menu a:after', '.navbar-top .dropdown-menu a:after', '.navbar-top .menu-item-has-children:hover > a:before', '.navbar-top .menu-item-has-children:hover > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top ul.sub-menu:before', '.navbar-top .dropdown-menu:before' ),
			'function' => 'css',
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'body .navbar-top a:hover', 'body .navbar-top a:hover span' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( 'body .navbar-top ul.sub-menu a:after', '.navbar-top .dropdown-menu a:after', '.navbar-top .menu-item-has-children:hover  > a:before', '.navbar-top .menu-item-has-children:hover > a:after' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top ul.sub-menu:before', '.navbar-top .dropdown-menu:before' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );
// Topbar Icon text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'topbar_icon_text_color',
	'label'    => __( 'Icon Text Color', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( 'body .navbar-top a span.item-counter' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'body .navbar-top a span.item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>