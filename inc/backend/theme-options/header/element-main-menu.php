<?php

// MAIN MENU
Kirki::add_section( 'main_menu', array(
	'title'          => __( 'Main Menu', 'davis' ),
	'panel'          => 'panel_header',
	'priority'       => 10,
) );
// Mega Menu Width
Kirki::add_field( 'pp_theme', array(
	'settings' => 'megamenu_fullwidth',
	'label'    => __( 'Fullwidth Mega Menu', 'davis' ),
	'section'  => 'main_menu',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
) );
Kirki::add_field( 'pp_theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'submenu_border_style',
	'label'       => __( 'Mega Menu Border Style', 'davis' ),
	'section'     => 'main_menu',
	'default'     => 'square',
	'priority'    => 10,
	'choices'     => array(
		'square'   	 => esc_attr__( 'Square', 'davis' ),
		'line' => esc_attr__( 'Line', 'davis' ),
		'no'  	 => esc_attr__( 'None', 'davis' ),
	),
) );
