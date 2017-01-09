<?php

global $wp, $current_user, $woocommerce_active;

?>

<?php if ( !get_field( 'hide_page_title' ) && !is_product() ){?>

	<section class="cd-hero">
		<ul class="cd-hero-slider">

			<?php

			$custom_title	= get_field( 'page_title_custom_title' );
			$subtitle		= get_field( 'page_title_subtitle' );
			$bg_img 		= get_field( 'page_title_background_image' );
			$bg_color		= get_field( 'page_title_background_color' );
			$bg_video		= get_field( 'page_title_background_video' );
			$bg_img 		= get_field( 'page_title_background_image' );
			$text_color 	= get_field('page_title_text_color');
			$color_style 	= '';
			$breadcrumb		= '';
			$name			= false;

			if ( $text_color ){ $color_style = 'style="color: '.$text_color.';"'; }

			// Get title
			$title = title();

			// If it is a product category page then use the attachement
			if ( $woocommerce_active ) {
				if ( is_product_category() ) {
					global $wp_query;
				    // get the query object
				    $cat = $wp_query->get_queried_object();
				    // get the thumbnail id user the term_id
				    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
				    // get the image URL
				    $bg_img = wp_get_attachment_url( $thumbnail_id );
				    if ( !$bg_img ){ $bg_img = ''; }
				}
			}

			// Check which title to display
			if ( $custom_title ){
				$title = $custom_title;
			}

			// Needed variable
			$classes = '';

			// List item slide classes
			if ( $bg_video ){
				$classes = 'cd-bg-video ';
			} else if ( $bg_img ){
				$classes = 'cd-bg-image ';
			}

			// Title for the account page
			if ( is_user_logged_in() && is_account_page() ){

				$name = sprintf( __( '<small>(not %1$s? <a href="%2$s">Sign out</a>)</small>', 'woocommerce' ), $current_user->display_name, wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ) );
				$title = sprintf( __( 'Hello %1$s', 'woocommerce' ), $current_user->display_name );
				$subtitle = __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses', 'davis' );

			}

			// Title for the thank you page
			if ( is_order_received_page() ) {
				$order_id = get_query_var('order-received');
				$order    = new WC_Order( $order_id );

				if ( $order ){

					if ( $order->has_status( 'failed' ) ){

						$title = __( 'Something went wrong', 'davis' );
						$subtitle = __( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'davis' );

					} else {

						$title = __( 'Thank you!', 'davis' );
						$subtitle = sprintf( __( 'Your order #%s has been received', 'woocommerce' ), $order->get_order_number() );

					}
				} else {

						$title = __( 'Thank you!', 'davis' );
						$subtitle = __( 'Your order has been received but cannot be viewed here. Please check your email for the order confirmation or login if you have an account.', 'woocommerce' );

				}
			}
			?>

			<li class="selected <?php echo $classes; ?>" style="<?php if ( $bg_img ){ echo 'background-image: url('.$bg_img.');'; } if ( $bg_color ){ echo 'background-color: '.$bg_color.';'; } ?>">

				<div class="cd-full-width">
					<?php if ( $woocommerce_active ) {
						if ( is_shop() ){ ?>
							<span class="shop-breadcrumb" <?php echo $color_style; ?>><?php do_action('woo_custom_breadcrumb'); ?></span>
						<?php }
						if ( $name ){ echo $name; }
					} ?>
					<h1 style="<?php echo $color_style; ?>"><?php echo $title; ?></h1>
					<p style="<?php echo $color_style; ?>"><?php echo $subtitle; ?></p>
				</div>

				<?php if ( $bg_video ){ ?>
					<div class="cd-bg-video-wrapper">
						<video loop>
							<source src="<?php echo $bg_video; ?>" type="video/mp4">
						</video>
					</div>
				<?php } ?>

			</li>

		</ul>

	</section>

<?php } ?>
