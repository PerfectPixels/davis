<?php 

// FOOTER PANET DECLARATION
Kirki::add_panel( 'panel_footer', array(
    'priority'    => 13,
    'title'       => __( 'Footer', 'davis' ),
) );

foreach ( glob( get_template_directory() . '/inc/backend/theme-options/footer/*.php' ) as $filename ){
    include_once $filename;
}

// TOP SIDEBAR SECTION
Kirki::add_section( 'section_sidebar_footer_top', array(
    'title'          => __( 'Top Sidebar' ),
    'panel'          => 'panel_footer', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Sidebar
Kirki::add_field( 'pp_theme', array(
	'settings' 		=> 'footer_sidebar',
	'label'    		=> __( 'Sidebar display options', 'davis' ),
    'description' 	=> __( 'Choose where to display the footer sidebar.', 'davis' ),
	'section'  		=> 'section_sidebar_footer_top',
	'type'     		=> 'select',
	'priority' 		=> 10,
	'default'  		=> 'products_pages',
	'choices'  		=> array(
		'no' 				=> esc_attr__( 'Nowhere', 'davis' ),
		'products_pages' 	=> esc_attr__( 'Products pages (shop, categories, product)', 'davis' ),
		'product'			=> esc_attr__( 'Product page only', 'davis' ),
		'all'				=> esc_attr__( 'Everywhere', 'davis' ),
	),
) );

// BOTTOM SIDEBAR SECTION
Kirki::add_section( 'section_sidebar_footer_bottom', array(
    'title'          => __( 'Bottom Sidebar' ),
    'panel'          => 'panel_footer', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Hide/Show
Kirki::add_field( 'pp_theme', array(
	'settings' => 'footer_sidebar_bottom',
	'label'    => __( 'Display Bottom Sidebar', 'davis' ),
    'description' => __( 'Choose if you want to display or remove the bottom sidebar in the footer.', 'davis' ),
	'section'  => 'section_sidebar_footer_bottom',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '1',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Background color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'footer_bg_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'section_sidebar_footer_bottom',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#1f292f',
	'js_vars' => array(
		array(
			'element'  => array( '#footer aside.bottom-widgets' ),
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
			'element'  => array( 'input[type=submit]', '.button' ),
			'function' => 'css',
			'property' => 'color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#footer aside.bottom-widgets' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( 'input[type=submit]', '.button' ),
			'property' => 'color',
		),
	),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'footer_txt_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'section_sidebar_footer_bottom',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'js_var' => array(
		array(
			'element'  => array( '#footer aside.bottom-widgets h3', '#footer aside.bottom-widgets ul li a', '#footer aside.bottom-widgets' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '#footer aside.bottom-widgets a:after', '#footer aside.bottom-widgets input[type=submit]', '#footer aside.bottom-widgets .button' ),
			'function' => 'css',
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
	'output' => array(
		array(
			'element'  => array( '#footer aside.bottom-widgets h3', '#footer aside.bottom-widgets ul li a', '#footer aside.bottom-widgets' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
		array(
			'element'  => array( '#footer aside.bottom-widgets a:after', '#footer aside.bottom-widgets input[type=submit]', '#footer aside.bottom-widgets .button' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
) );

// COPYRIGHT SECTION
Kirki::add_section( 'section_footer_copyright', array(
    'title'          => __( 'Copyright' ),
    'panel'          => 'panel_footer', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
) );
// Copyright text
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'copyright_text',
	'label'    => __( 'Copyright Text', 'davis' ),
	'section'  => 'section_footer_copyright',
	'type'     => 'textarea',
	'priority' => 10,
	'default'  => __( '© 2016 Perfect Pixels. All Rights Reserved.', 'davis' ),
	'js_vars'   => array(
		array(
			'element'  => '.footer_copyrights p',
			'function' => 'html',
		),
	)
) );
// Hide/Show Social media
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'footer_social',
	'label'    => __( 'Display Social Media', 'davis' ),
    'description' => __( 'Choose if you want to display or remove the social media.', 'davis' ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'choices'  => array(
		'on'  => esc_attr__( 'Show', 'davis' ),
		'off' => esc_attr__( 'Hide', 'davis' ),
	),
) );
// Facebook
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'facebook_footer',
	'label'    => __( 'Facebook', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Facebook URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'footer_social',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Twitter
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'twitter_footer',
	'label'    => __( 'Twitter', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Twitter URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'footer_social',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Google PLus
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'google_footer',
	'label'    => __( 'Google Plus', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Google Plus URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'footer_social',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Instagram
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'instagram_footer',
	'label'    => __( 'Instagram', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Instagram URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'footer_social',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Pinterest
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'pinterest_footer',
	'label'    => __( 'Pinterest', 'davis' ),
    'description' => sprintf( '%s <a href="%s">%s</a>', __( 'Make sure you have added the Pinterest URL to the ', 'davis' ), admin_url( 'customize.php?autofocus[section]=social_media' ), __( 'Social Media section', 'davis' ) ),
	'section'  => 'section_footer_copyright',
	'type'     => 'switch',
	'priority' => 10,
	'default'  => '0',
	'active_callback'  => array(
		array(
			'setting'  => 'footer_social',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
// Background color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'copyright_bg_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'section_footer_copyright',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#141b1f',
	'js_vars' => array(
		array(
			'element'  => array( '.footer_bottom' ),
			'function' => 'css',
			'property' => 'background-color',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.footer_bottom' ),
			'property' => 'background-color',
		),
	),
) );
// Text color
Kirki::add_field( 'pp_theme', array(
	'transport'	  => 'postMessage',
	'settings' => 'copyright_txt_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'section_footer_copyright',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'js_vars' => array(
		array(
			'element'  => array( '.footer_bottom *' ),
			'function' => 'css',
			'property' => 'color',
			'suffix'   => '!important',
		),
	),'output' => array(
		array(
			'element'  => array( '.footer_bottom *' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
