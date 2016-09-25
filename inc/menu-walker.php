<?php
/**
 * Custom walker class.
 */
class TC_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $curItem;
 
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu is-hidden',
            get_post_meta( $this->curItem->ID, 'menu-item-mega-menu', true ),
            ( $depth > 2 && get_post_meta( $this->curItem->ID, 'menu-item-mega-menu', true ) ? 'is-hidden' : '' )
        );
        $class_names = implode( ' ', $classes );
        
        // Get if any images is been added
		$add_img 	= get_post_meta( $this->curItem->ID, 'menu-item-add-img', true );
        $img_type 	= get_post_meta( $this->curItem->ID, 'menu-item-img-type', true );
        $bg_type 	= get_post_meta( $this->curItem->ID, 'menu-item-bg-mega-type', true );
        $icon_pos 	= get_post_meta( $this->curItem->ID, 'menu-item-icon-pos', true );
        $img_size 	= get_post_meta( $this->curItem->ID, 'menu-item-img-size', true );
        $img 		= wp_get_attachment_image_src( $this->curItem->thumbnail_id, $img_size, false );
        $bg_img		= '';
        $bg_class 	= '';
        
        if ( $add_img && $img_type == 'mega-menu-bg' ){
	        $bg_img = ' style="background-image: url(' . $img[0] . ');"';
	        $bg_class = ' bg-img-' . $bg_type;
        }               
        
        $back_btn = '<li class="go-back"><a href="#0">' . __( 'Back', 'davis' ) . '</a></li>';
		
        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . $bg_class . '"' . $bg_img . '>' . $back_btn . "\n";
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        
		$this->curItem = $item;
		
		$class = '';
        
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes. - Not needed here
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( get_post_meta( $item->ID, 'menu-item-megamenu-columns', true ) ),
        	( $depth == 0 && !get_post_meta( $item->ID, 'menu-item-mega-menu', true ) ? 'simple-nav' : '' )
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // Passed classes. 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        
        // Get if any images is been added
        $add_img 	= get_post_meta( $item->ID, 'menu-item-add-img', true );
        $img_type 	= get_post_meta( $item->ID, 'menu-item-img-type', true );
        $bg_type 	= get_post_meta( $item->ID, 'menu-item-bg-type', true );
        $icon_pos 	= get_post_meta( $item->ID, 'menu-item-icon-pos', true );
        $img_size 	= get_post_meta( $item->ID, 'menu-item-img-size', true );
        $img 		= wp_get_attachment_image( $item->thumbnail_id, $img_size, false, "class=menu-image {$img_type}" );
        $img_src	= wp_get_attachment_image_src( $item->thumbnail_id, $img_size, false ); 
        $bg_img		= '';
        $bg_class 	= '';
        
        if ( $add_img && $img_type == 'bg-img' ){
	        $bg_img  = ' style="background-image: url(' . $img_src[0] . ');background-size: cover; background-position: 50% 50%;"';
	        $bg_class = ' bg-img-' . $bg_type;
        }     
 
        // Build HTML.
        $output .= $indent . '<li class="' . $depth_class_names . ' ' . $class_names . $bg_class . '"' . $bg_img . '>';
 
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . ( $add_img ? ' has-img' : '' ) . ( $img_type == 'img-no-text' ? ' img-tag' : '' ) . '"';  
	 	
        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%6$s%7$s%8$s<span></span></a>%9$s',
            $args->before,
            $attributes,
            $args->link_before,
            ( $add_img && $img_type == 'icon' && ( $icon_pos == 'before' || $icon_pos == 'above' ) ? $img : '' ),
            ( $add_img && $img_type == 'img-no-text' ? $img : apply_filters( 'the_title', $item->title, $item->ID ) ),
            ( $add_img && $img_type == 'img-below-text' ? '<br>'.$img : '' ),
            ( $add_img && $img_type == 'icon' && ( $icon_pos == 'after' || $icon_pos == 'below' ) ? $img : '' ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /* Function to determine if the current item has children */
    function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output){
        // check, whether there are children for the given ID and append it to the element with a (new) ID
        $element->hasChildren = isset( $children_elements[$element->ID] ) && !empty( $children_elements[$element->ID] );

        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

?>