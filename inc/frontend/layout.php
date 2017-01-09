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

    	return $classes;
    }


    /**
     * Clean up the_excerpt()
     */
    function excerpt_more() {
    	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'davis') . '</a>';
    }

}
