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

    require get_template_directory() . '/inc/setup.php';
    require get_template_directory() . '/inc/assets.php';
    require get_template_directory() . '/inc/extras.php';
    require get_template_directory() . '/inc/frontend/cart.php';
    require get_template_directory() . '/inc/theme_options/conf.php';

    if ( is_admin() ) {
        require get_template_directory() . '/inc/menu-item-custom-fields/menu-item-custom-fields.php';
        require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
    } else {
        require get_template_directory() . '/inc/titles.php';
        require get_template_directory() . '/inc/template-tags.php';
        require get_template_directory() . '/inc/widgets.php';
        require get_template_directory() . '/inc/menu-walker.php';

        // Pluguns Override
        require get_template_directory() . '/inc/reviews-pro.php';
        require get_template_directory() . '/inc/reviews-pro-type.php';
        require get_template_directory() . '/inc/social-checkout.php';
    }

 /*
 * If ACF plugin is not activated, create this fallback
 */
 if ( !is_admin() && !function_exists('get_field') ) {

     function get_field($key) {
         return get_post_meta(get_the_ID(), $key, true);
     }

 }
