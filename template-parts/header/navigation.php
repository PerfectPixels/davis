<header class="nav-header flex-grid <?php pp_get_classes( 'main-header' ); ?>" style="<?php pp_get_styles( 'main-header-style' ); ?>" data-fixed-sticky-position='{"top": true, "bottom":false}'>

	<?php pp_get_styles( 'main-header-css' ); ?>

	<div class="logo">
		<?php get_template_part( 'template-parts/header/elements/logo' ); ?>
	</div>

	<ul class="flex-left primary-nav is-fixed <?php pp_get_classes( 'megamenu' ); ?>">
		<?php pp_get_header_elements( 'main_header_left_area' ); ?>
	</ul>

	<ul class="flex-right">
		<?php pp_get_header_elements( 'main_header_right_area' ); ?>
	</ul>

	<!-- <?php if ( $has_search_field ) { ?>
		<div class="search-box">
			<?php get_template_part( 'template-parts/header/search-form' ); ?>
		</div>
	<?php } ?>

	<ul class="header-buttons<?php echo $megamenu_class; ?>">
		<li class="menu">
			<a class="nav-button" href="#"><span class="header-text-color-bg header-text-color-bg-speudo"></span></a>
		</li>
		<?php if ( true == get_theme_mod( 'header_action_icons', true ) ) { ?>
			<?php get_template_part( 'template-parts/header/header-icons' ); ?>
		<?php } ?>
		<?php if ( true == get_theme_mod( 'header_search_icons', true ) ) { ?>
			<li class="search">
				<a class="search-button cd-search-trigger icon-android-search" href="#"></a>
			</li>
		<?php } ?>
	</ul>

	<?php if ( true == get_theme_mod( 'header_search_icons', true ) ) { ?>
		<div id="search" class="cd-main-search header-bg-color-bg">
			<?php get_template_part( 'template-parts/header/search-form' ); ?>
			<a href="#0" class="close cd-text-replace header-text-color-bg-speudo">Close Search</a>
		</div>
	<?php } ?> -->
</header>
