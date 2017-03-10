<?php

$style = get_theme_mod( 'contact_style', 'icon' );
$phone = get_theme_mod( 'phone_label', '+44(444)-7006332' );
$email = get_theme_mod( 'email_label', 'email@domain.com' );
$address = get_theme_mod( 'address_label', 'icon' );
$contact_details = get_theme_mod( 'contact_details_label', 'icon' );

?>

<li class="contact-details <?php pp_get_classes( 'contact' ); ?>">
    <a href="tel:<?php echo $phone; ?>" class="phone icon-phone"><?php echo $phone; ?></a>
    <a href="mailto:<?php echo $email; ?>" class="email icon-email"><?php echo $email; ?></a>
    <a href="http://maps.google.com/?q=<?php echo $address; ?>" class="address icon-location"><?php echo $address; ?></a>
    <span class="details"><?php echo $contact_details; ?></span>
</li>
