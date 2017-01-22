<% var itemId = data['menu-item-db-id']; %>

<div id="inside-background" class="inside-background inside">

	<div class="element_label"><?php esc_html_e( 'Image Type, Position & Size', 'davis' ) ?></div>
	<div class="edit_form_line spacing">
        <label>
            <span><?php esc_html_e( 'Image Source', 'davis' ) ?></span>
			<div class="item-media">
                <div class="thumbnail-image">
					<% if ( megaData.background.image ) { %>
						<img src="<%= megaData.background.image %>">
					<% } %>
				</div>
                <input type="hidden" name="<%= menuSettings.getFieldName( 'background.image', itemId ) %>" value="<%= megaData.background.image %>">
				<a class="remove-button <% if ( ! megaData.background.image ) { print( 'hidden' ) } %>"><span class="dashicons dashicons-no-alt"></span></a>
				<a class="upload-button <% if ( megaData.background.image ) { print( 'hidden' ) } %>" id="background_image-button"><span class="dashicons dashicons-plus"></span></a>
            </div>
        </label>
    </div>
	<div class="edit_form_line spacing image-size">
        <label>
            <span><?php esc_html_e( 'Image Type', 'davis' ) ?></span>
			<div class="inner">
				<select name="<%= menuSettings.getFieldName( 'img_type', itemId ) %>">
					<option value="background" <% if ( megaData.img_type == 'background' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Background Image', 'davis' ) ?></option>
					<option value="image" <% if ( megaData.img_type == 'image' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Image HTML Tag', 'davis' ) ?></option>
				</select>
			</div>
        </label>
    </div>
	<div class="edit_form_line spacing">
        <label>
            <span><?php esc_html_e( 'Image Size', 'davis' ) ?></span>
			<div class="inner">
				<select name="<%= menuSettings.getFieldName( 'img_size', itemId ) %>">
					<?php global $_wp_additional_image_sizes;
						$available_sizes = get_intermediate_image_sizes();

                        foreach ($available_sizes as &$size) {
                            if (in_array($size, array('thumbnail', 'medium', 'medium_large', 'large'))) { ?>
                                <option value="<?php echo $size ?>" <% if ( megaData.img_size == '<?php echo $size ?>' ) { print( 'selected="selected"' ) } %>>
                                    <?php echo ucwords(str_replace(array('_', '-'), array(' ', ' '), $size)) . ' (' . get_option("{$size}_size_w") . 'x' . get_option("{$size}_size_h") . ')' ?>
                                </option>
                            <?php } else if (isset($_wp_additional_image_sizes[$size])) { ?>
                            	<option value="<?php echo $size ?>" <% if ( megaData.img_size == '<?php echo $size ?>' ) { print( 'selected="selected"' ) } %>>
                                	<?php echo ucwords(str_replace(array('_', '-'), array(' ', ' '), $size)) . ' (' . $_wp_additional_image_sizes[$size]['width'] . 'x' . $_wp_additional_image_sizes[$size]['height'] . ')' ?>
                                </option>
							<?php }
                        }
                    ?>
					<option value="full" <% if ( 'full' == megaData.img_size ) { print( 'selected="selected"' ) } %>><?php _e('Full Size (Original Size)', 'davis') ?></option>
				</select>
			</div>
        </label>
    </div>

	<% if ( depth == 0 ) { %>
		<div class="edit_form_line spacing image-position <% if ( megaData.img_type == 'background' ) { print( 'hidden' ) } %>">
	        <label>
	            <span><?php esc_html_e( 'Image Absolute Position', 'davis' ) ?></span>
				<div class="inner">
					<p class="description"><?php esc_html_e( 'Top', 'davis' ) ?></p>
					<input type="text" name="<%= menuSettings.getFieldName( 'img_pos.top', data['menu-item-db-id'] ) %>" value="<%= megaData.img_pos.top %>">
				</div>
				<div class="inner">
					<p class="description"><?php esc_html_e( 'Right', 'davis' ) ?></p>
					<input type="text" name="<%= menuSettings.getFieldName( 'img_pos.right', data['menu-item-db-id'] ) %>" value="<%= megaData.img_pos.right %>">
				</div>
				<div class="inner">
					<p class="description"><?php esc_html_e( 'Bottom', 'davis' ) ?></p>
					<input type="text" name="<%= menuSettings.getFieldName( 'img_pos.bottom', data['menu-item-db-id'] ) %>" value="<%= megaData.img_pos.bottom %>">
				</div>
				<div class="inner">
					<p class="description"><?php esc_html_e( 'Left', 'davis' ) ?></p>
					<input type="text" name="<%= menuSettings.getFieldName( 'img_pos.left', data['menu-item-db-id'] ) %>" value="<%= megaData.img_pos.left %>">
				</div>
	        </label>
	    </div>
	<% } %>
	<div class="edit_form_line spacing background-position <% if ( megaData.img_type == 'image' ) { print( 'hidden' ) } %>">
        <label>
            <span><?php esc_html_e( 'Background Position', 'davis' ) ?></span>
			<div class="inner">
				<p class="description"><?php esc_html_e( 'Horizontally', 'davis' ) ?></p>
				<select name="<%= menuSettings.getFieldName( 'background.position.x', itemId ) %>">
					<option value="left" <% if ( megaData.background.position.x  == 'left' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Left', 'davis' ) ?></option>
					<option value="center" <% if ( megaData.background.position.x == 'center' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Center', 'davis' ) ?></option>
					<option value="right" <% if ( megaData.background.position.x == 'right' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Right', 'davis' ) ?></option>
				</select>
			</div>
			<div class="inner">
				<p class="description"><?php esc_html_e( 'Vertically', 'davis' ) ?></p>
				<select name="<%= menuSettings.getFieldName( 'background.position.y', itemId ) %>">
					<option value="top" <% if ( megaData.background.position.y == 'top' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Top', 'davis' ) ?></option>
					<option value="center" <% if (megaData.background.position.y == 'center' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Middle', 'davis' ) ?></option>
					<option value="bottom" <% if ( megaData.background.position.y == 'bottom' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Bottom', 'davis' ) ?></option>
				</select>
			</div>
        </label>
    </div>
	<div class="edit_form_line spacing background-repeat <% if ( megaData.img_type == 'image' ) { print( 'hidden' ) } %>">
        <label>
            <span><?php esc_html_e( 'Background Repeat', 'davis' ) ?></span>
			<div class="inner">
				<select name="<%= menuSettings.getFieldName( 'background.repeat', itemId ) %>">
					<option value="no-repeat" <% if ( megaData.background.repeat == 'no-repeat' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'No Repeat', 'davis' ) ?></option>
					<option value="repeat" <% if ( megaData.background.repeat == 'repeat' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Repeat', 'davis' ) ?></option>
					<option value="repeat-x" <% if ( megaData.background.repeat == 'repeat-x' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Repeat Horizontally', 'davis' ) ?></option>
					<option value="repeat-y" <% if ( megaData.background.repeat == 'repeat-y' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Repeat Vertically', 'davis' ) ?></option>
				</select>
			</div>
        </label>
    </div>
	<div class="edit_form_line spacing background-size <% if ( megaData.img_type == 'image' ) { print( 'hidden' ) } %>">
        <label>
            <span><?php esc_html_e( 'Background Size', 'davis' ) ?></span>
			<div class="inner">
				<select name="<%= menuSettings.getFieldName( 'background.size', itemId ) %>">
					<option value="auto" <% if ( megaData.background.size == 'auto' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Auto', 'davis' ) ?></option>
					<option value="cover" <% if ( megaData.background.size == 'cover' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Cover', 'davis' ) ?></option>
					<option value="contain" <% if ( megaData.background.size == 'contain' ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Contain', 'davis' ) ?></option>
				</select>
			</div>
        </label>
    </div>

	<% if ( depth > 0 ) { %>
		<div class="element_label"><?php esc_html_e( 'Image Settings', 'davis' ) ?></div>
		<div class="edit_form_line image-margin <% if ( megaData.img_type == 'background' ) { print( 'hidden' ) } %>">
	        <label>
	            <span><?php esc_html_e( 'No Margin', 'davis' ) ?></span>
	            <input type="checkbox" name="<%= menuSettings.getFieldName( 'img_no_margin', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.img_no_margin ) { print( 'checked="checked"' ); } %> >
	            <span class="description"><?php esc_html_e( 'Remove the spaces around the image.', 'davis' ) ?></span>
	        </label>
	    </div>
		<div class="edit_form_line">
	        <label>
	            <span><?php esc_html_e( 'Hide Image on Desktop', 'davis' ) ?></span>
	            <input type="checkbox" name="<%= menuSettings.getFieldName( 'hide_img_desktop', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hide_img_desktop ) { print( 'checked="checked"' ); } %> >
	            <span class="description"><?php esc_html_e( 'Hide the image for the desktop view.', 'davis' ) ?></span>
	        </label>
	    </div>
		<div class="edit_form_line">
	        <label>
	            <span><?php esc_html_e( 'Hide Image on Mobile', 'davis' ) ?></span>
	            <input type="checkbox" name="<%= menuSettings.getFieldName( 'hide_img_mobile', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hide_img_mobile ) { print( 'checked="checked"' ); } %> >
	            <span class="description"><?php esc_html_e( 'Hide the image for the mobile view.', 'davis' ) ?></span>
	        </label>
	    </div>
	<% } %>

</div>
