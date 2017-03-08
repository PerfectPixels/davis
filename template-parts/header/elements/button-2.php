<?php

$url = get_theme_mod( 'button_2_url' );
$label = get_theme_mod( 'button_2_label', 'Button' );

?>

<li><a href="<?php echo $url; ?>" id="button-2" class="header-button <?php pp_get_classes( 'button_2' ); ?>"><?php echo $label; ?></a></li>