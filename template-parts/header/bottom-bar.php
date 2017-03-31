<?php if ( pp_can_display( 'bottom_header' ) ){ ?>

    <header class="bottom visible-desktop" data-fixed-sticky-position='{"top": true, "bottom":false}'>

        <nav class="navbar-bottom flex-grid">
            <ul class="nav navbar-nav flex-left">
                <?php pp_get_header_elements( 'bottom_header_left_area' ); ?>
            </ul>
            <ul class="nav navbar-nav flex-center">
                <?php pp_get_header_elements( 'bottom_header_center_area' ); ?>
            </ul>
            <ul class="nav navbar-nav flex-right">
                <?php pp_get_header_elements( 'bottom_header_right_area' ); ?>
            </ul>
        </nav>

    </header>

<?php } ?>

<?php if ( pp_can_display( 'mobile_bottom' ) ){ ?>

    <nav class="navbar navbar-mobile-bottom visible-mobile">
        <?php pp_get_header_elements( 'mobile_bottom_bar_area' ); ?>
    </nav>

<?php } ?>