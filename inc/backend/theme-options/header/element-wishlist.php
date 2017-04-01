<?php

// ACCOUNT
Kirki::add_section( 'wishlist_element', array(
    'title'          => __( 'Wishlist', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );
// Stype of the account
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-buttonset',
	'settings'    => 'wishlist_style',
	'label'       => __( 'Style', 'davis' ),
	'section'     => 'wishlist_element',
	'default'     => 'icon_label',
	'priority'    => 10,
	'choices'     => array(
		'icon-only'   	 => esc_attr__( 'Icon Only', 'davis' ),
		'icon-label' => esc_attr__( 'Icon with Label', 'davis' ),
		'label-only'  	 => esc_attr__( 'Label Only', 'davis' ),
	),
) );
// Icon style
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'radio-image',
	'settings'    => 'wishlist_icon_style',
	'label'       => esc_html__( 'Icon Type', 'davis' ),
	'section'     => 'wishlist_element',
	'default'     => 'icon-heart',
	'priority'    => 10,
	'choices'     => array(
		'icon-heart'                  => get_template_directory_uri() . '/assets/images/admin/icon-heart.svg',
		'icon-heart-circle'           => get_template_directory_uri() . '/assets/images/admin/icon-heart-circle.svg',
		'icon-star'                   => get_template_directory_uri() . '/assets/images/admin/icon-star.svg',
		'icon-star-circle'            => get_template_directory_uri() . '/assets/images/admin/icon-star-circle.svg',
		'icon-heart-outline'          => get_template_directory_uri() . '/assets/images/admin/icon-heart-outline.svg',
		'icon-heart-circle-outline'   => get_template_directory_uri() . '/assets/images/admin/icon-heart-circle-outline.svg',
		'icon-star-outline'           => get_template_directory_uri() . '/assets/images/admin/icon-star-outline.svg',
		'icon-star-circle-outline'    => get_template_directory_uri() . '/assets/images/admin/icon-star-circle-outline.svg',
	),
	'active_callback'    => array(
		array(
			'setting'  => 'wishlist_style',
			'operator' => '!=',
			'value'    => 'label-only',
		),
	),
) );
// Label when logged in
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'     => 'text',
	'settings' => 'wishlist_label',
	'label'    => __( 'Label', 'davis' ),
	'section'  => 'wishlist_element',
	'default'  => esc_attr__( 'Favorites', 'davis' ),
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'wishlist_style',
			'operator' => '!=',
			'value'    => 'icon-only',
		),
	),
	'js_vars'   => array(
		array(
			'element'  => '.action-button.wishlist a span',
			'function' => 'html',
		),
	),
) );

function pp_element_wishlist_partials( WP_Customize_Manager $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'wishlist_element', array(
		'selector' => 'li.action-button.wishlist',
		'container_inclusive' => true,
		'settings' => array( 'wishlist_style', 'wishlist_icon_style' ),
		'render_callback' => function() {
			return get_template_part( 'template-parts/header/elements/wishlist' );
		},
	) );
}
add_action( 'customize_register', 'pp_element_wishlist_partials' );

?>