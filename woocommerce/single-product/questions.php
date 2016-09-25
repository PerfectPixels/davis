<?php
/**
 * WooCommerce Product Reviews Pro
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Product Reviews Pro to newer
 * versions in the future. If you wish to customize WooCommerce Product Reviews Pro for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-product-reviews-pro/ for more information.
 *
 * @package   WC-Product-Reviews-Pro/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2015-2016, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Display single product reviews (comments)
 *
 * @version 1.4.0
 * @since 1.0.0
 */
global $product;

if ( ! comments_open() )
	return;

$contribution_types = wc_product_reviews_pro()->get_enabled_contribution_types();
$ratings            = array( 5, 4, 3, 2, 1 );
$total_rating_count = $product->get_rating_count();

?>
<div id="questions">

	<?php $key = 0; ?>
	<?php foreach ( $contribution_types as $type ) : ?>

		<?php if ( 'question' === $type ) : $key++; ?>

			<div id="<?php echo esc_attr( $type ); ?>_form_wrapper" class="contribution-form-wrapper <?php if ( $key === 1 ) : ?>active<?php endif; ?>">
				<?php wc_get_template( 'single-product/form-contribution.php', array( 'type' => $type ) ); ?>
			</div>

		<?php endif; ?>

	<?php endforeach; ?>
	
	<div class="container-reviews">

		<?php if ( ! is_user_logged_in() && get_option('comment_registration') ) : ?>
	
			<noscript>
				<style type="text/css">#reviews .contribution-form-wrapper { display: none; }</style>
				<p class="must-log-in"><?php printf( __( 'You must be <a href="%s">logged in</a> to join the discussion.', 'woocommerce-product-reviews-pro' ), esc_url( add_query_arg( 'redirect_to', urlencode( get_permalink( get_the_ID() ) ), wc_get_page_permalink( 'myaccount' ) . '#tab-reviews' ) ) ); ?></p>
			</noscript>
	
		<?php endif; ?>
	
		<?php // Comments list ?>
		<div id="comments">
	
			<div id="contributions-list">
				<?php wc_get_template( 'single-product/contributions-list.php', array( 'comments' => $comments, 'comment_type' => 'question' ) ); ?>
			</div>
		</div>
	
		<div class="clear"></div>
	
		<?php if ( ! is_user_logged_in() ) : ?>
	
			<div class="modal login-modal" id="wc-product-reviews-pro-modal" tabindex="-1" role="dialog" aria-labelledby="wc-product-reviews-pro-modal">
				<div class="modal-dialog container" role="document">
	
					<?php wc_get_template( 'myaccount/form-login.php' ); ?>
				
					<a href="#" class="icon-close close"></a>
				</div>	
			</div>
			<div id="wc-product-reviews-pro-modal-overlay"></div>
	
		<?php endif; ?>
	
		<?php /* display all forms when no JS */ ?>
		<noscript>
			<style type="text/css">
				.contribution-form-wrapper { display: block; }
			</style>
		</noscript>
	</div>

</div>
