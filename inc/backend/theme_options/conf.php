<?php

if (class_exists('Kirki')) :

	// Style the Kirki customizer
	function kirki_styling( $config ) {
		return wp_parse_args( array(
			'disable_loader'  => true,
		), $config );
	}
	add_filter( 'kirki/config', 'kirki_styling' );

	// Add the configuration settings
	Kirki::add_config( 'pp_theme', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	$primary_color = '#c59d5f';
	$secondary_color = '#ffffff';

	// Include all files
	foreach ( glob( get_template_directory() . '/inc/backend/theme_options/inc/*.php' ) as $filename ){
	    require_once $filename;
	}

endif;

?>
