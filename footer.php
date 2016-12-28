<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Davis
 */

use PP\Setup;

global $woocommerce_active;

if ( $woocommerce_active ) {
	$footer_sidebar = get_theme_mod('footer_sidebar', 'products_pages');

	switch($footer_sidebar){
		case 'products_pages';
			if ( is_shop() || is_product_category() || is_product() ){
				$footer_sidebar = true;
			}
			break;
		case 'product';
			if ( is_product() ){
				$footer_sidebar = true;
			}
			break;
		case 'all';
			$footer_sidebar = true;
			break;
	}
}

$sidebar = (get_theme_mod('shop_sidebar', 'no') === 'no') ? false : get_theme_mod('shop_sidebar', 'no');

?>

	</main>

	<?php if (Setup\display_sidebar() && $sidebar) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>

</div>

<?php if ($footer_sidebar) :
	get_template_part("template-parts/sidebar-footer");
endif; ?>

<footer id="footer">

	<?php if (  get_theme_mod('footer_sidebar_bottom', true) == true ){ ?>
		<aside class="bottom-widgets">
			<div class="container">
			    <?php dynamic_sidebar('sidebar-footer-bottom'); ?>
			</div>
		</aside>
	<?php } ?>

    <div class="container-fluid footer_bottom">
        <div class="container">
            <div class="col-md-4 footer_copyrights">
                <p><?php echo get_theme_mod('copyright_text'); ?></p>
            </div>
			<div class="col-md-8 footer_nav">
                <?php if ( get_theme_mod('footer_social', false) == true ) { ?>
                	<ul id="footer-social">
			    		<?php get_template_part( 'template-parts/social', 'icons' ); ?>
                	</ul>
				<?php } ?>

	        	<?php if ( has_nav_menu('footer_navigation') ) {
			    	wp_nav_menu(['theme_location' => 'footer_navigation']);
				} ?>
			</div>
        </div>

    </div>
</footer>

<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="message-modal">
	<div class="modal-dialog container" role="document">
		<div class="content"></div>
		<a class="button" data-dismiss="modal">OK</a>
	</div>
</div>

<div class="nav-overlay"></div>

<?php if ( $woocommerce_active ) { ?>
	<?php if ( !is_user_logged_in() ) { ?>
		<div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal">
			<div class="modal-dialog container <?php echo get_theme_mod('login_style', 'left_img'); ?>" role="document">
				<?php wc_get_template( 'myaccount/form-login.php' ); ?>
				<a class="icon-close" data-dismiss="modal"></a>
			</div>
		</div>
	<?php } ?>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
