<?php

/**
 * If woocommerce is active
 */
$woocommerce_active = false;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  $woocommerce_active = true;
}

/**
 * Theme setup
 */
function setup() {
	// Enable features from Soil when plugin is activated
	// https://roots.io/plugins/soil/
	add_theme_support('soil-clean-up');
	add_theme_support('soil-nav-walker');
	add_theme_support('soil-nice-search');
	add_theme_support('soil-relative-urls');

	// Enable Woocommerce support
	add_theme_support('woocommerce');
	// Enable new Woocommerce plugins for product page
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );

	// Enable default logo support
	add_theme_support( 'site-logo', array(
		'height'      => 66,
		'width'       => 268,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Make theme available for translation
	load_theme_textdomain('davis', get_template_directory() . '/languages');

	// Enable plugins to manage the document title
	add_theme_support('title-tag');

	// Register wp_nav_menu() menus
	register_nav_menus([
		'primary_navigation' => __('Primary Navigation', 'davis'),
		'topbar_navigation_1' => __('Top Bar Navigation 1', 'davis' ),
		'topbar_navigation_2' => __('Top Bar Navigation 2', 'davis' ),
		'account_navigation' => __('Account Navigation', 'davis' ),
		'footer_navigation' => __('Footer Navigation', 'davis' )
	]);

	// Enable post thumbnails
	add_theme_support('post-thumbnails');

	// Enable post formats
	add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

	// Enable HTML5 markup support
	add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    // Initialize
	new PP_Cart;
    new PP_Layout;
    new PP_Search;
    new PP_Login;
    new PP_Woocommerce;

}
add_action('after_setup_theme', 'setup');

/**
 * Register sidebars
 */
function widgets_init() {
	register_sidebar([
		'name'          => __('Primary', 'davis'),
		'id'            => 'sidebar-primary',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	$total_widgets 	= wp_get_sidebars_widgets();
	$widget_class 	= '';

	if (isset( $total_widgets['sidebar-footer-top'] ) ){
		$widget_count = count( $total_widgets['sidebar-footer-top'] );
		if ( $widget_count === 0 ){
		   $widget_class = 'col-md-12';
		} else {
		   $widget_class = 'col-md-' . str_replace( '.', '-', ( 12 / $widget_count ) );
		}
	}

	register_sidebar([
		'name'          => __('Footer Top', 'davis'),
		'id'            => 'sidebar-footer-top',
		'before_widget' => '<section class="widget %1$s %2$s '.$widget_class.'">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	if (isset( $total_widgets['sidebar-footer-bottom'] ) ){
		$widget_count = count( $total_widgets['sidebar-footer-bottom'] );
		if ( $widget_count === 0 ){
		   $widget_class = 'col-md-12';
		} else {
		   $widget_class = 'col-md-' . str_replace( '.', '-', ( 12 / $widget_count ) );
		}
	}

	register_sidebar([
		'name'          => __('Footer Bottom', 'davis'),
		'id'            => 'sidebar-footer-bottom',
		'before_widget' => '<section class="widget %1$s %2$s '.$widget_class.'">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);
}
add_action('widgets_init', 'widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
    is_product(),
    is_checkout(),
  ]);

  return $display;
}

/**
 * Theme assets
 */
function assets() {
	global $woocommerce_active;

	$quick_checkout = get_theme_mod('quick_checkout', true);

	wp_enqueue_style('pp/css', get_stylesheet_directory_uri() . '/assets/styles/main.css', false, null);

	//wp_dequeue_style( 'wc-product-reviews-pro-frontend');

	wp_enqueue_script('modernizr', get_stylesheet_directory_uri() . '/assets/scripts/modernizr.min.js', null, null, false);

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if ( $woocommerce_active ) {
		if ( is_product() ){
			wp_enqueue_script('pp/js', get_stylesheet_directory_uri() . '/assets/scripts/main.min.js', ['jquery', 'wc-add-to-cart-variation'], null, true);

			if ( ! wc_version_check() ) {
				wp_enqueue_style('photoswipe', get_stylesheet_directory_uri() . '/assets/styles/plugins/photoswipe.css', false, null);
				wp_enqueue_style('photoswipe-ui-default', get_stylesheet_directory_uri() . '/assets/styles/plugins/default-skin/default-skin.css', false, null);
				wp_enqueue_script('photoswipe', get_stylesheet_directory_uri() . '/assets/scripts/plugins/photoswipe.min.js', null, null, false);
				wp_enqueue_script('photoswipe-ui-default', get_stylesheet_directory_uri() . '/assets/scripts/plugins/photoswipe-ui-default.min.js', null, null, false);
			}

		} else {
			wp_enqueue_script('pp/js', get_stylesheet_directory_uri() . '/assets/scripts/main.min.js', ['jquery'], null, true);
		}
	}

	if ( class_exists( 'WC_Wishlists_Plugin' ) ) {
		wp_dequeue_script( 'woocommerce-wishlists');

		$wishlist_params = array(
			'root_url' => untrailingslashit( get_site_url() ),
		    'current_url' => esc_url_raw( add_query_arg( array() ) ),
		    'are_you_sure' => __( 'Are you sure?', 'wc_wishlist' ),
		);
		wp_localize_script( 'pp/js', 'wishlist_params', apply_filters( 'woocommerce_wishlist_params', $wishlist_params ) );
	}

	if ( $woocommerce_active ) {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$assets_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
		$frontend_script_path = $assets_path . 'js/frontend/';

		// Cart localized script needed on all pages
		$wc_cart_params = array(
			'ajax_url'                     => WC()->ajax_url(),
			'wc_ajax_url'                  => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'update_shipping_method_nonce' => wp_create_nonce( "update-shipping-method" ),
			'checkout_page'                => esc_url( wc_get_checkout_url() ),
		);
		wp_localize_script( 'pp/js', 'wc_cart_params', apply_filters( 'woocommerce_wc_cart_params', $wc_cart_params ) );

		// Some script needed for all pages except checkout and my account
		if ( ! is_checkout() || ! is_account_page() ) {
			wp_enqueue_script( 'select2' );
			wp_enqueue_style( 'select2', $assets_path . 'css/select2.css' );

			// Password strength meter.
			// Load in checkout, account login and edit account page.
			if ( ( 'no' === get_option( 'woocommerce_registration_generate_password' ) && ! is_user_logged_in() ) || is_edit_account_page() ) {
				wp_enqueue_script( 'wc-password-strength-meter' );
			}
		}

	}
}
add_action('wp_enqueue_scripts', 'assets', 100);

/**
 * Woocommerce image size
 */
function pp_woocommerce_image_dimensions() {
	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

  	$catalog = array(
		'width' 	=> '255',	// px
		'height'	=> '290',	// px
		'crop'		=> 0 		// false
	);

	$single = array(
		'width' 	=> '1000',	// px
		'height'	=> '1000',	// px
		'crop'		=> 0 		// false
	);

	$thumbnail = array(
		'width' 	=> '110',	// px
		'height'	=> '110',	// px
		'crop'		=> 0 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs

}
add_action( 'after_switch_theme', 'pp_woocommerce_image_dimensions', 1 );

/**
 * Remove Woocommerce breadcrumbs
 */
function pp_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'pp_remove_wc_breadcrumbs' );


/**
 * Add an admin bar link
 */
function toolbar_link_to_options( $wp_admin_bar ) {
	// Main link
	$wp_admin_bar->add_node( array(
					'id'    => 'theme_options',
					'title' => '<span class="ab-icon dashicons-admin-settings"></span>'.__( 'Theme Options', 'davis' ),
					'href'  => admin_url( 'customize.php' )
				) );
	// Header
	$wp_admin_bar->add_node( array(
					'id'    => 'header_options',
					'title' => __( 'Header Options', 'davis' ),
					'href'  => admin_url( 'customize.php?autofocus[panel]=panel_header' ),
					'parent'=> 'theme_options'
				) );
}
add_action( 'admin_bar_menu', 'toolbar_link_to_options', 40 );


/**
 * Add some style option to head
 */
function hook_css() {
	$header_border = hex2rgba( get_theme_mod( 'header_text_color', '#000000' ), 0.1 );
	$top_bar_border = hex2rgba( get_theme_mod( 'top_bar_text_color', '#ffffff' ), 0.1 );
	$bottom_header_border = hex2rgba( get_theme_mod( 'bottom_header_text_color', '#000000' ), 0.1 );

	echo '<style id="options">';
	echo '.nav-header .menu-item-has-children > .sub-menu, .nav-header .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .nav-header .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .nav-header .dropdown-hover .dropdown-menu { border-color: ' . $header_border . ' !important; }';
	echo '.navbar-top .main-menu-item > .sub-menu, .navbar-top .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .navbar-top .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .navbar-top .dropdown-hover .dropdown-menu { border-color: ' . $top_bar_border . ' !important; }';
	echo '.navbar-bottom .main-menu-item > .sub-menu, .navbar-bottom .square-border.mega-nav.menu-item-has-children .mega-menu > .row > li, .navbar-bottom .line-border.mega-nav.menu-item-has-children .mega-menu > .row > li:after, .navbar-bottom .dropdown-hover .dropdown-menu { border-color: ' . $bottom_header_border . ' !important; }';
	echo '</style>';
}
add_action('wp_head', 'hook_css');


