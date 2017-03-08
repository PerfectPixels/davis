<?php

$default = '';
$transparent = esc_url( get_theme_mod( get_field( 'transparent_header_logo_selection' ) . '_logo', '' ) );
$page_setting = get_field( 'header_logo_selection' );

if ( $page_setting && $page_setting !== 'default' ){
	$default =  esc_url( get_theme_mod( $page_setting . '_logo', '' ) );
} else {
	$default =  esc_url( get_theme_mod( get_theme_mod( 'logo_selection', 'dark' ) . '_logo', '' ) );
}

?>

<a class="brand" href="<?= esc_url( home_url( '/' ) ); ?>">
    <?php if( get_theme_mod( get_theme_mod( 'logo_selection', 'dark' ) . '_logo', '' ) ) { ?>
        <img class="default" src="<?php echo $default; ?>" />
        <img class="for-transparent-header" src="<?php echo $transparent; ?>" />
    <?php } else { ?>
        <?php echo get_bloginfo( 'name' ); ?>
    <?php } ?>
</a>