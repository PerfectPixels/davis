<?php

global $primary_color, $header_options;

// HEADER TYPE
Kirki::add_section( 'main_header', array(
    'title'          => __( 'Main Header', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 3,
) );

// Desktop
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'main_header_title_1',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Desktop', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Fixed header
Kirki::add_field( 'pp_theme', array(
	'settings' => 'fixed_header',
	'label'    => __( 'Sticky Header', 'davis' ),
    'description' => __( 'Have the header always at the top of the page.', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );
// Height
//Kirki::add_field( 'pp_theme', array(
//    'transport'	  => 'postMessage',
//    'type'        => 'slider',
//    'settings'    => 'main_header_height',
//    'label'       => esc_attr__( 'Height', 'davis' ),
//    'section'     => 'main_header',
//    'default'     => 70,
//    'choices'     => array(
//        'min'  => '40',
//        'max'  => '300',
//        'step' => '1',
//    ),
//    'js_vars'  => array(
//        array(
//            'element'  => array( '.nav-header', '.nav-header .primary-nav > .menu-item > a' ),
//            'property' => 'height',
//            'suffix'   => 'px',
//        ),
//        array(
//            'element'  => array( '.admin-bar.top-bar-is-fixed.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(32px + 40px + $px)',
//        ),
//        array(
//            'element'  => array( '.admin-bar.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(32px + $px)',
//        ),
//        array(
//            'element'  => array( '.top-bar-is-fixed.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(40px + $px)',
//        ),
//        array(
//            'element'  => array( '.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'suffix'   => 'px',
//        ),
//    ),
//    'output' => array(
//        array(
//            'element'  => array( '.nav-header', '.nav-header .primary-nav > .menu-item > a' ),
//            'property' => 'height',
//            'suffix'   => 'px',
//        ),
//        array(
//            'element'  => array( '.admin-bar.top-bar-is-fixed.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(32px + 40px + $px)',
//        ),
//        array(
//            'element'  => array( '.admin-bar.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(32px + $px)',
//        ),
//        array(
//            'element'  => array( '.top-bar-is-fixed.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'value_pattern'   => 'calc(40px + $px)',
//        ),
//        array(
//            'element'  => array( '.nav-is-fixed.bottom-bar-is-fixed .navbar-bottom' ),
//            'function' => 'css',
//            'property' => 'top',
//            'suffix'   => 'px',
//        ),
//    ),
//) );
// Menu Position
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'content_pos',
	'label'    => __( 'Content Position', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'left',
	'choices'  => array(
		'left'  => esc_attr__( 'Left', 'davis' ),
		'center' => esc_attr__( 'Center', 'davis' ),
		'right' => esc_attr__( 'Right', 'davis' ),
	),
) );

// Logo
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'main_header_title_3',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Logo', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Logo Choice
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'logo_selection',
	'label'    => __( 'Logo Selection', 'davis' ),
    'description' => __( 'Select the logo type you want to display based on the header background color.', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'dark',
	'choices'  => array(
		'light'  => esc_attr__( 'Light', 'davis' ),
		'dark' => esc_attr__( 'Dark', 'davis' ),
	),
) );

// Colors
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'main_header_title_4',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Colors', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Header background color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_bg_color',
	'label'    => __( 'Header Background Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#ffffff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.nav-header', '.nav-header > ul > li > .sub-menu', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header .main-menu-item > .sub-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.nav-header .dropdown-hover > a:after' ),
			'function' => 'css',
			'property' => 'border-bottom-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .wishlist-counter' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header', '.nav-header > ul > li > .sub-menu', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header  .main-menu-item > .sub-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.nav-header .dropdown-hover > a:after' ),
			'property' => 'border-bottom-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .wishlist-counter' ),
			'property' => 'color',
		),
	),
) );
// Header text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_text_color',
	'label'    => __( 'Header Text Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header *', '.nav-header .header-text-color-txt-all *' ),
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => array( '.primary-nav .ul li a', '.nav-header .icon-search .select2-container .select2-choice', '.nav-header .dropdown-hover .dropdown-menu a' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .wishlist-counter', '.nav-header .sep', '.nav-header .contact-details a:after', '.nav-header .menu-item-has-children > a span.mobile-arrow:before', '.nav-header .menu-item-has-children > a span.mobile-arrow:after', '.nav-header .header-text-color-bg', '.nav-header .header-text-color-bg-speudo:before', '.nav-header .header-text-color-bg-speudo:after', '.nav-header .menu-link:before', '.nav-header .menu-link:after', '.nav-header .go-back a:before', '.nav-header .go-back a:after', '.nav-header .icon-search .select2-container .select2-choice:before', '.nav-header .icon-search .select2-container .select2-choice:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header *', '.nav-header .header-text-color-txt-all *' ),
			'property' => 'color',
		),
		array(
			'element'  => array( '.primary-nav .ul li a','.nav-header .icon-search .select2-container .select2-choice', '.nav-header .dropdown-hover .dropdown-menu a' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .wishlist-counter', '.nav-header .sep', '.nav-header .contact-details a:after', '.nav-header .menu-item-has-children > a span.mobile-arrow:before', '.nav-header .menu-item-has-children > a span.mobile-arrow:after', '.nav-header .header-text-color-bg', '.nav-header .header-text-color-bg-speudo:before', '.nav-header .header-text-color-bg-speudo:after', '.nav-header .menu-link:before', '.nav-header .menu-link:after', '.nav-header .go-back a:before', '.nav-header .go-back a:after', '.nav-header .icon-search .select2-container .select2-choice:before', '.nav-header .icon-search .select2-container .select2-choice:after' ),
			'property' => 'background-color',
		),
	),
) );
// Header hover text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_hover_text_color',
	'label'    => __( 'Header Hover Text Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header .dropdown-hover .dropdown-menu a:hover', '.nav-header .simple-menu-item > .sub-menu:before', '.nav-header .simple-menu-item:hover > a','.nav-header a:hover', '.nav-header a:hover i', '.nav-header .action-button a:hover span', '.nav-header .current_page_item > a', '.nav-header .current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:before', '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:after', '.nav-header .cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.nav-header .dropdown-menu li a:after', '.nav-header .menu-item:not(.simple-menu-item) > a:hover:before', '.nav-header .menu-item:not(.simple-menu-item) > a:hover:after', '.nav-header .go-back a:hover:before', '.nav-header .go-back a:hover:after','.nav-header a:hover .header-text-color-bg', '.nav-header a:hover .header-text-color-bg-speudo:before', '.nav-header a:hover .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
            'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header .dropdown-hover .dropdown-menu a:hover', '.nav-header .simple-menu-item > .sub-menu:before', '.nav-header .simple-menu-item:hover > a', '.nav-header a:hover', '.nav-header a:hover i', '.nav-header .action-button a:hover span', '.nav-header .current_page_item > a', '.nav-header .current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
        array(
            'element'  => array( '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:before', '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:after', '.nav-header .cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.nav-header .dropdown-menu  li a:after', '.nav-header .menu-item:not(.simple-menu-item) > a:hover:before', '.nav-header :not(.simple-menu-item) > a:hover:after', '.nav-header .go-back a:hover:before', '.nav-header .go-back a:hover:after','.nav-header a:hover .header-text-color-bg', '.nav-header a:hover .header-text-color-bg-speudo:before', '.nav-header a:hover .header-text-color-bg-speudo:after' ),
            'property' => 'background-color',
            'suffix'   => '!important',
        ),
	),
) );

