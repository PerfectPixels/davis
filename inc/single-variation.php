<?php
/*
Plugin Name: WooCommerce Show Single Variations
Plugin URI: http://www.jckemp.com
Description: Show product variations in the main product loops
Version: 1.0.4
Author: James Kemp
Author URI: http://www.jckemp.com
Text Domain: davis
*/


if(is_admin()) {
    
    add_action( 'woocommerce_variation_options', 'add_variation_checkboxes', 10, 3 );
    
    add_action( 'woocommerce_product_after_variable_attributes', 'add_variation_additional_fields', 10, 3 );

    add_action( 'woocommerce_save_product_variation', 'save_product_variation', 10, 2 );

    add_action( 'woocommerce_save_product_variation', 'add_variation_to_categories', 10, 2 );

    add_action(  'transition_post_status', 'transition_variation_status', 10, 3 );

} else {

    add_action( 'woocommerce_product_query', 'add_variations_to_product_query', 50, 2 );
    add_filter( 'woocommerce_shortcode_products_query', 'add_variations_to_shortcode_query', 10, 2 );

    add_filter( 'post_type_link', 'change_variation_permalink', 10, 2 );
            
    add_filter( 'post_class', 'add_post_classes_in_loop' );
    add_filter( 'woocommerce_product_is_visible', 'filter_variation_visibility', 10, 2 );

    add_filter( 'the_title', 'change_variation_title', 10, 2 );

}

add_filter( 'woocommerce_taxonomy_objects_product_cat','add_product_categories_to_variations' );





/** =============================
    *
    * Frontend: Add variaitons to product query, similar to pre_get_posts
    *
    * @param  [obj] [$q] The current query
    *
    ============================= */

    function add_variations_to_product_query( $q, $wc_query ) {

        if( !is_admin() && is_woocommerce() && $q->is_main_query() && isset( $q->query_vars['wc_query'] ) ) {
			
			// ADD BY DAVID
            global $_chosen_attributes, $wp_query;
            
            // Has this page got any subcategories?
            $children = false;
			$term 	  = $wp_query->get_queried_object();
			
			if ( is_tax() ){
				$children = get_terms( $term->taxonomy, array(
					'parent'    => $term->term_id,
					'hide_empty' => false
				) );
			}
			
			if ( !$children ){
				$tax_query = array(
	            	array(
						'taxonomy' => 'product_type',
						'field' => 'slug',
						'terms' => 'variable',
						'operator'  => 'NOT IN'
					)
				);
	
				$q->set('tax_query',$tax_query);
			}

            $post_type = (array) $q->get('post_type');
            $post_type[] = 'product_variation';
            if( !in_array('product', $post_type) ) $post_type[] = 'product';
            $q->set('post_type', $post_type );

            // update the meta query to include our variations

            $meta_query = (array) $q->get('meta_query');
            $meta_query = update_meta_query( $meta_query );

            $q->set('meta_query', $meta_query );

            // if we've filtered the products using layered nav

            if( is_filtered() ) {

                $current_post__in = (array) $q->get('post__in');
                $filtered_variation_ids = get_filtered_variation_ids();
                $post__in = array_merge($current_post__in, $filtered_variation_ids);

                $q->set( 'post__in', $post__in );
                $wc_query->post__in = $post__in;

            }

            add_action( 'wp', 'get_products_in_view', 5);

        }

    }

/** =============================
    *
    * Frontend: Add variaitons to shortcode queries
    *
    * @param arr $query_args
    * @param arr $shortcode_args
    *
    ============================= */

    function add_variations_to_shortcode_query( $query_args, $shortcode_args ) {

        // Add product variations to the query

        $post_type = (array) $query_args['post_type'];
        $post_type[] = 'product_variation';

        $query_args['post_type'] = $post_type;

        // update the meta query to include our variations

        $meta_query = (array) $query_args['meta_query'];
        $meta_query = $update_meta_query( $meta_query );

        $query_args['meta_query'] = $meta_query;

        return $query_args;

    }

