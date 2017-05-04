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
        if ( class_exists('YITH_WCWL_Premium') ){ $dropdown = 'dropdown-hover'; }
        $wishlists_url = YITH_WCWL()->get_wishlist_url();
    }

    if ( class_exists('WC_Wishlists_wishlist') || class_exists('YITH_WCWL') ) { ?>

        <li class="action-button wishlist <?php echo $dropdown; ?> <?php echo get_theme_mod( 'wishlist_style', 'icon_label' ); ?>">
            <a href="<?php echo $wishlists_url; ?>" class="<?php echo get_theme_mod( 'wishlist_icon_style', 'icon-heart' ); ?> <?php pp_get_classes( 'wishlist-icon' ); ?>" role="button" aria-haspopup="true" aria-expanded="false"><span><?php echo get_theme_mod( 'wishlist_label', 'Favorites' ); ?></span><span class="item-counter"><?php echo get_wishlist_items('total_items'); ?></span></a>

            <?php if ( $dropdown !== '' ) { ?>
                <span class="mobile-arrow"></span>
            <?php } ?>

            <?php echo get_wishlist_items(''); ?>
        </li>

    <?php } ?>

<?php } ?>
