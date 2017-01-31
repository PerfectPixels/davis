<?php
/**
 * Functions for entries.
 *
 * @package Davis
 */

/**
 * Display the correct title
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
function title() {

  if (is_home()) {

    if ( get_option( 'page_for_posts', true ) ) {
      return get_the_title( get_option( 'page_for_posts', true ) );
    } else {
      return __('Latest Posts', 'davis' );
    }

  } else if ( is_shop() ) {

  	return get_theme_mod( 'shop_page_title', __( 'Shop all products', 'davis' ) );

  } else if ( is_product_category() ) {

  	return single_cat_title( '', false );

  } else if ( is_archive() ) {

    return get_the_archive_title();

  } else if ( is_search() ) {

    return sprintf( __( 'Search Results for %s', 'davis' ), get_search_query() );

  } else if ( is_404() ) {

    return __( 'Not Found', 'davis' );

  } else {

    return get_the_title();

  }

}

/**
 * Share link socials
 *
 * @since  1.0
 *
 * @return html
 */
function social_links( $title, $link, $media ) {
    $attr = 'target="_blank" title="'. esc_attr( $title ) .'"'; ?>

    <span class="social-links">
        <a class="icon-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( $link ); ?>&t=<?php echo urlencode( $title ); ?>" <?php echo $attr; ?>></a>
        <a class="icon-twitter" href="http://twitter.com/share?text=<?php echo esc_attr( $title ); ?>&url=<?php echo urlencode( $link ); ?>"  <?php echo $attr; ?>></a>
        <a class="icon-google-plus " href="https://plus.google.com/share?url=<?php echo urlencode( $link ); ?>&text=<?php echo urlencode( $title ); ?>" <?php echo $attr; ?>></a>
        <a class="icon-pinterest" href="http://pinterest.com/pin/create/button?media=<?php echo urlencode( $media ); ?>&url=<?php echo urlencode( $link ); ?>&description=<?php echo urlencode( $title ); ?> " <?php echo $attr; ?>></a>
        <a class="icon-linkedin" href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode( $link ); ?>&title=<?php echo urlencode( $title ); ?> " <?php echo $attr; ?>></a>
    </span>

    <?php
}
