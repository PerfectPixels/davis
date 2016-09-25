<?php
/**
 * Display the default contribution markup
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<li itemprop="comment" itemscope itemtype="http://schema.org/Comment" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="comment-text">

			<?php // Display the meta markup.
			wc_product_reviews_pro_contribution_meta( $contribution ); ?>

			<div itemprop="text" class="description"><?php comment_text(); ?></div>

			<?php // Display the attachments.
			wc_product_reviews_pro_contribution_attachments( $contribution ); ?>
			
			<div class="actions-vote">
				<?php // Display the karma markup.
				wc_product_reviews_pro_contribution_karma( $contribution ); ?>
	
				<?php // Display the actions markup.
				wc_product_reviews_pro_contribution_actions( $contribution ); ?>
	
				<?php wc_product_reviews_pro_contribution_flag_form( $comment ); ?>
			</div>

		</div>
	</div>
