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

function pp_social_media_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'social_media', array(
		'selector' => 'li.social-media',
		'settings' => array( 'facebook', 'twitter', 'google', 'instagram', 'pinterest' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/social-media' );
		},
	) );
}
add_action( 'customize_register', 'pp_social_media_partials' );

?>