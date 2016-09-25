<?php
/**
 * Display a contribution's upvotes and downvotes
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<span class="contribution-karma">
	<?php if ( $contribution->get_vote_count() ) : ?>
		<?php /* translators: Number of users that found a contibution useful - %1$d number of users, %2$d - total number of users that found the contribution useful */
		printf( _n( 'One person found this helpful.', '%1$d out of %2$d people found this helpful.', $contribution->get_vote_count(), 'woocommerce-product-reviews-pro' ), $contribution->get_positive_votes(), $contribution->get_vote_count() ); ?>
	<?php endif; ?>
</span>
