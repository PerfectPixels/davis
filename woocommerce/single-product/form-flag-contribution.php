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
 * Display flag form for a single contribution
 *
 * @version 1.4.0
 * @since 1.0.0
 */
?>

<form method="post" class="contribution-flag-form" id="flag-contribution-<?php echo esc_attr( $comment->comment_ID ); ?>">

	<p><?php esc_html_e( 'Something wrong?', 'woocommerce-product-reviews-pro' ); ?></p>

	<p class="form-row form-row-wide">
		<textarea rows="6"cols="5" class="input-flag-reason" name="flag_reason" placeholder="<?php _e('Please be as detailed as possible', 'davis' ); ?>" id="comment_<?php echo esc_attr( $comment->comment_ID ); ?>_flag_reason"></textarea>
	</p>

	<p class="form-row form-row-wide">
		<button type="submit" class="button"><?php esc_html_e( 'Submit', 'woocommerce-product-reviews-pro' ); ?></button>
		<button type="button" class="button cancel"><?php esc_html_e( 'Cancel', 'davis' ); ?></button>
		<span class="clear"></span>
	</p>

    <input type="hidden" name="comment_id" value="<?php echo esc_attr( $comment->comment_ID ); ?>">
	<input type="hidden" name="action" value="flag_contribution">

</form>
