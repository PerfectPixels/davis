<?php
/**
* Class for all layout modification
*
* @version 1.0
*/
class PP_Layout {

    /**
	 * Construction function
	 *
	 * @since  1.0
	 * @return PP_Layout
	 */
	function __construct() {
		// Define all hook
		add_action( 'template_redirect', array( $this, 'initiate_hooks' ) );
	}

    /**
	 * Hooks to actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function initiate_hooks() {

        // Add some classes to the body
        add_filter('body_class', array( $this, 'body_class' ));

        // Return excerpt with hyperlink to read more
        add_filter('excerpt_more', array( $this, 'excerpt_more' ));

		add_filter('wp_nav_menu_objects', array( $this, 'pp_last_menu_class' ));
    }

    /**
     * Add <body> classes
     */
    function body_class($classes) {
        $sidebar = (get_theme_mod('shop_sidebar', 'no') === 'no') ? false : get_theme_mod('shop_sidebar', 'no');

    	// Add page slug if it doesn't exist
    	if (is_single() || is_page() && !is_front_page()) {
    		if (!in_array(basename(get_permalink()), $classes)) {
    		  	$classes[] = basename(get_permalink());
    		}
    	}

    	// Add class if sidebar is active
    	if (display_sidebar() && $sidebar) {
    		$classes[] = 'sidebar-primary';
    	}

	    if ( ( ! get_field( 'hide_sidebar' ) && ! is_checkout() && ! is_product() ) || ( $sidebar && ( is_shop() || is_product_category() || is_product_tag() ) ) ) {

		    if ( $sidebar === 'sidebar' ){
			    $classes[] = 'col-md-9 col-md-push-3';
		    } else if ( $sidebar === 'offcanvas' ){
			    $classes[] = 'col-md-12 offcanvas-sidebar';
		    }
	    }
	    if ( get_theme_mod( 'fixed_header', true ) == true ) { $classes[] = 'nav-is-fixed'; }
	    if ( get_theme_mod( 'fixed_top_bar', true ) == true ) {	$classes[] = ' top-bar-is-fixed'; }
	    if ( get_theme_mod( 'fixed_bottom_bar', true ) == true ) {	$classes[] = ' bottom-bar-is-fixed'; }

    	return $classes;
    }


    /**
     * Clean up the_excerpt()
     */
    function excerpt_more() {
    	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'davis') . '</a>';
    }


	/**
	 * Add last class to the menus
	 */
	function pp_last_menu_class( $items ) {
		foreach($items as $key => $val){
			$parent[$val->menu_item_parent][] = $val;
		}

		foreach($parent as $key => $val){
			$val[count($val)-1]->classes[] = 'last';
		}

		return $items;
	}


}
