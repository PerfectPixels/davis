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
 * Display the contribution form for a single product
 *
 * @since 1.0.0
 * @version 1.4.0
 */

global $product;
$contribution_type = new Tomo_Product_Reviews_Pro_Contribution_Type( $type );

/**
 * Fires before contribution form with type $type
 *
 * @since 1.0.0
 */
do_action( 'wc_product_reviews_pro_before_' . $type .'_form' );

if ( 'contribution_comment' == $type ) {

	/**
	 * Fires before comment contribution form for specific comment_ID
	 *
	 * @since 1.0.0
	 */
	do_action( 'wc_product_reviews_pro_before_' . $type .'_' . $comment->comment_ID . '_form' );
}

?>
	
<?php if ( 'contribution_comment' !== $type && 'question' !== $type ) : ?>
	<div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal" data-backdrop="static">
		<a class="icon-close" data-dismiss="modal"></a>
		<div class="modal-dialog container" role="document">
			
			<?php if ( has_post_thumbnail() ) {
			
				echo '<div class="review-thumb">' . get_the_post_thumbnail( $product->ID, 'shop_catalog' ) . '</div>'; 
				
			} else {
				$image_size = wc_get_image_size( 'shop_catalog' );
				if ( ! $placeholder_width ){ $placeholder_width = $image_size['width']; }
				if ( ! $placeholder_height ){ $placeholder_height = $image_size['height']; }
			
				echo '<div class="review-thumb"><img class="" src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" /></div>';
			
			} ?>
			
			<h3><?php printf( __( 'Add a review to "%s"', 'davis' ), get_the_title() ); ?></h3>
			
<?php endif; ?>

			<?php if ( 'contribution_comment' != $type ) : ?>
			<noscript><h3 id="share-<?php echo esc_attr( $type ); ?>"><?php echo $contribution_type->get_call_to_action(); ?></h3></noscript>
			<?php endif; ?>
		
			<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" enctype="multipart/form-data" novalidate class="form-contribution form-<?php echo esc_attr( $type ); ?>">
		
				<?php foreach ( $contribution_type->get_fields() as $key => $field ) : ?>
		
					<?php woocommerce_form_field( $key, $field, wc_product_reviews_pro_get_form_field_value( $key ) ); ?>
		
				<?php endforeach; ?>
		
				<?php if ( ! is_user_logged_in() && get_option( 'require_name_email' ) && ! get_option( 'comment_registration' ) ) : ?>
					<?php woocommerce_form_field( 'author', array( 'placeholder' => __( 'Name', 'woocommerce-product-reviews-pro' ), 'required' => true ) ); ?>
					<?php woocommerce_form_field( 'email', array( 'placeholder' => __( 'Email', 'woocommerce-product-reviews-pro' ), 'required' => true ) ); ?>
				<?php endif; ?>
		
				<?php if ( 'review' == $type ) : ?>
					<?php wc_product_reviews_pro_review_qualifiers_form_controls(); ?>
				<?php endif; ?>
		
				<input type="hidden" name="comment" value="<?php echo wp_create_nonce( 'contribution-content-input' ); ?>">
				<input type="hidden" name="comment_type" value="<?php echo esc_attr( $type ); ?>" />
				<input type="hidden" name="comment_post_ID" value="<?php the_ID(); ?>">
		
				<?php if ( 'contribution_comment' == $type ) : ?>
					<input type="hidden" name="comment_parent" value="<?php echo esc_attr( $comment->comment_ID ); ?>">
				<?php endif; ?>
				
				<p class="form-row submit-btn">
					<button type="submit" class="button"><?php echo esc_html( $contribution_type->get_button_text() ); ?></button>
				</p>
		
				<?php if ( wc_product_reviews_pro_comment_notification_enabled() ) : ?>
					<input type="hidden" name="comment_author_ID" value="<?php echo esc_attr( get_current_user_id() ); ?>">
					<div id="subscribe_to_replies_field" class="subscribe_to_replies">
					
						<?php if ( 'question' !== $type ) : ?>	
							<?php $checkbox_class = esc_attr( $comment->comment_ID ); ?>
						<?php else : ?>
							<?php $checkbox_class = 'question_' . esc_attr( $comment->comment_ID ); ?>
						<?php endif; ?>
						
						<input type="checkbox" class="input-checkbox " name="subscribe_to_replies" id="subscribe_to_replies_<?php echo $checkbox_class; ?>" value="1"> 
						<label for="subscribe_to_replies_<?php echo $checkbox_class; ?>" class="checkbox"><?php _e( 'Notify me of any replies', 'woocommerce-product-reviews-pro' ); ?></label>
					</div>
				<?php endif; ?>
		
				<?php wp_comment_form_unfiltered_html_nonce(); ?>
		
			</form>
		
			<?php if ( 'contribution_comment' == $type && ! is_user_logged_in() && get_option( 'comment_registration' ) ) : ?>
				<noscript>
					<style type="text/css">.form-contribution_comment { display: none; }</style>
					<p class="must-log-in"><?php printf( __( 'You must be <a href="%s">logged in</a> to join the discussion.', 'woocommerce-product-reviews-pro' ), esc_url( add_query_arg( 'redirect_to', urlencode( get_permalink( get_the_ID() ) ), wc_get_page_permalink( 'myaccount' ) . '#comment-' . $comment->comment_ID ) ) ); ?></p>
				</noscript>
			<?php endif; ?>
		
	<?php if ( 'contribution_comment' !== $type && 'question' !== $type ) : ?>	
		</div>
	</div>
	<?php endif; ?>
