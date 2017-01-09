<?php 

require_once(get_template_directory().'/lib/vc_overwrites.php');

// Tabs container & Tab Headers
add_shortcode( 'pp_tabs', 'pp_tabs_shortcode' );
function pp_tabs_shortcode( $atts, $content = null ) {
   $a = shortcode_atts( array(
      'foo' => ''
   ), $atts );
   
   // Extract tab titles
	preg_match_all( '/pp_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();
	
	if ( isset( $matches[1] ) ) {
		$tab_titles = $matches[1];
	}
	
	$tabs_nav .= '<ul class="nav nav-tabs" role="tablist">';
	
	foreach ( $tab_titles as $tab ) {
		$tab_atts = shortcode_parse_atts( $tab[0] );
		
		if ( isset( $tab_atts['title'] ) ) {
			$tab_id = ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) );
			$tabs_nav .= '<li role="presentation"><a href="#' . $tab_id . '" aria-controls="' . $tab_id . '" role="tab" data-toggle="tab">' . $tab_atts['title'] . '</a></li>';
		}
	}
	
	$tabs_nav .= '</ul>';
  
   echo $tabs_nav . '<div class="tab-content">' . pp_remove_wpautop( $content ) . '</div>';
}

// Tab Content
add_shortcode( 'pp_tab', 'pp_tab_shortcode' );
function pp_tab_shortcode( $atts, $content = null ) {
   $a = shortcode_atts( array(
      'title' => '',
      'tab_id' => ''
   ), $atts );
   
   $output = '<div role="tabpanel" class="tab-pane" id="tab-' . ( empty( $tab_id ) ? sanitize_title( $title ) : esc_attr( $tab_id ) ) . '">' . pp_remove_wpautop( $content ) . '</div>';
  
   echo $output;
}

?>