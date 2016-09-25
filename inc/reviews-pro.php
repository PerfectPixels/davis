<?php

if ( class_exists( 'WC_Product_Reviews_Pro' ) ) {

	require_once ABSPATH . 'wp-content/plugins/woocommerce-product-reviews-pro/includes/frontend/class-wc-product-reviews-pro-frontend.php';
	
	class Tomo_Product_Reviews_Pro_Frontend extends WC_Product_Reviews_Pro_Frontend {
	
		/**
		 * Add hooks
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			
			remove_filter( 'woocommerce_product_tabs', array( 'WC_Product_Reviews_Pro_Frontend', 'customize_review_tab' ), 1 );
			add_filter( 'woocommerce_product_tabs', array( $this, 'customize_review_tab' ), 98 );
		}
		
		/**
		 * Customize the review product tab
		 *
		 * Will replace the review tab title with a more generic
		 * one if multiple contribution types are enabled, or
		 * with a specific title, if only one type is enabled.
		 *
		 * @since 1.0.0
		 * @param array $tabs
		 * @return array
		 */
		public function customize_review_tab( $tabs ) {
			global $post;
	
			if ( isset( $tabs['reviews'] ) ) {
	
				$enabled_contribution_types = wc_product_reviews_pro()->get_enabled_contribution_types();
	
				// Do not take contribution_comments into account
				if ( ( $key = array_search( 'contribution_comment', $enabled_contribution_types ) ) !== false ) {
					unset( $enabled_contribution_types[$key] );
				}
	
				// Hide reviews tab if none of the types are enabled
				if ( empty( $enabled_contribution_types ) ) {
					unset( $tabs['reviews'] );
				}
	
				// For single types, get their type-specific tab title
				elseif ( count( $enabled_contribution_types ) == 1 ) {
	
					$type = $enabled_contribution_types[0];
					$contribution_type = wc_product_reviews_pro_get_contribution_type( $type );
					$count = wc_product_reviews_pro_get_comments_number( $post->ID, $type );
					$tabs['reviews']['title'] = $contribution_type->get_tab_title( $count );
	
				}
	
				// Otherwise, display the Discussions title and correct number of contributions
				else {
	
					$count = wc_product_reviews_pro_get_comments_number( $post->ID, $enabled_contribution_types );
					$contribution_type = wc_product_reviews_pro_get_contribution_type( null );
					$tabs['reviews']['title'] = sprintf( __( 'Customer Reviews', 'davis' ), $count );
					
					$tabs['description']['title'] = __( 'Product Description' );
				}
			}
			
			// Adds the new tab
			$tabs['questions'] = array(
				'title' 	=> __( 'Questions & Answers', 'woocommerce' ),
				'priority' 	=> 50,
				'callback' 	=> 'tomo_questions_tab_content'
			);
			
			/**
			 * Loads the product questions template
			*/
			function tomo_questions_tab_content() {
			
				
				// The WooCommerce template path within the theme
				$template_path = WC()->template_path();
			
				// Our custom comments template name
				$template_name = 'single-product/questions.php';
			
				// Look within the theme first
				$template = locate_template(
					array(
						trailingslashit( $template_path ) . $template_name,
						$template_name,
					)
				);
			
				require_once $template;
				
			}
	
			return $tabs;
		}
	
	}
	
	$tomo_reviews_pro_frontend = new Tomo_Product_Reviews_Pro_Frontend();

} ?>