// Icons Color
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'main_header_title_5',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Icons Color', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Header Icon color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_color',
	'label'    => __( 'Icon Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000',
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header li.action-button > a' ),
			'property' => 'color',
		),
		array(
			'element'  => array( '.nav-header li.action-button.label-only > a span.item-counter', '.nav-header .icon-badge span.item-counter' ),
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header li.action-button > a' ),
			'property' => 'color',
		),
		array(
			'element'  => array( '.nav-header li.action-button.label-only > a span.item-counter', '.nav-header .icon-badge span.item-counter' ),
			'property' => 'background-color',
		),
	),
) );
// Header Icon Hover color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_hover_color',
	'label'    => __( 'Icon Hover Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header li.action-button.label-only > a:hover span.item-counter', '.nav-header .icon-badge:hover span.item-counter' ),
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header li.action-button.label-only > a:hover span.item-counter', '.nav-header .icon-badge:hover span.item-counter' ),
			'property' => 'background-color',
		),
	),
) );
// Header Icon text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_text_color',
	'label'    => __( 'Icon Text Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#ffffff',
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header li.action-button a:not(.icon-outline) .item-counter', '.nav-header li.action-button a.icon-outline.icon-badge .item-counter' ),
			'property' => 'color',
			'function' => 'css',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header li.action-button a:not(.icon-outline) .item-counter', '.nav-header li.action-button a.icon-outline.icon-badge .item-counter' ),
			'property' => 'color',
		),
	),
) );
// Header Icon hover text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_hover_text_color',
	'label'    => __( 'Icon Hover Text Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header li.action-button a:hover .item-counter' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header li.action-button a:hover .item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

// Border
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'main_header_title_6',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Bottom Border', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport' => 'postMessage',
	'settings' => 'main_header_border',
	'label'    => __( 'Display Border', 'davis' ),
	'description' => __( 'Add a bottom border to the header', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '1',
) );
Kirki::add_field( 'pp_theme', array(
	'transport' => 'postMessage',
	'settings' => 'main_header_hide_border',
	'label'    => __( 'Hide Border at Top', 'davis' ),
	'description' => __( 'Hide the border when the page has not been scrolled', 'davis' ),
	'section'  => 'main_header',
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
	'settings' => 'main_header_border_color',
	'label'    => __( 'Border Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => 'rgba(0, 0, 0, 0.1)',
	'transport' => 'postMessage',
	'active_callback'    => array(
		array(
			'setting'  => 'main_header_border',
			'operator' => '==',
			'value'    => true,
		),
	),
	'js_vars' => array(
		array(
			'element'         => array( '.nav-header.shadow' ),
			'property'        => 'box-shadow',
			'function'        => 'css',
			'value_pattern'   => '0 1px 0 $',
		),
		array(
			'element'         => array( '.scrolled .nav-header.shadow.hide-shadow-top' ),
			'property'        => 'box-shadow',
			'function'        => 'css',
			'value_pattern'   => '0 1px 0 $',
			'suffix'          => '!important',
		),
	),
	'output' => array(
		array(
			'element'         => array( '.nav-header.shadow' ),
			'property'        => 'box-shadow',
			'value_pattern'   => '0 1px 0 $',
		),
		array(
			'element'         => array( '.scrolled .nav-header.shadow.hide-shadow-top' ),
			'property'        => 'box-shadow',
			'value_pattern'   => '0 1px 0 $',
			'suffix'          => '!important',
		),
	),
) );

function pp_element_main_header_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'main_header_element', array(
		'selector' => '.nav-header',
		'container_inclusive' => true,
		'settings' => array( 'content_pos', 'logo_selection', 'main_header_border', 'main_header_hide_border' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/navigation' );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'header_text_color', array(
		'selector' => '#options',
		'settings' => array( 'header_text_color' ),
		'render_callback' => function() {
			$rgba_color = hex2rgba( get_theme_mod( 'header_text_color', '#000000' ), 0.1 );

			return '.nav-header .menu-item-has-children > .sub-menu, .nav-header .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .nav-header .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .nav-header .dropdown-hover .dropdown-menu { border-color: ' . $rgba_color . ' !important; }';
		},
	) );
}
add_action( 'customize_register', 'pp_element_main_header_partials' );
