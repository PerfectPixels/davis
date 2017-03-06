<?php

if ( class_exists('Kirki') ) :

	// Available header elements
	$header_elements = array(
		array( 'account', __( 'Account', 'davis' ), 'account_element' ),
		array( 'button_1', __( 'Button 1', 'davis' ), 'buttons_element' ),
		array( 'button_2', __( 'Button 2', 'davis' ), 'buttons_element' ),
		array( 'cart', __( 'Cart', 'davis' ), 'cart_element' ),
		// array( 'checkout_button', __( 'Checkout Button', 'davis' ) ),
		array( 'contact', __( 'Contact', 'davis' ), 'contact_element' ),
		array( 'language_switcher', __( 'Language Menu', 'davis' ) ),
		array( 'main_menu', __( 'Main Menu', 'davis' ) ),
		array( 'menu-icon', __( 'Main Menu Icon', 'davis' ) ),
		// array( 'newsletter', __( 'Newsletter', 'davis' ), 'newsletter_element' ),
		array( 'html_1', __( 'Raw HTML 1', 'davis' ), 'raw_html_element' ),
		array( 'html_2', __( 'Raw HTML 2', 'davis' ), 'raw_html_element' ),
		array( 'search_icon', __( 'Search Icon', 'davis' ), 'search_element' ),
		array( 'search-form', __( 'Search Form', 'davis' ), 'search_element' ),
		array( 'separator_1', __( '|', 'davis' ) ),
		array( 'separator_2', __( '|', 'davis' ) ),
		array( 'separator_3', __( '|', 'davis' ) ),
		array( 'separator_4', __( '|', 'davis' ) ),
		array( 'social_media', __( 'Social Icons', 'davis' ), 'social_media' ),
		array( 'text_1', __( 'Text 1', 'davis' ), 'texts_element' ),
		array( 'text_2', __( 'Text 2', 'davis' ), 'texts_element' ),
		array( 'text_3', __( 'Text 3', 'davis' ), 'texts_element' ),
		array( 'topbar_nav_1', __( 'Top Bar Nav 1', 'davis' ) ),
		array( 'topbar_nav_2', __( 'Top Bar Nav 2', 'davis' ) ),
		array( 'whishlist', __( 'Whishlist', 'davis' ), 'whishlist_element' ),
	);

	// Parse to output the correct options in customizer
	$header_options = array();

	foreach ($header_elements as $key => $value) {
		$header_options[$value[0]] = $value[1];
	}

	// Style the Kirki customizer
	function kirki_styling( $config ) {
		return wp_parse_args( array(
			'disable_loader'  => true,
		), $config );
	}
	add_filter( 'kirki/config', 'kirki_styling' );

	// Add the configuration settings
	Kirki::add_config( 'pp_theme', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	$primary_color = '#c59d5f';
	$secondary_color = '#ffffff';
	$transport = 'refresh';

	if ( ! isset( $wp_customize->selective_refresh ) ) {
	  $transport = 'refresh';
	}

	// Include all files
	foreach ( glob( get_template_directory() . '/inc/backend/theme-options/*.php' ) as $filename ){
	    include_once $filename;
	}

endif;

?>
