<?php 

$product_cat = '';
$cat = '';

if (isset($_GET['product_cat'])) {
    $product_cat = $_GET['product_cat'];
}

if ( taxonomy_exists( 'product_cat' ) ) {
	$cat = wp_dropdown_categories(
		array(
			'name'            => 'product_cat',
			'taxonomy'        => 'product_cat',
			'orderby'         => 'NAME',
			'hierarchical'    => 1,
			'hide_empty'      => 1,
			'echo'            => 0,
			'show_option_all' => __('All', 'davis'),
			'selected'		  => $product_cat,
			'value_field'	  => 'slug',
            'hide_if_empty'   => true
		)
	);
}

$ajax = get_theme_mod( 'ajax_search', true );
$filter = get_theme_mod( 'search_cat', true );

?>

<form class="product-search <?php if ( ! $ajax ) { echo 'no-ajax'; } ?>" method="get" action="<?php echo home_url(); ?>">
    <?php if ( class_exists('WooCommerce') && $cat !== '' && $filter ) { ?>
        <div class="cd-select">
            <span class="in"><?php _e( 'in', 'davis' ); ?></span>
            <?php echo $cat ?>
        </div>
        <input type="hidden" name="post_type" value="product">
    <?php } ?>

    <button type="submit" class="<?php echo get_theme_mod( 'search_style', 'icon-search-1' ); ?>"></button>
    <div class="search-input"><input type="search" autocomplete="off" value="<?php echo esc_html($s, 1); ?>" name="s" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', 'Search here' ); ?>" /></div>
</form>

<div class="cd-search-suggestions">
    <div class="results">
    </div>
</div>
