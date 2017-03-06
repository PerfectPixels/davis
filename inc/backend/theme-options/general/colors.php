<?php

// COLORS
Kirki::add_section( 'section_colors', array(
    'title'          => __( 'Colors', 'davis' ),
    'panel'          => 'panel_general',
    'priority'       => 20,
) );
// Primary color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => $transport,
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
			'element'  => array( '.custom.tp-bullets .tp-bullet.selected', '.primary-bg-color-hover:hover', '.woocommerce-MyAccount-navigation li.is-active a', '#thumb-slider .thumb:after' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '.ui-slider-range', '.page-numbers.current' ),
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
	'transport'	  => $transport,
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