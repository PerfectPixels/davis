<?php

global $transport;

// Add the Header panel
Kirki::add_section( 'social_media', array(
    'title'          => __( 'Social Media', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// Facebook
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'facebook',
	'label'    => __( 'Facebook', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Twitter
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'twitter',
	'label'    => __( 'Twitter', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'google',
	'label'    => __( 'Google Plus', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'instagram',
	'label'    => __( 'Instagram', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );
// Facebook
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'pinterest',
	'label'    => __( 'Pinterest', 'davis' ),
	'section'  => 'social_media',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
) );

?>