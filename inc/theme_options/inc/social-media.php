<?php

// Add the Header panel
TC_Kirki::add_section( 'social_media', array(
    'title'          => __( 'Social Media' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
) );

// Facebook
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'facebook',
	'label'    => __( 'Facebook', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Twitter
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'twitter',
	'label'    => __( 'Twitter', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'google',
	'label'    => __( 'Google Plus', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'instagram',
	'label'    => __( 'Instagram', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
TC_Kirki::add_field( 'pp_theme', array(
	'settings' => 'pinterest',
	'label'    => __( 'Pinterest', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );

?>