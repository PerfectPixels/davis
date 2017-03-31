<?php

global $primary_color;

// BOTTOM HEADER
Kirki::add_section( 'bottom_header', array(
    'title'          => __( 'Bottom Header', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 4,
) );
// Fixed top bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'refresh',
	'settings' => 'fixed_bottom_bar',
	'label'    => __( 'Sticky Bottom Bar', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
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
			'element'  => array( '.navbar-bottom', '.navbar-bottom ul.sub-menu', '.navbar-bottom .dropdown-hover .dropdown-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom', '.navbar-bottom ul.sub-menu', '.navbar-bottom .dropdown-hover .dropdown-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
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
			'element'  => array( '.navbar-bottom *', '.navbar-bottom .menu-item:hover > a.no-link' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom .go-back > a:before', '.navbar-bottom .go-back > a:after', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a span.item-counter', '.navbar-bottom .icon-badge span.item-counter', '.navbar-bottom .header-text-color-bg', '.navbar-bottom .header-text-color-bg-speudo:before', '.navbar-bottom .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .menu-item > a:before', '.navbar-bottom .menu-item > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom *', '.navbar-bottom .menu-item:hover > a.no-link' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom .go-back > a:before', '.navbar-bottom .go-back > a:after', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a span.item-counter', '.navbar-bottom .icon-badge span.item-counter', '.navbar-bottom .header-text-color-bg', '.navbar-bottom .header-text-color-bg-speudo:before', '.navbar-bottom .header-text-color-bg-speudo:after' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .menu-item > a:before', '.navbar-bottom .menu-item > a:after' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Header hover text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_header_hover_text_color',
	'label'    => __( 'Hover Text Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-bottom a:hover', '.navbar-bottom a:hover span', '.navbar-bottom .menu-item:hover > a', '.navbar-bottom .current_page_item > a', '.navbar-bottom .current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom ul.sub-menu li:hover > a:before', '.navbar-bottom ul.sub-menu li:hover > a:after', '.navbar-bottom .dropdown-menu a:after', '.navbar-bottom .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a:hover span.item-counter', '.navbar-bottom .icon-badge:hover span.item-counter', '.navbar-bottom a:hover .header-text-color-bg', '.navbar-bottom a:hover .header-text-color-bg-speudo:before', '.navbar-bottom a:hover .header-text-color-bg-speudo:after', '.navbar-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom ul.sub-menu:before', '.navbar-bottom .dropdown-menu:before' ),
			'function' => 'css',
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom a:hover', '.navbar-bottom a:hover span', '.navbar-bottom .menu-item:hover > a', '.navbar-bottom .current_page_item > a', '.navbar-bottom .current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom ul.sub-menu li:hover > a:before', '.navbar-bottom ul.sub-menu li:hover > a:after', '.navbar-bottom .dropdown-menu a:after', '.navbar-bottom .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a:hover span.item-counter', '.navbar-bottom .icon-badge:hover span.item-counter', '.navbar-bottom a:hover .header-text-color-bg', '.navbar-bottom a:hover .header-text-color-bg-speudo:before', '.navbar-bottom a:hover .header-text-color-bg-speudo:after', '.navbar-bottom .search-box button' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-bottom ul.sub-menu:before', '.navbar-bottom .dropdown-menu:before' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Header Icon text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_header_icon_text_color',
	'label'    => __( 'Icon Text Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-bottom .action-button a:not(.icon-outline) span.item-counter', '.navbar-bottom .action-button a.icon-outline.icon-badge span.item-counter' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom .action-button a:not(.icon-outline) span.item-counter', '.navbar-bottom .action-button a.icon-outline.icon-badge span.item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>