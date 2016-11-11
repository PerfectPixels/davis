<?php 

/**
 * Calculate new width for VC
 */
function pp_translateColumnWidthToSpan( $width ) {
	preg_match( '/(\d+)\/(\d+)/', $width, $matches );

	if ( ! empty( $matches ) ) {
		$part_x = (int) $matches[1];
		$part_y = (int) $matches[2];
		if ( $part_x > 0 && $part_y > 0 ) {
			$value = ceil( $part_x / $part_y * 12 );
			if ( $value > 0 && $value <= 12 ) {
				$width = 'col-md-' . $value;
			}
		}
	}

	return $width;
}


/**
 * Calculate new offset for VC
 */
function pp_column_offset_class_merge( $column_offset, $width ) {
	// Remove offset settings if
	if ( '1' === vc_settings()->get( 'not_responsive_css' ) ) {
		$column_offset = preg_replace( '/col\-(lg|md|xs)[^\s]*/', '', $column_offset );
	}
	if ( preg_match( '/col\-sm\-\d+/', $column_offset ) ) {
		return $column_offset;
	}

	return $width . ( empty( $column_offset ) ? '' : ' ' . $column_offset );
}


/**
 * @param $content
 * @param bool $autop
 *
 * @since 4.2
 * @return string
 */
function pp_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

?>