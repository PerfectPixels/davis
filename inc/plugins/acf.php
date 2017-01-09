<?php
/**
 * ACF options for the theme
 */

// Hide ACF field group menu item
//add_filter('acf/settings/show_admin', '__return_false');


// Automatically save JSON
function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/inc/plugins/acf-json';
    // return
    return $path;

}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');


// Automatically load JSON
function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/inc/plugins/acf-json';
    // return
    return $paths;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
