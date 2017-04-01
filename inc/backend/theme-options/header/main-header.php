<?php

global $transport, $primary_color, $header_options;

// HEADER TYPE
Kirki::add_section( 'main_header', array(
    'title'          => __( 'Main Header', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 3,
) );

// Desktop
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'main_header_title_1',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Desktop', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Fixed header
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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
// Mega Menu Width
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'megamenu_fullwidth',
	'label'    => __( 'Mega Menu Width', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Fullwidth', 'davis' ),
		'off' => esc_attr__( 'Boxed', 'davis' ),
	),
) );
// Menu Position
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'main_header_title_3',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Logo', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// Logo Choice
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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
	'transport'	  => $transport,
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
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header .sub-menu' ),
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
			'element'  => array( '.nav-header .search-box button' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header .sub-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.nav-header .dropdown-hover > a:after' ),
			'property' => 'border-bottom-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .search-box button' ),
			'property' => 'color',
			'suffix'   => '!important',
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
			'element'  => array( '.primary-nav .ul li a','.nav-header .icon-search .select2-container .select2-choice' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .contact-details a:after', '.nav-header .menu-item-has-children > a span.mobile-arrow:before', '.nav-header .menu-item-has-children > a span.mobile-arrow:after', '.nav-header .header-text-color-bg', '.nav-header .header-text-color-bg-speudo:before', '.nav-header .header-text-color-bg-speudo:after', '.nav-header .menu-link:before', '.nav-header .menu-link:after', '.nav-header .go-back a:before', '.nav-header .go-back a:after', '.nav-header .icon-search .select2-container .select2-choice:before', '.nav-header .icon-search .select2-container .select2-choice:after' ),
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
			'element'  => array( '.primary-nav .ul li a','.nav-header .icon-search .select2-container .select2-choice' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .contact-details a:after', '.nav-header .menu-item-has-children > a span.mobile-arrow:before', '.nav-header .menu-item-has-children > a span.mobile-arrow:after', '.nav-header .header-text-color-bg', '.nav-header .header-text-color-bg-speudo:before', '.nav-header .header-text-color-bg-speudo:after', '.nav-header .menu-link:before', '.nav-header .menu-link:after', '.nav-header .go-back a:before', '.nav-header .go-back a:after', '.nav-header .icon-search .select2-container .select2-choice:before', '.nav-header .icon-search .select2-container .select2-choice:after' ),
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
			'element'  => array( '.nav-header .simple-menu-item > .sub-menu:before', '.nav-header .simple-menu-item:hover > a','.nav-header a:hover', '.nav-header a:hover i', '.nav-header .action-button a:hover span', '.nav-header .current_page_item > a', '.nav-header .current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:before', '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:after', '.nav-header .search-box button', '.nav-header .cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.nav-header .dropdown-menu li a:after', '.nav-header .menu-item:not(.simple-menu-item):hover > a:before', '.nav-header .menu-item:hover > a:after', '.nav-header .go-back a:hover:before', '.nav-header .go-back a:hover:after','.nav-header a:hover .header-text-color-bg', '.nav-header a:hover .header-text-color-bg-speudo:before', '.nav-header a:hover .header-text-color-bg-speudo:after' ),
			'function' => 'css',
			'property' => 'background-color',
            'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header .simple-menu-item > .sub-menu:before', '.nav-header .simple-menu-item:hover > a', '.nav-header a:hover', '.nav-header a:hover i', '.nav-header .action-button a:hover span', '.nav-header .current_page_item > a', '.nav-header .current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
        array(
            'element'  => array( '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:before', '.nav-header .menu-item-has-children:hover > a span.mobile-arrow:after','.nav-header .search-box button', '.nav-header .cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.nav-header .dropdown-menu  li a:after', '.nav-header .menu-item:not(.simple-menu-item):hover > a:before', '.nav-header .menu-item:hover > a:after', '.nav-header .go-back a:hover:before', '.nav-header .go-back a:hover:after','.nav-header a:hover .header-text-color-bg', '.nav-header a:hover .header-text-color-bg-speudo:before', '.nav-header a:hover .header-text-color-bg-speudo:after' ),
            'property' => 'background-color',
            'suffix'   => '!important',
        ),
	),
) );

// Icons Color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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

?>