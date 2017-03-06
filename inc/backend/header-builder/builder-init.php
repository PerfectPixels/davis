<?php

/**
* Add CSS/JS to the customizer screen
*
* @access public
*/

function pp_customize_controls_styles() {
    wp_enqueue_style( 'header-builder-css', get_template_directory_uri() . '/inc/backend/header-builder/customizer-controls.css', false, null );
    wp_enqueue_script( 'header-builder-js', get_template_directory_uri() . '/inc/backend/header-builder/customizer-preview.min.js', false, null );
}
add_action( 'customize_controls_print_styles', 'pp_customize_controls_styles' );


/**
* Add the Header Builder to the customizer screen
*
* @access public
*/

function pp_header_builder(){ 
	global $header_elements;

	require get_template_directory() . '/inc/backend/header-builder/template.php';

}

add_action('customize_controls_print_footer_scripts', 'pp_header_builder');

?>