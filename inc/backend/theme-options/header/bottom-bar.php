<?php

global $primary_color;

// Bottom Bar
Kirki::add_section( 'bottom_bar', array(
    'title'          => __( 'Bottom Bar', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 4,
) );
// Fixed top bar
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'refresh',
	'settings' => 'fixed_bottom_bar',
	'label'    => __( 'Sticky Bottom Bar', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
) );
// Bottom Bar color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_bar_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#ffffff',
	'js_vars'  => array(
		array(
			'element'  => array( '.navbar-mobile-bottom', '.navbar-mobile-bottom > ul > li > .sub-menu', '.navbar-mobile-bottom .dropdown-hover .dropdown-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom', '.navbar-mobile-bottom > ul > li > .sub-menu', '.navbar-mobile-bottom .dropdown-hover .dropdown-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Bar text color
Kirki::add_field( 'pp_theme', array(
    'transport'	  => 'postMessage',
	'settings' => 'bottom_bar_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom *', '.navbar-mobile-bottom .menu-item:hover > a.no-link' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .sep', '.navbar-mobile-bottom .contact-details a:after', '.navbar-mobile-bottom .go-back > a:before', '.navbar-mobile-bottom .go-back > a:after', '.navbar-mobile-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-mobile-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-mobile-bottom li.action-button.label-only > a span.item-counter', '.navbar-mobile-bottom .icon-badge span.item-counter', '.navbar-mobile-bottom .header-text-color-bg', '.navbar-mobile-bottom .header-text-color-bg-speudo:before', '.navbar-mobile-bottom .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .menu-item > a:before', '.navbar-mobile-bottom .menu-item > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom *', '.navbar-mobile-bottom .menu-item:hover > a.no-link' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .sep', '.navbar-mobile-bottom .contact-details a:after', '.navbar-mobile-bottom .go-back > a:before', '.navbar-mobile-bottom .go-back > a:after', '.navbar-mobile-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-mobile-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-mobile-bottom li.action-button.label-only > a span.item-counter', '.navbar-mobile-bottom .icon-badge span.item-counter', '.navbar-mobile-bottom .header-text-color-bg', '.navbar-mobile-bottom .header-text-color-bg-speudo:before', '.navbar-mobile-bottom .header-text-color-bg-speudo:after' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom .menu-item > a:before', '.navbar-mobile-bottom .menu-item > a:after' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Bar hover text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_bar_hover_text_color',
	'label'    => __( 'Hover Text Color', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom a:hover', '.navbar-mobile-bottom a:hover span', '.navbar-mobile-bottom .menu-item:hover > a', '.navbar-mobile-bottom .current_page_item > a', '.navbar-mobile-bottom .current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom ul.sub-menu li:hover > a:before', '.navbar-mobile-bottom ul.sub-menu li:hover > a:after', '.navbar-mobile-bottom .dropdown-menu a:after', '.navbar-mobile-bottom .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-mobile-bottom .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-mobile-bottom li.action-button.label-only > a:hover span.item-counter', '.navbar-mobile-bottom .icon-badge:hover span.item-counter', '.navbar-mobile-bottom a:hover .header-text-color-bg', '.navbar-mobile-bottom a:hover .header-text-color-bg-speudo:before', '.navbar-mobile-bottom a:hover .header-text-color-bg-speudo:after', '.navbar-mobile-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom ul.sub-menu:before', '.navbar-mobile-bottom .dropdown-menu:before' ),
			'function' => 'css',
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom a:hover', '.navbar-mobile-bottom a:hover span', '.navbar-mobile-bottom .menu-item:hover > a', '.navbar-mobile-bottom .current_page_item > a', '.navbar-mobile-bottom .current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom ul.sub-menu li:hover > a:before', '.navbar-mobile-bottom ul.sub-menu li:hover > a:after', '.navbar-mobile-bottom .dropdown-menu a:after', '.navbar-mobile-bottom .menu-item-has-children:hover > a span.mobile-arrow:before', '.navbar-mobile-bottom .menu-item-has-children:hover > a span.mobile-arrow:after', '.navbar-mobile-bottom li.action-button.label-only > a:hover span.item-counter', '.navbar-mobile-bottom .icon-badge:hover span.item-counter', '.navbar-mobile-bottom a:hover .header-text-color-bg', '.navbar-mobile-bottom a:hover .header-text-color-bg-speudo:before', '.navbar-mobile-bottom a:hover .header-text-color-bg-speudo:after', '.navbar-mobile-bottom .search-box button' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-mobile-bottom ul.sub-menu:before', '.navbar-mobile-bottom .dropdown-menu:before' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );
// Bottom Bar Icon text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'bottom_bar_icon_text_color',
	'label'    => __( 'Icon Text Color', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'js_vars' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom .action-button a:not(.icon-outline) span.item-counter', '.navbar-mobile-bottom .action-button a.icon-outline.icon-badge span.item-counter' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-mobile-bottom .action-button a:not(.icon-outline) span.item-counter', '.navbar-mobile-bottom .action-button a.icon-outline.icon-badge span.item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'settings' => 'bottom_bar_border_color',
	'label'    => __( 'Border Color', 'davis' ),
	'section'  => 'bottom_bar',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => 'rgba(0, 0, 0, 0.1)',
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'         => array( '.navbar-mobile-bottom' ),
			'property'        => 'box-shadow',
			'function'        => 'css',
			'value_pattern'   => '0 -1px 0 $',
		),
	),
	'output' => array(
		array(
			'element'         => array( '.navbar-mobile-bottom' ),
			'property'        => 'box-shadow',
			'value_pattern'   => '0 -1px 0 $',
		),
	),
) );

function pp_element_bottom_bar_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'bottom_bar', array(
		'selector' => '#options',
		'settings' => array( 'bottom_bar_text_color' ),
		'render_callback' => function() {
			$rgba_color = hex2rgba( get_theme_mod( 'bottom_bar_text_color', '#000000' ), 0.1 );

			return '.navbar-mobile-bottom .main-menu-item > .sub-menu, .navbar-mobile-bottom .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .navbar-mobile-bottom .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .navbar-mobile-bottom .dropdown-hover .dropdown-menu { border-color: ' . $rgba_color . ' !important; }';
		},
	) );
}
add_action( 'customize_register', 'pp_element_bottom_bar_partials' );