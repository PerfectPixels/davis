<div id="inside-mega" class="inside-mega inside">
	<ul class="inside-navbar">
		<li class="pp-mega-menu-toggle-btn">
			<span><?php esc_html_e( 'Enable Mega Menu', 'davis' ) ?></span>
			<div class="onoffswitch">
				<input type="checkbox" id="mega-menu-checkbox" class="onoffswitch-checkbox" name="<%= menuSettings.getFieldName( 'mega', data['menu-item-db-id'] ) %>" value="1" <% if ( megaData.mega ) { print( 'checked="checked"' ); } %> >
				<label for="mega-menu-checkbox" class="onoffswitch-label"></label>
			</div>
		</li>
	</ul>

	<ul id="pp-mega-content" class="pp-mega-content">
		<%
		var items = _.filter( children, function( item ) {
		return item.subDepth == 0;
		} );
		%>
		<% _.each( items, function( item, index ) { %>

		<li class="menu-item-container" data-width="<%= item.megaData.width %>">
			<div class="menu-item-handle">
				<span class="item-title">
					<% if ( item.megaData.icon ) { %>
						<i class="<%= item.megaData.icon %>"></i>
					<% } %>
					<%= item.data['menu-item-title'] %>
				</span>
				<span class="item-controls">
					<% if ( item.subDepth == 0 ) { %>
						<span class="submenu-smaller"><i class="dashicons dashicons-arrow-left"></i></span>
						<span class="submenu-bigger"><i class="dashicons dashicons-arrow-right"></i></span>
						<input type="hidden" name="<%= menuSettings.getFieldName( 'width', item.data['menu-item-db-id'] ) %>" value="<%= item.megaData.width %>" class="menu-item-width">
					<% } %>
				</span>
			</div>
		</li>

		<% } ) %>
	</ul>
</div>
