<?php
$fixed_class = '';
$sm_pos 	 = get_theme_mod( 'social_media_pos', 'left' );
$sm_display  = get_theme_mod( 'display_social_media', false );
$ms			 = get_theme_mod( 'message_text', __( 'Free shipping and returns on all orders', 'davis' ) );
$ms_display	 = get_theme_mod( 'display_message', false );
$ms_pos		 = get_theme_mod( 'message_pos', 'left' );

?>

<?php if (get_theme_mod( 'display_top_bar', false ) == true) : ?>

	<?php if (get_theme_mod( 'fixed_top_bar', true ) == true) {

		$fixed_class = 'navbar-fixed-top';

	} ?>

	<nav class="navbar navbar-top <?php echo $fixed_class; ?>">
		<div class="container-fluid">
	  		<ul class="nav navbar-nav navbar-left">

		  		<?php if ( true == $sm_display && $sm_pos === 'left' ){ ?>

			  		<?php get_template_part( 'template-parts/social-icons' ); ?>

			  	<?php } ?>

		  		<?php if ( has_nav_menu('left_topbar_navigation') ) { ?>

			  		<li class="nav-left-top nav-topbar ">
			  			<?php wp_nav_menu(['theme_location' => 'left_topbar_navigation', 'menu_class' => 'nav']); ?>
			  		</li>

			  	<?php } ?>

		  		<?php if ( true == $ms_display && $ms_pos === 'left' ){ ?>

		  			<li class="message-box"><?php echo $ms; ?></li>

		  		<?php } ?>

		  	</ul>
		  	<ul class="nav navbar-nav navbar-right">

			  	<?php if ( true == get_theme_mod( 'topbar_action_icons', true ) ) : ?>

			  		<?php get_template_part( 'template-parts/header/header-icons' ); ?>

			  	<?php endif; ?>

		  		<?php if ( true == $sm_display && $sm_pos === 'right' ){ ?>

			  		<?php get_template_part( 'template-parts/social-icons' ); ?>

			  	<?php } ?>

		  		<?php if ( has_nav_menu('right_topbar_navigation') ) { ?>

			  		<li class="nav-right-top nav-topbar ">
			  			<?php wp_nav_menu(['theme_location' => 'right_topbar_navigation', 'menu_class' => 'nav']); ?>
			  		</li>

			  	<?php } ?>

		  		<?php if ( true == $ms_display &&  $ms_pos === 'right' ){ ?>

		  			<li class="message-box"><?php echo $ms; ?></li>

		  		<?php } ?>
			</ul>
		</div>
	</nav>
<?php endif; ?>
