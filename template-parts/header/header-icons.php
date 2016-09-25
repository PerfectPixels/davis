<?php 

use PP\Extras;

global $woocommerce_active;

$current_page = $_SERVER['REQUEST_URI'];

if ( $woocommerce_active ) { ?>
			  		
		<li class="cart dropdown">
  			<a href="#" class="icon-shopping-bag dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span><?php _e('Cart', 'davis' ); ?></span><span class="item-counter"><?php echo WC()->cart->cart_contents_count; ?></span></a>
		</li>
		
		<?php // Compatibility with WC Wishlist
		if ( class_exists('WC_Wishlists_wishlist') ) : 
			$wishlists_url = WC_Wishlists_Pages::get_url_for( 'my-lists' );
			$dropdown = ' dropdown-hover';
		 // Compatibility with YITH Wishlist
		elseif ( class_exists('YITH_WCWL') ) : 
			$dropdown = '';
			if ( class_exists('YITH_WCWL_Premium') ){ $dropdown = ' dropdown-hover'; }
			$wishlists_url = \YITH_WCWL()->get_wishlist_url();
		endif; ?>
		
		<?php if ( class_exists('WC_Wishlists_wishlist') || class_exists('YITH_WCWL') ) : ?>
  		
	  		<li class="wishlist<?php echo $dropdown; ?>">
		  		<a href="<?php echo $wishlists_url; ?>" class="icon-heart-alt" role="button" aria-haspopup="true" aria-expanded="false"><span><?php _e('Wishlists', 'davis' ); ?></span><span class="item-counter"><?php echo Extras\get_wishlist_items('total_items'); ?></span></a>
		  		<?php echo Extras\get_wishlist_items(''); ?>
	  		</li>
		
		<?php endif; ?>
	
		<li class="account dropdown-hover">
			<?php if ( is_user_logged_in() ) { ?>
			<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" class="icon-user-alt" role="button" aria-haspopup="true" aria-expanded="false"><span><?php _e('My Account', 'davis' ); ?></span></a>
		<?php } else { ?>
			<a class="icon-user-alt" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#login-modal"><span><?php _e('Login', 'davis' ); ?></span></a>
		<?php } ?>
		<ul class="dropdown-menu">
			<?php if (has_nav_menu('account_navigation')) {
	        	wp_nav_menu(['theme_location' => 'account_navigation', 'container' => false, 'items_wrap' => '%3$s']);
			} ?>
			<?php if ( is_user_logged_in() ) { ?>
	        	<li class="icon-account-settings animation-delay-3"><a href="<?php echo wc_customer_edit_account_url(); ?>"><?php _e('Account Settings', 'davis' ); ?></a></li>
				<li class="icon-logout animation-delay-4"><a href="<?php echo wp_logout_url($current_page); ?>"><?php _e('Logout', 'davis' ); ?></a></li>
	        <?php } ?>
		</ul>
	</li>
	
<?php } ?>