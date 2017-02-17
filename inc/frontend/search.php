<?php
/**
* Class for the search
*
* @version 1.0
*/
class PP_Search {

    /**
	 * Construction function
	 *
	 * @since  1.0
	 * @return PP_Search
	 */
	function __construct() {
		// Define all hook
		add_action( 'template_redirect', array( $this, 'initiate_hooks' ) );

        add_action( 'wp_ajax_pp_search_product', array( $this, 'pp_search_product' ) );
        add_action( 'wp_ajax_nopriv_pp_search_product', array( $this, 'pp_search_product' ) );
	}

    /**
	 * Hooks to actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function initiate_hooks() {

    }

    /**
     * Search product by category
     */
    function pp_search_product() {
        global $woocommerce;
        
        $result = array(
            'status' => 'error',
            'html' => ''
        );
        
        if ( isset($_REQUEST['s']) ) {

            $wc_get_template = function_exists( 'wc_get_template' ) ? 'wc_get_template' : 'woocommerce_get_template';            
            $s = sanitize_text_field( $_REQUEST['s'] );
            $ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );

            $args = array(
                's'                   => $s,
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby'             => $ordering_args['orderby'],
                'order'               => $ordering_args['order'],
                'posts_per_page'      => -1,
                'suppress_filters'    => false,
                'meta_query'          => array(
                    array(
                        'key'     => '_visibility',
                        'value'   => array( 'search', 'visible' ),
                        'compare' => 'IN'
                    )
                )
            );

            if ( isset( $_REQUEST['product_cat'] ) && $_REQUEST['product_cat'] !== '0' ) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $_REQUEST['product_cat']
                    ) );
            }

            $products = get_posts( $args );

            if ( ! empty($products) ) {
                ob_start();

                foreach ( $products as $post ) {
                    setup_postdata( $post );
                    $wc_get_template( 'content-widget-product.php' );
                }

                $output .= '<ul class="product-results">' . ob_get_clean() . '</ul><a class="view-all" href="' . esc_url( home_url() ) . '/?s='. $s .'&post_type=product&product_cat='.$_REQUEST['product_cat'].'">' . esc_html__('View all', 'davis' ) . '</a>';
            }

            wp_reset_postdata();

            if ( empty( $products ) ) {
                $output = '<p class="no-results">' . esc_html__( 'No results was found', 'davis' ) . '</p>';
            }
        }

        echo json_encode($output);

        die();
    }

}
