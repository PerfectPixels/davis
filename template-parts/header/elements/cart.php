<?php

global $woocommerce_active;

if ( $woocommerce_active ) { ?>

    <li class="action-button cart dropdown <?php echo get_theme_mod( 'cart_style', 'icon_label' ); ?>">
        <a href="#" class="<?php echo get_theme_mod( 'cart_icon_style', 'icon-shopping-bag' ); ?> <?php pp_get_classes( 'cart-icon' ); ?> dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span><?php echo get_theme_mod( 'cart_label', 'Cart' ); ?></span><span class="item-counter"><?php echo WC()->cart->cart_contents_count; ?></span></a>
    </li>

<?php } else { ?>

    <li>
        <?php _e( 'Woocommerce plugin needed', 'davis' ); ?>
    </li>

<?php }