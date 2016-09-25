<?php 

// REGISTER TAB SHORTCODE
vc_map( array(
    "name" => __("Horizontal Tabs", "tomokids"),
    "base" => "tomo_tabs",
    "as_parent" => array('only' => 'tomo_tab'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name" => __("Tab", "tomokids"),
    "base" => "tomo_tab",
    "as_child" => array('only' => 'tomo_tabs'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Add a title", "tomokids"),
            "param_name" => "title"
        ),
        
        array(
            "type" => "textfield",
            "heading" => __("Add a tab ID", "tomokids"),
            "param_name" => "tab_id"
        )
    )
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Tomo_Tabs extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Tomo_Tab extends WPBakeryShortCode {
    }
}

?>