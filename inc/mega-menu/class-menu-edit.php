<?php
/**
 * Customize and add more fields for mega menu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Walker_Nav_Menu_Edit' ) ) {
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
}

class PP_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$icon            	= get_post_meta( $item->ID, 'pp_menu_item_icon', true );
		$mega_menu       	= get_post_meta( $item->ID, 'pp_menu_item_mega', true );
		$mega_menu_width 	= get_post_meta( $item->ID, 'pp_menu_item_mega_width', true );
		$menu_item_width 	= get_post_meta( $item->ID, 'pp_menu_item_width', true );
		$hide_text       	= get_post_meta( $item->ID, 'pp_menu_item_hide_text', true );
		$hide_desktop    	= get_post_meta( $item->ID, 'pp_menu_item_hide_desktop', true );
		$hide_mobile     	= get_post_meta( $item->ID, 'pp_menu_item_hide_mobile', true );
		$uppercase_text 	= get_post_meta( $item->ID, 'pp_menu_item_uppercase_text', true );
		$disable_link    	= get_post_meta( $item->ID, 'pp_menu_item_disable_link', true );
		$hot_badge       	= get_post_meta( $item->ID, 'pp_menu_item_hot', true );
		$new_badge       	= get_post_meta( $item->ID, 'pp_menu_item_new', true );
		$trend_badge     	= get_post_meta( $item->ID, 'pp_menu_item_trending', true );
		$sale_badge      	= get_post_meta( $item->ID, 'pp_menu_item_sale', true );
		$img_background  	= get_post_meta( $item->ID, 'pp_menu_item_background', true );
		$img_type		  	= get_post_meta( $item->ID, 'pp_menu_item_img_type', true );
        $img_size 	     	= get_post_meta( $item->ID, 'pp_menu_item_img_size', true );
		$img_pos		  	= get_post_meta( $item->ID, 'pp_menu_item_img_pos', true );
		$img_hide_desktop	= get_post_meta( $item->ID, 'pp_menu_item_hide_img_desktop', true );
		$img_hide_mobile 	= get_post_meta( $item->ID, 'pp_menu_item_hide_img_mobile', true );
        $icon_pos 		 	= get_post_meta( $item->ID, 'pp_menu-item-icon_pos', true );
		$content         	= get_post_meta( $item->ID, 'pp_menu_item_content', true );

		$img_background = wp_parse_args(
			get_post_meta( $item->ID, 'pp_menu_item_background', true ),
			array(
				'image'      => '',
				'attachment' => 'scroll',
				'size'       => '',
				'repeat'     => 'no-repeat',
				'position'   => array(
					'x'      => 'left',
					'y'      => 'top',
				)
			)
		);
		$img_pos = wp_parse_args(
			get_post_meta( $item->ID, 'pp_menu_item_img_pos', true ),
			array(
				'top'      	=> '',
				'right' 	=> '',
				'bottom'	=> '',
				'left'     	=> ''
			)
		);

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args );

		$dom = new DOMDocument();
		$dom->loadHTML( mb_convert_encoding($item_output, 'HTML-ENTITIES', 'UTF-8') );

		// Add more menu item data
		$settings = $dom->getElementById( 'menu-item-settings-' . esc_attr( $item->ID ) );
		$data     = $dom->createElement( 'span' );
		$data->setAttribute( 'class', 'hidden pp-data' );
		$data->setAttribute( 'data-mega', intval( $mega_menu ) );
		$data->setAttribute( 'data-mega_width', esc_attr( $mega_menu_width ) );
		$data->setAttribute( 'data-width', esc_attr( $menu_item_width ) );
		$data->setAttribute( 'data-background', json_encode( $img_background ) );
		$data->setAttribute( 'data-img_type', esc_attr( $img_type ) );
		$data->setAttribute( 'data-img_size', esc_attr( $img_size ) );
		$data->setAttribute( 'data-img_pos', json_encode( $img_pos ) );
		$data->setAttribute( 'data-hide_img_desktop', intval( $img_hide_desktop ) );
		$data->setAttribute( 'data-hide_img_mobile', intval( $img_hide_mobile ) );
		$data->setAttribute( 'data-icon', esc_attr( $icon ) );
		$data->setAttribute( 'data-icon_pos', esc_attr( $icon_pos ) );
		$data->setAttribute( 'data-hide_text', intval( $hide_text ) );
		$data->setAttribute( 'data-hide_desktop', intval( $hide_desktop ) );
		$data->setAttribute( 'data-hide_mobile', intval( $hide_mobile ) );
		$data->setAttribute( 'data-uppercase_text', intval( $uppercase_text ) );
		$data->setAttribute( 'data-hot', intval( $hot_badge ) );
		$data->setAttribute( 'data-new', intval( $new_badge ) );
		$data->setAttribute( 'data-trending', intval( $trend_badge ) );
		$data->setAttribute( 'data-sale', intval( $sale_badge ) );
		$data->setAttribute( 'data-disable_link', intval( $disable_link ) );
		$data->nodeValue = $content;
		if( $settings ) {
			$settings->appendChild( $data );
		}

		// Add settings link
		$link = $dom->createElement( 'a' );
		$link->nodeValue = esc_html__( 'Settings', 'davis' );
		$link->setAttribute( 'class', 'item-config-mega opensettings submitcancel hide-if-no-js' );
		$link->setAttribute( 'href', '#' );
		$sep = $dom->createElement( 'span' );
		$sep->nodeValue = ' | ';
		$sep->setAttribute( 'class', 'meta-sep hide-if-no-js' );
		$cancel = $dom->getElementById( 'cancel-' . esc_attr( $item->ID ) );
		if( $cancel ) {
			$cancel->parentNode->insertBefore( $link, $cancel );
			$cancel->parentNode->insertBefore( $sep, $cancel );
		}


		$output .= $dom->saveHTML();
	}
}

class PP_Nav_Menu_Edit {
	/**
	 * PP_Nav_Menu_Edit constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'modal' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'templates' ) );
		add_action( 'wp_ajax_pp_save_menu_item_data', array( $this, 'save_menu_item_data' ) );
	}

	/**
	 * Load scripts on Menus page only
	 *
	 * @param string $hook
	 */
	public function scripts( $hook ) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}

		wp_register_style( 'pp-mega-font-awesome', get_template_directory_uri() . '/inc/mega-menu/css/ionicons.min.css', array(), '4.5' );
		wp_register_style( 'pp-mega-menu', get_template_directory_uri() . '/inc/mega-menu/css/mega-menu.css', array( 'media-views', 'wp-color-picker', 'pp-mega-font-awesome' ), '20160530' );
		wp_enqueue_style( 'pp-mega-menu' );

		wp_register_script( 'pp-mega-menu', get_template_directory_uri() . '/inc/mega-menu/js/mega-menu.js', array( 'jquery', 'jquery-ui-resizable', 'backbone', 'underscore', 'wp-color-picker' ), '20160530', true );
		wp_enqueue_media();
		wp_enqueue_script( 'pp-mega-menu' );
	}

	/**
	 * Prints HTML of modal on footer
	 */
	public function modal() {
		?>
		<div id="menu-modal" tabindex="0" class="menu-modal">
			<div class="mega-modal media-modal wp-core-ui">
				<div class="media-modal-content">
					<div class="pp-mega-menu-item-header-bar"></div>
					<div class="pp-mega-menu-item-setting-tabs"></div>
					<div class="pp-menu-item-tab-content"></div>
				</div>
			</div>
			<div class="media-modal-backdrop mega-modal-backdrop"></div>
		</div>
		<?php
	}

	/**
	 * Prints underscore template on footer
	 */
	public function templates() {
		$templates = apply_filters(
			'pp_js_templates', array(
				'menus',
				'title',
				'mega',
				'background',
				'icon',
				'content',
				'general'
			)
		);

		foreach ( $templates as $template ) {
			$file = apply_filters( 'pp_js_template_path', plugin_dir_path( __FILE__ ) . 'tmpl/' . $template . '.php', $template );
			?>
			<script type="text/template" id="pp-tmpl-<?php echo esc_attr( $template ) ?>">
				<?php
				if ( file_exists( $file ) ) {
					include $file;
				}
				?>
			</script>
			<?php
		}
	}

	/**
	 * Ajax function to save menu item data
	 */
	public function save_menu_item_data() {
		$_POST['data'] = stripslashes_deep( $_POST['data'] );
		parse_str( $_POST['data'], $data );

		$i = 0;
		// Save menu item data
		foreach ( $data['menu-item'] as $id => $meta ) {

			// Update meta value for checkboxes
			$keys = array_keys( $meta );

			if ( $i == 0 ) {
				if ( in_array( 'mega', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_mega', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_mega' );
				}

				if ( in_array( 'hide_text', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hide_text', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hide_text' );
				}

				if ( in_array( 'hide_desktop', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hide_desktop', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hide_desktop' );
				}

				if ( in_array( 'hide_mobile', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hide_mobile', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hide_mobile' );
				}

				if ( in_array( 'hide_img_desktop', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hide_img_desktop', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hide_img_desktop' );
				}

				if ( in_array( 'hide_img_mobile', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hide_img_mobile', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hide_img_mobile' );
				}

				if ( in_array( 'uppercase_text', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_uppercase_text', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_uppercase_text' );
				}

				if ( in_array( 'disable_link', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_disable_link', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_disable_link' );
				}

				if ( in_array( 'hot', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_hot', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_hot' );
				}

				if ( in_array( 'new', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_new', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_new' );
				}

				if ( in_array( 'trending', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_trending', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_trending' );
				}

				if ( in_array( 'sale', $keys ) ) {
					update_post_meta( $id, 'pp_menu_item_sale', true );
				} else {
					delete_post_meta( $id, 'pp_menu_item_sale' );
				}
			}

			foreach ( $meta as $key => $value ) {
				$key = str_replace( '-', '_', $key );
				update_post_meta( $id, 'pp_menu_item_' . $key, $value );
			}

			$i ++;
		}


		do_action( 'solar_save_menu_item_data', $data );

		wp_send_json_success( $data );
	}
}
