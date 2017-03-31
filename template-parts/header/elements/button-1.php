<?php

$url = get_theme_mod( 'button_1_url' );
$label = get_theme_mod( 'button_1_label', 'Button' );

?>

<li class="button-element button-1 border-bottom"><a href="<?php echo $url; ?>" id="button-1" class="header-button <?php pp_get_classes( 'button_1' ); ?>"><?php echo $label; ?></a></li>