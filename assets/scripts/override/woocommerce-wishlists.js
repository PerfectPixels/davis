
(function ($) {

	var WCWL = {
		current_product_form: 0
	};



	jQuery(document).ready(function ($) {
		//it seems composite products has changed their class name. 
		var composite_class = $( '.bundle_wrap' ).length ? '.bundle_wrap' : ( $( '.composite_wrap' ).length ? '.composite_wrap' : false );
		
		
		var bundles = $(composite_class);
		if (bundles.length) {
			$( '.wl-button-wrap' ).appendTo($(composite_class)).removeClass( 'hide' );
		} else {
			//Move the add to wishlist button inside the variation. 
			var variations = $( '.variations_button' );
			if (variations.length && $( '.variations_button .wl-button-wrap' ).length < 0) {
				$( '.wl-button-wrap' ).appendTo($( '.variations_button' )).removeClass( 'hide' );
			}
		}
		
		$(document).bind( 'show_variation', function (event, variation) { 
			var bundles = $(composite_class);
			if (!bundles.length) {
				if (!variation.is_in_stock) {
					if ( $( '.variations_button .wl-button-wrap' ).length < 0 ) {
						$( '.wl-button-wrap' ).appendTo($( '.single_variation_wrap' )).removeClass( 'hide' );
					} else {
						$( '.wl-button-wrap' ).removeClass( 'hide' );
					}
				} else {
					if ( $( '.variations_button .wl-button-wrap' ).length < 0 ) {
						$( '.wl-button-wrap' ).appendTo($( '.variations_button' )).removeClass( 'hide' );
					} else {
						$( '.wl-button-wrap' ).removeClass( 'hide' );
					}
				}
			}
		});

		//When page loads...
		$(".wl-panel").hide(); //Hide all content
		$("ul.wl-tabs li:first").addClass("active").show(); //Activate first tab
		$(".wl-panel:first").show(); //Show first tab content

		//On Click Event
		$("ul.wl-tabs li").click(function () {
			$("ul.wl-tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".wl-panel").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active ID content
			return false;
		});

		/////////////////////////////////
		// add to wishlist button effects
		/////////////////////////////////	

		// basic wishlist popup stuff	
		$( '#wl-list-pop-wrap' ).hide(); // hide background click-off on load	
		$( '.wishlist-options' ).hide(); // hide modal on load	
		$( '#wl-list-pop-wrap' ).click(function () {

			WCWL.current_product_form = null;
			WCWL.current_product_id = 0;
			
			if ($( 'body' ).hasClass( 'archive' )){
				$( '.wishlist-options' ).removeClass( 'open' ).insertAfter( '#wl-list-pop-wrap' );
			}
			
			$( '.wishlist-options' ).hide(); // hide modal when click in background	
			$( '#wl-list-pop-wrap' ).hide(); // hide background click-off
		});

		_productlink = null;
		// position popup at button click 

		$( 'body' ).on( 'click', '.wl-add-to', function () {

			if ( $( this ).parents( 'ul.products' ).length > 0 ){
				WCWL.current_product_form = $(this).parents( 'li.product' );
				$( '.wishlist-options' ).appendTo( WCWL.current_product_form );
			} else {
				// Add the form in the var
				WCWL.current_product_form = $(this).closest( 'form.cart' ).eq(0);
				
				// If it doesn't exist, check for other types
				if ( ! WCWL.current_product_form || WCWL.current_product_form.length === 0) {
					if ( $(this).closest( 'form.composite_form' ).length ) {
						WCWL.current_product_form = $(this).closest( 'form.composite_form' ).eq(0);
					} else if ( $(this).closest( 'form.bundle_form' ).length ) {
						WCWL.current_product_form = $(this).closest( 'form.bundle_form' ).eq(0);
					}
				}
				
				// Move the wishlists list i the button
				$( '.wishlist-options' ).appendTo( $( this ) );
			}
			
			WCWL.current_product_id = $(this).data( 'productid' );
			
			_productlink = $(this);
			
			if ( $(this).hasClass( 'wl-add-to-single' )) {
				return;
			}
			
			$( '#wl-list-pop-wrap' ).show(); // show background click-off on click
			$( '.wishlist-options' ).show(10, function(){
				$(this).addClass( 'open' );
			}); // show modal on click

			return false;
		});


		// close wishlist on esc key press
		$(document).keyup(function (e) {
			if (e.keyCode === 27) {
				$( '.wl-list-pop-wrap' ).hide();
			}
		});

		$( 'body' ).on( 'click', '.wl-add-to-single', function (event) {
			event.preventDefault();
			var $btn = $(this),
				wlid = $btn.data( 'listid' ),
				$form = WCWL.current_product_form,
				sep = wishlist_params.current_url.indexOf( '?' ) >= 0 ? '&' : '?',
				newURL = wishlist_params.current_url + sep + 'add-to-wishlist-itemid=' + WCWL.current_product_id;
				
			$form.find("input#wlid").val(wlid);
			
			// If we are on a page with several product (i.e. Archive Page)
			if ( $( this ).parents( 'ul.products' ).length > 0 ){
				
				$( '<div class="loading-overlay"><p class="loading"></p></div>' ).appendTo($form);
				$( '#wl-list-pop-wrap' ).hide();
				$( '.wishlist-options' ).hide().removeClass( 'open' ).insertAfter( '#wl-list-pop-wrap' );
				
				var formData = 'quantity=1';
				
				formData += '&add-to-cart=' + $form.find( '.add_to_cart_button' ).data( 'product_id' );
				formData += '&wlid=' + $form.find( '[name=wlid]' ).val();
				formData += '&add-to-wishlist-type=' + $form.find( '[name=add-to-wishlist-type]' ).val();
				formData += '&wl_from_single_product=' + $form.find( '[name=wl_from_single_product]' ).val();
				
				if ( $form.hasClass( 'product-type-variable' ) ){
					// attribute_variations=Fox&quantity=1&add-to-cart=1365&product_id=1365&variation_id=1371&wlid=1400&add-to-wishlist-type=variable&wl_from_single_product=1
					var $slide = $form.find( 'div.owl-item.active a' ),
						attrCounter = parseInt( $slide.data( 'attr-counter' ) );
					
					for (i = 1; i <= attrCounter; i++){
						formData += '&' + $slide.data( 'attr-name-' + i ) + '=' + $slide.data( 'attr-value-' + i );
					}
					
					formData += '&product_id=' + $form.find( '.add_to_cart_button' ).data( 'product_id' );
					formData += '&variation_id=' + $slide.data( 'variation-id' );
				}
				
				if ( $(this).data( 'listid' ) === 'session' ) {
					window.location.href = newURL + '&' + formData;
					
					return false;
				} 
			// If we are on a single product page
			} else {	
				var formData = 'quantity=' + $form.find( 'input.qty' ).val();
				
				formData += '&add-to-cart=' + $form.data( 'product_id' );
				formData += '&wlid=' + $form.find( '[name=wlid]' ).val();
				formData += '&add-to-wishlist-type=' + $form.find( '[name=add-to-wishlist-type]' ).val();
				formData += '&wl_from_single_product=' + $form.find( '[name=wl_from_single_product]' ).val();
			}
				
			$.ajax({
				type: "POST",
				url: newURL,
				data: formData,
				success: function(data){
					var div = $( '<div>' );
					div.html(data);
					$( '.navbar-top li.favorites' ).replaceWith(div.find( '.navbar-top li.favorites' ));
					$form.find( '.loading-overlay' ).remove();
					$form.find( '.wl-add-to' ).removeClass( 'icon-heart-line' ).addClass( 'icon-heart' );
				},
			    error: function (request, status, error) {
			        alert(request.responseText);
			    }
			});
		

			return false;
		});


		$( '.wl-shop-add-to-single' ).click(function (event) {
			event.preventDefault();
			window.location.href = _productlink.attr( 'href' ) + "&wlid=" + $(this).data( 'listid' );
			return false;
		});


		$( '.wlconfirm' ).click(function () {
			var message = $(this).data( 'message' );

			var answer = confirm(message ? message : wishlist_params.are_you_sure);
			return answer;
		});

		$( 'input[type=checkbox]', '.wl-table thead tr th' ).click(function () {
			$(this).closest( 'table' ).find( ':checkbox' ).attr( 'checked', this.checked);
		});


		$( '.share-via-email-button' ).click(function (event) {
			var form_id = $(this).data( 'form' );
			$( '#' + form_id).trigger( 'submit', []);
			return true;
		});


		$( '.move-list-sel' ).change(function (event) {

			$( '.move-list-sel' ).val($(this).val());

		});

		$( '.btn-apply' ).click(function (event) {
			event.preventDefault();

			$("#wlupdateaction").val( 'bulk' );
			$( '#wl-items-form' ).submit();

			return false;
		});

		$( '#wleditaction1' ).change(function () {
			$( '#wleditaction2' ).val($(this).val());
		});

		$( '#wleditaction2' ).change(function () {
			$( '#wleditaction1' ).val($(this).val());
		});

	});

})(jQuery);