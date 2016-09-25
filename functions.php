<?php
/**
 	* Davis functions and definitions.
 	*
 	* @link https://developer.wordpress.org/themes/basics/theme-functions/
 	*
 	* @package Davis
	*
  * The $pp_includes array determines the code incrary included in your theme.
  * Add or remove files to the array as needed. Supports child theme overrides.
  *
  * Please note that missing files will produce a fatal error.
  *
  */
 $pp_includes = [
   'inc/assets.php',    // Scripts and stylesheets
   'inc/extras.php',    // Custom functions
   //'inc/single-variation.php',    // Display variations as simple products
   'inc/setup.php',     // Theme setup
   'inc/widgets.php',   // Widgets creation
   'inc/titles.php',    // Page titles
   'inc/template-tags.php',    // Page titles
   //'inc/wrapper.php',   // Theme wrapper class
   'inc/menu-item-custom-fields/menu-item-custom-fields.php',   // Custom field for mega menu
   'inc/menu-walker.php',   // Custom menu walker
   //'inc/customizer.php', // Theme customizer
   //'inc/shortcodes.php', // Theme Shortcodes
   //'inc/vc_mapper.php', // Map Shortcodes to VC
   'inc/reviews-pro.php', // Change the reviews pro plugin
   'inc/reviews-pro-type.php', // Change the reviews pro plugin
   'inc/social-checkout.php', // Change the reviews pro plugin
   'inc/kirki/kirki.php', // Include Kirki customiser
   'inc/theme-kirki.php', // Include Kirki customiser
   'inc/theme_options/conf.php' // All customiser sections, panel, fields
 ];

 foreach ($pp_includes as $file) {
   if (!$filepath = locate_template($file)) {
     trigger_error(sprintf(__('Error locating %s for inclusion', 'davis'), $file), E_USER_ERROR);
   }

   require_once $filepath;
 }
 unset($file, $filepath);
