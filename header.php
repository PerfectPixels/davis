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

// Remove class .container is fullwidth
if (get_field('fullwidth') || is_product()) {
	$fullwidth_class = '';
	$content_classes = '';
}

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

	<body <?php body_class(); ?>>

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

			// Botton Header
			get_template_part( 'template-parts/header/bottom-header' );

			// Botton Bar
			get_template_part( 'template-parts/header/bottom-bar' );

			// Offcanvas Cart
			get_template_part( 'template-parts/header/offcanvas-cart' );

			// Page Title
			get_template_part( 'template-parts/header/page-title' );

		} ?>

        <nav class="primary-nav offcanvas">
			<?php pp_get_header_elements( 'offcanvas_main_menu_elements', array( 'search_form', 'main_menu', 'social_media' ) ); ?>
        </nav>

		<div id="page-content" class="wrap <?php echo $fullwidth_class; ?>" role="document">

			<?php do_action( 'main_result_count' ); ?>

		  <main class="main <?php echo $content_classes; ?>">
