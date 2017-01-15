<?php

global $woocommerce_active;

if ($woocommerce_active){

	$cart_class = '';

	if ( WC()->cart->is_empty() ){ $cart_class .= ' empty'; }
	if ( get_theme_mod('quick_checkout', true) == true ){ $cart_class .= ' quick-checkout'; }

	?>

	<aside class="offcanvas-cart<?php echo $cart_class; ?>">
		<?php if ( class_exists( 'WC_Widget_Cart' ) ) { the_widget( 'PP_WC_Widget_Cart' ); } ?>
		<a href="#" class="close-cart"></a>
	</aside>

<?php } ?>
