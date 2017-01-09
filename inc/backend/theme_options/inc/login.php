<?php 

// LOGIN PANET DECLARATION
Kirki::add_panel( 'panel_login', array(
    'priority'    => 11,
    'title'       => __( 'Login Popup', 'davis' ),
) );

// LOGIN SECTION
Kirki::add_section( 'section_login', array(
    'title'          => __( 'Login Section' ),
    'panel'          => 'panel_login', // Not typically needed.
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
) );
// Login popup
if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) :
	Kirki::add_field( 'pp_theme', array(
		'settings' 		=> 'login_style',
		'label'    		=> __( 'Login Popup Style', 'davis' ),
	    'description' 	=> __( 'Choose which style you can to display the login popup.', 'davis' ),
		'section'  		=> 'section_login',
		'type'     		=> 'select',
		'priority' 		=> 10,
		'default'  		=> 'left_img',
		'choices'  		=> array(
			'tabs' 		=> esc_attr__( 'Tabs', 'davis' ),
			'left_img' 	=> esc_attr__( 'Left Image', 'davis' ),
		),
	) );
endif;

// Login background color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_bg_color',
	'label'    => __( 'Background Color', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#31a3d6',
	'output' => array(
		array(
			'element'  => array( '.login-panel' ),
			'property' => 'background-color',
		),
		array(
			'element'  => array( 'body .container .login-panel a.button' ),
			'property' => 'color',
			'suffix'   => '!important',
		),
	),
) );
// Login background image
Kirki::add_field( 'pp_theme', array(
	'settings'    => 'login_bg_img',
	'label'       => __( 'Background Image', 'davis' ),
	'section'     => 'section_login',
	'type'        => 'image',
	'default'     => '',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => array( '.login-panel' ),
			'property' => 'background-image',
		),
	),
) );
// Login background repeat
Kirki::add_field( 'pp_theme', array(
	'settings' 		=> 'login_bg_img_repeat',
	'label'    		=> __( 'Background Repeat', 'davis' ),
	'section'  		=> 'section_login',
	'type'     		=> 'select',
	'priority' 		=> 10,
	'default'  		=> 'no-repeat',
	'choices'  		=> array(
		'repeat' 		=> esc_attr__( 'Repeat', 'davis' ),
		'no-repeat' 	=> esc_attr__( 'No Repeat', 'davis' ),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'login_bg_img',
			'operator' => '!=',
			'value'    => '',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.login-panel' ),
			'property' => 'background-repeat',
		),
	),
) );
// Login background size
Kirki::add_field( 'pp_theme', array(
	'settings' 		=> 'login_bg_img_size',
	'label'    		=> __( 'Background Size', 'davis' ),
	'section'  		=> 'section_login',
	'type'     		=> 'select',
	'priority' 		=> 10,
	'default'  		=> 'cover',
	'choices'  		=> array(
		'cover' 	=> esc_attr__( 'Cover', 'davis' ),
		'contain' 	=> esc_attr__( 'Contain', 'davis' ),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'login_bg_img',
			'operator' => '!=',
			'value'    => '',
		),
	),
	'output' => array(
		array(
			'element'  => array( '.login-panel' ),
			'property' => 'background-size',
		),
	),
) );
// Login text color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_txt_color',
	'label'    => __( 'Text Color', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'color',
	'alpha'    => false,
	'priority' => 10,
	'default'  => '#fff',
	'output' => array(
		array(
			'element'  => array( '.login-panel h2', '.login-panel h6' ),
			'property' => 'color',
		),
	),
) );
// Login button color
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_btn_color',
	'label'    => __( 'Button Color', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'color',
	'alpha'    => true,
	'priority' => 10,
	'default'  => '#fff',
	'output' => array(
		array(
			'element'  => array( 'body .container .login-panel a.button' ),
			'property' => 'background-color',
			'suffix'   => '!important',
		),
	),
) );
// Login Title
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_title',
	'label'    => __( 'Title', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Welcome back!', 'davis' ),
) );
// Login Subtitle
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_subtitle',
	'label'    => __( 'Title', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'textarea',
	'priority' => 10,
	'default'  => __( 'If you already have an account, you can sign in again by clicking on the button below.', 'davis' ),
) );
// Login Button
Kirki::add_field( 'pp_theme', array(
	'settings' => 'login_btn',
	'label'    => __( 'Button', 'davis' ),
	'section'  => 'section_login',
	'type'     => 'text',
	'priority' => 10,
	'default'  => __( 'Login now', 'davis' ),
) );

