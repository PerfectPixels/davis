<?php

// Add the General panel
Kirki::add_panel( 'panel_general', array(
    'priority'    => 10,
    'title'       => __( 'General', 'davis' ),
) );

foreach ( glob( get_template_directory() . '/inc/backend/theme-options/general/*.php' ) as $filename ){
    include_once $filename;
}

?>
