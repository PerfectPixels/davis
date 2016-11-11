<?php

if ( class_exists( 'WC_Product_Reviews_Pro' ) ) {

	require_once ABSPATH . 'wp-content/plugins/woocommerce-product-reviews-pro/includes/class-wc-product-reviews-pro-contribution-type.php';
	
	class pp_Product_Reviews_Pro_Contribution_Type extends WC_Product_Reviews_Pro_Contribution_Type {
	
	
		/** @public string contribution type */
		public $type;
	
	
		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @param string $type
		 */
		public function __construct( $type ) {
	
			$this->type = $type;
		}
	
		/**
		 * Returns form fields for the given contribution type
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_fields() {
	
			// Get default contribution fields
			$fields = $this->get_default_fields();
	
			// Add type-specific fields
			switch ( $this->type ) {
	
				case 'review' :
	
					if ( 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
	
						// Add rating field to beginning of fields
						$fields = array_merge( array(
							'rating' => array(
								'type'    => 'wc_product_reviews_pro_radio',
								'label'   => __( 'How would you rate this product?', 'woocommerce-product-reviews-pro' ),
								'class'   => array( 'star-rating-selector' ),
								'options' => array(
									'5' => __( 'I love it', 'woocommerce-product-reviews-pro' ),
									'4' => __( 'I like it', 'woocommerce-product-reviews-pro' ),
									'3' => __( "It's okay", 'woocommerce-product-reviews-pro' ),
									'2' => __( "I don't like it", 'woocommerce-product-reviews-pro' ),
									'1' => __( 'I hate it', 'woocommerce-product-reviews-pro' ),
								),
								'required' => get_option( 'woocommerce_review_rating_required' ) === 'yes',
							)
						), $fields );
					}
	
					// Review title placeholder
					$fields['title']['placeholder'] = __( 'What is the title of your review?', 'woocommerce-product-reviews-pro' );
	
					// Review content label
					$fields['comment']['label'] = __( 'Your Review', 'woocommerce-product-reviews-pro' );
				break;
	
	
				case 'question' :
	
					// Remove title from question fields
					unset( $fields['title'] );
	
					// Question content label
					$fields['comment']['label'] = __( 'Question', 'woocommerce-product-reviews-pro' );
	
					// Question content placeholder
					$fields['comment']['placeholder'] = __( 'What is your question?', 'woocommerce-product-reviews-pro' );
				break;
	
	
				case 'photo' :
	
					// Photo title placeholder
					$fields['title']['placeholder'] = __( 'What is the title of your photo?', 'woocommerce-product-reviews-pro' );
	
					// Photo content label
					$fields['comment']['label'] = __( 'Description', 'woocommerce-product-reviews-pro' );
	
					// Photo content placeholder
					$fields['comment']['placeholder'] = __( 'Your photo\'s description', 'woocommerce-product-reviews-pro' );
	
					// Set attachment type explicitly
					$fields['attachment_type'] = array(
						'type'    => 'wc_product_reviews_pro_hidden',
						'default' => 'photo',
						'class'   => array( 'attachment-type' ),
					);
	
					if ( isset( $fields['comment']['custom_attributes']['data-min-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-min-word-count'] );
					}
	
					if ( isset( $fields['comment']['custom_attributes']['data-max-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-max-word-count'] );
					}
				break;
	
	
				case 'video' :
	
					// Video title placeholder
					$fields['title']['placeholder'] = __( 'What is the title of your video?', 'woocommerce-product-reviews-pro' );
	
					// Video content label
					$fields['comment']['label'] = __( 'Description', 'woocommerce-product-reviews-pro' );
	
					// Video content placeholder
					$fields['comment']['placeholder'] = __( 'Your video\'s description', 'woocommerce-product-reviews-pro' );
	
					// Set attachment type explicitly
					$fields['attachment_type'] = array(
						'type'    => 'wc_product_reviews_pro_hidden',
						'default' => 'video',
						'class'   => array( 'attachment-type' ),
					);
	
					$fields['attachment_url']['required'] = true;
	
					if ( isset( $fields['comment']['custom_attributes']['data-min-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-min-word-count'] );
					}
	
					if ( isset( $fields['comment']['custom_attributes']['data-max-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-max-word-count'] );
					}
	
					unset( $fields['attachment_file'] );
				break;
	
	
				case 'contribution_comment' :
	
					// Comment content placeholder
					$fields['comment']['placeholder'] = __( 'What is your comment?', 'woocommerce-product-reviews-pro' );
					
					$fields['comment']['label'] = __( 'Leave a comment', 'woocommerce-product-reviews-pro' );
	
					// Unset unnecessary fields
					unset( $fields['title'] );
					unset( $fields['attachment_type'] );
					unset( $fields['attachment_file'] );
					unset( $fields['attachment_url'] );
	
					if ( isset( $fields['comment']['custom_attributes']['data-min-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-min-word-count'] );
					}
	
					if ( isset( $fields['comment']['custom_attributes']['data-max-word-count'] ) ) {
						unset( $fields['comment']['custom_attributes']['data-max-word-count'] );
					}
				break;
	
			}
	
			/**
			 * Filter contribution form fields
			 *
			 * @since 1.0.0
			 * @param array $fields Associative array of contribution form fields
			 * @param string $type The contribution type
			 */
			$fields = apply_filters( 'wc_product_reviews_pro_contribution_type_fields', $fields, $this->type );
	
			$contribution_fields = array();
	
			// Prefix field keys with contribution type to avoid duplicate IDs
			// when using woocommerce_form_field
			$prefix = $this->type . '_';
	
			foreach ( $fields as $key => $value ) {
	
				$contribution_fields[ $prefix . $key ] = $value;
			}
	
			return $contribution_fields;
		}
	
		/**
		 * Get the button text for the contribution type
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function get_button_text() {
	
			switch ( $this->type ) {
	
				case 'review':
	
					$button_text = __( 'Submit Review', 'woocommerce-product-reviews-pro' );
				break;
	
				case 'question':
	
					$button_text = __( 'Submit Question', 'woocommerce-product-reviews-pro' );
				break;
	
				case 'photo':
	
					$button_text = __( 'Save Photo', 'woocommerce-product-reviews-pro' );
				break;
	
				case 'video':
	
					$button_text = __( 'Save Video', 'woocommerce-product-reviews-pro' );
				break;
	
				default:
	
					$button_text = sprintf( __( 'Submit %s', 'woocommerce-product-reviews-pro' ), $this->get_title() );
				break;
	
			}
	
			/**
			 * Filter contribution type button text
			 *
			 * @since 1.0.0
			 * @param string $button_text The button text
			 * @param string $type The contribution type
			 */
			return apply_filters( 'wc_product_reviews_pro_contribution_type_button_text', $button_text, $this->type );
		}
		
	}
	
} ?>
