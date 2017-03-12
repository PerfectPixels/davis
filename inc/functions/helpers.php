<?php
/**
 * Functions to retrieve customizer options
 *
 * @package Davis
 */

/**
  * Get the header elements.
  *
  * @access public
  * @param string $section
  */
function pp_get_header_elements( $section ){
	$options = get_theme_mod( $section );

	if ( is_array($options) ) {
		foreach ( $options as $key => $value ) {

			if ( $value === 'topbar_nav_1' ) {
				pp_get_menu( 'topbar_navigation_1' );
			} else if ( $value === 'topbar_nav_2' ) {
				pp_get_menu( 'topbar_navigation_2' );
			} else if ( $value === 'main_menu' ) {
				pp_get_menu( 'primary_navigation' );
			} else if ( $value == 'separator_1' || $value == 'separator_2' || $value == 'separator_3' || $value == 'separator_4' ) {
				echo '<hr>';
			} else if ( $value == 'html' || $value == 'html-2' || $value == 'html-3' || $value == 'html-4' || $value == 'html-5' ) {
				echo flatsome_get_header_html_element( $value );
			} else if ( $value == 'wpml' ) {
				get_template_part( 'template-parts/header/element/languages' );
			} else {
				get_template_part( 'template-parts/header/elements/' . str_replace( '_', '-', $value ) );
			}

			//do_action( 'pp_get_header_elements', $value );

		}
	}
}

/**
 * Check if can display the element
 *
 * @access public
 * @param string $element
 * @return boolean
 */
function pp_can_display( $element ){
    $output = false;

    if ( $element === 'bottom_header' ){
        if ( get_theme_mod( 'bottom_header_left_area' ) || get_theme_mod( 'bottom_header_center_area' ) || get_theme_mod( 'bottom_header_right_area' ) ){
            $output = true;
        }
    } else if ( $element === 'mobile_bottom' ){
        if ( get_theme_mod( 'mobile_bottom_bar_area' ) ){
            $output = true;
        }
    }

    return $output;
}

/**
  * Get menu
  *
  * @access public
  * @param string $location
  */
function pp_get_menu( $location ){
	$args = array();

	if ( $location === 'primary_navigation' ){
		$args = array( 'walker' => new PP_Walker_Nav_Menu() );
	}

	$defaults = array(
		'theme_location' 	=> $location,
		'container'			=> '',
		'items_wrap'      	=> '%3$s',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( has_nav_menu( $location ) ){
		wp_nav_menu( $args );
	} else {
		echo '<li><a href="' . get_admin_url().'customize.php?url='.get_permalink().'&autofocus%5Bsection%5D=menu_locations' . '">' . __( 'Assign a menu in Theme Options > Menus', 'davis' ) . '</a></li>';
	}
}

 /**
  * Get classes
  *
  * @access public
  * @param string $element
  */
function pp_get_classes( $element ){
	$header_classes = array();

	switch ( $element ) {
		case 'top_bar':
			if ( get_theme_mod( 'fixed_top_bar', true ) == true ) { $header_classes[] = 'navbar-fixed-top'; }
			break;
		
		case 'main-header':
			if ( get_theme_mod( 'logo_pos', 'left' ) == 'split_menu' ) { $header_classes[] = 'center_logo_split_menu'; }
			if ( get_field( 'transparent_header' ) ) { $header_classes[] = 'transparent'; }
			$header_classes[] = get_theme_mod( 'content_pos', 'left' ) . '_content';
			break;

		case 'megamenu':
			if ( get_theme_mod( 'megamenu_fullwidth', false ) == true ) { $header_classes[] = 'fullwidth'; }
			break;

		case 'button_1':
			if ( get_theme_mod( 'button_1_outlined', false ) == true ) { $header_classes[] = 'outlined'; }
			$header_classes[] = get_theme_mod( 'button_1_type', 'rounded' );
			break;

        case 'contact':
            $header_classes[] = get_theme_mod( 'contact_style', 'icon_label' );
            break;
	}

	echo implode( ' ', $header_classes );
}

/**
  * Get header styles
  *
  * @access public
  * @param string $element
  */
function pp_get_styles( $element ){
	global $primary_color;

	$style = '';

	switch ( $element ) {
		case 'main-header-css':
			$transparent 	   = get_field( 'transparent_header' );
			$transparent_color = get_field( 'transparent_header_text_color' );
			$transparent_icon  = get_field( 'transparent_header_icon_counter_color' );
			$header_bg		   = get_field( 'header_background_color' );
			$header_text	   = get_field( 'header_text_color' );
			$header_icon	   = get_field( 'header_icon_counter_color' );

			if ( $header_text || $header_bg || $transparent ) {
				$style .= '<style>';

					if ( $header_text ){
						$style .= '.nav-header * { color:' . $header_text . '; }
							.header-text-color-bg,
							.header-text-color-bg-speudo:before,
							.header-text-color-bg-speudo:after,
							.menu-link:before,
							.menu-link:after,
							.go-back a:before,
							.go-back a:after { background-color: ' . $header_text . '; }
							.nav-header .item-counter { color:' . $header_icon . ' !important; }';
					}

					if ( $header_bg ) {
						$style .= '.header-bg-color-bg,
							.primary-nav .mega-menu,
							.primary-nav .simple-nav .sub-menu { background-color:' . $header_bg . '; }';
					}

					if ( $transparent ) {
						$style .= '.nav-header.transparent:not(.fixedsticky-on) nav > ul > li > a,
							.nav-header.transparent:not(.fixedsticky-on) .header-button > a { color: ' . $transparent_color .'; }
							.nav-header.transparent:not(.fixedsticky-on) .nav-button span,
							.nav-header.transparent:not(.fixedsticky-on) .nav-button span:before,
							.nav-header.transparent:not(.fixedsticky-on) .nav-button span:after { background-color: ' . $transparent_color . '; }
							.nav-heaver.transparent .item-counter { color:' . $transparent_icon . '; }';
					}

				$style .= '</style>';
			}
			break;
	}

	echo $style;
}



 ?>