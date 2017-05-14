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
  * @param array $default
  */
function pp_get_header_elements( $section, $default = array('') ){
	$options = get_theme_mod( $section, $default );

	if ( is_array($options) ) {
		foreach ( $options as $key => $val ) {

			if ( $val === 'topbar_nav_1' ) {
				pp_get_menu( 'topbar_navigation_1' );
			} else if ( $val === 'topbar_nav_2' ) {
				pp_get_menu( 'topbar_navigation_2' );
			} else if ( $val === 'main_menu' ) {
			    if ( $section === 'offcanvas_main_menu_elements' ) {
                    echo '<ul class="main-menu">';
			        pp_get_menu('primary_navigation');
                    echo '</ul>';
                } else {
                    pp_get_menu('primary_navigation');
                }
            } else if ( $val == 'separator_1' || $val == 'separator_2' || $val == 'separator_3' || $val == 'separator_4' ) {
				echo '<li class="sep"></li>';
			} else if ( $val == 'wpml' ) {
				get_template_part( 'template-parts/header/element/languages' );
			} else {
				get_template_part( 'template-parts/header/elements/' . str_replace( '_', '-', $val ) );
			}

			//do_action( 'pp_get_header_elements', $val );

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
        if ( get_theme_mod( 'mobile_bottom_bar_area', array('search_icon', 'account', 'wishlist', 'cart') ) ){
            $output = true;
        }
    } else if ( $element === 'top_bar' ){
	    if ( get_theme_mod( 'top_bar_left_area', array('social_icon', 'text_1') ) || get_theme_mod( 'top_bar_center_area' ) || get_theme_mod( 'top_bar_right_area', array('account', 'wishlist', 'cart') ) || get_theme_mod( 'tablet_top_bar_left_area' ) || get_theme_mod( 'tablet_top_bar_right_area' ) || get_theme_mod( 'mobile_top_bar_area' ) ){
		    $output = true;
	    }
    } else if ( $element === 'sidebar_footer' ){
	    global $woocommerce_active;

	    $footer_sidebar = false;

	    if ( $woocommerce_active ) {
		    $footer_sidebar_type = get_theme_mod('footer_sidebar', 'products_pages');

		    switch( $footer_sidebar_type ){
			    case 'products_pages';
				    if ( is_shop() || is_product_category() || is_product() ){
					    $footer_sidebar = true;
				    }
				    break;
			    case 'product';
				    if ( is_product() ){
					    $footer_sidebar = true;
				    }
				    break;
			    case 'all';
				    $footer_sidebar = true;
				    break;
			    case 'no';
				    $footer_sidebar = false;
				    break;
		    }
	    }

	    if ($footer_sidebar) {
		    $output = get_template_part( "template-parts/sidebar-footer" );
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
	} else {
		$args = array( 'walker' => new PP_Walker_Other_Menu() );
	}

	$defaults = array(
		'theme_location' 	=> $location,
		'container'			=> '',
		'items_wrap'      	=> '%3$s',
		'walker' => new PP_Walker_Nav_Menu()
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
	$classes = array();

	switch ( $element ) {
		case 'top_bar':
			if ( get_theme_mod( 'fixed_top_bar', true ) == true ) { $classes[] = 'navbar-fixed-top'; }
			break;

		case 'main-header':
			if ( get_field( 'transparent_header' ) ) { $classes[] = 'transparent'; }
			if ( get_theme_mod( 'main_header_border', true ) == true ) { $classes[] = 'shadow'; }
			if ( get_theme_mod( 'main_header_hide_border', true ) == true ) { $classes[] = 'hide-shadow-top'; }
			$classes[] = get_theme_mod( 'content_pos', 'left' ) . '_content';
			$classes[] = get_theme_mod( 'logo_position_desktop', 'left' );
			$classes[] = get_theme_mod( 'logo_position_tablet', 'left' );
			$classes[] = get_theme_mod( 'logo_position_mobile', 'center' );
			break;

		case 'bottom-header':
			if ( get_field( 'transparent_header' ) ) { $classes[] = 'transparent'; }
			if ( get_theme_mod( 'bottom_header_border', true ) == true ) { $classes[] = 'shadow'; }
			if ( get_theme_mod( 'bottom_header_hide_border', true ) == true ) { $classes[] = 'hide-shadow-top'; }
			break;

        case 'button_1':
            if ( get_theme_mod( 'button_1_outlined', false ) == true ) { $classes[] = 'outlined'; }
            $classes[] = get_theme_mod( 'button_1_type', 'rounded' );
            break;

        case 'button_2':
            if ( get_theme_mod( 'button_2_outlined', false ) == true ) { $classes[] = 'outlined'; }
            $classes[] = get_theme_mod( 'button_2_type', 'rounded' );
            break;

		case 'cart-icon':
			$icon = get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' );
			$badge = array( 'icon-shopping-basket', 'icon-shopping-basket-outline', 'icon-shopping-basket-2', 'icon-shopping-basket-2-outline', 'icon-shopping-cart', 'icon-shopping-cart-outline', 'icon-shopping-cart-2', 'icon-shopping-cart-2-outline' );

			if ( in_array( $icon, $badge ) ){ $classes[] = 'icon-badge'; }
			if ( strpos($icon, 'outline') !== false ) { $classes[] = 'icon-outline'; }
			break;

		case 'wishlist-icon':
			$icon = get_theme_mod( 'wishlist_icon_style', 'icon-heart' );
			$badge = array( 'icon-heart-circle', 'icon-star', 'icon-star-circle', 'icon-heart-circle-outline', 'icon-star-outline', 'icon-star-circle-outline' );

			if ( in_array( $icon, $badge ) ){ $classes[] = 'icon-badge'; }
			if ( strpos($icon, 'outline') !== false ) { $classes[] = 'icon-outline'; }
			break;
	}

	echo implode( ' ', $classes );
}

/**
 * Get theme option
 *
 * @access public
 * @param string $name
 */
function pp_get_option( $name ){
    $output = array();

    switch ( $name ) {
        case 'cart_icon':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ) );
            break;

        case 'cart_icon_add':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ) ) . '-add';
            break;

        case 'cart_icon_outline':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ) ) . '-outline';
            break;

        case 'cart_icon_checkout':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ) ) . '-checkout';
            break;

        case 'wishlist_icon':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'wishlist_icon_style', 'icon-heart' ) );
            break;

        case 'wishlist_icon_outline':
            $output[] = str_replace( '-outline', '', get_theme_mod( 'wishlist_icon_style', 'icon-heart' ) ) . '-outline';
            break;
    }

    return implode( ' ', $output );
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
						$style .=  '.nav-header *, 
									.navbar-bottom * { color:' . $header_text . '; }
									.header-text-color-bg,
									.header-text-color-bg-speudo:before,
									.header-text-color-bg-speudo:after,
									.menu-link:before,
									.menu-link:after,
									.go-back a:before,
									.go-back a:after { background-color: ' . $header_text . '; }
									.nav-header .item-counter,
									.navbar-bottom .item-counter { color:' . $header_icon . ' !important; }';
					}

					if ( $header_bg ) {
						$style .= '.header-bg-color-bg,
							.primary-nav .mega-menu,
							.primary-nav .simple-nav .sub-menu { background-color:' . $header_bg . '; }';
					}

					if ( $transparent ) {
						$style .=  '.nav-header.transparent:not(.sticky) > ul > li > a,
									.nav-header.transparent:not(.sticky) .action-button > a,
									.nav-header.transparent:not(.sticky) .action-button > a:before,
									.navbar-bottom.transparent:not(.sticky) > ul > li > a,
									.navbar-bottom.transparent:not(.sticky) .action-button > a,
									.navbar-bottom.transparent:not(.sticky) .action-button > a:before { color: ' . $transparent_color .'; }
									.nav-header.transparent:not(.sticky) .nav-button span,
									.nav-header.transparent:not(.sticky) .nav-button span:before,
									.nav-header.transparent:not(.sticky) .nav-button span:after,
									.navbar-bottom.transparent:not(.sticky) .nav-button span,
									.navbar-bottom.transparent:not(.sticky) .nav-button span:before,
									.navbar-bottom.transparent:not(.sticky) .nav-button span:after,
									.navbar-bottom.transparent:not(.sticky) .menu-item-has-children > a span.mobile-arrow:before,
									.navbar-bottom.transparent:not(.sticky) .menu-item-has-children > a span.mobile-arrow:after,
									.navbar-bottom.transparent:not(.sticky) .sep,
									.navbar-bottom.transparent:not(.sticky) > ul > .menu-item > a:before,
									.navbar-bottom.transparent:not(.sticky) > ul > .menu-item > a:after { background-color: ' . $transparent_color . '; }
									.nav-header.transparent .item-counter,
									.navbar-bottom.transparent .item-counter{ color:' . $transparent_icon . '; }';
					}

				$style .= '</style>';
			}
			break;
	}

	echo $style;
}

/**
 * Get header styles
 *
 * @access public
 * @param string $color
 * @param mixed $opacity
 * @return string $output
 */
function hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}