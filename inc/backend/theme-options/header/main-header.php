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

// Mobile/Tablet
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'main_header_title_2',
	'section'     => 'main_header',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Mobile/Tablet', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
// OffCanvas Menu background color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_bg_color',
	'label'    => __( 'OffCanvas Menu Background Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#2e3233',
	'transport' => 'postMessage',
	'js_varss'   => array(
		array(
			'element'  => array( '' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '' ),
			'property' => 'background-color',
		),
	),
) );
// OffCanvas Menu text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'offcanvas_menu_txt_color',
	'label'    => __( 'OffCanvas Menu Text Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#bbb',
	'transport' => 'postMessage',
	'js_varss'   => array(
		array(
			'element'  => array( '' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '' ),
			'property' => 'color',
		),
	),
) );
// OffCanvas Menu Content
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'select',
	'settings'    => 'offcanvas_menu_elements',
	'label'       => __( 'OffCanvas Menu Content', 'davis' ),
	'section'     => 'main_header',
	'default'     => array( 'main_menu', 'account', 'social_media' ),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => $header_options,
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
	'js_varss'   => array(
		array(
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header .sub-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.dropdown-hover > a:after' ),
			'function' => 'css',
			'property' => 'border-bottom-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.nav-header .sub-menu' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.dropdown-hover > a:after' ),
			'property' => 'border-bottom-color',
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
			'element'  => array( '.nav-header *', '.header-text-color-txt-all *' ),
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => array( '.primary-nav .ul li a','.cd-main-search .select2-container .select2-choice' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.header-text-color-bg', '.header-text-color-bg-speudo:before', '.header-text-color-bg-speudo:after', '.menu-link:before', '.menu-link:after', '.go-back a:before', '.go-back a:after', '.cd-main-search .select2-container .select2-choice:before', '.cd-main-search .select2-container .select2-choice:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header *', '.header-text-color-txt-all *' ),
			'property' => 'color',
		),
		array(
			'element'  => array( '.primary-nav .ul li a','.cd-main-search .select2-container .select2-choice' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.header-text-color-bg', '.header-text-color-bg-speudo:before', '.header-text-color-bg-speudo:after', '.menu-link:before', '.menu-link:after', '.go-back a:before', '.go-back a:after', '.cd-main-search .select2-container .select2-choice:before', '.cd-main-search .select2-container .select2-choice:after' ),
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
			'element'  => array( '.nav-header a:hover', '.nav-header a:hover i', '.nav-header a:hover:before', '.nav-header a:hover:after', '.current_page_item > a', '.current_page_item > a > i' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.search-box button', '.cd-marker', '.cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.dropdown-menu li a:after', '.menu-link:hover:before', '.menu-link:hover:after', '.go-back a:hover:before', '.go-back a:hover:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header a:hover', '.nav-header a:hover i', '.nav-header a:hover:before', '.nav-header a:hover:after', '.current_page_item > a', '.current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.search-box button', '.cd-marker', '.cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.dropdown-menu li a:after', '.menu-link:hover:before', '.menu-link:hover:after', '.go-back a:hover:before', '.go-back a:hover:after' ),
			'property' => 'background-color',
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
			'element'  => array( '.nav-header > li.icon > a:before' ),
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header > li.icon > a:before' ),
			'property' => 'color',
		),
	),
) );
// Header Icon Hover color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_color',
	'label'    => __( 'Icon Hover Color', 'davis' ),
	'section'  => 'main_header',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => array( '.nav-header > li.icon > a:hover:before' ),
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header > li.icon > a:hover:before' ),
			'property' => 'color',
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
			'element'  => array( '.nav-header > li.icon .item-counter' ),
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header > li.icon .item-counter' ),
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
			'element'  => array( '.nav-header > li.icon a:hover .item-counter' ),
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header > li.icon a:hover .item-counter' ),
			'property' => 'color',
		),
	),
) );

?>