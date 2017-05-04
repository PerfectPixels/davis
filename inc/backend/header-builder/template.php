<?php

global $header_elements, $header_presets;

?>

<aside class="header-builder active">
	<div class="customize-pane-child">
		<div class="customize-section-title">
			<h3><?php _e('Header Builder', 'davis'); ?> - 
				<span class="desktop"><?php _e('Desktop', 'davis'); ?></span>
				<span class="tablet"><?php _e('Tablet', 'davis'); ?></span>
				<span class="mobile"><?php _e('Mobile', 'davis'); ?></span>
			</h3>
		</div>
		<div class="wp-full-overlay-footer">
            <button class="button presets-button" type="button"><?php _e('Presets', 'davis'); ?></button>
			<div class="devices">
				<button type="button" class="preview-desktop" aria-pressed="true" data-device="desktop">
					<span class="screen-reader-text"><?php _e('Enter desktop preview mode', 'davis'); ?></span>
				</button>
				<button type="button" class="preview-tablet" aria-pressed="false" data-device="tablet">
					<span class="screen-reader-text"><?php _e('Enter tablet preview mode', 'davis'); ?></span>
				</button>
				<button type="button" class="preview-mobile" aria-pressed="false" data-device="mobile">
					<span class="screen-reader-text"><?php _e('Enter mobile preview mode', 'davis'); ?></span>
				</button>
			</div>
			<button type="button" class="collapse-builder button" aria-expanded="true" aria-label="<?php _e('Hide Builder', 'davis'); ?>">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php _e('Hide Builder', 'davis'); ?></span>
			</button>
		</div>
	</div>
	<div id="header-desktop" class="customize-pane-content <?php echo get_theme_mod( 'logo_position_desktop', 'left_logo' ); ?>">
		<ul class="top-bar">
			<li class="left sortable" data-setting="top_bar_left_area"></li>
			<li class="center sortable" data-setting="top_bar_center_area"></li>
			<li class="right sortable" data-setting="top_bar_right_area"></li>
            <span data-section="top_bar"><?php _e( 'Edit Top Bar', 'davis' ); ?></span>
		</ul>
		<ul class="main-header">
			<li id="logo">
				<h3><?php _e( 'Logo', 'davis' ); ?><i class="dashicons dashicons-admin-generic" data-section="title_tagline"></i></h3>
			</li>
			<li class="left sortable" data-setting="main_header_left_area"></li>
			<li class="right sortable" data-setting="main_header_right_area"></li>
            <span data-section="main_header"><?php _e( 'Edit Main Header', 'davis' ); ?></span>
		</ul>
		<ul class="bottom-header">
			<li class="left sortable" data-setting="bottom_header_left_area"></li>
			<li class="center sortable" data-setting="bottom_header_center_area"></li>
			<li class="right sortable" data-setting="bottom_header_right_area"></li>
            <span data-section="bottom_header"><?php _e( 'Edit Bottom Header', 'davis' ); ?></span>
		</ul>
		<ul class="unused">
			<h4><?php _e('Inactive Elements', 'davis'); ?></h4>
			<li class="sortable">
				<?php foreach ( $header_elements as $element ) {
                	echo '<span class="button elements" data-type="' . $element[0] . '">' . $element[1];
                		if ( isset($element[2]) ){
	                		echo '<i class="dashicons dashicons-admin-generic" data-section="' . $element[2] . '"></i>';
    					}
                	echo '</span>';
                } ?>
			</li>
		</ul>
	</div>
	<div id="header-tablet" class="customize-pane-content <?php echo get_theme_mod( 'logo_position_tablet', 'center_logo_tablet' ); ?>">
		<ul class="top-bar">
			<li class="left sortable" data-setting="tablet_top_bar_left_area"></li>
			<li class="right sortable" data-setting="tablet_top_bar_right_area"></li>
            <span data-section="top_bar"><?php _e( 'Edit Top Bar', 'davis' ); ?></span>
		</ul>
		<ul class="main-header">
			<li id="logo">
				<h3><?php _e( 'Logo', 'davis' ); ?><i class="dashicons dashicons-admin-generic" data-section="title_tagline"></i></h3>
			</li>
			<li class="left sortable" data-setting="tablet_main_header_left_area"></li>
			<li class="right sortable" data-setting="tablet_main_header_right_area"></li>
            <span data-section="main_header"><?php _e( 'Edit Main Header', 'davis' ); ?></span>
		</ul>
		<ul class="unused">
			<h4><?php _e('Inactive Elements', 'davis'); ?></h4>
			<li class="sortable">
				<?php foreach ( $header_elements as $element ) {
                	echo '<span class="button elements" data-type="' . $element[0] . '">' . $element[1];
                		if ( isset($element[2]) ){
	                		echo '<i class="dashicons dashicons-admin-generic" data-section="' . $element[2] . '"></i>';
    					}
                	echo '</span>';
                } ?>
			</li>
		</ul>
	</div>
	<div id="header-mobile" class="customize-pane-content <?php echo get_theme_mod( 'logo_position_mobile', 'center_logo_mobile' ); ?>">
		<ul class="top-bar">
			<li class="center sortable" data-setting="mobile_top_bar_area"></li>
            <span data-section="top_bar"><?php _e( 'Edit Top Bar', 'davis' ); ?></span>
		</ul>
		<ul class="main-header">
			<li id="logo">
				<h3><?php _e( 'Logo', 'davis' ); ?><i class="dashicons dashicons-admin-generic" data-section="title_tagline"></i></h3>
			</li>
			<li class="left sortable" data-setting="mobile_main_header_left_area"></li>
			<li class="right sortable" data-setting="mobile_main_header_right_area"></li>
            <span data-section="main_header"><?php _e( 'Edit Main Header', 'davis' ); ?></span>
		</ul>
		<ul class="bottom-bar">
			<h4><?php _e('Bottom Bar Elements', 'davis'); ?></h4>
			<li class="center sortable" data-setting="mobile_bottom_bar_area"></li>
            <span data-section="bottom_bar"><?php _e( 'Edit Bottom Bar', 'davis' ); ?></span>
		</ul>
		<ul class="unused">
			<h4><?php _e('Inactive Elements', 'davis'); ?></h4>
			<li class="sortable">
				<?php foreach ( $header_elements as $element ) {
                	echo '<span class="button elements" data-type="' . $element[0] . '">' . $element[1];
                		if ( isset($element[2]) ){
	                		echo '<i class="dashicons dashicons-admin-generic" data-section="' . $element[2] . '"></i>';
    					}
                	echo '</span>';
                } ?>
			</li>
		</ul>
	</div>
    <div id="header-presets" class="customize-pane-content">
        <?php foreach ( $header_presets as $preset ) {
            echo '<img src="'. get_template_directory_uri() .'/assets/images/admin/'. $preset[0] .'.jpg" data-elements="' . $preset[1] . '" data-logo="' . $preset[2] . '" data-content-pos="' . $preset[3] . '" data-options="' . $preset[4] . '" />';
        } ?>
    </div>
</aside>