<?php

global $woocommerce_active;

if ( $woocommerce_active ) {
	if ( !is_user_logged_in() ) { ?>

		<div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal">
			<div class="modal-dialog container <?php echo get_theme_mod('login_style', 'left_img'); ?>" role="document">
				<?php wc_get_template( 'myaccount/form-login.php' ); ?>
				<a class="icon-close" data-dismiss="modal"></a>
			</div>
		</div>

	<?php }
}