<header class="navbar navbar-bottom visible-md-block <?php pp_get_classes( 'bottom_header' ); ?>">
	<div class="flex-grid">
  		<ul class="nav navbar-nav flex-left">
	  		<?php pp_get_header_elements( 'bottom_header_left_area' ); ?>
	  	</ul>
  		<ul class="nav navbar-nav flex-center">
	  		<?php pp_get_header_elements( 'bottom_header_center_area' ); ?>
	  	</ul>
	  	<ul class="nav navbar-nav flex-right">
		  	<?php pp_get_header_elements( 'bottom_header_right_area' ); ?>
		</ul>
	</div>
</header>

<nav class="navbar navbar-mobile-bottom  visible-xs-block">
	<?php pp_get_header_elements( 'mobile_bottom_bar_area' ); ?>
</nav>