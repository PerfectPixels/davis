<% if ( depth == 0 ) { %>
    <li class="pp-mega-menu-item-setting-tab pp-mega-menu-to-content active-item-setting-tab" data-panel="mega">
        <a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Content', 'davis' ) ?>"><?php esc_html_e( 'Mega Menu', 'davis' ) ?></a>
    </li>
<% } else { %>
    <li class="pp-mega-menu-item-setting-tab pp-mega-menu-to-content active-item-setting-tab" data-panel="content">
        <a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Content', 'davis' ) ?>"><?php esc_html_e( 'Menu Content', 'davis' ) ?></a>
    </li>
<% } %>

<li class="pp-mega-menu-item-setting-tab pp-mega-menu-to-content" data-panel="general">
    <a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Settings', 'davis' ) ?>"><?php esc_html_e( 'Settings', 'davis' ) ?></a>
</li>
<li class="pp-mega-menu-item-setting-tab pp-mega-menu-to-content" data-panel="background">
    <a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Design', 'davis' ) ?>"><?php esc_html_e( 'Design', 'davis' ) ?></a>
</li>
<li class="pp-mega-menu-item-setting-tab pp-mega-menu-to-content" data-panel="icon">
    <a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'davis' ) ?>"><?php esc_html_e( 'Icon', 'davis' ) ?></a>
</li>