/** =============================
    *
    * Frontend: Update unfiltered_product_ids to include variations
    *
    * This means the layered nav count will be correct
    *
    ============================= */

    function get_products_in_view() {

        global $wp_the_query;

        // Get main query
		$current_wp_query = $wp_the_query->query;

		// Get WP Query for current page (without 'paged')
		unset( $current_wp_query['paged'] );

		// Generate a transient name based on current query
		$transient_name = 'jck_wssv_uf_pid_' . md5( http_build_query( $current_wp_query ) . WC_Cache_Helper::get_transient_version( 'product_query' ) );
		$transient_name = ( is_search() ) ? $transient_name . '_s' : $transient_name;

		if ( false === ( $unfiltered_product_ids = get_transient( $transient_name ) ) ) {

            $current_unfiltered_product_ids = WC()->query->unfiltered_product_ids;

            // Get all visible posts, regardless of filters
    		$unfiltered_product_ids = get_posts(
    			array_merge(
    				$current_wp_query,
    				array(
    					'post_type'              => 'product_variation',
    					'numberposts'            => -1,
    					'post_status'            => 'publish',
    					'meta_query'             => $wp_the_query->meta_query->queries,
    					'fields'                 => 'ids',
    					'no_found_rows'          => true,
    					'update_post_meta_cache' => false,
    					'update_post_term_cache' => false,
    					'pagename'               => '',
    					'wc_query'               => 'get_product_variations_in_view'
    				)
    			)
    		);

    		$unfiltered_product_ids = array_merge($unfiltered_product_ids, $current_unfiltered_product_ids);

    		set_transient( $transient_name, $unfiltered_product_ids, DAY_IN_SECONDS * 30 );

		}

        WC()->query->unfiltered_product_ids = $unfiltered_product_ids;

        // Also store filtered posts ids...
		if ( sizeof( WC()->query->post__in ) > 0 ) {
			WC()->query->filtered_product_ids = array_intersect( WC()->query->unfiltered_product_ids, WC()->query->post__in );
		} else {
			WC()->query->filtered_product_ids = WC()->query->unfiltered_product_ids;
		}

		// And filtered post ids which just take layered nav into consideration (to find max price in the price widget)
		if ( sizeof( WC()->query->layered_nav_post__in ) > 0 ) {
			WC()->query->layered_nav_product_ids = array_intersect( WC()->query->unfiltered_product_ids, WC()->query->layered_nav_post__in );
		} else {
			WC()->query->layered_nav_product_ids = WC()->query->unfiltered_product_ids;
		}

    }
    
/** =============================
    *
    * Helper: Update meta query
    *
    * Add OR parameters to also search for variations with specific visibility
    *
    * @param  [arr] [$meta_query]
    * @return [arr]
    *
    ============================= */

    function update_meta_query( $meta_query ) {
		
		// ADD BY DAVID
        global $wp_query;
    	
    	// Has this page got any subcategories?
    	$children = false;
		$term 	  = $wp_query->get_queried_object();
		
		if ( is_tax() ){
			$children = get_terms( $term->taxonomy, array(
				'parent'    => $term->term_id,
				'hide_empty' => false
			) );
		}

        if( !empty($meta_query) && !$children ) {

            foreach( $meta_query as $index => $meta_query_item ) {
                if( isset( $meta_query_item['key'] ) && $meta_query_item['key'] == "_visibility" ) {

                    $meta_query[$index] = array();
                    $meta_query[$index]['relation'] = 'OR';

                    $meta_query[$index][] = array(
                        'key' => '_visibility',
                        'value' => 'visible',
                        'compare' => 'LIKE'
                    );

                    if( is_search() ) {

                        $meta_query[$index][] = array(
                            'key' => '_visibility',
                            'value' => 'search',
                            'compare' => 'LIKE'
                        );

                    } else {

                        $meta_query[$index][] = array(
                            'key' => '_visibility',
                            'value' => 'catalog',
                            'compare' => 'LIKE'
                        );

                    }

                    if( is_filtered() ) {

                        $meta_query[$index][] = array(
                            'key' => '_visibility',
                            'value' => 'filtered',
                            'compare' => 'LIKE'
                        );

                    }

                }
            }
        }

        return $meta_query;

    }

