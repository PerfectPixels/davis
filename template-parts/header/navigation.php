<?php

$megamenu_class    = '';
$transparent 	   = get_field( 'transparent_header' );
$transparent_color = get_field( 'transparent_header_text_color' );
$transparent_icon  = get_field( 'transparent_header_icon_counter_color' );
$header_bg		   = get_field( 'header_background_color' );
$header_text	   = get_field( 'header_text_color' );
$header_icon	   = get_field( 'header_icon_counter_color' );
$header_type	   = get_theme_mod( 'header_type' );
$search_field 	   = get_theme_mod( 'header_search_field', false );
$has_search_field  = false;

if ( true == $search_field && ( $header_type == 'center_logo-left_menu' || $header_type == 'top_logo-center_menu' || $header_type == 'top_logo-left_menu' ) ) {
	$has_search_field = true;
}

?>

<header class="nav-header animate-search <?php echo $header_type; ?> <?php if ( $transparent ) { ?>transparent<?php } ?> <?php if ( $has_search_field ){ ?>has-search-field<?php } ?>" style="<?php if ( $header_bg ) { echo 'background-color:' . $header_bg . ';'; } ?>" data-fixed-sticky-position='{"top": true, "bottom":false}'>

	<?php

		if ( $header_text || $header_bg || $transparent ) {
			echo '<style>';

				if ( $header_text ){
					echo '.nav-header * { color:' . $header_text . '; }
						.header-text-color-bg,
						.header-text-color-bg-speudo:before,
						.header-text-color-bg-speudo:after,
						.menu-link:before,
						.menu-link:after,
						.go-back a:before,
						.go-back a:after { background-color: ' . $header_text . '; }
						.nav-header .item-counter { color:' . $header_icon . ' !important; }';
				}

				if ( $header_bg ) {
					echo '.header-bg-color-bg,
						.primary-nav .mega-menu,
						.primary-nav .simple-nav .sub-menu { background-color:' . $header_bg . '; }';
				}

				if ( $transparent ) {
					echo '.nav-header.transparent:not(.fixedsticky-on) nav > ul > li > a,
						.nav-header.transparent:not(.fixedsticky-on) .header-buttons > li > a { color: ' . $transparent_color .'; }
						.nav-header.transparent:not(.fixedsticky-on) .nav-button span,
						.nav-header.transparent:not(.fixedsticky-on) .nav-button span:before,
						.nav-header.transparent:not(.fixedsticky-on) .nav-button span:after { background-color: ' . $transparent_color . '; }
						.nav-heaver.transparent .item-counter { color:' . $transparent_icon . '; }';
				}

			echo '</style>';
		}

	?>

	<a class="brand" href="<?= esc_url( home_url( '/' ) ); ?>">
		<img class="default" src="<?php if ( get_field( 'header_logo_selection' ) ){ echo esc_url( get_theme_mod( get_field( 'header_logo_selection' ) . '_logo' ) ); } else { echo esc_url( get_theme_mod( get_theme_mod( 'logo_selection', 'dark' ) . '_logo' ) ); } ?>" />
		<img class="for-transparent-header" src="<?php echo esc_url( get_theme_mod( get_field( 'transparent_header_logo_selection' ) . '_logo' ) ); ?>" />
	</a>

	<?php if ( $has_search_field ) { ?>
		<div class="search-box">
			<form method="get" action="<?php echo home_url(); ?>" class="header-text-color-txt-all">
		        <?php if ( class_exists('WooCommerce') ) { ?>
			        <div class="cd-select">
						<select>
							<option value="all"><?php _e( 'All', 'davis' ); ?></option>

							<?php
							$product_cat = get_terms( 'product_cat' );

							foreach ( $product_cat as $cat ) {
						        echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
						    }
							?>

						</select>
						<span class="selected-value header-text-color-bg-speudo"><?php _e( 'All', 'davis' ); ?></span>
					</div>
				<?php } ?>
		        <button name="button" type="submit" class="icon-android-search"></button>
		        <div class="search-input"><input type="search" value="<?php echo esc_html($s, 1); ?>" name="s" id="s" /></div>
		    </form>
		</div>
	<?php } ?>

	<?php if ( true == get_theme_mod( 'megamenu_fullwidth', false ) ) { $megamenu_class = ' fullwidth'; } ?>

	<nav class="nav-primary">
		<?php if ( has_nav_menu( 'primary_navigation' ) ){
			wp_nav_menu( [
				'theme_location' 	=> 'primary_navigation',
				'container'			=> '',
				'menu_class' 		=> 'primary-nav is-fixed' . $megamenu_class,
				'walker' 			=> new PP_Walker_Nav_Menu()
			] );
		} ?>
    </nav>

	<ul class="header-buttons<?php echo $megamenu_class; ?>">
		<li class="menu">
			<a class="nav-button" href="#"><span class="header-text-color-bg header-text-color-bg-speudo"></span></a>
		</li>
		<?php if ( true == get_theme_mod( 'header_action_icons', true ) ) : ?>
			<?php get_template_part( 'template-parts/header/header-icons' ); ?>
		<?php endif; ?>
		<?php if ( true == get_theme_mod( 'header_search_icons', true ) ) : ?>
			<li class="search">
				<a class="search-button cd-search-trigger icon-android-search" href="#"></a>
			</li>
		<?php endif; ?>
	</ul>

	<div id="search" class="cd-main-search header-bg-color-bg">
		<form method="get" action="<?php echo home_url(); ?>" class="header-text-color-txt-all">
	        <input class="search-input" type="search" value="<?php echo esc_html($s, 1); ?>" name="s" id="s" placeholder="<?php _e( 'Search Products...', 'davis' ); ?>" title="<?php _e( 'Search for:', 'davis' ); ?>" />
	        <?php if (class_exists('WooCommerce')) { ?>
		        <div class="cd-select">
					<span><?php _e( 'in', 'davis' ); ?></span>
					<select>
						<option value="all"><?php _e( 'All', 'davis' ); ?></option>

						<?php
						$product_cat = get_terms( 'product_cat' );

						foreach ( $product_cat as $cat ) {
					        echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
					    }
						?>

					</select>
					<span class="selected-value header-text-color-bg-speudo"><?php _e( 'All', 'davis' ); ?></span>
				</div>
			<?php } ?>
	    </form>

		<!--
<div class="cd-search-suggestions">
			<div class="news">
				<h3>News</h3>
				<ul>
					<li>
						<a class="image-wrapper" href="#0"><img src="assests/images/placeholder.png" alt="News image"></a>
						<h4><a class="cd-nowrap" href="#0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h4>
						<time datetime="2016-01-12">Feb 03, 2016</time>
					</li>

				</ul>

			<div class="quick-links">
				<h3>Quick Links</h3>
				<ul>
					<li><a href="#0">Find a store</a></li>
				</ul>
			</div>
		</div>
-->

		<a href="#0" class="close cd-text-replace header-text-color-bg-speudo">Close Form</a>
	</div>
</header>
