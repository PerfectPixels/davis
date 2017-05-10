<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */

/**
 * Summary sidebar is display only when there is a rating. WC settings "Enable ratings on reviews" and.
 * "Ratings are required to leave a review" should be selected in order to display the summary rating.
 */

global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

$ratings = array( 5, 4, 3, 2, 1 );
$total_rating_count = $product->get_rating_count();
$average = $product->get_average_rating();

?>
<div id="reviews">
	<div id="comments" <?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) : ?>class="no-rating"<?php endif; ?>>

		<?php if ( $total_rating_count > 0 ) : ?>
			<div class="product-rating">
				<div class="product-rating-summary">
					<h3><?php _e( 'Summary', 'davis' ); ?></h3>

					<span class="number"><?php printf( __( '%s', 'davis' ), floatval( $average ) ); ?></span>

					<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
						<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"></span>
					</div>

					<p><?php printf( _nx( 'Based on %d rating', 'Based on %d ratings', $total_rating_count, 'noun', 'davis' ), $total_rating_count ); ?></p>
				</div>
				<div class="product-rating-details default-rating">
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
									<span class="star-number"><?php echo $rating; ?></span>
									<span class="rating-star"></span>
								</td>
								<td class="rating-graph">
									<span class="bar" style="width: <?php echo $percentage; ?>%" title="<?php printf( '%s%%', $percentage ); ?>"></span>
									<span class="full-bar"></span>
								</td>
								<td class="rating-count">
									<span class="review-number"><?php echo $count; ?></span>
								</td>
							</tr>

						<?php endforeach; ?>

					</table>
				</div>

				<div id="review_form_wrapper" class="contribution-form-wrapper active">

					<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) !== 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

						<a class="leave-review button" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#review-modal"><?php _e('Leave a review', 'davis' ); ?></a>

					<?php else : ?>

						<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="container-reviews <?php if (!have_comments()){ echo 'noreview'; } ?>" <?php if ( $total_rating_count === 0 ) : ?>style="width: 100%;<?php endif; ?>">
			<div id="contributions-list">
				<?php if ( have_comments() ) : ?>

					<ol class="commentlist">
						<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
					</ol>

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
						echo '<nav class="woocommerce-pagination">';
						paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						) ) );
						echo '</nav>';
					endif; ?>

					<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) !== 'no' && $total_rating_count === 0  || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) && $total_rating_count === 0 ) : ?>

						<p class="woocommerce-noreviews">
							<a class="leave-review button" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#review-modal"><?php _e('Leave a review', 'davis' ); ?></a>
						</p>
						
					<?php endif; ?>

				<?php else : ?>

					<p class="woocommerce-noreviews">
						<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) !== 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

							<?php _e( 'There are no reviews yet. Be the first to review this product.', 'woocommerce' ); ?>
							<a class="leave-review button" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#review-modal"><?php _e('Leave a review', 'davis' ); ?></a>

						<?php else : ?>
							<?php _e( 'There are no reviews yet. Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?>
						<?php endif; ?>
					</p>

				<?php endif; ?>
			</div>
		</div>

		<div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal" data-backdrop="static">
			<a class="icon-close" data-dismiss="modal"></a>
			<div class="modal-dialog container" role="document">

				<?php if ( has_post_thumbnail() ) {

					echo '<div class="review-thumb">' . get_the_post_thumbnail( $product->get_id(), 'shop_catalog' ) . '</div>';

				} else {
					$image_size = wc_get_image_size( 'shop_catalog' );
					if ( ! $placeholder_width ){ $placeholder_width = $image_size['width']; }
					if ( ! $placeholder_height ){ $placeholder_height = $image_size['height']; }

					echo '<div class="review-thumb"><img class="" src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" /></div>';

				} ?>

				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? sprintf( __( 'Add a review to &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
						'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => __( 'Submit review', 'woocommerce' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
							<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
						</select></p>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	</div>

</div>
