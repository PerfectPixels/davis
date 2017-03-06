<?php
/**
* The header for our theme.
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
*
*/

global $woocommerce;

$content_classes 	= 'col-xs-12';
$fullwidth_class 	= 'container';
$fixed_classes 		= '';
$sidebar 			= (get_theme_mod('shop_sidebar', 'no') === 'no') ? false : get_theme_mod('shop_sidebar', 'no');
$sidebar_class 		= '';

if ((!get_field('hide_sidebar') && !is_checkout() && !is_product()) || ($sidebar && (is_shop() || is_product_category() || is_product_tag()))) {

	if ($sidebar === 'sidebar'){
		$content_classes = 'col-md-9 col-md-push-3';
	} else if ($sidebar === 'offcanvas'){
		$content_classes = 'col-md-12';
		$sidebar_class = 'offcanvas-sidebar';
	}
} else {
	$sidebar = false;
}

// Remove class .container is fullwidth
if (get_field('fullwidth') || is_product()) {
	$fullwidth_class = '';
	$content_classes = '';
}

// Check if header is sticky
if (get_theme_mod('fixed_header', true) == true) { $fixed_classes .= 'nav-is-fixed'; }
// Check if top bar is sticky
if (get_theme_mod('fixed_top_bar', false) == true) {	$fixed_classes .= ' top-bar-is-fixed'; }

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(array( $fixed_classes, $sidebar_class )); ?>>

		<!--[if IE]>
		  <div class="alert alert-warning">
		    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'davis' ); ?>
		  </div>
		<![endif]-->

		<?php if ( !is_quick_checkout() ){

			// Top Bar
			get_template_part( 'template-parts/header/top-bar' );

			// Main Navigation
			get_template_part( 'template-parts/header/navigation' );

			// Botton Bar
			get_template_part( 'template-parts/header/bottom-bar' );

			// Offcanvas Cart
			get_template_part( 'template-parts/header/offcanvas-cart' );

			// Page Title
			get_template_part( 'template-parts/header/page-title' );

		} ?>

		<div id="page-content" class="wrap <?php echo $fullwidth_class; ?>" role="document">

			<?php do_action( 'main_result_count' ); ?>

		  <main class="main <?php echo $content_classes; ?>">
