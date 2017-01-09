<?php
/**
 * Register the TGM Plugin
 */
 function davis_register_required_plugins() {
 	/*
 	 * Array of plugin arrays. Required keys are name and slug.
 	 * If the source is NOT from the .org repo, then source is also required.
 	 */
 	$plugins = array(

 		array(
 			'name'               => 'Kirki', // The plugin name.
 			'slug'               => 'kirki', // The plugin slug (typically the folder name).
 			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
 			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
 			),

 		array(
 			'name'               => 'Advanced Custom Fields Pro', // The plugin name.
 			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/tgm-plugins/advanced-custom-fields-pro.zip', // The plugin source.
 			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
 			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
 		),

 	);

 	/*
 	 * Array of configuration settings. Amend each line as needed.
 	 */
 	$config = array(
 		'id'           => 'davis',                 // Unique ID for hashing notices for multiple instances of TGMPA.
 		'default_path' => '',                      // Default absolute path to bundled plugins.
 		'menu'         => 'tgmpa-install-plugins', // Menu slug.
 		'has_notices'  => true,                    // Show admin notices or not.
 		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
 		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
 		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
 	);

 	tgmpa( $plugins, $config );
 }
add_action( 'tgmpa_register', 'davis_register_required_plugins' );
