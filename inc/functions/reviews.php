<?php
/**
 * Functions for the reviews.
 *
 * @package Davis
 */

 /**
  * Get product review children comment count
  *
  * @access public
  * @param int
  */
  function wc_product_reviews_pro_get_children_comment_count( $comment_id ) {

  	global $wpdb;

  	$count = $wpdb->get_var( $wpdb->prepare( "
  	  SELECT COUNT(comment_ID) FROM $wpdb->comments
  	  WHERE comment_parent = %d
  	  AND comment_approved = '1'
  	  AND comment_type = 'contribution_comment'
  	", $comment_id ) );

  	return intval( $count );
  }
