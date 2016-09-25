<?php
/**
 * Menu item custom fields example
 *
 * Copy this file into your wp-content/mu-plugins directory.
 *
 * @package Menu_Item_Custom_Fields_Example
 * @version 0.2.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 *
 *
 * Plugin name: Menu Item Custom Fields Example
 * Plugin URI: https://github.com/kucrut/wp-menu-item-custom-fields
 * Description: Example usage of Menu Item Custom Fields in plugins/themes
 * Version: 0.2.0
 * Author: Dzikri Aziz
 * Author URI: http://kucrut.org/
 * License: GPL v2
 * Text Domain: menu-item-custom-fields-example
 */


/**
 * Sample menu item metadata
 *
 * This class demonstrate the usage of Menu Item Custom Fields in plugins/themes.
 *
 * @since 0.1.0
 */
class Menu_Item_Media_Fields {

	/**
	 * Holds our custom fields
	 *
	 * @var    array
	 * @access protected
	 * @since  Menu_Item_Custom_Fields_Example 0.2.0
	 */
	protected static $fields = array();
	protected static $attachment_id = false;
	protected static $ajax = false;


	/**
	 * Initialize plugin
	 */
	public static function init() {
		global $pagenow;
		
		add_action( 'wp_ajax_set-menu-item-thumbnail', array( __CLASS__, 'wp_ajax_set_menu_item_thumbnail' ) );
		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		add_filter( 'wp_setup_nav_menu_item', array( __CLASS__, 'menu_image_wp_setup_nav_menu_item' ) );
		add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );
		add_action( 'admin_head-nav-menus.php', array( __CLASS__, 'menu_image_admin_head_nav_menus_action' ) );
		
		if( $pagenow == 'nav-menus.php' ) {
			add_action( 'admin_head', array( __CLASS__, 'menu_css' ) );
		}
		
