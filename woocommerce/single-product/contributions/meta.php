<?php
/**
 * Display a contribution's meta
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php if ( $contribution->moderation == '0' ) : ?>

    <p class="meta"><em><?php _e( 'Your contribution is awaiting approval', 'woocommerce-product-reviews-pro' ); ?></em></p>

<?php else : ?>

    <p class="meta">
    
    	<?php _e( 'By', 'davis' ); ?>

        <strong itemprop="author" itemscope itemtype="http://schema.org/Person">
            <span itemprop="name"><?php comment_author(); ?></span>
        </strong>
        
        <?php wc_product_reviews_pro_author_badge( $comment ); ?>
        
        <?php _e( 'on the', 'davis' ); ?>
        
		<time itemprop="dateCreated" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( date_i18n( wc_date_format(), get_comment_date( 'U' ) ) ); ?></time>
		
		<?php if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' ) {

            if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) ) {

                echo '<em class="verified">' . esc_html__( 'Verified buyer', 'woocommerce-product-reviews-pro' ) . '</em> ';
            }
        } ?>
    </p>

<?php endif; ?>
