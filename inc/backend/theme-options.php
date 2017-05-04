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
		array( 'main_menu', __( 'Main Menu', 'davis' ), 'main_menu' ),
		array( 'menu_icon', __( 'Offcanvas Main Menu', 'davis' ), 'offcanvas_main_menu_element' ),
		// array( 'newsletter', __( 'Newsletter', 'davis' ), 'newsletter_element' ),
		array( 'html_1', __( 'Raw HTML 1', 'davis' ), 'raw_html_element' ),
		array( 'html_2', __( 'Raw HTML 2', 'davis' ), 'raw_html_element' ),
		array( 'search_icon', __( 'Search Icon', 'davis' ), 'search_element' ),
		array( 'search_form', __( 'Search Form', 'davis' ), 'search_element' ),
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
	);

	$header_presets = array(
        array( 'preset-1', '[main_header_left_area:main_menu][main_header_right_area:search_icon,account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'left_logo,center_logo_tablet', 'center', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
        array( 'preset-2', '[main_header_left_area:main_menu][main_header_right_area:search_icon,account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'left_logo,center_logo_tablet', 'left', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
        array( 'preset-3', '[main_header_left_area:main_menu][main_header_right_area:search_icon,account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'left_logo,center_logo_tablet', 'right', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
        array( 'preset-4', '[main_header_left_area:main_menu][main_header_right_area:search_icon,account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'center_logo,center_logo_tablet', 'left', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
        array( 'preset-5', '[main_header_left_area:search_icon,account][main_header_right_area:wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'center_logo_split_menu,center_logo_tablet', 'center', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
        array( 'preset-7', '[main_header_right_area:search_icon,account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart][bottom_header_center_area:main_menu]', 'center_logo,center_logo_tablet', 'center', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only][switch:fixed_bottom_bar:true][switch:main_header_border:false][slider:bottom_header_height:40]' ),
        array( 'preset-8', '[main_header_left_area:search_form][main_header_right_area:account,wishlist,cart][bottom_header_center_area:main_menu][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'center_logo,center_logo_tablet', 'center', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only][switch:fixed_bottom_bar:true][switch:main_header_border:false][slider:search_box_width:35][slider:bottom_header_height:40]' ),
        array( 'preset-9', '[main_header_right_area:search_form][bottom_header_left_area:main_menu][bottom_header_right_area:account,wishlist,cart][tablet_main_header_left_area:menu_icon][tablet_main_header_right_area:search_icon,account,wishlist,cart]', 'left_logo,center_logo_tablet', 'left', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only][switch:fixed_bottom_bar:true][switch:main_header_border:false][slider:search_box_width:80][slider:bottom_header_height:40]' ),
        array( 'preset-10', '[main_header_left_area:main_menu][main_header_right_area:wishlist,separator_1,account,cart,search_icon][tablet_main_header_left_area:search_icon,cart][tablet_main_header_right_area:menu_icon]', 'center_logo,center_logo_tablet', 'center', '[radio:account_style:label-only][radio:wishlist_style:label-only][radio:cart_style:icon-only][radio:cart_icon_style:icon-shopping-cart-outline][radio:search_style:icon-search-2]' ),
        array( 'preset-11', '[main_header_right_area:account,separator_1,cart,search_icon,menu_icon][tablet_main_header_right_area:account,separator_1,cart,search_icon,menu_icon]', 'left_logo,left_logo_tablet', 'left', '[radio:account_style:label-only][radio:wishlist_style:label-only][radio:cart_style:icon-only][radio:cart_icon_style:icon-shopping-basket-outline][radio:search_style:icon-search-2]' ),
        array( 'preset-12', '[main_header_left_area:menu_icon][main_header_right_area:cart,search_icon,account][tablet_main_header_left_area:search_icon][tablet_main_header_right_area:cart,search_icon,account]', 'center_logo,center_logo_tablet', 'center', '[radio:account_style:label-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only][radio:cart_icon_style:icon-shopping-bag-2][radio:search_style:icon-search-1]' ),
		array( 'preset-6', '[top_bar_left_area:social_media,text_1][top_bar_right_area:topbar_nav_1][main_header_left_area:main_menu][main_header_right_area:account,wishlist,cart][tablet_top_bar_left_area:topbar_nav_1,text_1][tablet_top_bar_right_area:account,wishlist,cart][tablet_main_header_left_area:search_icon][tablet_main_header_right_area:menu_icon]', 'left_logo,center_logo_tablet', 'center', '[radio:account_style:icon-only][radio:wishlist_style:icon-only][radio:cart_style:icon-only]' ),
		array( 'preset-13', '[top_bar_left_area:text_1][top_bar_right_area:account,separator_1,wishlist][main_header_right_area:search_form][bottom_header_center_area:main_menu,separator_2,cart][tablet_main_header_left_area:search_icon][tablet_main_header_right_area:account,separator_1,cart]', 'left_logo,center_logo_tablet', 'left', '[radio:account_style:label-only][radio:wishlist_style:label-only][slider:search_box_width:30][radio:cart_style:icon-label][radio:cart_icon_style:icon-shopping-bag-3][slider:bottom_header_height:50][switch:fixed_header:false][switch:fixed_bottom_bar:true]' )
	);

	// If wishlist plugin is activated
	if ( class_exists('WC_Wishlists_wishlist') || class_exists('YITH_WCWL') ) {
		$header_elements[] = array( 'wishlist', __( 'Wishlist', 'davis' ), 'wishlist_element' );
	}

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

	// Include all files
	foreach ( glob( get_template_directory() . '/inc/backend/theme-options/*.php' ) as $filename ){
	    include_once $filename;
	}

endif;

?>
