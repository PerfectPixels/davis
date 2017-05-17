<?php

// Add the Shop panel
Kirki::add_panel( 'panel_shop', array(
    'priority'    => 12,
    'title'       => __( 'Shop', 'davis' ),
) );

foreach ( glob( get_template_directory() . '/inc/backend/theme-options/shop/*.php' ) as $filename ){
    include_once $filename;
}
