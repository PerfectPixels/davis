<?php 

// FONTS
Kirki::add_section( 'section_fonts', array(
    'title'          => __( 'Fonts' ),
    'panel'          => 'panel_general',
    'priority'       => 15,
) );
// Header font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'header_font',
	'label'       => esc_attr__( 'Header & Nav Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
		'line-height'    => '26px',
		'letter-spacing' => '-0.02em',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => array( '.navbar-top', '.nav-header' ),
		),
	),
) );
// H1 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h1_font',
	'label'       => esc_attr__( 'H1 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h1',
		),
	),
) );
// H2 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h2_font',
	'label'       => esc_attr__( 'H2 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h2',
		),
	),
) );
// H3 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h3_font',
	'label'       => esc_attr__( 'H3 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h3',
		),
	),
) );
// H4 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h4_font',
	'label'       => esc_attr__( 'H4 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h4',
		),
	),
) );
// H5 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h5_font',
	'label'       => esc_attr__( 'H5 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h5',
		),
	),
) );
// H6 font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'h6_font',
	'label'       => esc_attr__( 'H6 Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'h6',
		),
	),
) );
// Body font
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'body_font',
	'label'       => esc_attr__( 'Body Font', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
		'line-height'    => '26px',
		'letter-spacing' => '-0.02em',
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'body',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
	'type'        => 'typography',
	'settings'    => 'body_font_bold',
	'label'       => esc_attr__( 'Body Font - Bold', 'kirki' ),
	'section'     => 'section_fonts',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '700',
	),
	'priority'    => 10,
) );

?>