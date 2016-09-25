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
$average     		= $product->get_average_rating();
$comment_type = 'review';

?>
<div id="reviews" <?php if ( 'no' == get_option( 'woocommerce_enable_review_rating' ) ) : ?>class="no-rating"<?php endif; ?>>

	<?php // Product ratings ?>
	<?php if ( $total_rating_count > 0 ) : ?>
		
		<div class="product-rating">
			<div class="product-rating-summary">
				<h3><?php _e( 'Summary', 'davis' ); ?></h3>
				
				<span class="number"><?php printf( __( '%s', 'woocommerce-product-reviews-pro' ), floatval( $product->get_average_rating() ) ); ?></span>

				<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
					<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"></span>
				</div>

				<?php $reviews_count = wc_product_reviews_pro_get_comments_number( $product->id, 'review' ); ?>
				<p><?php printf( _nx( '%d review', '%d reviews', $reviews_count, 'noun', 'woocommerce-product-reviews-pro' ), $reviews_count ); ?></p>
			</div>
			<div class="product-rating-details">
				<table>

					<?php foreach ( $ratings as $rating ) : ?>

						<?php

							$count      = $product->get_rating_count( $rating );
							$percentage = $count / $total_rating_count * 100;

							$url    = remove_query_arg( 'comment_filter', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );
							$filter = "comment_type=review&rating={$rating}";
							$url    = add_query_arg( 'comments_filter', urlencode( $filter ), $url );

						?>
						<tr>
							<td class="rating-number">
								<a href="<?php echo esc_url( $url ); ?>#comments"><?php echo $rating; ?></a>
								<span class="rating-star"></span>
							</td>
							<td class="rating-graph">
								<a href="<?php echo esc_url( $url ); ?>#comments" class="bar" style="width: <?php echo $percentage; ?>%" title="<?php printf( '%s%%', $percentage ); ?>"></a>
								<span class="full-bar"></span>
							</td>
							<td class="rating-count">
								<a href="<?php echo esc_url( $url ); ?>#comments"><?php echo $count; ?></a>
							</td>
						</tr>

					<?php endforeach; ?>

				</table>
			</div>
			
			<?php $key = 0; ?>
			
			<?php foreach ( $contribution_types as $type ) : ?>
		
				<?php if ( 'review' === $type ) : ?>
		
					<div id="<?php echo esc_attr( $type ); ?>_form_wrapper" class="contribution-form-wrapper active">
					
						<?php if ( 'review' != $type || get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>
						
							<a class="leave-review button" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#review-modal"><?php _e('Leave a review', 'davis' ); ?></a>
							
						<?php else : ?>

							<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce-product-reviews-pro' ); ?></p>
						
						<?php endif; ?>
					</div>
		
				<?php endif; ?>
		
			<?php endforeach; ?>
			
		</div>

	<?php endif; ?>

	<div class="container-reviews" <?php if ( $total_rating_count === 0 ) : ?>style="width: 100%;<?php endif; ?>">
		<?php
			/**
		     * Fires before contribution list and title
		     *
		     * @since 1.0.1
			 */
			do_action( 'wc_product_reviews_pro_before_contributions' ); ?>
	
		<?php if ( ! is_user_logged_in() && get_option('comment_registration') ) : ?>
	
			<noscript>
				<style type="text/css">#reviews .contribution-form-wrapper { display: none; }</style>
				<p class="must-log-in"><?php printf( __( 'You must be <a href="%s">logged in</a> to join the discussion.', 'woocommerce-product-reviews-pro' ), esc_url( add_query_arg( 'redirect_to', urlencode( get_permalink( get_the_ID() ) ), wc_get_page_permalink( 'myaccount' ) . '#tab-reviews' ) ) ); ?></p>
			</noscript>
	
		<?php endif; ?>
	
		<?php // Comments list ?>
		<div id="comments">
			
			<?php if ( $total_rating_count > 0 ) : ?>
				<form method="get" action="#comments" class="contributions-filter">
					<?php
		
					// Filter options
					$options = array(
						'' => __( 'Show everything', 'woocommerce-product-reviews-pro' ),
					);
		
					// Add option for each contribution type
					foreach ( $contribution_types as $type ) {
		
						if ( 'contribution_comment' == $type || 'question' == $type ) {
							continue;
						}
		
						$contribution_type = wc_product_reviews_pro_get_contribution_type( $type );
						$options[ 'comment_type=' . $type ] = $contribution_type->get_filter_title();
					}
		
					// Special options
					$options[ 'comment_type=review&classification=positive&helpful=1' ] = __( 'Show helpful positive reviews', 'woocommerce-product-reviews-pro' );
					$options[ 'comment_type=review&classification=negative&helpful=1' ] = __( 'Show helpful negative reviews', 'woocommerce-product-reviews-pro' );
		
					/**
					 * Filter the filter options.
					 *
					 * @since 1.0.0
					 * @param array $options The filter options.
					 */
					$options = apply_filters( 'wc_product_reviews_pro_contribution_filter_options', $options );
		
					// Other field args
					$args = array(
						'type'    => 'select',
						'options' => $options,
					);
		
					$comments_filter = isset( $_REQUEST['comments_filter'] ) ? $_REQUEST['comments_filter'] : null;
		
					?>
		
					<a href="<?php the_permalink(); ?>" class="js-clear-filters" style="display:none;" title="<?php _e( 'Click to clear filters', 'woocommerce-product-reviews-pro' ); ?>"><?php _e( '(clear)', 'woocommerce-product-reviews-pro' ); ?></a>
		
					<?php woocommerce_form_field( 'comments_filter', $args, $comments_filter ); ?>
		
					<noscript><button type="submit" class="button"><?php _e( 'Go', 'woocommerce-product-reviews-pro' ); ?></button></noscript>
				</form>
			<?php endif; ?>
	
			<div id="contributions-list">
				<?php wc_get_template( 'single-product/contributions-list.php', array( 'comments' => $comments, 'comment_type' => 'review' ) ); ?>
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
	
	<?php foreach ( $contribution_types as $type ) : ?>
		<?php if ( 'review' === $type ) : ?>
		
			<?php wc_get_template( 'single-product/form-contribution.php', array( 'type' => $type ) ); ?>
			
		<?php endif; ?>
	<?php endforeach; ?>

</div>