/** =============================
    *
    * Helper: Get filtered variation ids
    *
    * @return [arr]
    *
    ============================= */

    function get_filtered_variation_ids() {

        global $_chosen_attributes;

        $variation_ids = array();

        $args = array(
            'post_type'  => 'product_variation',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key'     => '_visibility',
                    'value'   => 'filtered',
                    'compare' => 'LIKE',
                )
            )
        );

        $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : false;
		$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : false;

		if( $min_price !== false && $max_price !== false ) {

    		$args['meta_query'][] = array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            );

		}

		if( $_chosen_attributes && !empty( $_chosen_attributes ) ) {

            $i = 10; foreach( $_chosen_attributes as $attribute_key => $attribute_data ) {

                $attribute_meta_key = sprintf('attribute_%s', $attribute_key);

                $attribute_term_slugs = array();

                foreach( $attribute_data['terms'] as $attribute_term_id ) {
                    $attribute_term = get_term_by('id', $attribute_term_id, $attribute_key);
                    $attribute_term_slugs[] = $attribute_term->slug;
                }

                if( $attribute_data['query_type'] == "or" ) {

                    $args['meta_query'][$i] = array(
                        'key'     => $attribute_meta_key,
                        'value'   => $attribute_term_slugs,
                        'compare' => 'IN',
                    );

                } else {

                    $args['meta_query'][$i] = array(
                        'relation' => 'AND'
                    );

                    foreach( $attribute_term_slugs as $attribute_term_slug ) {
                        $args['meta_query'][$i][] = array(
                            'key'     => $attribute_meta_key,
                            'value'   => $attribute_term_slug,
                            'compare' => '=',
                        );
                    }

                }

            $i++; }

        }

        $variations = new WP_Query( $args );

        if ( $variations->have_posts() ) {

        	while ( $variations->have_posts() ) {
        		$variations->the_post();

        		$variation_ids[] = get_the_id();
        	}

        }

        wp_reset_postdata();

        return $variation_ids;

    }

/** =============================
    *
    * Frontend: Add relevant product classes to loop item
    *
    * @param  [arr] [$classes]
    * @return [arr]
    *
    ============================= */

    function add_post_classes_in_loop( $classes ) {

        global $post, $product;

        if( $product && $post->post_type === "product_variation" ) {

            $classes = array_diff($classes, array('hentry', 'post'));

            $classes[] = "product";
            // add other classes here, find woocommerce function

        }

        return $classes;

    } 

/** =============================
    *
    * Admin: Add variation checkboxes
    *
    * @param  [str] [$loop]
    * @param  [arr] [$variation_data]
    * @param  [obj] [$variation]
    *
    ============================= */

    function add_variation_checkboxes( $loop, $variation_data, $variation ) {

        $checkboxes = get_variation_checkboxes( $variation, $loop );

		if( !empty( $checkboxes ) ) {
			foreach( $checkboxes as $checkbox ) { ?>

				<label><input type="checkbox" class="checkbox <?php echo $checkbox['class']; ?>" name="<?php echo $checkbox['name']; ?>" <?php checked( $checkbox['checked'], true ); ?> /> <?php echo $checkbox['label']; ?></label>

			<?php }
		}
	
	}

/** =============================
    *
    * Admin: Add variation options
    *
    * @param  [str] [$loop]
    * @param  [arr] [$variation_data]
    * @param  [obj] [$variation]
    *
    ============================= */

    function add_variation_additional_fields( $loop, $variation_data, $variation ) { ?>

		<div class="davis-display-options" style="margin-top: 20px;">
	
		    <strong><?php _e('DISPLAY OPTIONS','davis'); ?></strong>
		
		    <div class="form-row form-row-full">
		        <?php woocommerce_wp_text_input( array(
		            'id' => "jck_wssv_display_title[$loop]",
		            'label' => __( 'Title', 'davis' ),
		            'type' => 'text',
		            'value' => get_variation_title( $variation->ID )
		        ) ); ?>
		    </div>
			
			<?php // ADD BY DAVID ?>
		    <div class="form-row form-row-full">
		        <?php woocommerce_wp_text_input( array(
		            'id' => "jck_product_colors[$loop]",
		            'label' => __( 'Colors (lowercase separate with a comma)', 'davis' ),
		            'type' => 'text',
		            'value' => get_variation_colors( $variation->ID )
		        ) ); ?>
		    </div>
		
		</div>

    <?php }


