<?php 

global $primary_color;

Kirki::add_section( 'buttons_element', array(
    'title'          => __( 'Buttons', 'davis' ),
    'panel'          => 'panel_header',
    'priority'       => 10,
) );

// BUTTON 1
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'button_title_1',
	'section'     => 'buttons_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Button 1', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_1_label',
	'label'    => __( 'Button 1 Label', 'davis' ),
	'section'  => 'buttons_element',
	'default'  => esc_html__( 'Button', 'davis' ),
	'type'     => 'text',
	'priority' => 10,
	'js_vars'   => array(
		array(
			'element'  => '#button-1',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'button_1_type',
	'label'       => __( 'Button Type', 'davis' ),
	'section'     => 'buttons_element',
	'default'     => 'rounded',
	'priority'    => 10,
	'choices'     => array(
		'squared'  => esc_attr__( 'Squared', 'davis' ),
		'rounded' 	=> esc_attr__( 'Rounded', 'davis' ),
		'circle' 	=> esc_attr__( 'Circle', 'davis' ),
		'link' 	=> esc_attr__( 'Link', 'davis' ),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_1_outlined',
	'label'    => __( 'Outlined', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
	'active_callback'    => array(
		array(
			'setting'  => 'button_1_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
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
	'transport'	  => 'postMessage',
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
	'transport'	  => 'postMessage',
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
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_1_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#fff',
	'active_callback'    => array(
		array(
			'setting'  => 'button_1_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( '#button-1' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#button-1' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_1_bgcolor',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => $primary_color,
	'active_callback'    => array(
		array(
			'setting'  => 'button_1_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( '#button-1' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '#button-1' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#button-1' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '#button-1' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );

// BUTTON 2
Kirki::add_field( 'pp_theme', array(
	'type'        => 'custom',
	'settings'    => 'button_title_2',
	'section'     => 'buttons_element',
	'default'     => '<h3 class="section_title">' . esc_html__( 'Button 2', 'davis' ) . '</h3>',
	'priority'    => 10,
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_2_label',
	'label'    => __( 'Button 2 Label', 'davis' ),
	'section'  => 'buttons_element',
	'default'  => esc_html__( 'Button', 'davis' ),
	'type'     => 'text',
	'priority' => 10,
	'js_vars'   => array(
		array(
			'element'  => '#button-2',
			'function' => 'html',
		),
	)
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'type'        => 'select',
	'settings'    => 'button_2_type',
	'label'       => __( 'Button Type', 'davis' ),
	'section'     => 'buttons_element',
	'default'     => 'rounded',
	'priority'    => 10,
	'choices'     => array(
		'squared'  => esc_attr__( 'Squared', 'davis' ),
		'rounded' 	=> esc_attr__( 'Rounded', 'davis' ),
		'circle' 	=> esc_attr__( 'Circle', 'davis' ),
		'link' 	=> esc_attr__( 'Link', 'davis' ),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_2_outlined',
	'label'    => __( 'Outlined', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'toggle',
	'priority' => 10,
	'default'  => '0',
	'active_callback'    => array(
		array(
			'setting'  => 'button_2_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
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
	'transport'	  => 'postMessage',
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
	'transport'	  => 'postMessage',
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
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_2_text_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#fff',
	'active_callback'    => array(
		array(
			'setting'  => 'button_2_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( '#button-2' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#button-2' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'button_2_bgcolor',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'buttons_element',
	'type'     => 'color',
	'priority' => 10,
	'default'  => $primary_color,
	'active_callback'    => array(
		array(
			'setting'  => 'button_2_type',
			'operator' => '!=',
			'value'    => 'link',
		),
	),
	'js_vars' => array(
		array(
			'element'  => array( '#button-2' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '#button-2' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#button-2' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( '#button-2' ),
			'property' => 'border-color',
			'suffix'   => '!important',
		),
	),
) );


function pp_element_buttons_partials( WP_Customize_Manager $wp_customize ) {
    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'buttons_element-1', array(
        'selector' => 'li.button-element.button-1',
        'container_inclusive' => true,
        'settings' => array( 'button_1_type', 'button_1_outlined', 'button_1_link_type', 'button_1_url', 'button_1_page' ),
        'render_callback' => function() {
            return get_template_part( 'template-parts/header/elements/button-1' );
        },
    ) );

    $wp_customize->selective_refresh->add_partial( 'buttons_element-2', array(
        'selector' => 'li.button-element.button-2',
        'container_inclusive' => true,
        'settings' => array( 'button_2_type', 'button_2_outlined', 'button_2_link_type', 'button_2_url', 'button_2_page' ),
        'render_callback' => function() {
            return get_template_part( 'template-parts/header/elements/button-2' );
        },
    ) );
}
add_action( 'customize_register', 'pp_element_buttons_partials' );