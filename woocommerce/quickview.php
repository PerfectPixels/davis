<?php
/**
 * Quickview template
 *
 * @author 		PerfectPixels
 * @version     1.0.0
 */

remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'pp_variable_add_to_cart_quickview', 30 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

$quickview_layout = get_theme_mod( 'quickview_layout', 'left' );

?>

<div id="quickview-modal" class="modal fade <?php echo $quickview_layout; ?>" tabindex="-1" role="dialog" aria-labelledby="quickview-modal">
	<div class="modal-dialog container" role="document">
		<div class="content">
			<div class="images">
				<?php
					wc_get_template( 'single-product/product-image.php', array(
						'quickview' => true
					));
				?>
			</div>
			<div class="summary">
				<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?> 
			</div>	
		</div>
		<nav class="product-nav">
			<a class="prev" href="" data-product-id="">
				<div class="nav-button">
					<span class="icon-wrap">
						<svg class="icon" width="24" height="24" viewBox="0 0 64 64"><path d="M46.077 55.738c0.858 0.867 0.858 2.266 0 3.133s-2.243 0.867-3.101 0l-25.056-25.302c-0.858-0.867-0.858-2.269 0-3.133l25.056-25.306c0.858-0.867 2.243-0.867 3.101 0s0.858 2.266 0 3.133l-22.848 23.738 22.848 23.738z"></path></svg>
					</span>
				</div>
				<div class="details">
					<img src="" alt="Previous thumb"/>
					<div>
						<span><?php _e('Previous Product', 'davis'); ?></span>
						<h3></h3>
					</div>
				</div>
			</a>
			<a class="next" href="" data-product-id="">
				<div class="nav-button">
					<span class="icon-wrap">
						<svg class="icon" width="24" height="24" viewBox="0 0 64 64"><path d="M17.919 55.738c-0.858 0.867-0.858 2.266 0 3.133s2.243 0.867 3.101 0l25.056-25.302c0.858-0.867 0.858-2.269 0-3.133l-25.056-25.306c-0.858-0.867-2.243-0.867-3.101 0s-0.858 2.266 0 3.133l22.848 23.738-22.848 23.738z"></path></svg>
					</span>
				</div>
				<div class="details">
					<img src="" alt="Next thumb"/>
					<div>
						<span><?php _e('Next Product', 'davis'); ?></span>
						<h3></h3>
					</div>
				</div>
			</a>
		</nav>
		<a class="icon-close" data-dismiss="modal"></a>
	</div>
</div>