/** =============================
    *
    * Admin: Save variation options
    *
    * @param  [int] [$variation_id]
    * @param  [int] [$i]
    *
    ============================= */

    function save_product_variation( $variation_id, $i ) {

        // setup posted data

        $visibility = array();
        $title = isset( $_POST['jck_wssv_display_title'] ) ? $_POST['jck_wssv_display_title'][ $i ] : false;
        $colors = isset( $_POST['jck_product_colors'] ) ? $_POST['jck_product_colors'][ $i ] : false; // ADD BY DAVID

        if( isset( $_POST['jck_wssv_variable_show_search'][$i] ) )
            $visibility[] = "search";

        if( isset( $_POST['jck_wssv_variable_show_filtered'][$i] ) )
            $visibility[] = "filtered";

        if( isset( $_POST['jck_wssv_variable_show_catalog'][$i] ) )
            $visibility[] = "catalog";

        // set visibility

        if( !empty( $visibility ) ) {
            update_post_meta( $variation_id, '_visibility', $visibility );
        } else {
            delete_post_meta( $variation_id, '_visibility' );
        }

        // set featured

        if( isset( $_POST['jck_wssv_variable_featured'][$i] ) && $_POST['jck_wssv_variable_featured'][$i] == "on" ) {
            update_post_meta( $variation_id, '_featured', "yes" );
        } else {
            delete_post_meta( $variation_id, '_featured' );
        }

		// set display title

		if( $title ) {
    		update_post_meta( $variation_id, '_jck_wssv_display_title', $title );

            // Update variation title to be included in search

            $variation_args = array(
                'ID'           => $variation_id,
                'post_title'   => $title
            );

            wp_update_post( $variation_args );
        }
        
        
		// set colors
		/*
if( $colors ){
    		update_post_meta( $variation_id, '_jck_product_colors', $colors );
    		
    		$colors = explode(",", $colors);
    		wp_set_object_terms( $variation_id, $colors, 'pa_colors' , false);    		
    		
    	}
*/

    }

/** =============================
    *
    * Frontend: Change variation title
    *
    * @param  [str] [$title]
    * @param  [int] [$id]
    * @return [str]
    *
    ============================= */

    function change_variation_title( $title, $id ) {

        if( is_product_variation( $id ) ) {
            $title = get_variation_title( $id );
        }

        return $title;

    }

/** =============================
    *
    * Helper: Get default variation title
    *
    * @param  [int] [$variation_id]
    * @return [str]
    *
    ============================= */

    function get_variation_title( $variation_id ) {

        if( !$variation_id || $variation_id == "" )
            return "";

        $variation = wc_get_product( absint( $variation_id ), array( 'product_type' => 'variable' ) );
        $variation_title = ( $variation->get_title() != "Auto Draft" ) ? $variation->get_title() : "";
        $variation_custom_title = get_post_meta($variation->variation_id, '_jck_wssv_display_title', true);

        return ( $variation_custom_title ) ? $variation_custom_title : $variation_title;

    }

/** =============================
    *
    * Helper: Get default variation colors
    *
    * @param  [int] [$variation_id]
    * @return [str]
    *
    ============================= */

    function get_variation_colors( $variation_id ) {

        if( !$variation_id || $variation_id == "" )
            return "";

        $variation = wc_get_product( absint( $variation_id ), array( 'product_type' => 'variable' ) );
        $variation_colors = get_post_meta($variation->variation_id, '_jck_product_colors', true);

        return $variation_colors;

    }

