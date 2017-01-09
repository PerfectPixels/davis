<?php
/**
 * Display Review contributions
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = $contribution->get_rating();
$title  = $contribution->get_title();
$rating_enabled = $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes';

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="comment-text">

			<?php if ( $title || $rating_enabled ) : ?>

				<h3 class="contribution-title review-title">

					<?php if ( $rating_enabled ) : ?>

						<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', 'woocommerce-product-reviews-pro' ), $rating ) ); ?>">
							<span style="width:<?php echo esc_attr( ( $rating / 5 ) * 100 ); ?>%"></span>
						</span>

					<?php endif; ?>

					<?php if ( $title ) : ?>

						<span itemprop="name"><?php echo esc_html( $title ); ?></span>

					<?php endif; ?>

				</h3>

			<?php endif; ?>

			<?php // Display the meta markup.
			wc_product_reviews_pro_contribution_meta( $contribution ); ?>

			<?php wc_product_reviews_pro_review_qualifiers( $contribution ); ?>

			<div itemprop="reviewBody" class="description">
				<?php comment_text(); ?>

				<?php // Display the attachments.
				wc_product_reviews_pro_contribution_attachments( $contribution ); ?>
			</div>

			<?php // Display the comment icon
			$comment_count = wc_product_reviews_pro_get_children_comment_count( get_comment_ID() ); ?>

			<a class="icon-bubble-chat toggle-comment">
				<?php if ( $comment_count === 0 ){
					_e( 'comment', 'davis' );
				} else {
					echo sprintf( _n( '%s comment', '%s comments', $comment_count, 'davis' ), $comment_count );
				} ?>
			</a>

			<div class="actions-vote">
				<?php // Display the karma markup.
				wc_product_reviews_pro_contribution_karma( $contribution ); ?>

				<?php // Display the actions markup.
				wc_product_reviews_pro_contribution_actions( $contribution ); ?>

				<?php wc_product_reviews_pro_contribution_flag_form( $comment ); ?>
			</div>

		</div>
	</div>
