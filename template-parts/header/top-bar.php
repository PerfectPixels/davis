<?php if (get_theme_mod( 'display_top_bar', false ) == true) { ?>

	<header class="navbar navbar-top flex-grid <?php pp_get_classes( 'top_bar' ); ?>">
  		<ul class="flex-left">
	  		<?php pp_get_header_elements( 'top_bar_left_area' ); ?>
	  	</ul>
  		<ul class="flex-center">
	  		<?php pp_get_header_elements( 'top_bar_center_area' ); ?>
	  	</ul>
	  	<ul class="flex-right">
		  	<?php pp_get_header_elements( 'top_bar_right_area' ); ?>
		</ul>
	</header>

<?php } ?>
