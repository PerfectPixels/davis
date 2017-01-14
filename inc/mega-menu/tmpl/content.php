<?php
global $wp_widget_factory;
?>
<div id="inside-content" class="inside-content inside">
	<p>
		<textarea name="<%= menuSettings.getFieldName( 'content', data['menu-item-db-id'] ) %>" class="widefat" rows="20" contenteditable="true"><%= megaData.content %></textarea>
	</p>

	<p class="description"><?php esc_html_e( 'Allow HTML and Shortcodes', 'davis' ) ?></p>
</div>
