<header class="nav-header flex-grid <?php pp_get_classes( 'main-header' ); ?>" data-fixed-sticky-position='{"top": true, "bottom":false}'>

	<?php pp_get_styles( 'main-header-css' ); ?>

	<div class="logo visible-desktop primary-nav">
        <?php if ( get_theme_mod( 'logo_position_desktop', 'left' ) === 'center_logo_split_menu' ){
	        pp_get_menu('primary_navigation');
        } ?>
		<?php get_template_part( 'template-parts/header/elements/logo' ); ?>
	</div>

	<ul class="flex-left visible-desktop primary-nav">
		<?php pp_get_header_elements( 'main_header_left_area', array('main_menu') ); ?>
	</ul>

	<ul class="flex-right visible-desktop primary-nav">
		<?php pp_get_header_elements( 'main_header_right_area', array('search_icon') ); ?>
	</ul>

    <div class="logo visible-tablet primary-nav">
		<?php get_template_part( 'template-parts/header/elements/logo' ); ?>
    </div>

    <ul class="flex-left visible-tablet primary-nav">
        <?php pp_get_header_elements( 'tablet_main_header_left_area', array('menu_icon', 'search_icon') ); ?>
    </ul>

    <ul class="flex-right visible-tablet primary-nav">
        <?php pp_get_header_elements( 'tablet_main_header_right_area', array('account', 'wishlist', 'cart') ); ?>
    </ul>

    <div class="logo visible-mobile primary-nav">
		<?php get_template_part( 'template-parts/header/elements/logo' ); ?>
    </div>

    <ul class="flex-left visible-mobile primary-nav">
        <?php pp_get_header_elements( 'mobile_main_header_left_area' ); ?>
    </ul>

    <ul class="flex-right visible-mobile primary-nav">
        <?php pp_get_header_elements( 'mobile_main_header_right_area', array('menu_icon') ); ?>
    </ul>

    <div class="icon-search header-bg-color-bg">
        <?php get_template_part( 'template-parts/header/search-form' ); ?>
        <a href="#0" class="close header-text-color-bg-speudo">Close Search</a>
    </div>

</header>
