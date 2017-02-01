<?php

// Add the Header panel
Kirki::add_panel( 'panel_header', array(
    'priority'    => 10,
    'title'       => __( 'Header', 'davis' ),
) );

// LOGO
Kirki::add_section( 'logos', array(
    'title'          => __( 'Logos' ),
    'panel'          => 'panel_header', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Light logo
Kirki::add_field( 'pp_theme', array(
	'settings' => 'light_logo',
	'label'    => __( 'Light Logo', 'davis' ),
    'description' => __( 'Make sure you upload a logo that is at least 100 pixels tall.', 'davis' ),
	'section'  => 'logos',
	'type'     => 'upload',
	'priority' => 10,
	'default'  => '',
) );
// Dark logo
Kirki::add_field( 'pp_theme', array(
	'settings' => 'dark_logo',
	'label'    => __( 'Dark Logo', 'davis' ),
    'description' => __( 'Make sure you upload a logo that is at least 100 pixels tall.', 'davis' ),
	'section'  => 'logos',
	'type'     => 'upload',
	'priority' => 10,
	'default'  => '',
) );

// TOP BAR
Kirki::add_section( 'top_bar', array(
    'title'          => __( 'Top Bar' ),
    'panel'          => 'panel_header', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Show/Hide top bar
Kirki::add_field( 'pp_theme', array(
	'settings' => 'display_top_bar',
	'label'    => __( 'Display Top Bar', 'davis' ),
    'description' => __( 'Choose to show/hide the top bar above the menu header.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Fixed top bar
Kirki::add_field( 'pp_theme', array(
	'settings' => 'fixed_top_bar',
	'label'    => __( 'Fixed Top Bar', 'davis' ),
    'description' => __( 'Choose to have the top bar always at the top of the page whenever the user scroll the page or to let it move.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Fixed', 'davis' ),
		'off' => esc_attr__( 'Moving', 'davis' ),
	),
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
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.navbar-top', '.nav-topbar ul.sub-menu', '.navbar-top .dropdown-hover .dropdown-menu' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.navbar-top', '.nav-topbar ul.sub-menu', '.navbar-top .dropdown-hover .dropdown-menu' ),
			'property' => 'background-color',
		),
	),
) );
// Top Bar text color
Kirki::add_field( 'pp_theme', array(
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
	'transport' => 'postMessage',
	'output' => array(
		array(
			'element'  => '.navbar-top *',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.nav-topbar .menu-item-has-children > a:before', '.nav-topbar .menu-item-has-children > a:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
) );
// Top Bar hover text color
Kirki::add_field( 'pp_theme', array(
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
	'transport' => 'postMessage',
	'output' => array(
		array(
			'element'  => array( 'body .navbar-top a:hover', 'body .navbar-top a:hover span' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( 'body .navbar-top  ul.sub-menu a:after', '.navbar-top .dropdown-menu a:after' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.navbar-top .nav>li ul.sub-menu:before', '.navbar-top .dropdown-menu:before' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );
// Topbar Icons
Kirki::add_field( 'pp_theme', array(
	'settings' => 'topbar_action_icons',
	'label'    => __( 'User Action Icons', 'davis' ),
    'description' => __( 'Choose to show/hide the action icons (account/login, cart, wishlist...)', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Topbar Icon text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'topbar_icon_text_color',
	'label'    => __( 'Icon Counter Color', 'davis' ),
    'description' => __( 'Select the color of the text counter inside the action icons (cart and wishlist).', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.navbar-top .item-counter' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( 'body .navbar-top a span.item-counter' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'topbar_action_icons',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Show/Hide social media
Kirki::add_field( 'pp_theme', array(
	'settings' => 'display_social_media',
	'label'    => __( 'Display Social Media', 'davis' ),
    'description' => __( 'Choose to show/hide the social media icons.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Social media position
Kirki::add_field( 'pp_theme', array(
	'settings' => 'social_media_pos',
	'label'    => __( 'Social media location', 'davis' ),
    'description' => __( 'Choose to display the social media icons on the left or the right of the top bar.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'left',
	'choices'  => array(
		'right'  => esc_attr__( 'Right', 'davis' ),
		'left' => esc_attr__( 'Left', 'davis' ),
	),
) );
// Facebook
Kirki::add_field( 'pp_theme', array(
	'settings' => 'facebook_top_bar',
	'label'    => __( 'Facebook', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Facebook URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_social_media',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Twitter
Kirki::add_field( 'pp_theme', array(
	'settings' => 'twitter_top_bar',
	'label'    => __( 'Twitter', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Twitter URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_social_media',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Google PLus
Kirki::add_field( 'pp_theme', array(
	'settings' => 'google_top_bar',
	'label'    => __( 'Google Plus', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Google Plus URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_social_media',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Instagram
Kirki::add_field( 'pp_theme', array(
	'settings' => 'instagram_top_bar',
	'label'    => __( 'Instagram', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Instagram URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_social_media',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Pinterest
Kirki::add_field( 'pp_theme', array(
	'settings' => 'pinterest_top_bar',
	'label'    => __( 'Pinterest', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Pinterest URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_social_media',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Show/Hide message
Kirki::add_field( 'pp_theme', array(
	'settings' => 'display_message',
	'label'    => __( 'Display Message Box', 'davis' ),
    'description' => __( 'Choose to show/hide the message box.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Message position
Kirki::add_field( 'pp_theme', array(
	'settings' => 'message_pos',
	'label'    => __( 'Message location', 'davis' ),
    'description' => __( 'Choose to display the message box on the left or the right of the top bar.', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'left',
	'choices'  => array(
		'right'  => esc_attr__( 'Right', 'davis' ),
		'left' => esc_attr__( 'Left', 'davis' ),
	),
) );
// Message text
Kirki::add_field( 'pp_theme', array(
	'settings' => 'message_text',
	'label'    => __( 'Message Text', 'davis' ),
	'section'  => 'top_bar',
	'type'     => 'textarea',
	'priority' => 10,
	'default'  => __( 'Free shipping and returns on all orders', 'davis' ),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_message',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'message_text_color',
	'label'    => __( 'Message text Color', 'davis' ),
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
		array(
			'setting'  => 'display_message',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.navbar-top li.message-box',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '.navbar-top li.message-box',
			'property' => 'color',
		),
	),
) );
// Box color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'message_box_color',
	'label'    => __( 'Message Box Color', 'davis' ),
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
		array(
			'setting'  => 'display_message',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.navbar-top li.message-box',
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => '.navbar-top li.message-box',
			'property' => 'background-color',
		),
	),
) );
// HEADER TYPE
Kirki::add_section( 'header_options', array(
    'title'          => __( 'Header Options' ),
    'panel'          => 'panel_header', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Header Style
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_type',
    'label'    => __( 'Header Style', 'davis' ),
    'description' => __( 'Choose a layout between all the available ones.', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'radio-image',
	'priority' => 10,
	'default'  => 'left_logo-center_menu',
	'choices'     => array(
		'left_logo-center_menu'   => get_template_directory_uri() . '/assets/images/admin/header1.jpg',
		'left_logo-left_menu'   => get_template_directory_uri() . '/assets/images/admin/header2.jpg',
		'left_logo-right_menu'   => get_template_directory_uri() . '/assets/images/admin/header3.jpg',
		'center_logo-left_menu'   => get_template_directory_uri() . '/assets/images/admin/header4.jpg',
		'center_logo-center_menu'   => get_template_directory_uri() . '/assets/images/admin/header5.jpg',
		'top_logo-center_menu'   => get_template_directory_uri() . '/assets/images/admin/header6.jpg',
		'top_logo-left_menu'   => get_template_directory_uri() . '/assets/images/admin/header7.jpg',
	),
) );
// Fixed header
Kirki::add_field( 'pp_theme', array(
	'settings' => 'fixed_header',
	'label'    => __( 'Sticky Header', 'davis' ),
    'description' => __( 'Have the header always at the top of the page.', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Sticky', 'davis' ),
		'off' => esc_attr__( 'Scrollable', 'davis' ),
	),
) );
// Transparent header
/*
Kirki::add_field( 'pp_theme', array(
	'settings' => 'transparent_header',
	'label'    => __( 'Top Page Transparent Header', 'davis' ),
    'description' => __( 'Choose to have a transparent header when at the top page. ( Ideal if you have a slideshow underneath a sticky header )', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Yes', 'davis' ),
		'off' => esc_attr__( 'No', 'davis' ),
	),
) );
// Transparent Header text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'transparent_header_text_color',
	'label'    => __( 'Transparent Header Text Color', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.nav-header.transparent *',
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => '.nav-header.transparent *',
			'property' => 'color',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'transparent_header',
			'operator' => '==',
			'value'    => true,
		),
	),
) );
*/
// Header background color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_bg_color',
	'label'    => __( 'Header Background Color', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#ffffff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.primary-nav .mega-menu', '.primary-nav .simple-nav .sub-menu' ),
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
			'element'  => array( '.nav-header', '.nav-header .dropdown-menu', '.header-bg-color-bg', '.header-bg-color-bg-speudo:before', '.header-bg-color-bg-speudo:after', '.primary-nav .mega-menu', '.primary-nav .simple-nav .sub-menu' ),
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
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.nav-header *', '.header-text-color-txt-all *' ),
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => array( '.primary-nav ul li a' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.header-text-color-bg', '.header-text-color-bg-speudo:before', '.header-text-color-bg-speudo:after', '.menu-link:before', '.menu-link:after', '.go-back a:before', '.go-back a:after' ),
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
			'element'  => array( '.primary-nav .ul li a' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.header-text-color-bg', '.header-text-color-bg-speudo:before', '.header-text-color-bg-speudo:after', '.menu-link:before', '.menu-link:after', '.go-back a:before', '.go-back a:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
) );
// Header hover text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_hover_text_color',
	'label'    => __( 'Header Hover Text Color', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'transport' => 'postMessage',
	'output' => array(
		array(
			'element'  => array( '.nav-header a:hover', '.nav-header a:hover i', '.nav-header a:hover:before', '.nav-header a:hover:after', '.current_page_item > a', '.current_page_item > a > i' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.search-box button', '.cd-marker', '.cd-search-trigger.search-form-visible:after', '.primary-nav > li > a:after', '.dropdown-menu li a:after', '.menu-link:hover:before', '.menu-link:hover:after', '.go-back a:hover:before', '.go-back a:hover:after' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
) );
// Logo Choice
Kirki::add_field( 'pp_theme', array(
	'settings' => 'logo_selection',
	'label'    => __( 'Logo Selection', 'davis' ),
    'description' => __( 'Select the logo type you want to display depending on the header color.', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'select',
	'priority' => 10,
	'default'  => 'dark',
	'choices'  => array(
		'light'  => esc_attr__( 'Light', 'davis' ),
		'dark' => esc_attr__( 'Dark', 'davis' ),
	),
) );
// Mega Menu style
Kirki::add_field( 'pp_theme', array(
	'settings' => 'megamenu_fullwidth',
	'label'    => __( 'Mega Menu Style', 'davis' ),
    'description' => __( 'Choose to have the submenu fullwidth or boxed', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Fullwidth', 'davis' ),
		'off' => esc_attr__( 'Boxed', 'davis' ),
	),
) );
// Header Icons
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_action_icons',
	'label'    => __( 'User Action Icons', 'davis' ),
    'description' => __( 'Choose to show/hide the action icons (account/login, cart, wishlist...)', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Header Icon text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_text_color',
	'label'    => __( 'Icon Counter Color', 'davis' ),
    'description' => __( 'Select the color of the text counter inside the action icons (cart and wishlist).', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#ffffff',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.nav-header .item-counter' ),
			'property' => 'color',
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'header_action_icons',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header .item-counter' ),
			'property' => 'color',
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'header_action_icons',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Header Icon hover text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_icon_hover_text_color',
	'label'    => __( 'Icon Counter Hover Color', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#000000',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => array( '.nav-header a:hover .item-counter' ),
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.nav-header a:hover .item-counter' ),
			'property' => 'color',
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'header_action_icons',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Search Icons
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_search_icons',
	'label'    => __( 'Search Icon', 'davis' ),
    'description' => __( 'Choose to show/hide the search icon', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Search Field
Kirki::add_field( 'pp_theme', array(
	'settings' => 'header_search_field',
	'label'    => __( 'Search Input Field', 'davis' ),
    'description' => __( 'Choose to show/hide the search input field.', 'davis' ),
	'section'  => 'header_options',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'header_type',
			'operator' => 'contains',
			'value'    => array( 'top_logo-center_menu', 'top_logo-left_menu', 'center_logo-left_menu' ),
		),
	),
) );

?>
