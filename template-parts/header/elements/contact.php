<?php

$style = get_theme_mod( 'contact_style', 'icon' );
$phone = get_theme_mod( 'phone_label', '+44(444)-7006332' );
$email = get_theme_mod( 'email_label', 'email@domain.com' );
$address = get_theme_mod( 'address_label', '1 Address St' );
$contact_details = get_theme_mod( 'contact_details_label', 'icon' );

?>

<li class="contact-details border-bottom <?php pp_get_classes( 'contact' ); ?>">
    <a href="tel:<?php echo $phone; ?>" class="phone <?php echo get_theme_mod( 'phone_icon_style', 'icon-phone-1' ); ?>"><?php echo $phone; ?></a>
    <a href="mailto:<?php echo $email; ?>" class="email <?php echo get_theme_mod( 'email_icon_style', 'icon-email-1' ); ?>"><?php echo $email; ?></a>
    <a href="http://maps.google.com/?q=<?php echo $address; ?>" class="address <?php echo get_theme_mod( 'address_icon_style', 'icon-address-1' ); ?>"><?php echo $address; ?></a>
<!--    <span class="details">--><?php //echo $contact_details; ?><!--</span>-->
</li>
