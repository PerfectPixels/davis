<?php if ( pp_can_display( 'bottom_header' ) ){ ?>

    <header class="navbar navbar-bottom flex-grid <?php pp_get_classes( 'bottom_header' ); ?>">
        <ul class="nav navbar-nav flex-left">
            <?php pp_get_header_elements( 'bottom_header_left_area' ); ?>
        </ul>
        <ul class="nav navbar-nav flex-center">
            <?php pp_get_header_elements( 'bottom_header_center_area' ); ?>
        </ul>
        <ul class="nav navbar-nav flex-right">
            <?php pp_get_header_elements( 'bottom_header_right_area' ); ?>
        </ul>
    </header>

<?php } ?>

<?php if ( pp_can_display( 'mobile_bottom' ) ){ ?>

    <nav class="navbar navbar-mobile-bottom">
        <?php pp_get_header_elements( 'mobile_bottom_bar_area' ); ?>
    </nav>

<?php } ?>