<?php

global $woocommerce_active;

if ( $woocommerce_active ) {

    // Compatibility with WC Wishlist
    if ( class_exists('WC_Wishlists_wishlist') ) {
        $wishlists_url = WC_Wishlists_Pages::get_url_for( 'my-lists' );
        $dropdown = ' dropdown-hover';

    // Compatibility with YITH Wishlist
    } else if ( class_exists('YITH_WCWL') ) {
        $dropdown = '';
        if ( class_exists('YITH_WCWL_Premium') ){ $dropdown = ' dropdown-hover'; }
        $wishlists_url = YITH_WCWL()->get_wishlist_url();
    }

    if ( class_exists('WC_Wishlists_wishlist') || class_exists('YITH_WCWL') ) : ?>

        <li class="header-button wishlist<?php echo $dropdown; ?>">
            <a href="<?php echo $wishlists_url; ?>" class="icon-heart-alt" role="button" aria-haspopup="true" aria-expanded="false"><span><?php _e('Wishlists', 'davis' ); ?></span><span class="item-counter"><?php echo get_wishlist_items('total_items'); ?></span></a>
            <?php echo get_wishlist_items(''); ?>
        </li>

    <?php endif; ?>

<?php } ?>
