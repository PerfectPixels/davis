<?php

/**
 * Class menu walker
 *
 * @package MrBara
 */
class PP_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Current item
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private $curItem;

	/**
	 * Item mega menu
	 *
	 * @since 1.0.0
	 * @var boolean
	 */
	private $mega;

	/**
	 * Mega menu column
	 *
	 * @since 1.0.0
	 * @var int
	 */
	protected $column = '';

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see   Walker::start_lvl()
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Get settings added
		$mega_menu       	= get_post_meta( $this->curItem->ID, 'pp_menu_item_mega', true );
		$img_background  	= get_post_meta( $this->curItem->ID, 'pp_menu_item_background', true );
		$img_type		  	= get_post_meta( $this->curItem->ID, 'pp_menu_item_img_type', true );
        $img_size 	     	= get_post_meta( $this->curItem->ID, 'pp_menu_item_img_size', true );
		$img_pos		  	= get_post_meta( $this->curItem->ID, 'pp_menu_item_img_pos', true );

        $style		= '';
        $bg_class 	= '';
		$img = '';

        $classes = array(
            'sub-menu is-hidden',
            ( $depth == 0 && $mega_menu ? 'mega-menu' : ''),
            ( $depth > 2 && $mega_menu ? 'is-hidden' : '' )
        );
        $class_names = implode( ' ', $classes );

        if ( $img_background ){
			$attachment_id = get_attachment_id( $img_background['image'] );
			$img_src = wp_get_attachment_image_src( $attachment_id, $img_size, false );

			if ( $img_type == 'background' ){
				$style 	= ' style="background-image: url(' . $img_src[0] . ');';
				$style .= ' background-position:'. $img_background['position']['x'] . ' ' . $img_background['position']['y'] . ';';
				$style .= ' background-repeat:' . $img_background['repeat'] . ';';
				$style .= ' background-size:' . $img_background['size'] . ';"';
	        } else {
				$img = wp_get_attachment_image( $attachment_id, $img_size, false, array('class' => 'menu-image', 'style' => 'top:'.$img_pos['top'].'; right:'.$img_pos['right'].'; bottom:'.$img_pos['bottom'].'; left:'.$img_pos['left'].';') );
			}
		}

        $back_btn = '<li class="go-back"><a href="#0">' . __( 'Back', 'davis' ) . '</a></li>';

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . $bg_class . '"' . $style . '>' .$img . $back_btn . "\n";
    }

	/**
	 * Start the element output.
	 * Display item description text and classes
	 *
	 * @see   Walker::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		$this->curItem = $item;

		$class = '';
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// Get settings added
		$mega_menu       	= get_post_meta( $item->ID, 'pp_menu_item_mega', true );
		$menu_item_width 	= get_post_meta( $item->ID, 'pp_menu_item_width', true );
		$hide_text       	= get_post_meta( $item->ID, 'pp_menu_item_hide_text', true );
		$hide_desktop    	= get_post_meta( $item->ID, 'pp_menu_item_hide_desktop', true );
		$hide_mobile     	= get_post_meta( $item->ID, 'pp_menu_item_hide_mobile', true );
		$uppercase_text  	= get_post_meta( $item->ID, 'pp_menu_item_uppercase_text', true );
		$disable_link	  	= get_post_meta( $item->ID, 'pp_menu_item_disable_link', true );
		$hot_badge       	= get_post_meta( $item->ID, 'pp_menu_item_hot', true );
		$new_badge       	= get_post_meta( $item->ID, 'pp_menu_item_new', true );
		$trend_badge     	= get_post_meta( $item->ID, 'pp_menu_item_trending', true );
		$sale_badge      	= get_post_meta( $item->ID, 'pp_menu_item_sale', true );
		$img_background  	= get_post_meta( $item->ID, 'pp_menu_item_background', true );
		$img_type		  	= get_post_meta( $item->ID, 'pp_menu_item_img_type', true );
        $img_size 	     	= get_post_meta( $item->ID, 'pp_menu_item_img_size', true );
        $img_pos 	     	= get_post_meta( $item->ID, 'pp_menu_item_img_pos', true );
        $img_no_margin     	= get_post_meta( $item->ID, 'pp_menu_item_img_no_margin', true );
		$img_hide_desktop	= get_post_meta( $item->ID, 'pp_menu_item_hide_img_desktop', true );
		$img_hide_mobile 	= get_post_meta( $item->ID, 'pp_menu_item_hide_img_mobile', true );
		$icon           	= get_post_meta( $item->ID, 'pp_menu_item_icon', true );
        $icon_pos 		 	= get_post_meta( $item->ID, 'pp_menu_item_icon_pos', true );

        $style		= '';
        $bg_class 	= '';
		$badge		= '';
		$img		= '';
		$img_src	= '';

		// Save the parent post meta mega menu
		if ( ! $depth ) {
			$this->mega = $mega_menu;
			$this->imgType = $img_type;
		}

		// Store mege menu panel's column
		if ( 1 == $depth && $this->mega ) {
			$columns = array(
				'20.00%'  => 'col-md-5',
				'25.00%'  => 'col-md-3',
				'33.33%'  => 'col-md-4',
				'50.00%'  => 'col-md-6',
				'66.66%'  => 'col-md-8',
				'75.00%'  => 'col-md-9',
				'100.00%' => 'col-md-12',
			);
			$width = $menu_item_width ? $menu_item_width : '25.00%';
			$this->column = $columns[$width];
		}

        // List item classes
        $li_classes = array(
            $depth == 0 ? 'main-menu-item' : 'sub-menu-item',
            $depth == 1 ? $this->column : '',
        	$depth == 0 && !$this->mega ? 'simple-nav' : '',
        	$img_hide_desktop ? 'hide-img-desktop' : '',
        	$img_hide_mobile ? 'hide-img-mobile' : '',
        	$hide_desktop ? 'hide-text-desktop' : '',
        	$hide_mobile ? 'hide-text-mobile' : '',
        );
        $li_class_names = esc_attr( implode( ' ', $li_classes ) );

		// Get image
		if ( $img_background && $depth > 0 ){
			$attachment_id 	= get_attachment_id( $img_background['image'] );
	        $img 			= wp_get_attachment_image( $attachment_id, $img_size, false, "class=menu-image" );
	        $img_src		= wp_get_attachment_image_src( $attachment_id, $img_size, false );
		}

        if ( $img_background && $depth > 0 && $img_type == 'background' ){
			$style 	= ' style="background-image: url(' . $img_src[0] . ');';
			$style .= ' background-position:'. $img_background['position']['x'] . ' ' . $img_background['position']['y'] . ';';
			$style .= ' background-repeat:' . $img_background['repeat'] . ';';
			$style .= ' background-size:' . $img_background['size'] . ';"';
        }

        // Build HTML.
        $output .= $indent . '<li class="' . $li_class_names . ' ' . $class_names . $bg_class . '"' . $style . '>';

		// Title
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		// Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		// Link classes
        $attributes .= ' class="menu-link ';
		$attributes .= ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' );
		$attributes .= isset($img_background['image']) && $img_type == 'image' && $depth > 0 ? ' has-img' : '';
		$attributes .= $hide_text ? ' text-hidden' : '';
		$attributes .= $img_no_margin ? ' no-margin' : '';
		$attributes .= $uppercase_text ? ' uppercase-text' : '';
		$attributes .= $disable_link ? ' no-link' : '';
		$attributes .= $icon ? ' has-icon' : '';
		$attributes .= $icon && $icon_pos ? ' icon-pos-'.$icon_pos : '';
		$attributes .= '"';
		$attributes .= $icon && $icon_pos == 'icon-only' ? ' title="'.$title.'"' : '';

		// Badges
		if ( $hot_badge ) {
			$badge .= '<span class="hot badge">' . esc_html__( 'Hot', 'davis' ) . '</span>';
		}
		if ( $new_badge ) {
			$badge .= '<span class="new badge">' . esc_html__( 'New', 'davis' ) . '</span>';
		}
		if ( $trend_badge ) {
			$badge .= '<span class="trending badge">' . esc_html__( 'Trending', 'davis' ) . '</span>';
		}
		if ( $sale_badge ) {
			$badge .= '<span class="sale badge">' . esc_html__( 'Sale', 'davis' ) . '</span>';
		}

		// Icon
		if ( $icon ) {
			$icon = '<i class="'.$icon.'"></i>';
		}

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%6$s%7$s%8$s<span class="mobile-arrow"></span>%9$s</a>%10$s',
            $args->before,
            $attributes,
            $args->link_before,
            ( $icon && ( $icon_pos == 'left' || $icon_pos == 'above' || $icon_pos == 'icon-only' ) ? $icon : '' ),
            ( $hide_text ? '' : $title ),
            ( $img_background && $img_type == 'image' ? $img : '' ),
            ( $icon && ( $icon_pos == 'right' || $icon_pos == 'below' ) ? $icon : '' ),
            $args->link_after,
			$badge,
            $args->after
        );

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/* Function to determine if the current item has children */
    // function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output){
    //     // check, whether there are children for the given ID and append it to the element with a (new) ID
    //     $element->hasChildren = isset( $children_elements[$element->ID] ) && !empty( $children_elements[$element->ID] );

    //     return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    // }
}
