<div class="woo_sc_item woo_sc_item_<?php echo $item->id; ?>">
	<?php if ( !empty( $item->image ) ) : ?>
	    <div class="woo_sc_item_image">
	        <?php echo $item->image; ?>
	    </div>
	<?php endif; ?>
    <span class="woo_sc_item_title"><?php echo esc_html( $item->title ); ?></span>
    <div class="woo_sc_links <?php esc_attr_e( $settings['button_style'] ); ?>buttons">
        <?php foreach ( $services as $service ) : ?>
            <div class="woo_sc_link woo_sc_link_<?php esc_attr_e($service); ?>">
                <?php do_action( 'woo_sc_render_' . $service, $order, $item ); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="clear"></div>
</div>
