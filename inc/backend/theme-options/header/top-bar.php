<?php

global $transport, $primary_color;

// TOP BAR
Kirki::add_section( 'top_bar', array(
    'title'          => __( 'Top Bar', 'davis' ),
    'description'	 => __( 'Layout', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 2,
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
) );
// Top Bar color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'top_bar_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#000000',
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
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-top *', '.navbar-top .menu-item:hover > a.no-link' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top .contact-details a:after', '.navbar-top .go-back > a:before', '.navbar-top .go-back > a:after', '.navbar-top .menu-item-has-children > a span.mobile-arrow:before', '.navbar-top .menu-item-has-children > a span.mobile-arrow:after', '.navbar-top li.action-button.label-only > a span.item-counter', '.navbar-top .icon-badge span.item-counter', '.navbar-top .header-text-color-bg', '.navbar-top .header-text-color-bg-speudo:before', '.navbar-top .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-top .menu-item > a:before', '.navbar-top .menu-item > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-top *', '.navbar-top .menu-item:hover > a.no-link' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top .contact-details a:after', '.navbar-top .go-back > a:before', '.navbar-top .go-back > a:after', '.navbar-top .menu-item-has-children > a span.mobile-arrow:before', '.navbar-top .menu-item-has-children > a span.mobile-arrow:after', '.navbar-top li.action-button.label-only > a span.item-counter', '.navbar-top .icon-badge span.item-counter', '.navbar-top .header-text-color-bg', '.navbar-top .header-text-color-bg-speudo:before', '.navbar-top .header-text-color-bg-speudo:after' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-top .menu-item > a:before', '.navbar-top .menu-item > a:after' ),
			'property' => 'background-color',
			'suffix'   => '!important',
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
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-top a:hover', '.navbar-top a:hover span', '.navbar-top .menu-item:hover > a', '.navbar-top .current_page_item > a', '.navbar-top .current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top ul.sub-menu li:hover > a:before', '.navbar-top ul.sub-menu li:hover > a:after', '.navbar-top .dropdown-menu a:after', '.navbar-top .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-top .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-top li.action-button.label-only > a:hover span.item-counter', '.navbar-top .icon-badge:hover span.item-counter', '.navbar-top a:hover .header-text-color-bg', '.navbar-top a:hover .header-text-color-bg-speudo:before', '.navbar-top a:hover .header-text-color-bg-speudo:after' ),
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
			'element'  => array( '.navbar-top a:hover', '.navbar-top a:hover span', '.navbar-top .menu-item:hover > a', '.navbar-top .current_page_item > a', '.navbar-top .current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top ul.sub-menu li:hover > a:before', '.navbar-top ul.sub-menu li:hover > a:after', '.navbar-top .dropdown-menu a:after', '.navbar-top .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-top .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-top li.action-button.label-only > a:hover span.item-counter', '.navbar-top .icon-badge:hover span.item-counter', '.navbar-top a:hover .header-text-color-bg', '.navbar-top a:hover .header-text-color-bg-speudo:before', '.navbar-top a:hover .header-text-color-bg-speudo:after' ),
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
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-top .action-button a:not(.icon-outline) span.item-counter', '.navbar-top .action-button a.icon-outline.icon-badge span.item-counter' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-top .action-button a:not(.icon-outline) span.item-counter', '.navbar-top .action-button a.icon-outline.icon-badge span.item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>