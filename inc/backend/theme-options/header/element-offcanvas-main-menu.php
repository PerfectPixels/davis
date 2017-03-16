<?php

global $header_options, $transport;

// ACCOUNT
Kirki::add_section( 'offcanvas_main_menu_element', array(
	'title'          => __( 'OffCanvas Main Menu', 'davis' ),
	'panel'          => 'panel_header',
	'priority'       => 10,
) );
// OffCanvas Menu background color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_bg_color',
	'label'    => __( 'Menu Background Color', 'davis' ),
	'section'  => 'offcanvas_main_menu_element',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#2e3233',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.primary-nav.offcanvas, .primary-nav.offcanvas ul' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.primary-nav.offcanvas, .primary-nav.offcanvas ul' ),
			'property' => 'background-color',
		),
	),
) );
// OffCanvas Menu text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_txt_color',
	'label'    => __( 'Menu Text Color', 'davis' ),
	'section'  => 'offcanvas_main_menu_element',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#bbb',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.primary-nav.offcanvas li a' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.primary-nav.offcanvas li a' ),
			'property' => 'color',
		),
	),
) );
// OffCanvas Menu text hover color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_txt_hover_color',
	'label'    => __( 'Menu Text Hover Color', 'davis' ),
	'section'  => 'offcanvas_main_menu_element',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#fff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.primary-nav.offcanvas li a:hover', '.primary-nav.offcanvas li a.selected', '.primary-nav.offcanvas span.mobile-arrow:hover:before', '.primary-nav.offcanvas span.mobile-arrow:hover:after' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important'
		),
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow:hover:before', '.primary-nav.offcanvas span.mobile-arrow:hover:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.primary-nav.offcanvas li a:hover', '.primary-nav.offcanvas li a.selected', '.primary-nav.offcanvas span.mobile-arrow:hover:before', '.primary-nav.offcanvas span.mobile-arrow:hover:after' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important'
		),
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow:hover:before', '.primary-nav.offcanvas span.mobile-arrow:hover:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
) );
// OffCanvas Menu Lines color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_lines_color',
	'label'    => __( 'Menu Lines Color', 'davis' ),
	'section'  => 'offcanvas_main_menu_element',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#3a3f40',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow' ),
			'function' => 'css',
			'property' => 'border-left-color',
			'suffix'   => '!important'
		),
		array(
			'element'  => array( '.primary-nav.offcanvas a', '.primary-nav.offcanvas li.social-media' ),
			'function' => 'css',
			'property' => 'border-bottom-color',
			'suffix'   => '!important'
		),
	),
	'output' => array(
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow' ),
			'function' => 'css',
			'property' => 'border-left-color',
			'suffix'   => '!important'
		),
		array(
			'element'  => array( '.primary-nav.offcanvas a', '.primary-nav.offcanvas li.social-media' ),
			'function' => 'css',
			'property' => 'border-bottom-color',
			'suffix'   => '!important'
		),
	),
) );
// OffCanvas Menu Icons color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_icons_color',
	'label'    => __( 'Menu Icons Color', 'davis' ),
	'section'  => 'offcanvas_main_menu_element',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#5F6667',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow:before', '.primary-nav.offcanvas span.mobile-arrow:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.primary-nav.offcanvas span.mobile-arrow:before', '.primary-nav.offcanvas span.mobile-arrow:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
) );
// OffCanvas Menu Content
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'select',
	'settings'    => 'offcanvas_main_menu_elements',
	'label'       => __( 'Content', 'davis' ),
	'section'     => 'offcanvas_main_menu_element',
	'default'     => array( 'main_menu', 'account', 'social_media' ),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
) );