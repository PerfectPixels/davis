<?php

global $woocommerce_active;

if ( $woocommerce_active ) { ?>

    <li class="action-button cart dropdown <?php echo get_theme_mod( 'cart_style', 'icon_label' ); ?>">
        <a href="#" class="icon-shopping-bag dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span><?php _e('Cart', 'davis' ); ?></span><span class="item-counter"><?php echo WC()->cart->cart_contents_count; ?></span></a>
    </li>

<?php } else { ?>

    <li>
        <?php _e( 'Woocommerce plugin needed', 'davis' ); ?>
    </li>

<?php }