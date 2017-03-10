<header class="nav-header flex-grid <?php pp_get_classes( 'main-header' ); ?>" data-fixed-sticky-position='{"top": true, "bottom":false}'>

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

</header>
