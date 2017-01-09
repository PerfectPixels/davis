<?php
/**
 * Menu item Select boxes
 *
 * @since 0.1.0
 */
class Menu_Item_Select_Fields {

	/**
	 * Holds our custom fields
	 */
	protected static $fields = array();


	/**
	 * Initialize plugin
	 */
	public static function init() {
		global $pagenow;

		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		//add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

		if( $pagenow == 'nav-menus.php' ) {
			add_action( 'admin_head', array( __CLASS__, 'menu_css' ) );
		}

		self::$fields = array(
			'img-type' => array (
				'title' => __( 'Image Type', 'davis' ),
				'choices' => array(
					'img-no-text' => 'Image without text',
					'img-below-text' => 'Image below text',
					'icon' => 'Icon',
					'mega-menu-bg' => 'Mega submenu background',
					'bg-img' => 'Background image'
				)
			),
			'icon-pos' => array (
				'title' => __( 'Icon Position', 'davis' ),
				'choices' => array(
					'before' => 'Before',
					'after' => 'After',
					'above' => 'Above',
					'below' => 'Below'
				)
			),
			'bg-type' => array (
				'title' => __( 'Background Location', 'davis' ),
				'choices' => array(
					'desktop-mobile' => 'Desktop & Mobile',
					'desktop' => 'Desktop only',
					'mobile' => 'Mobile only'
				)
			),
			'bg-mega-type' => array (
				'title' => __( 'Background Location', 'davis' ),
				'choices' => array(
					'desktop-mobile' => 'Desktop & Mobile',
					'desktop' => 'Desktop only',
					'mobile' => 'Mobile only'
				)
			),
			'img-size' => array (
				'title' => __( 'Image Size', 'davis' ),
				'choices' => array(
					'thumbnail' => 'Thumbnail',
					'medium' => 'Medium',
					'large' => 'Large',
					'full' => 'Original'
				)
			),
			'megamenu-columns' => array (
				'title' => __( 'Number of columns', 'davis' ),
				'choices' => array(
					'column-1' => '1 Column',
					'column-2' => '2 Columns',
					'column-3' => '3 Columns',
					'column-4' => '4 Columns',
					'column-5' => '5 Columns',
					'column-6' => '6 Columns'
				)
			)
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

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
			}
			else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
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
		foreach ( self::$fields as $_key => $opts ) :
			$key   = sprintf( 'menu-item-%s', $_key );
			$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
			$label = $opts['title'];
			$name  = sprintf( '%s[%s]', $key, $item->ID );
			$value = get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $_key );

			?>
			<p class="description description-thin <?php echo esc_attr( $class ) ?>">
				<label for="<?php echo esc_attr( $id ); ?>">
					<?php echo esc_html( $label ); ?><br>
					<select id="<?php echo esc_attr( $id ); ?>" class="widefat <?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
						<?php foreach ( $opts['choices'] as $val => $nam ){ ?>
							<option value="<?php echo $val; ?>" <?php selected( $val, esc_attr( $value ) ); ?>><?php echo $nam; ?></option>
						<?php } ?>
					</select>
				</label>
			</p>
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
	 * Add some CSS
	 *
	 */
	public static function menu_css() {
	  echo '<style>
	  	.field-megamenu-columns {
	  		display: none;
	  		width: 100%;
	  	}
	  	.field-img-type,
	  	.field-icon-pos,
	  	.field-bg-type,
	  	.field-bg-mega-type,
	  	.field-img-size { display: none; }
	  </style>';
	}
}
Menu_Item_Select_Fields::init();
