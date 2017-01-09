<?php

// Add the General panel
Kirki::add_panel( 'panel_general', array(
    'priority'    => 10,
    'title'       => __( 'Fonts & Colors', 'davis' ),
) );

// FONTS
Kirki::add_section( 'section_fonts', array(
    'title'          => __( 'Fonts' ),
    'panel'          => 'panel_general', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Header font
Kirki::add_field( 'pp_theme', array(
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

// COLORS
Kirki::add_section( 'section_colors', array(
    'title'          => __( 'Colors' ),
    'panel'          => 'panel_general', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Primary color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'primary_color',
	'label'    => __( 'Primary Color', 'davis' ),
	'section'  => 'section_colors',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $primary_color,
	'output' => array(
		array(
			'element'  => array( '.primary-color', '.subtitle-by a', 'section.widget ul li a:hover', '.page-numbers:hover', '.page-numbers:hover:before', '.cd-hero-slider small a' ),
			'property' => 'color',
		),
		array(
			'element'  => array( 'body a:hover', 'body a:focus', '.primary-color-hover:hover', 'span.price', '.slick-dots .slick-active button', '.ui-slider-handle', '.widget_product_categories li.current-cat:before', '.widget_product_categories li.current-cat > a', '.widget_product_categories li.current-cat > .count', '.chosen:before', '.chosen a', '.chosen .count', 'ul.product_list_widget a:hover span.product-title', 'ul#login-tabs a.active', '.woocommerce-tabs li.active a', '.style-slideshow .thumb.slick-current img' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( 'body a:after', '.custom.tp-bullets .tp-bullet.selected', '.primary-bg-color-hover:hover', '.woocommerce-MyAccount-navigation li.is-active a', '#thumb-slider .thumb:after' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.ui-slider-range', '.page-numbers.current', '.rating-graph span' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.woocommerce-MyAccount-navigation li.is-active a:before' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '.woocommerce-tabs li.active a' ),
			'property' => 'border-bottom-color',
			'suffix'   => '!important',
		),
	),
) );
// Secondary color color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'secondary_color',
	'label'    => __( 'Secondary Color', 'davis' ),
	'description'    => __( 'Color used on the top of the primary color.', 'davis' ),
	'section'  => 'section_colors',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => $secondary_color,
	'output' => array(
		array(
			'element'  => array( '.woocommerce-MyAccount-navigation li.is-active a' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );

?>