if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) :

	// REGISTRATION SECTION
	Kirki::add_section( 'section_registration', array(
	    'title'          => __( 'Registration Section' ),
		'panel'          => 'panel_login', // Not typically needed.
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	) );
	// Registration background color
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_bg_color',
		'label'    => __( 'Background Color', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'color',
		'alpha'    => false,
		'priority' => 10,
		'default'  => '#cd4436',
		'output' => array(
			array(
				'element'  => array( '.account-panel' ),
				'property' => 'background-color',
			),
			array(
				'element'  => array( 'body .container .account-panel a.button' ),
				'property' => 'color',
				'suffix'   => '!important',
			),
		),
	) );
	// Registration background image
	Kirki::add_field( 'pp_theme', array(
		'settings'    => 'registration_bg_img',
		'label'       => __( 'Background Image', 'davis' ),
		'section'     => 'section_registration',
		'type'        => 'image',
		'default'     => '',
		'priority'    => 10,
		'output' => array(
			array(
				'element'  => array( '.account-panel' ),
				'property' => 'background-image',
			),
		),
	) );
	// Registration background repeat
	Kirki::add_field( 'pp_theme', array(
		'settings' 		=> 'registration_bg_img_repeat',
		'label'    		=> __( 'Background Repeat', 'davis' ),
		'section'  		=> 'section_registration',
		'type'     		=> 'select',
		'priority' 		=> 10,
		'default'  		=> 'no-repeat',
		'choices'  		=> array(
			'repeat' 		=> esc_attr__( 'Repeat', 'davis' ),
			'no-repeat' 	=> esc_attr__( 'No Repeat', 'davis' ),
		),
		'active_callback'    => array(
			array(
				'setting'  => 'registration_bg_img',
				'operator' => '!=',
				'value'    => '',
			),
		),
		'output' => array(
			array(
				'element'  => array( '.account-panel' ),
				'property' => 'background-repeat',
			),
		),
	) );
	// Registration background size
	Kirki::add_field( 'pp_theme', array(
		'settings' 		=> 'registration_bg_img_size',
		'label'    		=> __( 'Background Size', 'davis' ),
		'section'  		=> 'section_registration',
		'type'     		=> 'select',
		'priority' 		=> 10,
		'default'  		=> 'cover',
		'choices'  		=> array(
			'cover' 	=> esc_attr__( 'Cover', 'davis' ),
			'contain' 	=> esc_attr__( 'Contain', 'davis' ),
		),
		'active_callback'    => array(
			array(
				'setting'  => 'registration_bg_img',
				'operator' => '!=',
				'value'    => '',
			),
		),
		'output' => array(
			array(
				'element'  => array( '.account-panel' ),
				'property' => 'background-size',
			),
		),
	) );
	// Registration text color
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_txt_color',
		'label'    => __( 'Text Color', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'color',
		'alpha'    => false,
		'priority' => 10,
		'default'  => '#fff',
		'output' => array(
			array(
				'element'  => array( '.account-panel h2', '.account-panel h6' ),
				'property' => 'color',
			),
		),
	) );
	// Registration button color
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_btn_color',
		'label'    => __( 'Button Color', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'color',
		'alpha'    => true,
		'priority' => 10,
		'default'  => '#fff',
		'output' => array(
			array(
				'element'  => array( 'body .container .account-panel a.button' ),
				'property' => 'background-color',
				'suffix'   => '!important',
			),
		),
	) );
	// Registration Title
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_title',
		'label'    => __( 'Title', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'text',
		'priority' => 10,
		'default'  => __( 'Hi There!', 'davis' ),
	) );
	// Registration Subtitle
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_subtitle',
		'label'    => __( 'Title', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'textarea',
		'priority' => 10,
		'default'  => __( 'If you don’t have an account yet, you can join us by clicking on the button below.', 'davis' ),
	) );
	// Registration Button
	Kirki::add_field( 'pp_theme', array(
		'settings' => 'registration_btn',
		'label'    => __( 'Button', 'davis' ),
		'section'  => 'section_registration',
		'type'     => 'text',
		'priority' => 10,
		'default'  => __( 'Create an account', 'davis' ),
	) );
	
endif;

?>