		self::$fields = array(
			'menu-img' => __( 'Menu Image', 'davis' )
		);
	}


	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int   $menu_id         Nav menu ID
	 * @param int   $menu_item_db_id Menu item ID
	 * @param array $menu_item_args  Menu item data
	 */
	public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf( 'menu-item-%s', $_key );

			// Sanitize
			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				// Do some checks here...
				$value = $_POST[ $key ][ $menu_item_db_id ];
			}
			else {
				$value = null;
			}
			
			error_log( print_r($value, true) );

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
				set_post_thumbnail( $menu_item_db_id, $value );
			}  else {
				delete_post_meta( $menu_item_db_id, $key );
				delete_post_thumbnail( $menu_item_db_id );
			}
			
		}
	}
	
	/**
	 * Load menu image meta for each menu item.
	 *
	 * @since 2.0
	 */
	public static function menu_image_wp_setup_nav_menu_item( $item ) {
		if ( !isset( $item->thumbnail_id ) ) {
			$item->thumbnail_id = get_post_thumbnail_id( $item->ID );
		}

		return $item;
	}
	
	/**
	 * Update item thumbnail via ajax action.
	 *
	 */
	public static function wp_ajax_set_menu_item_thumbnail() {
		$json = !empty( $_REQUEST[ 'json' ] );

		$post_ID = intval( $_POST[ 'post_id' ] );
		if ( !current_user_can( 'edit_post', $post_ID ) ) {
			wp_die( - 1 );
		}

		$thumbnail_id  = intval( $_POST[ 'thumbnail_id' ] );

		check_ajax_referer( "update-menu-item" );
		
		self::$ajax = true;
		
		if ( $thumbnail_id == '-1' ) {
			$return = self::_fields( $post_ID, '', '', '' );
		} else {
			self::$attachment_id = $thumbnail_id;
			$return = self::_fields( $post_ID, '', '', '' );
		}

		wp_die();
	}


	/**
	 * Print field
	 *
	 * @param object $item  Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args  Menu item args.
	 * @param int    $id    Nav menu ID.
	 *
	 * @return string Form fields
	 */
	public static function _fields( $id, $item, $depth, $args ) { 
		foreach ( self::$fields as $_key => $label ) :
			$key   			= sprintf( 'menu-item-%s', $_key );
			$id_class = sprintf( 'edit-%s-%s', $key, $item->ID );
			$item_id		= $item->ID;
			$name  			= sprintf( '%s[%s]', $key, $item->ID );
			$value 			= get_post_meta( $item->ID, $key, true );
			$class 			= sprintf( 'field-%s', $_key );
			$default_size 	= apply_filters( 'menu_image_default_size', array( 125, 125, false ) );
			
			if ( $id ){ 
				$item_id  = $id; 					
				$id_class = sprintf( 'edit-%s-%s', $key, $item_id );
				$name  	  = sprintf( '%s[%s]', $key, $item_id );
			} 
			
			if ( ! self::$ajax ){
				$thumbnail_id 	= get_post_thumbnail_id( $item_id );
			}
			
			if ( self::$attachment_id ){ 
				$thumbnail_id = self::$attachment_id; 
			} ?>
			
			<div id="menu-image-<?php echo $item_id; ?>" class="field-image hide-if-no-js wp-media-buttons">
				<p class="description description-thin <?php echo esc_attr( $class ) ?>">
					<label><?php echo esc_html( $label ); ?><br /><a title="<?php $thumbnail_id ? esc_attr_e( 'Change menu item image', 'davis' ) : esc_attr_e( 'Set menu item image', 'davis' ); ?>" href="#" class="set-post-thumbnail button" data-item-id="<?php echo $item_id; ?>" style="height: auto;"><?php echo ( $thumbnail_id ? wp_get_attachment_image( $thumbnail_id, $default_size ) : esc_html__( 'Set image', 'davis' ) ); ?></a><?php echo ( $thumbnail_id ? '<a href="#" class="remove-post-thumbnail">' . __( 'Remove', 'davis' ) . '</a>' : '' ); ?></label>
					<input type="hidden" id="<?php echo esc_attr( $id_class ); ?>" class="<?php echo esc_attr( $id_class ); ?>" value="<?php echo $value; ?>" name="<?php echo esc_attr( $name ); ?>" />
				</p>
			</div>
			
			<?php 
		endforeach;
	}


	/**
	 * Add our fields to the screen options toggle
	 *
	 * @param array $columns Menu item columns
	 * @return array
	 */
	public static function _columns( $columns ) {
		$columns = array_merge( $columns, self::$fields );

		return $columns;
	}
	
	
	/**
	 * Loading media-editor script ot nav-menus page.
	 *
	 */
	public static function menu_image_admin_head_nav_menus_action() {
		wp_enqueue_script( 'davis-admin', get_template_directory_uri() . '/lib/menu-item-custom-fields/fields/js/media-upload.js', array( 'jquery' ) );
		wp_localize_script(
			'davis-admin', 'menuImage', array(
				'l10n'     => array(
					'uploaderTitle'      => __( 'Chose menu image', 'davis' ),
					'uploaderButtonText' => __( 'Select', 'davis' ),
				),
				'settings' => array(
					'nonce' => wp_create_nonce( 'update-menu-item' ),
				),
			)
		);
		wp_enqueue_media();
		wp_enqueue_style( 'editor-buttons' );
	}


	/**
	 * Add some CSS
	 *
	 */
	public static function menu_css() {
	  echo "<style>
	  	.field-image { display: none; }
	  	.set-post-thumbnail { max-width: 100%; text-align: center; padding: 5px !important; }
	  	.set-post-thumbnail img { width: 125px; height: auto; padding:0 !important; }
	  	
	  	.menu-item:not(.menu-item-depth-0) .field-img-type option[value=mega-menu-bg] { display: none; }
	  </style>";
	}
}
Menu_Item_Media_Fields::init();
