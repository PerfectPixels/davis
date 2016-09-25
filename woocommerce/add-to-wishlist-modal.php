<?php 
// Woocommerce Wishlists Plugin -- WC_Wishlists_Plugin

$public_lists = WC_Wishlists_User::get_wishlists('Public');
$shared_lists = WC_Wishlists_User::get_wishlists('Shared'); 
$private_lists = WC_Wishlists_User::get_wishlists('Private');

?>

<div id="wl-list-pop-wrap" style="display:none;"></div><!-- /wl-list-pop-wrap -->
    
<div class="wishlist-options product-overlay woocommerce">
	<div class="wrap">
		<div class="container">
			<div class="content">
				<h3><?php _e( 'Add to your lists', 'wc_wishlist' ); ?></h3>
				<table>
					<tbody>
					    <?php if ($public_lists && count($public_lists)) : ?>      
					   		<tr class="option"> 
					            <td><h4><?php _e( 'Public', 'wc_wishlist' ); ?></h4></td>
					            <td>
					            	<ul>
							            <?php foreach ($public_lists as $list) : ?>
							            	<li><a class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>"><?php $list->the_title(); ?></a></li>
							            <?php endforeach; ?>      
					            	</ul>
								</td>
					   		</tr>
					    <?php endif; ?>
					    
					    <?php if ($shared_lists && count($shared_lists)) : ?>
					       	<tr class="option"> 
					            <td><h4><?php _e( 'Shared', 'wc_wishlist' ); ?></h4></td>
					            <td>
					            	<ul>
							            <?php foreach ($shared_lists as $list) : ?>
							                <li><a class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>"><?php $list->the_title(); ?></a></li>
							            <?php endforeach; ?> 
					            	</ul>
					            </td>    
					   		</tr>
					    <?php endif; ?>
					
					    <?php  ?>
					    <?php if ($private_lists && count($private_lists)) : ?>          
					        <tr class="option"> 
					            <td><h4><?php _e( 'Private', 'wc_wishlist' ); ?></h4></td>
					            <td>
					            	<ul>
							            <?php foreach ($private_lists as $list) : ?>
							                <li><a class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>"><?php $list->the_title(); ?></a></li>
							            <?php endforeach; ?>  
					            	</ul>
					            </td>     
					   		</tr>       
					    <?php endif; ?>
				 	</tbody>
				</table>
			    <strong><a class="wl-add-to-single button" data-listid="session" href="#"><?php _e( 'Create a new list', 'wc_wishlist' ); ?></a></strong>
			</div>
		</div>
	</div>
</div>
