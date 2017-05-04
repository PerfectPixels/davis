<?php

$style = get_theme_mod( 'contact_style', 'icon_label' );
$phone = get_theme_mod( 'phone_label', '+44(444)-7006332' );
$email = get_theme_mod( 'email_label', 'email@domain.com' );
$address = get_theme_mod( 'address_label', '1 Address St' );
$contact_details = get_theme_mod( 'contact_details_label', 'icon' );
$tooltip = false;

if ( strrpos( $style, 'icon-only') !== false ) {
    $tooltip = true;
}

?>

<li class="contact-details border-bottom <?php echo $style; ?>">
    <a href="tel:<?php echo $phone; ?>" class="phone <?php echo get_theme_mod( 'phone_icon_style', 'icon-phone-1' ); ?>"<?php if ( $tooltip ) { ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $phone; ?>"<?php } ?>>
        <?php if ( !$tooltip ) { echo $phone; } ?>
    </a>
    <a href="mailto:<?php echo $email; ?>" class="email <?php echo get_theme_mod( 'email_icon_style', 'icon-email-1' ); ?>"<?php if ( $tooltip ) { ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $email; ?>"<?php } ?>>
        <?php if ( !$tooltip ) { echo $email; } ?>
    </a>
    <a href="http://maps.google.com/?q=<?php echo $address; ?>" class="address <?php echo get_theme_mod( 'address_icon_style', 'icon-address-1' ); ?>" target="_blank"<?php if ( $tooltip ) { ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $address; ?>"<?php } ?>>
        <?php if ( !$tooltip ) { echo $address; } ?>
    </a>
</li>
