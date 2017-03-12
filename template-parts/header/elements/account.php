<?php

global $woocommerce_active;

$current_page = $_SERVER['REQUEST_URI'];

if ( $woocommerce_active ) { ?>

    <li class="action-button account dropdown-hover <?php echo get_theme_mod( 'account_style', 'icon_label' ); ?>">

        <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" class="icon-user-alt" role="button" aria-haspopup="true" aria-expanded="false"><span><?php echo get_theme_mod( 'account_in_label', 'My Account' ); ?></span></a>
        <?php } else { ?>
            <a class="icon-user-alt" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#login-modal"><span><?php echo get_theme_mod( 'account_out_label', 'Login' ); ?></span></a>
        <?php } ?>

        <ul class="dropdown-menu">

            <?php if (has_nav_menu('account_navigation')) {
                wp_nav_menu([
                    'theme_location' => 'account_navigation',
                    'container' => false,
                    'items_wrap' => '%3$s'
                ]);
            } ?>

            <?php if ( is_user_logged_in() ) { ?>
                <li class="icon-account-settings"><a href="<?php echo wc_customer_edit_account_url(); ?>"><?php _e('Account Settings', 'davis' ); ?></a></li>
                <li class="icon-logout"><a href="<?php echo wp_logout_url($current_page); ?>"><?php _e('Logout', 'davis' ); ?></a></li>
            <?php } ?>

        </ul>
    </li>

<?php } ?>