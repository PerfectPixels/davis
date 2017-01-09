(function ($) {
	$(document).ready(function () {
		
		// Show/Hide the some option fields
		var toggleCheckbox = function( $container, $els ){
			if ( $container.find( 'input[type=checkbox]:checked' ).length > 0 ){
				$els.css( 'display', 'block' );
			} else {
				$els.css( 'display', 'none' );
			}
		};
		
		// Ajax request to replqce the image
		var menuImageUpdate = function( item_id, thumb_id ) {		
			$.post( ajaxurl, {
				action		: 'set-menu-item-thumbnail',
				json		: true,
				post_id		: item_id,
				thumbnail_id: thumb_id,
				_wpnonce	: menuImage.settings.nonce
			}).done( function( html ) { 
				$( '#menu-image-' + item_id ).replaceWith( html );
				$( 'input#edit-menu-item-menu-img-' + item_id ).val( thumb_id );
			});
		};
		
		var toggleSelects = function(){
			// Check each "image type" checkbox	
			$( '.field-img-type' ).each( function(){
				var $container 	= $( this ),
					choices		= ['icon', 'bg-img', 'mega-menu-bg'],
					getField	= function( value ){
						switch( value ) {
						    case 'icon':
						        return $container.siblings( '.field-icon-pos' );
						        break;
						    case 'bg-img':
						        return $container.siblings( '.field-bg-type' );
						        break;
						    case 'mega-menu-bg':
						        return $container.siblings( '.field-bg-mega-type' );
						        break;
						}
					};				
				
				$.each( choices, function( index, value ){
					var $field = getField( value );
					
					if ( $container.siblings( '.field-add-img' ).find( 'input[type=checkbox]:checked' ).length > 0 && $container.find( 'option[value='+value+']' ).is( ':selected' ) ){
						$field.css( 'display', 'block' );
					} else {
						$field.css( 'display', 'none' );					
					}
					
				});
				
				$container.find( 'select' ).on( 'change', function(){
					var $select = $( this );
					
					$.each( choices, function( index, value ){
						var $field = getField( value );
						
						if ( $container.siblings( '.field-add-img' ).find( 'input[type=checkbox]:checked' ).length > 0 && $select.val() == value ){
							$field.css( 'display', 'block' );
						} else {
							$field.css( 'display', 'none' );					
						}
					});
				});
			
			});
		};
		
		toggleSelects();
		
		// Make the checkbox display/hide elements
		$( 'ul.menu' ).on( 'click', '.field-add-img input[type=checkbox]', function(){
			var $container 	= $( this ).parents('.field-add-img'),
				$els		= $container.siblings( '.field-image, .field-img-type, .field-img-size' );
				
			toggleCheckbox( $container, $els );
			toggleSelects();
		});
		
		// Check each "add image" checkbox that are already created
		$( '.field-add-img' ).each( function(){
			var $container 	= $( this ),
				$els		= $container.siblings( '.field-image, .field-img-type, .field-img-size' );
			
			toggleCheckbox( $container, $els );
		});
		
		// Click on the add image button
		$('#menu-to-edit').on('click', '.menu-item .set-post-thumbnail', function (e) {
			e.preventDefault();
			e.stopPropagation();

			var item_id 	= $(this).parents('.field-image').siblings('input.menu-item-data-db-id').val(),
				uploader 	= wp.media({
					title: menuImage.l10n.uploaderTitle, // todo: translate
					button: { text: menuImage.l10n.uploaderButtonText },
					multiple: false
				}).on('select', function () {
					var attachment = uploader.state().get('selection').first().toJSON();
					menuImageUpdate( item_id, attachment.id );
				}).open();
		}).on('click', '.menu-item .remove-post-thumbnail', function (e) {
			e.preventDefault();
			e.stopPropagation();

			var item_id = $(this).parents('.field-image').siblings('input.menu-item-data-db-id').val();
			menuImageUpdate( item_id, -1 );
		});
		
		// Check if it is a top menu item and if mega menu is selected
		$( '.menu-item-depth-0' ).each( function(){
			var $el       		= $( this ),
				$imgTypeSlt		= $el.find( '.field-img-type select' ),
				$megaMenuChkb 	= $el.find( '.field-mega-menu' ),
				$megaMenuCol 	= $el.find( '.field-megamenu-columns' );
				
			$imgTypeSlt.find( 'option' ).css( 'display', 'none' );
			$imgTypeSlt.find( 'option[value=icon], option[value=bg-img]' ).css( 'display', 'block' );
			
			toggleCheckbox( $megaMenuChkb, $imgTypeSlt.find( 'option[value=mega-menu-bg]' ) );
			toggleCheckbox( $megaMenuChkb, $megaMenuCol );
		});
		// Make the checkbox display/hide elements
		$( 'ul.menu' ).on( 'click', '.field-mega-menu input[type=checkbox]', function(){
			var $container 		= $( this ).parents('.field-mega-menu'),
				$els 			= $container.siblings( '.field-img-type' ).find( 'option[value=mega-menu-bg]' ),
				$megaMenuCol 	= $container.siblings( '.field-megamenu-columns' );
				
			// Move the columns selection to be below the checkbox
			$megaMenuCol.detach().insertAfter( $container );
				
			toggleCheckbox( $container, $els );
			toggleCheckbox( $container, $megaMenuCol );
		});
		
		// Check if menu is in Primary navigation
		if ( $( '.menu-theme-locations input#locations-primary_navigation' ).is( ':checked' ) ){
			$( '#menu-to-edit' ).addClass( 'is-primary-navigation' );
		}
		
	});
})(jQuery);
