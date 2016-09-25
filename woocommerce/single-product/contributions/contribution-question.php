<?php
/**
 * Display Question contributions
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<li itemprop="question" itemscope itemtype="http://schema.org/Question" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<h3 class="question-title">
		<?php _e( 'Question:', 'davis' ); ?>
	</h3>

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="comment-text">

			<div itemprop="text" class="description">
				<?php comment_text(); ?>
				<a class="open_answer_form"><?php _e( 'Answer question', 'davis' ); ?></a>	
			</div>

			<?php // Display the meta markup.
			wc_product_reviews_pro_contribution_meta( $contribution ); ?>

			<?php // Display the attachments.
			wc_product_reviews_pro_contribution_attachments( $contribution ); ?>
			
			<div class="actions-vote">
				<?php // Display the karma markup.
				wc_product_reviews_pro_contribution_karma( $contribution ); ?>
	
				<?php // Display the actions markup.
				wc_product_reviews_pro_contribution_actions( $contribution ); ?>
	
				<?php wc_product_reviews_pro_contribution_flag_form( $comment ); ?>
			</div>
			
			<span class="clearfix"></span>

		</div>
	</div>

	<h3 class="answer-title">
		<?php _e( 'Answer:', 'davis' ); ?>
	</h3>
	
	<input type="hidden" class="answer-placeholder" value="<?php _e( 'What is your answer?', 'davis' ); ?>">
	<input type="hidden" class="answer-button" value="<?php _e( 'Submit answer', 'davis' ); ?>">