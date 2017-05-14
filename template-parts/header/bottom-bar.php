<?php if ( pp_can_display( 'mobile_bottom' ) ){ ?>

    <nav class="navbar navbar-mobile-bottom visible-mobile">
        <ul class="flex-grid"><?php pp_get_header_elements( 'mobile_bottom_bar_area', array('search_icon', 'account', 'wishlist', 'cart') ); ?></ul>
    </nav>

<?php } ?>
