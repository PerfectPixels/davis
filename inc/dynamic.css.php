<?php

header('Content-type: text/css');
// I can access any WP or theme functions
// here to get values that will be used in
// dynamic css below
  
$primary_color = <?php echo get_theme_mod( 'primary_color', '#c59d5f' ); ?>;

?>
/****** CSS Starts Here ******/


/* TOP BAR */

.navbar-top { background-color: <?php echo get_theme_mod( 'top_bar_color', '#000' ); ?>; }

.navbar-top * { color: <?php echo get_theme_mod( 'top_bar_text_color', '#fff' ); ?>; }

.navbar-top li.message-box { background-color: <?php echo get_theme_mod( 'message_box_color', $primary_color ); ?>; color: <?php echo get_theme_mod( 'message_text_color', '#fff' ); ?>; }

.navbar-top a .item-counter { color: <?php echo get_theme_mod( 'top_bar_icon_color', '#000' ); ?>; }


/* HEADER */

.nav-header { background-color: <?php echo get_theme_mod( 'header_bg_color', '#fff' ); ?>; }
.nav-header * { color: <?php echo get_theme_mod( 'header_text_color', '#000' ); ?>; }


/* LOGO */

.nav-header .brand { background-image:url(<?php echo get_theme_mod('logo'); ?>); }
.nav-header .brand.dark { background-image:url(<?php echo get_theme_mod('logo-dark'); ?>); }
