<?php if ( pp_can_display( 'top_bar' ) ) { ?>

	<header class="navbar navbar-top flex-grid <?php pp_get_classes( 'top_bar' ); ?>">
  		<ul class="flex-left visible-desktop">
	  		<?php pp_get_header_elements( 'top_bar_left_area', array('social_icon', 'text_1') ); ?>
	  	</ul>
  		<ul class="flex-center visible-desktop">
	  		<?php pp_get_header_elements( 'top_bar_center_area' ); ?>
	  	</ul>
	  	<ul class="flex-right visible-desktop">
		  	<?php pp_get_header_elements( 'top_bar_right_area', array('account', 'wishlist', 'cart') ); ?>
		</ul>

        <ul class="flex-left visible-tablet">
            <?php pp_get_header_elements( 'tablet_top_bar_left_area' ); ?>
        </ul>
        <ul class="flex-right visible-tablet">
            <?php pp_get_header_elements( 'tablet_top_bar_right_area' ); ?>
        </ul>

        <ul class="flex-center visible-mobile">
            <?php pp_get_header_elements( 'mobile_top_bar_area' ); ?>
        </ul>
	</header>

<?php } ?>
