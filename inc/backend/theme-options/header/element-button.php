<?php 

Kirki::add_section( 'buttons_element', array(
    'title'          => __( 'Buttons', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// BUTTON 1
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'button_title_1',
	'section'     => 'buttons_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Button 1', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'button_1_label',
	'label'    => __( 'Button 1 Label', 'davis' ),
	'section'  => 'buttons_element',
	'default'  => esc_html__( 'Button', 'davis' ),
	'type'     => 'text',
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-buttonset',
	'settings'    => 'button_1_link_type',
	'label'       => __( 'Link Type', 'davis' ),
	'section'     => 'buttons_element',
	'default'     => 'url',
	'priority'    => 10,
	'choices'     => array(
		'page'  => esc_attr__( 'Internal Page', 'davis' ),
		'url' 	=> esc_attr__( 'External Link', 'davis' ),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'button_1_url',
	'label'    => __( 'URL', 'davis' ),
	'section'  => 'buttons_element',
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'button_1_link_type',
			'operator' => '==',
			'value'    => 'url',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'dropdown-pages',
	'settings' => 'button_1_page',
	'label'    => __( 'Page', 'davis' ),
	'section'  => 'buttons_element',
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'button_1_link_type',
			'operator' => '==',
			'value'    => 'page',
		),
	),
) );

// BUTTON 2
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'custom',
	'settings'    => 'button_title_2',
	'section'     => 'buttons_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Button 2', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'settings' => 'button_2_label',
	'label'    => __( 'Button 2 Label', 'davis' ),
	'section'  => 'buttons_element',
	'default'  => esc_html__( 'Button', 'davis' ),
	'type'     => 'text',
	'priority' => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'radio-buttonset',
	'settings'    => 'button_2_link_type',
	'label'       => __( 'Link Type', 'davis' ),
	'section'     => 'buttons_element',
	'default'     => 'url',
	'priority'    => 10,
	'choices'     => array(
		'page'  => esc_attr__( 'Internal Page', 'davis' ),
		'url' => esc_attr__( 'External Link', 'davis' ),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'text',
	'settings' => 'button_2_url',
	'label'    => __( 'URL', 'davis' ),
	'section'  => 'buttons_element',
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'button_2_link_type',
			'operator' => '==',
			'value'    => 'url',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'     => 'dropdown-pages',
	'settings' => 'button_2_page',
	'label'    => __( 'Page', 'davis' ),
	'section'  => 'buttons_element',
	'priority' => 10,
	'active_callback'    => array(
		array(
			'setting'  => 'button_2_link_type',
			'operator' => '==',
			'value'    => 'page',
		),
	),
) );

?>