/** =============================
    *
    * Frontend: Change variation permalink
    *
    * @param  [str] [$url]
    * @param  [str] [$post]
    * @return [str]
    *
    ============================= */

    function change_variation_permalink( $url, $post ) {

        if ( 'product_variation' == get_post_type( $post ) ) {

            global $product;

            return get_variation_url( $product );

        }

        return $url;

    }

/** =============================
    *
    * Helper: Get variation URL
    *
    * @param  [str] [$variation]
    * @return [str]
    *
    ============================= */

    function get_variation_url( $variation ) {

        $url = "";

        if( $variation->variation_id ) {

            $variation_data = array_filter( wc_get_product_variation_attributes( $variation->variation_id ) );
            $parent_product_id = $variation->parent->post->ID;
            $parent_product_url = get_the_permalink( $parent_product_id );

            $url = add_query_arg( $variation_data, $parent_product_url );

        }

        return $url;

    }


/** =============================
    *
    * Helper: Is product variation?
    *
    * @param  [int] [$id]
    * @return [bool]
    *
    ============================= */

    function is_product_variation( $id ) {

        $post_type = get_post_type( $id );

        return $post_type == "product_variation" ? true : false;

    }

/** =============================
    *
    * Admin: Get variation checkboxes
    *
    * @param  [obj] [$variation]
    * @param  [int] [$index]
    * @return [arr]
    *
    ============================= */

    function get_variation_checkboxes( $variation, $index ) {

        $visibility = get_post_meta($variation->ID, '_visibility', true);
        $featured = get_post_meta($variation->ID, '_featured', true);

        $checkboxes = array(
            array(
                'class' => 'jck_wssv_variable_show_search',
                'name' => sprintf('jck_wssv_variable_show_search[%d]', $index),
                'checked' => is_array( $visibility ) && in_array('search', $visibility) ? true : false,
                'label' => __( 'Show in Search Results?', 'davis' )
            ),
            array(
                'class' => 'jck_wssv_variable_show_filtered',
                'name' => sprintf('jck_wssv_variable_show_filtered[%d]', $index),
                'checked' => is_array( $visibility ) && in_array('filtered', $visibility) ? true : false,
                'label' => __( 'Show in Filtered Results?', 'davis' )
            ),
            array(
                'class' => 'jck_wssv_variable_show_catalog',
                'name' => sprintf('jck_wssv_variable_show_catalog[%d]', $index),
                'checked' => is_array( $visibility ) && in_array('catalog', $visibility) ? true : false,
                'label' => __( 'Show in Catalog?', 'davis' )
            ),
            array(
                'class' => 'jck_wssv_variable_featured',
                'name' => sprintf('jck_wssv_variable_featured[%d]', $index),
                'checked' => $featured === "yes" ? true : false,
                'label' => __( 'Featured', 'davis' )
            ),
        );

        return $checkboxes;

    }


/** =============================
    *
    * Helper: Filter variaiton visibility
    *
    * Set variation to is_visible() if the options are selected
    *
    * @param  [bool] [$visible]
    * @param  [bool] [$id]
    * @return [bool]
    *
    ============================= */

    function filter_variation_visibility( $visible, $id ) {

        global $product;

        if( isset( $product->variation_id ) ) {

            $visibility = get_post_meta($product->variation_id, '_visibility', true);

            if( is_array( $visibility ) ) {

                // visible in search

                if( is_visible_when('search', $product->variation_id) ) {
                    $visible = true;
                }

                // visible in filtered

                if( is_visible_when('filtered', $product->variation_id) ) {
                    $visible = true;
                }

                // visible in catalog

                if( is_visible_when('catalog', $product->variation_id) ) {
                    $visible = true;
                }


            }

        }

        return $visible;

    }

/** =============================
    *
    * Helper: Is visible when...
    *
    * Check if a variation is visible when search, filtered, catalog
    *
    * @param  [str] [$when]
    * @param  [int] [$id]
    * @return [bool]
    *
    ============================= */

    function is_visible_when( $when = false, $id ) {

        $visibility = get_post_meta($id, '_visibility', true);

        if( is_array( $visibility ) ) {

            // visible in search

            if( is_search() && in_array($when, $visibility) ) {
                return true;
            }

            // visible in filtered

            if( is_filtered() && in_array($when, $visibility) ) {
                return true;
            }

            // visible in catalog

            if( !is_filtered() && !is_search() && in_array($when, $visibility) ) {
                return true;
            }


        }

        return false;

    }

