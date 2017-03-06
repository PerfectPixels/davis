<?php
/**
* Davis files definition
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Davis
*
*
*/

// Setup the theme
require get_template_directory() . '/inc/setup.php';
// Functions for woocommerce
require get_template_directory() . '/inc/functions/woocommerce.php';
// Hooks for the cart
require get_template_directory() . '/inc/frontend/cart.php';
// Hooks for the login
require get_template_directory() . '/inc/frontend/login.php';
// Hooks for woocommerce
require get_template_directory() . '/inc/frontend/woocommerce.php';
// Hooks for layout
require get_template_directory() . '/inc/frontend/layout.php';
// Hooks for search
require get_template_directory() . '/inc/frontend/search.php';
// Options for the customizer
require get_template_directory() . '/inc/backend/theme-options.php';
// Options for the header builder
require get_template_directory() . '/inc/backend/header-builder/builder-init.php';
// Global function for wishlist
require get_template_directory() . '/inc/functions/wishlist.php';
// Global function for images
require get_template_directory() . '/inc/functions/images.php';

if ( is_admin() ) {

    // Backend hooks related
    require get_template_directory() . '/inc/backend/register-plugins.php';

    // Plugins libs/init
    require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
    require get_template_directory() . '/inc/plugins/acf.php';

    // Mega menu
    require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';

} else {

    // Global functions
    require get_template_directory() . '/inc/functions/entries.php';
    require get_template_directory() . '/inc/functions/cart.php';
    require get_template_directory() . '/inc/functions/reviews.php';
    require get_template_directory() . '/inc/functions/helpers.php';

    require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';

    require get_template_directory() . '/inc/frontend/template-tags.php';
    require get_template_directory() . '/inc/frontend/widgets.php';

    // Plugins Override
    require get_template_directory() . '/inc/plugins/reviews-pro.php';
    require get_template_directory() . '/inc/plugins/reviews-pro-type.php';
    require get_template_directory() . '/inc/plugins/social-checkout.php';

}

 /*
 * If ACF plugin is not activated, create this fallback
 */
 if ( !is_admin() && !function_exists('get_field') ) {

     function get_field($key) {
         return get_post_meta(get_the_ID(), $key, true);
     }

 }
