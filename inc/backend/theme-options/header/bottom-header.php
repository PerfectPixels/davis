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
// Colors
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'bottom_header_title_1',
	'section'     => 'bottom_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Colors', 'davis' ) . '</h3>',
	'priority'    => 10,
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
			'element'  => array( '.navbar-bottom', '.navbar-bottom > ul > li > .sub-menu', '.navbar-bottom .dropdown-hover .dropdown-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .wishlist-counter', '.navbar-bottom .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom', '.navbar-bottom > ul > li > .sub-menu', '.navbar-bottom .dropdown-hover .dropdown-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.navbar-bottom .wishlist-counter', '.navbar-bottom .search-box button' ),
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
		),
		array(
			'element'  => array( '.navbar-bottom .wishlist-counter', '.navbar-bottom .menu-item > a:before', '.navbar-bottom .menu-item > a:after', '.navbar-bottom .sep', '.navbar-bottom .contact-details a:after', '.navbar-bottom .go-back > a:before', '.navbar-bottom .go-back > a:after', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a span.item-counter', '.navbar-bottom .icon-badge span.item-counter', '.navbar-bottom .header-text-color-bg', '.navbar-bottom .header-text-color-bg-speudo:before', '.navbar-bottom .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-bottom *', '.navbar-bottom .menu-item:hover > a.no-link' ),
			'property' => 'color',
		),
		array(
			'element'  => array( '.navbar-bottom .wishlist-counter', '.navbar-bottom .menu-item > a:before', '.navbar-bottom .menu-item > a:after', '.navbar-bottom .sep', '.navbar-bottom .contact-details a:after', '.navbar-bottom .go-back > a:before', '.navbar-bottom .go-back > a:after', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:before', '.navbar-bottom .menu-item-has-children > a span.mobile-arrow:after', '.navbar-bottom li.action-button.label-only > a span.item-counter', '.navbar-bottom .icon-badge span.item-counter', '.navbar-bottom .header-text-color-bg', '.navbar-bottom .header-text-color-bg-speudo:before', '.navbar-bottom .header-text-color-bg-speudo:after' ),
			'property' => 'background-color',
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
// Icon
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'bottom_header_title_2',
	'section'     => 'bottom_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Icons', 'davis' ) . '</h3>',
	'priority'    => 10,
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
// Border
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'bottom_header_title_3',
	'section'     => 'bottom_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Bottom Border', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport' => 'postMessage',
	'settings' => 'bottom_header_border',
	'label'    => __( 'Display Border', 'davis' ),
	'description' => __( 'Add a bottom border', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );
Kirki::add_field( 'pp_theme', array(
	'transport' => 'postMessage',
	'settings' => 'bottom_header_hide_border',
	'label'    => __( 'Hide Border at Top', 'davis' ),
	'description' => __( 'Hide the border when the page has not been scrolled', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
	'active_callback'    => array(
		array(
			'setting'  => 'main_header_border',
			'operator' => '==',
			'value'    => true,
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'settings' => 'bottom_header_border_color',
	'label'    => __( 'Border Color', 'davis' ),
	'section'  => 'bottom_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => 'rgba(0, 0, 0, 0.1)',
	'transport' => 'postMessage',
	'active_callback'    => array(
		array(
			'setting'  => 'bottom_header_border',
			'operator' => '==',
			'value'    => true,
		),
	),
	'js_vars' => array(
		array(
			'element'         => array( '.navbar-bottom.shadow' ),
			'property'        => 'box-shadow',
			'function'        => 'css',
			'value_pattern'   => '0 1px 0 $',
		),
		array(
			'element'         => array( '.scrolled .navbar-bottom.shadow.hide-shadow-top' ),
			'property'        => 'box-shadow',
			'function'        => 'css',
			'value_pattern'   => '0 1px 0 $',
			'suffix'          => '!important',
		),
	),
	'output' => array(
		array(
			'element'         => array( '.navbar-bottom.shadow' ),
			'property'        => 'box-shadow',
			'value_pattern'   => '0 1px 0 $',
		),
		array(
			'element'         => array( '.scrolled .navbar-bottom.shadow.hide-shadow-top' ),
			'property'        => 'box-shadow',
			'value_pattern'   => '0 1px 0 $',
			'suffix'          => '!important',
		),
	),
) );

function pp_element_bottom_header_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'bottom_header_element', array(
		'selector' => '.nav-header',
		'container_inclusive' => true,
		'settings' => array( 'bottom_header_hide_border' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/bottom-header' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'bottom_header', array(
		'selector' => '#options',
		'settings' => array( 'bottom_header_text_color' ),
		'render_callback' => function() {
			$rgba_color = hex2rgba( get_theme_mod( 'bottom_header_text_color', '#000000' ), 0.1 );

			return '.navbar-bottom .main-menu-item > .sub-menu, .navbar-bottom .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .navbar-bottom .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .navbar-bottom .dropdown-hover .dropdown-menu { border-color: ' . $rgba_color . ' !important; }';
		},
	) );
}
add_action( 'customize_register', 'pp_element_bottom_header_partials' );