<header class="nav-header flex-grid <?php pp_get_classes( 'main-header' ); ?>" data-fixed-sticky-position='{"top": true, "bottom":false}'>

	<?php pp_get_styles( 'main-header-css' ); ?>

	<div class="logo visible-desktop">
		<?php get_template_part( 'template-parts/header/elements/logo' ); ?>
	</div>

	<ul class="flex-left visible-desktop primary-nav <?php pp_get_classes( 'megamenu' ); ?>">
		<?php pp_get_header_elements( 'main_header_left_area' ); ?>
	</ul>

	<ul class="flex-right visible-desktop">
		<?php pp_get_header_elements( 'main_header_right_area' ); ?>
	</ul>

    <div class="icon-search visible-desktop header-bg-color-bg">
        <?php get_template_part( 'template-parts/header/search-form' ); ?>
        <a href="#0" class="close header-text-color-bg-speudo">Close Search</a>
    </div>

</header>
