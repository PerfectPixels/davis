<?php
global $wp_widget_factory;
?>
<div id="inside-general" class="inside-general inside">

	<% if ( depth == 0 ) { %>
	    <div class="element_label"><?php esc_html_e( 'Mega Width', 'davis' ) ?></div>
	    <div class="edit_form_line">
	        <input type="text" name="<%= menuSettings.getFieldName( 'mega_width', data['menu-item-db-id'] ) %>" placeholder="100%" value="<%= megaData.mega_width %>">
	    </div>
	<% } %>


	<div class="element_label"><?php esc_html_e( 'Item Settings', 'davis' ) ?></div>
	<% if ( depth > 0 ) { %>
		<div class="edit_form_line">
	        <label>
	            <span><?php esc_html_e( 'Hide Text', 'davis' ) ?></span>
	            <input type="checkbox" name="<%= menuSettings.getFieldName( 'hide_text', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hide_text == 1 ) { print( 'checked="checked"' ); } %> >
	            <span class="description"><?php esc_html_e( 'Hide the menu item text. Useful if the menu item needs to be an image only.', 'davis' ) ?></span>
	        </label>
	    </div>
	<% } %>

	<% if ( depth == 1 ) { %>
		<div class="edit_form_line">
	        <label>
	            <span><?php esc_html_e( 'Uppercase SubMenu', 'davis' ) ?></span>
	            <input type="checkbox" name="<%= menuSettings.getFieldName( 'uppercase_text', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.uppercase_text ) { print( 'checked="checked"' ); } %> >
	            <span class="description"><?php esc_html_e( 'Display the menu item text uppercased.', 'davis' ) ?></span>
	        </label>
	    </div>
	<% } %>

	<div class="edit_form_line">
		<label>
			<span><?php esc_html_e( 'Disable Link', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'disable_link', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.disable_link ) { print( 'checked="checked"' ); } %> >
			<span class="description"><?php esc_html_e( 'Remove the hyperlink from the menu item.', 'davis' ) ?></span>
		</label>
	</div>

	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'Hide on Desktop', 'davis' ) ?></span>
            <input type="checkbox" name="<%= menuSettings.getFieldName( 'hide_desktop', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hide_desktop ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Hide the menu item for the desktop view.', 'davis' ) ?></span>
        </label>
    </div>
	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'Hide on Mobile', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'hide_mobile', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hide_mobile ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Hide the menu item text for the mobile view.', 'davis' ) ?></span>
        </label>
    </div>


	<div class="element_label"><?php esc_html_e( 'Item Badges', 'davis' ) ?></div>
	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'Hot Badge', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'hot', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.hot ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Add a hot badge next to the menu item.', 'davis' ) ?></span>
        </label>
    </div>
	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'New Badge', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'new', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.new ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Add a new badge next to the menu item.', 'davis' ) ?></span>
        </label>
    </div>
	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'Trending Badge', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'trending', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.trending ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Add a trending badge next to the menu item.', 'davis' ) ?></span>
        </label>
    </div>
	<div class="edit_form_line">
        <label>
            <span><?php esc_html_e( 'Sale Badge', 'davis' ) ?></span>
			<input type="checkbox" name="<%= menuSettings.getFieldName( 'sale', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.sale ) { print( 'checked="checked"' ); } %> >
            <span class="description"><?php esc_html_e( 'Add a sale badge next to the menu item.', 'davis' ) ?></span>
        </label>
    </div>
</div>