/** =============================
    *
    * Attach product categories to variations
    *
    * @param  [arr] [$post_types]
    * @return [arr]
    *
    ============================= */

    function add_product_categories_to_variations( $post_types ) {

        $post_types[] = "product_variation";

        return $post_types;

    }

/** =============================
    *
    * Admin: Save variation hook
    *
    * @param  [int] [$variation_id]
    * @param  [int] [$i]
    *
    ============================= */

    function add_variation_to_categories( $variation_id, $i ) {

        $parent_product_id = wp_get_post_parent_id( $variation_id );

        if( $parent_product_id ) {

            // add categories to variation

            $terms = (array) wp_get_post_terms( $parent_product_id, 'product_cat', array("fields" => "ids") );
            wp_set_post_terms( $variation_id, $terms, 'product_cat' );

            // add attributes to variation so it shows in the layered nav count

            $variation_attributes = wc_get_product_variation_attributes( $variation_id );

            if( $variation_attributes && !empty( $variation_attributes ) ) {
                foreach( $variation_attributes as $attribute_name => $attribute_value ) {
                    if( strpos( $attribute_name, 'attribute_pa_' ) !== false ) {
                    	if( isset( $_POST['jck_wssv_variable_show_filtered'] ) ) {
                            wp_set_object_terms( $variation_id, $attribute_value, str_replace('attribute_', '', $attribute_name) );
                        } else {
                            wp_set_object_terms( $variation_id, "", str_replace('attribute_', '', $attribute_name) );
                        }
                    }
                }
            }
            
            // ADD BY DAVID
            $colors = isset( $_POST['jck_product_colors'] ) ? $_POST['jck_product_colors'][ $i ] : false;
			$colors = explode(",", $colors);
							
			wp_set_object_terms( $variation_id, $colors, 'pa_colors');

        }

    }

/** =============================
    *
    * Frontend: is_purchasable
    *
    * @param  [obj] [$product]
    * @return [bool]
    *
    ============================= */

    function is_purchasable( $product ) {

        $purchasable = $product->is_purchasable();

        if( $product->variation_id ) {

            if( $product->variation_data && !empty( $product->variation_data ) ) {
                foreach( $product->variation_data as $value ) {
                    if( $value == "" ) {
                        $purchasable = false;
                    }
                }
            }

        }

        return $purchasable;

    }

/** =============================
    *
    * Frontend: Add to Cart Text
    *
    * @param  [str] [$text]
    * @param  [obg] [$product]
    * @return [str]
    *
    ============================= */

    function add_to_cart_text( $text, $product ) {

        if( $product->variation_id ) {

            $text = is_purchasable( $product ) && $product->is_in_stock() ? $text : __( 'Select options', 'woocommerce' );

        }

        return $text;

    }

/** =============================
    *
    * Frontend: Add to Cart URL
    *
    * @param  [str] [$url]
    * @param  [obg] [$product]
    * @return [str]
    *
    ============================= */

    function add_to_cart_url( $url, $product ) {

        if( $product->variation_id ) {

            $url = is_purchasable( $product ) && $product->is_in_stock() ? $url : get_variation_url( $product );

        }

        return $url;

    }



/**	=============================
    *
    * Admin: Transition variation post_status when parent changes
    *
    ============================= */

    function transition_variation_status( $new_status, $old_status, $post ) {

        global $wpdb;

        if( $post->post_type == "product" ) {

            $wpdb->update(
                "{$wpdb->prefix}posts",
                array( 'post_status' => $new_status ),
                array(
                    'post_parent' => $post->ID,
                    'post_type' => 'product_variation'
                ),
                array( '%s' ),
                array(
                    '%d',
                    '%s'
                )
            );

        }

    }
