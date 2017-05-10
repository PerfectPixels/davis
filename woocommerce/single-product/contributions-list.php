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

$filters        = wc_product_reviews_pro_get_current_comment_filters();
$current_type   = isset( $filters['comment_type'] ) ? $filters['comment_type'] : null;
$current_rating = isset( $filters['rating'] ) ? $filters['rating'] : null;
?>


<div class="contributions-container">
	<?php if ( have_comments() ) : ?>

		<ol class="commentlist">
			<?php
			wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array(
				'callback'     => 'wc_product_reviews_pro_contributions',
				'max_depth'    => 2,
				'end-callback' => 'wc_product_reviews_pro_contribution_comment_form',
			) ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<nav class="woocommerce-pagination">
				<?php paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) ); ?>
			</nav>
			
		<?php endif; ?>

	<?php else : ?>

		<p class="woocommerce-noreviews">
			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
				
				<?php if ( $comment_type === 'review' ){ ?>
					<?php _e( 'There are no reviews yet. Be the first to review this product.', 'davis' ); ?>	
					<a class="leave-review button" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#review-modal"><?php _e('Leave a review', 'davis' ); ?></a>
				<?php } ?>
				
			<?php else :
			
				if ( $comment_type === 'review' ){
					_e( 'There are no reviews yet. Only logged in customers who have purchased this product may leave a review.', 'davis' );
				}
	
			endif; ?>
		</p>

	<?php endif; ?>
</div>
