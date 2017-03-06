<a class="brand" href="<?= esc_url( home_url( '/' ) ); ?>" style="width:<?php echo get_theme_mod( 'logo_width', '82' ); ?>px;">
	<img class="default" src="<?php if ( get_field( 'header_logo_selection' ) != 'default' ){ echo esc_url( get_theme_mod( get_field( 'header_logo_selection' ) . '_logo' ) ); } else { echo esc_url( get_theme_mod( get_theme_mod( 'logo_selection', 'dark' ) . '_logo' ) ); } ?>" />
	<img class="for-transparent-header" src="<?php echo esc_url( get_theme_mod( get_field( 'transparent_header_logo_selection' ) . '_logo' ) ); ?>" />
</a>