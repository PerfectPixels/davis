/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($){

	// Do not run it twice
	if ( typeof PP !== 'undefined' ){
		return false;
	}

	// Use this variable to set up the common and page specific functions. If you
	// rename this variable, you will also need to rename the namespace below.
	var PP = {
		// Store all objects
		'obj': {
			$window				: $(window),
			$document			: $(document),
			$html				: $('html'),
			$head				: $('head'),
			$body				: $('body'),
			lang				: $('html').attr('lang'),
			devicePixelRatio	: window.devicePixelRatio || 1,
			$mobileNavBtn		: $('.nav-button'),
			cartDismiss			: true,
			last_src			: $( 'div.images img:eq(0)' ).attr( 'src' ),
			$searchTrigger		: $( '.cd-search-trigger' ),
			$searchForm			: $('.cd-main-search'),
			$coverLayer			: $('.cd-cover-layer'),
			prevIconColor		: '',
			upd					: null,
		},
		// Methods
		'method': {

			// Check the screen / device type
			checkWindowWidth: function() {
				if ( $( '.nav-header' ).length > 0 ){
					var mq = window.getComputedStyle( $( '.nav-header' ).get(0), ':before' ).getPropertyValue( 'content' ).replace( /"/g, '' ).replace( /'/g, "" );
					return mq;
				}
			},

			// Check if we are on a mobile device
			checkMobile: function(){
				var isTouch = ('ontouchstart' in document.documentElement);

				if ( isTouch ) {
					PP.method.funcTouch();
				} else {
					PP.method.funcNoTouch();
				}

				PP.method.funcAll();
			},

			// Main Navigation
			'navigation': {

				// Attach all handlers
				regEventHandlers: function(){
					var $overlay 	= $('.nav-overlay'),
						swipeEvent	= 'swiperight',
						$this		= this;

					if ( $( '.nav-on-left' ).length > 0 ){
						swipeEvent = 'swipeleft';
					}

					PP.obj.$window.on('resize', function(){
						( !window.requestAnimationFrame ) ? setTimeout( $this.moveNavigation, 300 ) : window.requestAnimationFrame( $this.moveNavigation );
					});

					// Open lateral menu clicking on the menu icon
					PP.obj.$mobileNavBtn.on('click', function( event ){
						event.preventDefault();
						$this.openMobileNav( $( this ) );
					});

					// Close lateral menu on mobile
					$overlay.on( swipeEvent, function(){
						if( $( '.primary-nav' ).hasClass( 'nav-is-visible' ) ) {
							$this.closeNav();
							$overlay.removeClass( 'is-visible' );
						}
					});

					// Open the search form
					PP.obj.$searchTrigger.on( 'click', function( event ){
						event.preventDefault();
						$this.openSearchForm( $( this ) );
					});

					// Update span.selected-value text when user selects a new option
					PP.obj.$searchForm.on( 'change', 'select', function(){
						PP.obj.$searchForm.find( '.selected-value' ).text( $(this).children( 'option:selected' ).text() );
					});

					// Searchbox Select - Update span.selected-value text when user selects a new option
					$( '.search-box select' ).on( 'change', function(){
						$( '.search-box .selected-value' ).text( $(this).children( 'option:selected' ).text() );
					});

					// Close search form
					PP.obj.$searchForm.on( 'click', '.close', function( event ){
						event.preventDefault();
						$this.closeSearchForm();
					});

					// Close search form when clicked on the overlay
					PP.obj.$coverLayer.on( 'click', function(){
						$this.closeSearchForm();
					});

					// Close search form on escape key
					PP.obj.$document.keyup(function( event ){
						if( event.which=='27' ){ $this.closeSearchForm(); }
					});

					// Open submenu for submenu item
					$( '.sub-menu-item.menu-item-has-children' ).children( 'a' ).on( 'click', function( event ){
						event.preventDefault();
						$this.openSubmenu( $( this ) );
					});

					//submenu items - go back link
					$( '.go-back' ).on( 'click' , function( event ){
						event.preventDefault();
						var $parent		= $( this ).parent( 'ul' ),
							$prevMenu 	= $parent.parent( '.menu-item-has-children' ).parent( 'ul' ),
							prevMenuH 	= parseInt( $prevMenu.attr( 'data-height' ) ) + 40,
							screenSize 	= PP.method.checkWindowWidth();

						$parent.addClass( 'is-hidden' );
						$prevMenu.removeClass( 'moves-out' );

						// Only for desktop
						if ( screenSize === 'desktop' ) {
							if ( $prevMenu.parents( '.mega-menu' ).length > 0 ){
								$prevMenu.parents( '.mega-menu' ).children( '.menu-item-has-children' ).css( 'height', prevMenuH );
							} else {
								$prevMenu.parents( '.main-menu-item' ).children( '.sub-menu' ).css( 'height', prevMenuH );
							}
						}
					});

				},

				// Center logo
				centerLogo: function(){

					// Center the nav and logo
					if ( $( '.center_logo-center_menu' ).length > 0 ){
						var $brand			= $( '.brand' ),
							brandW			= $brand.outerWidth(),
							$navBrand		= $brand.clone().css( 'width', brandW ),
							$navChild		= $( '.primary-nav' ).children( 'li' ),
							breakpoint		= Math.ceil( $navChild.length / 2 ),
							$headerBtns		= $( '.header-buttons' );

						$( '.primary-nav > li:nth-child(' + breakpoint + ')' ).after( '<li class="nav-brand"></li>' );
						$( '.nav-brand' ).html( $navBrand );

						$( '.center_logo-center_menu' ).prepend( '<ul class="header-buttons left"></ul>' );
						$headerBtns.find( 'li.search, li.account' ).detach().appendTo( '.header-buttons.left' );
					}

				},

				// Open the navigation
				openMobileNav: function( $btn ){
					var $container 	= $('#page-content'),
						$els 		= $( 'nav.navbar-top, #header-slider, #page-content, .nav-button, .nav-header, .primary-nav, #footer' ),
						$overlay 	= $('.nav-overlay');

					if( $container.hasClass('nav-is-visible') ) {
						this.closeNav();
						$overlay.removeClass('is-visible');
					} else {
						$btn.addClass( 'nav-is-visible' );
						$els.addClass( 'nav-is-visible' );
						$container.addClass('nav-is-visible').one( 'transitionend', function(){
							PP.obj.$body.addClass( 'overflow-hidden' );
						});
						this.closeSearchForm();
						$overlay.addClass( 'is-visible' );
					}
				},

				// Open the submenu
				openSubmenu: function( selected ){

					if( selected.next( 'ul' ).hasClass( 'is-hidden' ) ) {
						var $nextMenu = selected.addClass( 'selected' ).next( 'ul' ),
							nextMenuH = parseInt( $nextMenu.attr( 'data-height' ) ) + 40,
							screenSize 	= PP.method.checkWindowWidth();

						// Desktop version only
						$nextMenu.removeClass( 'is-hidden' ).end().parent( '.menu-item-has-children' ).parent( 'ul' ).addClass( 'moves-out' );

						// Change the height of the menu - Only for desktop
						if ( screenSize === 'desktop' ) {
							if ( $nextMenu.parents( '.mega-menu' ).length > 0 ){
								$nextMenu.parents( '.mega-menu' ).children( '.menu-item-has-children' ).css( 'height', nextMenuH );
							} else {
								$nextMenu.parents( '.main-menu-item' ).children( '.sub-menu' ).css( 'height', nextMenuH );
							}
						} else {
							$( '#page-content' ).off().one( 'transitionend', function(){
								$( window ).resize();
							});
						}

						selected.parent( '.menu-item-has-children' ).siblings( '.menu-item-has-children' ).children( 'ul' ).addClass( 'is-hidden' ).end().children( 'a' ).removeClass( 'selected' );
						$( '.nav-overlay' ).addClass( 'is-visible' );
					} else {
						selected.removeClass( 'selected' ).next( 'ul' ).addClass( 'is-hidden' ).end().parent( '.menu-item-has-children' ).parent( 'ul' ).removeClass( 'moves-out' );
						$( '.nav-overlay' ).removeClass( 'is-visible' );
					}
				},

				// Close the navigation
				closeNav: function(){
					var $container 	= $('#page-content'),
						$els 		= $( 'nav.navbar-top, #header-slider, .nav-button, .nav-header, .primary-nav, #footer' );

					$els.removeClass( 'nav-is-visible' );
					$( '.menu-item-has-children ul' ).addClass( 'is-hidden' );
					$( '.menu-item-has-children a' ).removeClass( 'selected' );
					$( '.moves-out' ).removeClass( 'moves-out' );
					$container.removeClass( 'nav-is-visible' ).one( 'transitionend', function(){
						PP.obj.$body.removeClass( 'overflow-hidden' );
					});
				},

				// Open the search form
				openSearchForm: function(){

					if( PP.obj.$searchTrigger.hasClass( 'search-form-visible' ) ) {
						searchForm.find('form').submit();
					} else {
						PP.obj.$html.addClass( 'search-form-visible' );
						PP.obj.$searchTrigger.addClass( 'search-form-visible' );
						PP.obj.$coverLayer.addClass( 'search-form-visible' );
						PP.obj.$searchForm.addClass( 'is-visible' ).one( 'transitionend', function(){
							PP.obj.$searchForm.find( 'input[type="search"]' ).focus().end().off( 'transitionend' );
						});
					}
				},

				// Close the search form
				closeSearchForm: function() {
					PP.obj.$html.removeClass( 'search-form-visible' );
					PP.obj.$searchTrigger.removeClass( 'search-form-visible' );
					PP.obj.$searchForm.removeClass( 'is-visible' );
					PP.obj.$coverLayer.removeClass( 'search-form-visible' );
				},

				// Move navigation in order to make it responsive
				moveNavigation: function(){
					var navigation 	= $( '.nav-primary' ),
			  			screenSize 	= PP.method.checkWindowWidth();

			        if ( screenSize === 'desktop' ) {
						navigation.detach().insertAfter( '.nav-header .brand' );
						navigation.find('.cd-search-wrapper' ).remove();

						// For mobile - Unbind click on main menu item
						$( '.main-menu-item.menu-item-has-children' ).children( 'a' ).off( 'click' );
					} else {
						$( '.cd-search-wrapper' ).remove();

						var newListItem = $('<li class="cd-search-wrapper"></li>');

						navigation.detach().insertAfter( '#page-content' );
						PP.obj.$searchForm.clone().appendTo( newListItem );
						newListItem.appendTo( navigation.find( 'ul' ) );

						// For mobile - Bind click on main menu item
						$( '.main-menu-item.menu-item-has-children' ).children( 'a' ).on( 'click', function( event ){
							if ( $(event.target).is('span') ){
								event.preventDefault();
								PP.method.navigation.openSubmenu( $( this ) );
							}
						});
					}
				},

				// Give a height to all submenus
				calSubmenuHeight: function(){

					$( '.menu-item-has-children ul .sub-menu' ).each( function(){
						var $el = $( this );

						$el.attr( 'data-height', $el.outerHeight() );
					});

				},

				// Give a width to all simple submenus
				calSubmenuWidth: function(){

					$( '.simple-nav > .sub-menu' ).each( function(){
						var $el = $( this ),
							w = 0;

						// Loop throught each submenu item to get the longest value
						$el.find('.sub-menu-item > .sub-menu-link').not('.sub-menu-item ul li .sub-menu-link').each(function(){
							var itemTxt = $(this).text();
							var c = document.createElement("canvas");
							var ctx = c.getContext("2d");

							ctx.font="13px Montserra";

						    var txtW = ctx.measureText(itemTxt).width;

							if (txtW > w) {
								w = txtW;
							}
						});

						$el.css('width', w + 'px');
					});

				},

				// Measure the width of navs to make them horizontally scrollable
				navHorizontalScroll: function(){
					var screenSize = PP.method.checkWindowWidth();

					if ( screenSize !== 'desktop' ){
						$('.horizontal-scroll, .woocommerce-MyAccount-navigation ul').each(function(){
							var $el = $(this),
								w = 0;

							$el.find('li').each(function(){
								w += $(this).outerWidth();
							});

							$el.css('width', w);

						});
					}

				},

				// Call all functions to initiate
				init: function(){

					this.centerLogo();
					this.calSubmenuHeight();
					this.regEventHandlers();
					this.moveNavigation();
					this.navHorizontalScroll();
					// Make it sticky
					$( '.nav-header' ).fixedsticky();

				}

			},

			// Header Slider/Banner
			'slider': {

				// Attached all handlers
				regEventHandlers: function(){
					var slidesWrapper 	= $( '.cd-hero-slider' ),
						sliderNav 		= $( '.cd-slider-nav' ),
						navMarker 		= $( '.cd-marker' ),
						slidesNumber 	= slidesWrapper.children( 'li' ).length,
						visibleSlidePos	= 0,
						autoPlayId,
						autoPlayDelay 	= 5000,
						windowH 		= PP.obj.$window.height() - ( ( $( '.navbar-top' ).length > 0 ) ? $( '.navbar-top' ).outerHeight() : 0 ),
						$this 			= this;

					// Change visible slide
					sliderNav.on( 'click', 'li', function( event ){
						event.preventDefault();

						var selectedItem = $(this);

						if( !selectedItem.hasClass( 'selected' ) ) {
							// if it's not already selected
							var selectedPosition = selectedItem.index(),
								activePosition = slidesWrapper.find( 'li.selected' ).index();

							if( activePosition < selectedPosition) {
								$this.nextSlide(slidesWrapper.find( '.selected' ), slidesWrapper, sliderNav, selectedPosition);
							} else {
								$this.prevSlide(slidesWrapper.find( '.selected' ), slidesWrapper, sliderNav, selectedPosition);
							}

							//this is used for the autoplay
							visibleSlidePos = selectedPosition;

							$this.updateSliderNavigation( sliderNav, selectedPosition );
							$this.updateNavigationMarker( navMarker, selectedPosition + 1 );
							//reset autoplay
							$this.setAutoplay( slidesWrapper, slidesNumber, autoPlayDelay ) ;
						}
					});

				},

				// Go to next slide
				nextSlide: function( visibleSlide, container, pagination, n ){
					visibleSlide.removeClass( 'selected from-left from-right' ).addClass( 'is-moving' ).one( 'transitionend', function(){
						visibleSlide.removeClass( 'is-moving' );
					});

					container.children( 'li' ).eq(n).addClass( 'selected from-right' ).prevAll().addClass( 'move-left' );
					this.checkVideo( visibleSlide, container, n );
				},

				// Go to previous slide
				prevSlide: function( visibleSlide, container, pagination, n ){
					visibleSlide.removeClass( 'selected from-left from-right' ).addClass( 'is-moving' ).one( 'transitionend', function(){
						visibleSlide.removeClass( 'is-moving' );
					});

					container.children( 'li' ).eq(n).addClass( 'selected from-left' ).removeClass( 'move-left' ).nextAll().removeClass( 'move-left' );
					this.checkVideo( visibleSlide, container, n );
				},

				// Add class selected to the new slide
				updateSliderNavigation: function( pagination, n ) {
						var navigationDot = pagination.find( '.selected' );

						navigationDot.removeClass( 'selected' );
						pagination.find( 'li' ).eq( n ).addClass( 'selected' );
					},

					// If class autoplay, make it play
					setAutoplay: function( wrapper, length, delay ) {
						if( wrapper.hasClass( 'autoplay' ) ) {
							clearInterval( autoPlayId );
							autoPlayId = window.setInterval( function(){ this.autoplaySlider( length ) }, delay);
						}
					},

					// Autoplay, nothing more
					autoplaySlider: function( length ) {
						if( visibleSlidePos < length - 1 ) {
							this.nextSlide( slidesWrapper.find( '.selected' ), slidesWrapper, sliderNav, visibleSlidePos + 1 );
							visibleSlidePos +=1;
						} else {
							this.prevSlide( slidesWrapper.find( '.selected' ), slidesWrapper, sliderNav, 0 );
							visibleSlidePos = 0;
						}
						this.updateNavigationMarker( navMarker, visibleSlidePos + 1 );
						this.updateSliderNavigation( sliderNav, visibleSlidePos );
					},

					// Add the video tag
					uploadVideo: function( container ) {
					container.find( '.cd-bg-video-wrapper' ).each(function(){
						var videoWrapper 	= $(this),
							video 			= videoWrapper.find( 'video' ),
							iframe 			= videoWrapper.find( 'iframe' );

						// If video is self hosted
						if( videoWrapper.is( ':visible ') && video.length > 0 ) {
							// play video if first slide
							if ( videoWrapper.parent( '.cd-bg-video.selected' ).length > 0){
								video.get(0).play();
							}
						}

						// If video is embed
						if ( iframe.length > 0 ){
							var iframeSrc 	= iframe.attr( 'src' ).split( '?' )[0],
								iframeH		= parseInt( iframe.attr( 'height' ) ),
								iframeW		= parseInt( iframe.attr( 'width' ) ),
								newW		= videoWrapper.outerWidth(),
								newH 		= ( newW / iframeW ) * iframeH;

							// Check video type
							if ( iframeSrc.indexOf( 'youtube' > -1 ) ){
								videoWrapper.html( '<iframe width="'+newW+'" height="'+newH+'" src="'+iframeSrc+'?version=3&autoplay=1&loop=1&rel=0&wmode=transparent&controls=0&showinfo=0" frameborder="0" allowfullscreen wmode="Opaque"></iframe>' );
							} else if ( iframeSrc.indexOf( 'vimeo' > -1 ) ){
								videoWrapper.html( '<iframe width="'+newW+'" height="'+newH+'" src="'+iframeSrc+'?autoplay=1&loop=1&title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' );
							}

							// Save the new src on the tag itself
							iframe = videoWrapper.find( 'iframe' );

							iframe.attr( 'data-src', iframe.attr( 'src' ) );

							// play video if first slide, if not don't
							if ( videoWrapper.not( ':visible' ) ) {
								iframe.attr( 'src', '' );
							}

						}
					});
				},

				// Check where is the video tag
				checkVideo: function(hiddenSlide, container, n) {
					// Check if a video outside the viewport is playing - if yes, pause it
					var hiddenVideo = hiddenSlide.find( 'video' );
					if( hiddenVideo.length > 0 ) hiddenVideo.get(0).pause();

					// Check if the selected slide contains a video element - if yes, play the video
					var visibleVideo = container.children( 'li' ).eq(n).find( 'video' );
					if( visibleVideo.length > 0 ) visibleVideo.get(0).play();

					// Check if an embed video outside the viewport is playing - if yes, pause it
					var hiddenIframe = hiddenSlide.find( 'iframe' );
					if( hiddenIframe.length > 0 ) hiddenIframe.attr( 'src', '' );

					// Check if the selected slide contains an embed video element - if yes, play the video
					var visibleIframe = container.children( 'li' ).eq(n).find( 'iframe' );
					if( visibleIframe.length > 0 ) visibleIframe.attr( 'src', visibleIframe.attr( 'data-src' ) );
				},

				updateNavigationMarker: function( marker, n ) {
					marker.removeClassPrefix( 'item' ).addClass( 'item-'+n );

					$.fn.removeClassPrefix = function(prefix) {
						//remove all classes starting with 'prefix'
					    this.each(function(i, el) {
					        var classes = el.className.split(" ").filter(function(c) {
					            return c.lastIndexOf(prefix, 0) !== 0;
					        });
					        el.className = $.trim(classes.join(" "));
					    });
					    return this;
					};
				},

				init: function(){
					var slidesWrapper = $('.cd-hero-slider'),
						slidesNumber 	= slidesWrapper.children( 'li' ).length,
						autoPlayDelay 	= 5000;

					if ( slidesWrapper.length > 0 ) {

						// Register the needed event handlers
						this.regEventHandlers();

						// Upload videos (if not on mobile devices)
						this.uploadVideo( slidesWrapper );

						// Autoplay slider
						this.setAutoplay( slidesWrapper, slidesNumber, autoPlayDelay);


					}

				},

			},

			// Everything related to forms (input field, checkbox, spinners...)
			'forms':{

				// Create a Plus/Minus button to update input
				spinner: function(){
					$('[data-spinner]').each(function(){
						var $el = $(this),
							$spinBtn = $el.find('.spinner'),
							$input = $el.find('input'),
							step = parseInt($input.attr('step')),
							min = parseInt(($input.attr('min') === undefined) ? 1 : $input.attr('min')),
							max = parseInt(($input.attr('max') === undefined) ? 9999 : $input.attr('max')),
							newVal = 0;

						$spinBtn.off().on('click', function(){
							var curVal = parseInt($input.val());

							if ($(this).hasClass('up')){
								// Add
								newVal = curVal + step;
								// Check if the threshold is respected
								if (newVal > max){
									// Add tooltip
									$(this).attr('data-original-title', 'Only '+max+' in stock').tooltip('show');
									return false;
								} else {
									// Remove tooltip
									$(this).attr('data-original-title', '');
								}
							} else {
								// Remove
								newVal = curVal - step;
								// Remove tooltip
								$(this).siblings('.up').attr('data-original-title', '');
								// Check if the threshold is respected
								if (newVal < min){
									return false;
								}
							}

							$input.val(newVal).change();
						});
					});
				},

				// Animate the input fields
				animInput: function(){
					$('span.input label').on('click', function(){
						$(this).parent().addClass('focus');
					});
					$('span.input input').on('focus', function(){
						$(this).parent().addClass('focus');
					});
					$('span.input input').on('blur', function(){
						var $el = $(this),
							inputVal = $el.val();

						if (!inputVal && inputVal === ''){
							$(this).parent().removeClass('focus');
						}
					});

					$('span.input').each(function(){
						var $el = $(this),
							inputVal = $el.find('input').val();

						if (inputVal){
							$el.addClass('focus');
						}
					});
				},

				init: function(){

					this.spinner();
					this.animInput();

				},

			},

			// Everything related to cart
			'cart': {

				// Register event handler
				regEventHandlers: function(){

					// Open/close cart
					PP.obj.$body.on( 'click', 'li.cart > a', function () {
						PP.method.cart.popupCart( $( '.offcanvas-cart .widget_shopping_cart' ), 'open' );
						return false;
					});

					// Updating the cart quantity on spinner change
					$( 'body' ).on( 'change', '.cart_list input.qty', function() {
						var $el = $( this );

						// Do not run the timeout if clicked again
						clearTimeout( PP.obj.upd );

						// Set a timeout if click multiple time in a row
						PP.obj.upd = setTimeout( function() {
							PP.method.cart.updateCartQty( $el );
						}, 600);
					});

				},

				// Update the cart item number
				updateCartQty: function( $el ){
					var item_hash 		= $el.attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1"),
						currentVal 		= parseInt( $el.val() ),
						$item 			= $el.parents('.mini_cart_item'),
						$checkoutForm	= $item.parents('form.checkout'),
					    $cart 			= $item.parent();

					// If quantity is 0, remove the item
					if ( currentVal === 0 ){
						$item.slideUp( 400, function(){
							$item.remove();

							if ( $checkoutForm.length > 0 ){
								$( 'form.checkout .cart_list' ).html( $cart.html() );
								// Create the spinner binding
								PP.method.forms.spinner();

								$( 'body' ).trigger( 'updated_shipping_method' ).trigger('update_checkout');
							}
						});
					}

					$.ajax({
						type: 'POST',
						url: woocommerce_params.ajax_url,
						data: {
							action: 'qty_cart',
							hash: item_hash,
							quantity: currentVal
						},
						success: function(data) {
							// Replace cart
							$.each(data.fragments, function(name, value){
								// If the cart is empty
								if ( value.indexOf( 'empty-cart' ) > 0 ){
									// Close the checkout if open
									if ( $( '.offcanvas-cart', window.parent.document ).hasClass( 'expanded' ) ){
										window.parent.location.hash = '#cart';
										parent.location.reload( true );
									}
								}
								// Replace DOM elements
								$(name).replaceWith(value);
							});

							// Check if checkout page and update
							if ( $checkoutForm.length > 0 ){
								$( 'form.checkout .cart_list input[name="' + $el.attr( 'name' ) + '"]' ).val( currentVal );
								$( 'body' ).trigger( 'updated_shipping_method' ).trigger( 'update_checkout' );
							}

							// Update all the pricing
							$( '.cart_list' ).each( function(){
								$( this ).find( '.mini_cart_item' ).each(function(){
									var $item			= $( this ),
										itemNb 			= parseInt( $item.find( 'input.qty' ).val() ),
										symbol			= $item.find( '.item-details .amount .woocommerce-Price-currencySymbol' ).detach(),
										itemPrice 		= parseFloat( $item.find( '.item-details .amount' ).html() ),
										newItemPrice 	= itemPrice * itemNb;

									$item.find( '.item-details .amount' ).prepend( symbol );
									$item.find( '.price .amount' ).text( newItemPrice.toFixed(2) ).prepend( symbol.clone() );
								});
							});
						},
					    error: function (request, status, error) {
					        alert(request.responseText);
					    }
					});
				},

				// Display the cart
				popupCart: function( element, event ){
					if ( event === 'open' ){
						var $cartParent = element.parent();

						if ( ! $cartParent.hasClass( 'cartParent' ) ){
							$cartParent.addClass( 'open' );
							// Create the spinner binding
							PP.method.forms.spinner();
							// Make sure the cart is not longer than the screen
							PP.method.cart.cartMaxHeight();
						}
					} else {
						element.removeClass('open');
					}
				},

				// Run the function to calculate the max-height for the cart (need a separate func as it is call in resize too)
				cartMaxHeight: function(){
					var $cart 		= $( '.offcanvas-cart' ),
						$listItem 	= $cart.find( '#checkout_cart .cart_list' ),
						$navHeader	= $cart.find( '.cart-header' ).outerHeight( true ),
						$total		= $cart.find( 'p.total' ).outerHeight( true ),
						$btn		= $cart.find( '.button.checkout' ).outerHeight( true ),
						cartListsH	= ( $cart.outerHeight() - ( $navHeader + $total + $btn ) );

					$listItem.css( 'max-height', cartListsH );

					if ( $cart.hasClass( 'expanded' ) && ! $cart.hasClass( 'stripe' ) ){
						$cart.find( '.cart-container' ).css( 'height', ( $cart.outerHeight() - ( $navHeader + $total ) ) );
					} else if ( $cart.hasClass( 'stripe' ) ){
						$cart.find( '.cart-container' ).css( 'height', $cart.outerHeight() );
					}
				},

				// Remove a product from the mini cart
				removeProduct: function(){
					$( 'body' ).on( 'click', '.cart_list a.remove', function () {
						var $el = $(this),
							$item = $el.parents( '.mini_cart_item' );

						$.ajax({
							type: 'POST',
							url: woocommerce_params.ajax_url,
							data: {
								action: 'product_remove',
								item_key: $el.parents('.mini_cart_item').find('input.qty').attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1")
							},
							success: function(data) {

								// Delete the item
					            $item.slideUp( 400, function(){
					            	var $checkoutForm 	= $item.parents('form.checkout'),
					            		$cart 			= $item.parent();

									$item.remove();

									// Check if checkout page and update the cart
									if ( $checkoutForm.length > 0 ){
										$( 'form.checkout .cart_list' ).html( $cart.html() );
										// Create the spinner binding
										PP.method.forms.spinner();

										$( 'body' ).trigger( 'updated_shipping_method' ).trigger('update_checkout');
									}
								});

								// Replace cart
								$.each(data.fragments, function(name, value){
									// If the cart is empty
									if ( value.indexOf( 'empty-cart' ) > 0 ){
										// Close the checkout if open
										if ( $( '.offcanvas-cart', window.parent.document ).hasClass( 'expanded' ) ){
											window.parent.location.hash = '#cart';
											parent.location.reload( true );
										}
										// Add the empty class
										$('.offcanvas-cart').addClass('empty');
									}

									$(name).replaceWith(value);
								});

					        },
						    error: function (request, status, error) {
						        alert(request.responseText);
						    }
						});

						return false;
					});

				},

				// Ajax call to dynamically add the product to cart
				ajaxToCart: function($container, productId, productSku, variationId, variation, qty){
					clearTimeout( PP.obj.cartDismiss );

					$('<div class="loading-overlay"><p class="loading"></p></div>').appendTo($container);

					$.ajax({
						type: 'POST',
				        dataType: 'json',
						url: woocommerce_params.ajax_url,
						data: {
							action: 'woocommerce_add_to_cart_variable_rc',
							quantity: qty,
							product_id: productId,
							product_sku: productSku,
							variation_id: variationId,
							variation: variation
						},
						success: function(data) {
							if (data.error === true){
								var $modal = $('#message-modal');

								$modal.find('.content').html('<h4>'+data.title+'</h4><p>'+data.message+'</p>');
								$modal.addClass('error').modal('show');
								$container.find('a.cart_button').removeClass('icon-cart').addClass('icon-cart-line');
							} else {
								var cart_hash = data.cart_hash;

								// Replace cart
								$.each(data.fragments, function(name, value){
									$(name).replaceWith(value);
									$( '.offcanvas-cart' ).removeClass( 'empty' ).find( '[data-toggle="tooltip"]').tooltip({ container: 'body' });
								});

								// Retina the imgs
								$('nav.navbar li.mini_cart_item img').each(function(){
									PP.method.global.retinaImg( $(this), false );
								});

								// Animate cart and add a message
								$('<p class="message show">The item has been added to your cart</p>').insertBefore('.widget_shopping_cart .cart_list');

								// Open cart
								PP.method.cart.popupCart( $( '.offcanvas-cart .widget_shopping_cart' ), 'open' );

								// Scroll to the newly added item in the cart
								$( '.widget_shopping_cart .cart_list' ).scrollTo( $( '.mini_cart_item:last-child' ), 300 );

								// Delete message after 2s
								setTimeout(function(){
									$('.widget_shopping_cart .message').remove();
								}, 2000);

								// Close the cart after 2.5s
								PP.obj.cartDismiss = setTimeout(function(){
									if (PP.obj.cartDismiss){
										PP.method.cart.popupCart( $( '.offcanvas-cart' ), 'close' );
									}
								}, 2500);

								// Do not close it if mouse over
								$('.offcanvas-cart').one('mouseover', function(){
									clearTimeout( PP.obj.cartDismiss );
								});

							}
							$container.find('.loading-overlay').remove();
						}
					});
				},

				// Archive products add to cart function
				addToCart: function(){
					$('.add_to_cart_button').off().on('click', function(){
						var $el = $(this),
							$container = $el.parents( 'li.product' ),
							$item = $container.find( '.slick-track .slick-active a' ),
							url = $el.attr( 'href' ),
							url = url.split( '?' ),
							param = ( ( url[1] !== undefined ) ? url[1].split( '&' ) : '' ),
							variation = {},
							variationId = '',
							productId = $el.attr( 'data-product_id' ),
							productSku = $el.attr( 'data-product_sku' );

						// Hide tooltip
						$( '[data-toggle="tooltip"]' ).tooltip( 'hide' );

						// Do nothing if out of stock
						if ( $el.hasClass('out-of-stock') ){
							return false;
						}

						// Change container if not a variable product
						if ( !$container.hasClass('product-type-variable') ){
							$item = $container.find( 'a.img' );
						} else {
							// Set correct variationID
							variationId = $item.attr( 'data-variation-id' );

							$.each(param, function(key, value){
								var sanitized = value.replace('attribute_pa_', '').replace('attribute_', ''),
									attribute = sanitized.split('=');

								variation[ attribute[0] ] = attribute[1];
							});
						}

						if ( $el.hasClass('select-options') ){
							var $options = $el.parents( 'li.product' ).find('section.variation-options'),
								$content = $options.find('.content'),
								$confirmBtn = $content.find('a.button'),
								selected = false;

							// Reset previous selection
							$options.find('input:checked').attr( 'checked', false );
							$options.find('label.selected').removeClass( 'selected' );

							PP.method.product.filterVariationAttributes( $el, '',true );

							$options.addClass('open');

							$confirmBtn.off().on('click', function(){
								$content.find('.option').each(function(){
									var $option = $(this);

									$option.find('input').each(function(){
										var $input = $(this);

										if( $input.is(':checked') ) {
											var key = $input.attr('name').replace('attribute_pa_', '').replace('attribute_', '').replace('pa_', ''),
												val = $input.val();

											variation[ key ] = val;

											selected = true;

											return false;
										} else {
											selected = false;
										}
									});

									if ( !selected ){
										$option.find('h4').addClass('error').one('animationend', function(){
											$(this).removeClass('error');
										});
									}
								});

								if (selected) {
									$el.removeClass('icon-shopping-bag-add').addClass('icon-shopping-bag');
									$options.removeClass('open');
									PP.method.cart.ajaxToCart($container, productId, productSku, variationId, variation, 1);
								}

								return false;
							});
						} else {
							$el.removeClass('icon-shopping-bag-add').addClass('icon-shopping-bag');
							PP.method.cart.ajaxToCart($container, productId, productSku, variationId, variation, 1);
						}

						return false;
					});
				},

				init: function(){

					this.regEventHandlers();
					this.removeProduct();
					this.addToCart();

					// Retina the imgs
					$('nav.navbar li.mini_cart_item img').each(function(){
						PP.method.global.retinaImg( $(this), false );
					});

				},
			},

			// Functions related to login ( display popup, AJAX call, replace parts... )
			'login': {

				// Replace the top bar when login in
				replaceTopBarMenu: function( $loginForm, $submitBtn, submitBtnTxt ){
					$('ul.navbar-right').load(document.URL + ' ul.navbar-right > *', function(){
						// Replace cart
						$.ajax({
							type:'POST',
							url: '\/?wc-ajax=get_refreshed_fragments',
							success:function(data){
								$.each(data.fragments, function(name, value){
									if ( name !== 'div.widget_shopping_cart_content' ){
										$(name).replaceWith(value);
									}
								});
							}
						});
						setTimeout(function(){
			              	// Reset the login button
			              	$submitBtn.removeAttr('disabled').html(submitBtnTxt).removeClass('message show');
			            }, 500);

		              	PP.obj.$body.addClass('logged-in');
		           });
				},

				// Perform AJAX login on login form submit
				ajaxLogin: function( $loginForm, ajax ){

			    	var $submitBtn = $loginForm.find('.submit'),
						submitBtnTxt = $submitBtn.text(),
						lodingMessage = $submitBtn.attr('data-message'),
						$rememberChkb = $loginForm.find('input.remember');

					// Change the button text to let message to the user
				    $submitBtn.addClass('load').html('<p class="loading"></p>' + lodingMessage);

				    // Remove the helper
				    $loginForm.find( '.woocommerce-password-strength' ).remove();


					if ( $loginForm.parents( '#wc-product-reviews-pro-modal' ).length === 0 || $loginForm.attr( 'id' ) === 'password' &&  $loginForm.parents( '#wc-product-reviews-pro-modal' ).length > 0 ){

				        $.ajax({
				            type: 'POST',
				            dataType: 'json',
				            url: woocommerce_params.ajax_url,
				            data: {
				                'action': $loginForm.attr('action'),
								'username': $loginForm.find('input.username').val(),
				                'email': $loginForm.find('input.email').val(),
				                'order_id': $loginForm.find('input.order_id').val(),
				                'password': $loginForm.find('input.password').val(),
				                'remember': ( ($rememberChkb.is(':checked')) ? $rememberChkb.val() : '' ),
				                'security': $loginForm.find('#security').val()
				            },
				            success: function(data){
				                if (data.successful === true){
				                	// Success message
				                	$submitBtn.removeClass('load').addClass('message show').html(data.message).attr('disabled', 'disabled');

									if ( ajax ){

										// When login from the checkout form - Update the form
										if ( ajax === 'reloadForm' ){

											// Replace the NEW CONTENT
											$.ajax({
											   url: wc_cart_params.checkout_page,
											   type: 'GET',
											   data: {
												 ajax_request: 'true'
											   },
											   success: function(data){
											   		// Replace customer details form
											   		$( '#checkout_details' ).html( $( data ).find( '#checkout_details' ).html() );

											   		// Replace the nonce to make everything work
											   		$( '#checkout_review .place-order #_wpnonce' ).replaceWith( $( data ).find( '#checkout_review .place-order #_wpnonce' ) );

											   		// We are now logged in, say it
											   		$( 'body' ).addClass( 'logged-in' );
											   },
											   complete: function(){

												   // Style the select box
												   $( 'select#billing_country, select#shipping_country, select#billing_state' ).select2();

												   // Check if "shipping to different address" is ticked
												   if ( $( 'input[name="ship_to_different_address"]' ).not( ':checked' ) ){
													   $( 'div.shipping_address' ).css( 'display' , 'none' );
												   }

												   // Update the variable nonce in order to update_checkout to work
												   wc_checkout_params.update_order_review_nonce = $( '#checkout_details #_wpnonce' ).val();

													// Functions for the checkout UI
													PP.method.checkout.shippingCountry();

													// Making sure it calculates the right selections
													$( 'select#billing_country, select#shipping_country' ).trigger( 'change' );

												   // Re-calculate the section height
												   PP.method.checkout.viewHeight();
											   }
											});

											$loginForm = $( 'form#login' );

										}

										// Replace the right to bar (account menu, favs, cart)
										PP.method.login.replaceTopBarMenu( $loginForm, $submitBtn, submitBtnTxt );

										if ( $loginForm.parents( '#create-account' ).length > 0 ){
											setTimeout(function(){
												$loginForm.parents( '#create-account' ).next( '#signup-form' ).removeClass( 'col-md-6' ).addClass( 'col-md-12' );
												$loginForm.parents( '#create-account' ).remove();
											}, 1500);
										}
									} else {
										redirect = $loginForm.find('input[name=redirect_to]').val();

										if ( redirect === '' || redirect === undefined ){
											redirect = PP.method.global.getUrlParameter('redirect');
										}

										window.location = redirect;
									}

				                } else if (data.requestPwd === true) {
				                	// Success message
				                	$submitBtn.removeClass('load').addClass('message show').html(data.message).attr('disabled', 'disabled');

				                	setTimeout(function(){
				                		$loginForm.find('a.lost').click();
				                		$submitBtn.removeClass('message show').html(submitBtnTxt).removeAttr('disabled');
				                	}, 3000);
				                } else {
					                $submitBtn.removeClass('load').addClass('message show error').html(data.message).attr('disabled', 'disabled');
					                $loginForm.find('input').one('keyup', function(){
						                $submitBtn.html(submitBtnTxt).removeClass('message show error').removeAttr('disabled');
					                });
				                }
				            },
							complete: function(){
								if (ajax === 'popup'){
									setTimeout(function(){
										$('#login-modal').modal( 'hide' );
									}, 1200);
								}
							},
				            error: function(xhr, ajaxOptions, thrownError){
					            $submitBtn.removeClass('load').addClass('message show error').html(xhr.responseText).attr('disabled', 'disabled');
					            $loginForm.find('input').one('keyup', function(){
					                $submitBtn.html(submitBtnTxt).removeClass('message show error').removeAttr('disabled');
				                });
				            }
				        });

					} else {
						setTimeout(function(){
							PP.method.login.replaceTopBarMenu( $loginForm, $submitBtn, submitBtnTxt );
						}, 3000);
					}
				},

				// Check for URL parameter
				loginRegisterForms: function(){
				    $('div.wrap-form form').on('submit', function(){

				    	if ( PP.method.global.getUrlParameter('login') === 'true' && PP.method.global.getUrlParameter('redirect') !== '' ){
					    	PP.method.login.ajaxLogin( $(this), false );
				    	} else {
					    	PP.method.login.ajaxLogin( $(this), 'popup' );
						}

				        return false;
				    });
				},

				// Toggle the login/register forms
				modalForm: function(){
					// Toggle between forms
					$('a.toggle-btn').on('click', function(){
						var $toggleBtn = $(this),
							$modalParent = $toggleBtn.parents( '.login-modal' )
							target = $toggleBtn.attr('data-target'),
							switchPanel = $toggleBtn.attr('data-switch');

						// Hide all
						$modalParent.find('.wrap-form form').addClass('hide');

						// Display the targeted form
						$modalParent.find('.wrap-form form' + target).removeClass('hide').one('animationend', function(){
							$(this).find('input.email').focus();
						});

						// If the panel need to change
						if (switchPanel !== ''){
							$toggleBtn.parents('.toggle-view').addClass('hide');
							$modalParent.find(switchPanel).removeClass('hide');
						}

						// If it is the tabs style popup
						if ( $('#login-tabs').length > 0 ){
							$('#login-tabs a.toggle-btn').removeClass('active');
							$('#login-tabs a.toggle-btn[data-target='+target+']').addClass('active');
						}

						return false;
					});

					// When entering the password to register, make sure submit button is not clickable
					$( '#reg_password' ).on('keyup', function(){
						var $input = $(this),
							$btn = $input.parents('#registration').find('button');

						setTimeout(function(){
							var $strength = $input.next('.woocommerce-password-strength');

							if ( $strength.length > 0 && ( $strength.hasClass('short') || $strength.hasClass('bad') ) ){
								$btn.attr( 'disabled', 'disabled' );
							} else {
								$btn.removeAttr( 'disabled' );
							}
						}, 100);
					});

					// Once the modal is opened
					$('#login-modal').on('shown.bs.modal', function (e) {
						setTimeout(function(){
							$('#login-modal').addClass('open').find('form:not(.hide) input.email').focus();
						}, 300);
					});

					// Once the modal is closed
					$('#login-modal').on('hide.bs.modal', function (e) {
						$(this).removeClass('open');
					});
				},

				init: function(){

					this.loginRegisterForms();
					this.modalForm();

				},

			},

			// Functions related to the shop page and product page
			'product': {

				// Register event handler
				regEventHandlers: function(){
					var _this = this;

					$('#toggle-offcanvas-sidebar').on('click', function(){
						var $parent  = $(this).parents('#page-content'),
							parentH  = $parent.height(),
							sidebarH = $('aside.sidebar').outerHeight();

						if ( $parent.hasClass('sidebar-open') ){
							$parent.removeAttr('style').removeClass('sidebar-open');
						} else {
							if ( sidebarH > parentH ){
								$parent.css('height', sidebarH);
							}
							$parent.addClass('sidebar-open');
						}
					});

					$('.yith-wcwl-add-button').on('click', function(){
						var $container = $(this).parents('li.product');

						_this.addToFav($container);
					});



					$('.delete-once-added-cart .cart_button').on('click', function(){
						var $container = $(this).parents('.product');

						$container.find('.product-remove a.remove').trigger('click');
					});

				},

				// Adding product to wishlist - Add loader and reload the icons
				addToFav: function($container){
					// Add loader
					$('<div class="loading-overlay"><p class="loading"></p></div>').appendTo($container);

					// Wait for the yith wishlist ajax request to finish
					$( document ).one('ajaxComplete', function( event, xhr, settings ) {
						var response = $.parseJSON( xhr.responseText );

						if ( response.result === 'true' ){
							// Replace the top bar wishlist icon
							if ( $('ul.navbar-right .wishlist').length > 0 ){
								$('ul.navbar-right .wishlist').load(document.URL + ' ul.navbar-right .wishlist > *', function(){
									// Remove loader
									$container.find('.loading-overlay').remove();
								});
							}

							// Replace the header wishlist icon
							if ( $('.nav-header .header-buttons .wishlist').length > 0 ){
								$('.nav-header .header-buttons .wishlist').load(document.URL + ' .nav-header .header-buttons .wishlist > *', function(){
									// Remove loader
									$container.find('.loading-overlay').remove();
								});
							}
						}
					});
				},

				// YITH Wishlist compatibility - Remove to list when added to cart
				removeToFav: function(){

				},

				// Add a class if one or more variations need to be selected on single variation products - Change the link
				singleVariationProduct: function(){
					$('li.product_variation').each(function(){
						var $product = $(this),
							$item = $product.find( 'a.img' ),
							addCartUrl = $item.attr('href'),
							variationCounter = $item.attr('data-attr-counter'),
							variations = '?',
							moreOption = '';

						if (variationCounter > 1 && !$item.hasClass( 'out-of-stock' ) ) {
							moreOption = 'select-options';
						}

						// Change the add to cart button
						$product.find('nav.buttons a.cart_button').addClass(moreOption).attr( 'href', addCartUrl );
					});
				},

				// Slider for the variation products
				productSlider: function(){
					var $sliders = $('.product-slider'),
						$productsList = $sliders.parents( 'ul.products' ),
						sliderP = '22%';

					// Check the product styly
					if ($productsList.hasClass('product-style-2') || !$productsList.hasClass('display-3-per-row')) {
						sliderP = '0px';
					}

					// Slick Slider
					$sliders.slick({
						accessibility: true,
						arrows: true,
						dots: true,
						centerMode: true,
						resize: true,
						centerPadding: sliderP,
						prevArrow: '<button type="button" class="slick-prev"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></button>',
						nextArrow: '<button type="button" class="slick-next"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>'
					});

					// Change the slide details on slider change event
					$sliders.on('afterChange', function(event, slick, currentSlide) {
						// Get instance
						PP.method.product.slideDetails($(this), currentSlide);
					});

					// Avoid the flick of stacked images on load
					$sliders.css( 'opacity', 1 );
					$('.product-type-simple a.img').css( 'opacity', 1 );

					$sliders.each(function(){
						var $slider		= $(this),
							$container	= $slider.parents( 'ul.products' ),
							sliderW		= $slider.find('img:first').innerWidth();

						if ( sliderW === 0 ) { sliderW = 'auto'; }

						// Dynamically add the correct image width
						if ( $container.hasClass( 'product-style-1' ) ) {
							$slider.find( '.slick-track .slick-slide' ).css('width', sliderW);
						}

						// Run setupDetails on flickity init
						PP.method.product.slideDetails( $slider, $slider.find('.slick-active').attr('data-slick-index') );
					});
				},

				// Setting up the correct product details on the current slide
				slideDetails: function( $slider, slideIndex ){
					var $container		 = $slider.parents( 'li.product' ),
						$currentSlide	 = $slider.find('.slick-slide[data-slick-index="'+ slideIndex +'"]'),
						priceHtml 		 = $currentSlide.find( '.price' ).html(),
						$item 			 = $currentSlide.find( 'a' ),
						$cartBtn 		 = $container.find('nav.buttons a.cart_button'),
						addCartUrl 		 = $item.attr('href'),
						inStock 		 = $item.data( 'stock-class' ),
						variationCounter = $item.data( 'attr-counter' );

					if ( inStock === false ){
						$cartBtn.removeClass( 'icon-shopping-bag-add select-options' ).addClass( 'icon-shopping-bag out-of-stock' ).attr( 'data-original-title', $cartBtn.data( 'nostock-text' ) );
					} else {
						$cartBtn.removeClass( 'icon-shopping-bag out-of-stock' ).addClass( 'icon-shopping-bag-add' ).attr( 'data-original-title', $cartBtn.data( 'stock-text' ) );

						if ( variationCounter > 1 ) {
							$cartBtn.addClass( 'select-options' );
						}
					}

					// Change to the correct pricing
					$container.find( '.product-meta .price' ).html( priceHtml );

					// Change the add to cart button
					$cartBtn.attr( 'href', addCartUrl );
				},

				// Select variations on the shop page
				selectVariations: function(){
					$('.variation-options').on('change', 'input', function(){
						var $input = $(this);

						if( $input.is(':checked') ){
							$input.parents('.option').find('label').removeClass('selected');
							$input.next().addClass('selected');

							PP.method.product.filterVariationAttributes( $input, $input.parents( '.option' ), false );
						}
					});
				},

				// Display the correct available attributes depending on item and other attribute selection
				filterVariationAttributes: function( $el, exclude, opening ){
					var $container = $el.parents( 'li.product' ),
						$item = $container.find( '.slick-track .slick-active a' ),
						current_settings = {},
						$product_variations = $container.find( '.product-slider' ).data( 'product_variations' ),
						$options = $container.find('section.variation-options');

					// If is empty, it has no slider
					if ( $item.length === 0 ){
						$item = $container.find( '.img' );
						$product_variations = $item.data( 'product_variations' );
					}

					// Get the variation name
					current_settings[ $item.data( 'attr-name-1' ) ] = $item.data( 'attr-value-1' );

					if ( !opening ){
						$options.find( 'tr.option' ).each( function() {
							var $selected = $( this ).find( 'input:checked' );

							// Add to settings array
							if ( $selected.length > 0 ){
								current_settings[ 'attribute_' + $selected.attr( 'name' ) ] = $selected.val();
							} else {
								current_settings[ $( this ).data( 'attribute_name' ) ] = '';
							}
						});
					}

					var variations = PP.method.product.wc_variation_form_matcher.find_matching_variations( $product_variations, current_settings );

					// Loop through selects and disable/enable options based on selections
					$options.find( 'tr.option' ).each( function( index, el ) {

						if ( $(this).is(exclude) ){
							return true;
						}

						var current_attr_name,
							current_attr_select = $( el );

						// Reset options
						if ( ! current_attr_select.data( 'attribute_options' ) ) {
							current_attr_select.data( 'attribute_options', current_attr_select.find( 'li' ).get() );
						}

						current_attr_select.find( 'li' ).remove();
						current_attr_select.find( 'ul' ).append( current_attr_select.data( 'attribute_options' ) );
						current_attr_select.find( 'input' ).removeClass( 'attached enabled' ).removeAttr( 'disabled' );

						// Get name from data-attribute_name
						current_attr_name = current_attr_select.data( 'attribute_name' );

						// Loop through variations
						for ( var num in variations ) {

							if ( typeof( variations[ num ] ) !== 'undefined' ) {

								var attributes = variations[ num ].attributes;

								for ( var attr_name in attributes ) {
									if ( attributes.hasOwnProperty( attr_name ) ) {
										var attr_val = attributes[ attr_name ];

										if ( attr_name === current_attr_name ) {

											var variation_active = '';

											if ( variations[ num ].variation_is_active ) {
												variation_active = 'enabled';
											}

											if ( attr_val ) {

												// Decode entities
												attr_val = $( '<div/>' ).html( attr_val ).text();

												// Add slashes
												attr_val = attr_val.replace( /'/g, '\\\'' );
												attr_val = attr_val.replace( /"/g, '\\\"' );

												// Compare the meerkat
												current_attr_select.find( 'input[value="' + attr_val + '"]' ).addClass( 'attached ' + variation_active );

											} else {

												current_attr_select.find( 'input' ).addClass( 'attached ' + variation_active );

											}
										}
									}
								}
							}
						}

						// Detach unattached
						current_attr_select.find( 'input:not(.attached)' ).parent().remove();

						// Grey out disabled
						current_attr_select.find( 'input:not(.enabled)' ).attr( 'disabled', 'disabled' );

					});
				},

				// Matches inline variation objects to chosen attributes -- Took from WC/assets/js/frontend/add-to-cart-variation.js
				wc_variation_form_matcher: {

					find_matching_variations: function( product_variations, settings ) {
						var matching = [];
						for ( var i = 0; i < product_variations.length; i++ ) {
							var variation    = product_variations[i];

							if ( PP.method.product.wc_variation_form_matcher.variations_match( variation.attributes, settings ) ) {
								matching.push( variation );
							}
						}
						return matching;
					},

					variations_match: function( attrs1, attrs2 ) {
						var match = true;
						for ( var attr_name in attrs1 ) {
							if ( attrs1.hasOwnProperty( attr_name ) ) {
								var val1 = attrs1[ attr_name ];
								var val2 = attrs2[ attr_name ];
								if ( val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
									match = false;
								}
							}
						}
						return match;
					}
				},

				// Make the products color filterable when single variation product is displayed
				checkFilterColor: function(){
					var url = window.location.href;

					if (url.indexOf('/colors/') > 0){
						var colors = url.split('colors/');

						colors = colors[1].replace('/', '').split('/');

						// Check if there are multiple colors selected
						if (colors[0].indexOf('-') > 0){
							colors = colors[0].split('-');
						}

						$('li.product .product-slider').each(function(){
							var $product = $(this),
								$slides = $product.find('.owl-item:not(.cloned) a.img'),
								itemCount = 0,
								variationTxt = $slides.attr( 'data-attr-name-1').replace('attribute_pa_', '').replace('attribute_', '');

							$slides.each(function(){
								var $el = $(this),
									productColors = $el.attr('data-colors').split(',');

								$.each(productColors, function(index, productColor){
									$.each(colors, function(index, filteredColor){
										if ( filteredColor !== productColor ){
											// Mark the slide to delete
											if ( !$el.hasClass( 'keep' ) ){
												$el.addClass( 'remove' );
											}
										} else {
											$el.removeClass( 'remove' ).addClass( 'keep' );
											itemCount++;
										}
									});
								});

							});

							// Removing the marked slides
							$product.trigger('destroy.owl.carousel')
									.html( $product.find('.owl-stage-outer').html() ).removeClass( 'owl-loaded' )
									.find( '.remove' ).each( function(){
										$( this ).parent().remove();
									});

							// Rebuild the carousel - If one slide do not use the loop option
							if ( itemCount === 1 ){
								$product.owlCarousel({
								    items: 1,
									center:true,
									nav: false,
									navText: [ '', '' ],
									dots: false,
									mouseDrag: false
								});

								// If the last character is a S remove it
								var l = variationTxt.length,
									lastChar = variationTxt.substring(l-1, l);
								if (lastChar == "s") {
									variationTxt = variationTxt.substring(0, l-1);
								}
							} else {
								$product.owlCarousel({
									items: 1,
									loop: true,
									center:true,
									nav: true,
									navText: [ '', '' ],
									navClass: [ 'owl-prev icon-left-arrow', 'owl-next icon-right-arrow' ],
									dots: false,
									mouseDrag: false
								});
							}

							// Update the number of item
							$product.parents( 'li.product' ).find( 'span.variation' ).html( itemCount + ' ' + variationTxt );

						});
					}
				},

				// Select product variations on single product page
				selectProductVariation: function(){

					// Stopped if not a single product page
					if ( ! PP.obj.$body.hasClass( 'single-product' ) ){
						return false;
					}

					var $form = $( 'form.cart' ),
						$mainSlider = $( '#main-slider' ),
						$thumbSlider = $( '#thumb-slider' );

					// Check if the product style layout has a vertical thumbnails slider
					if ($form.parents('.style-vertical-thumb').length > 0){
						// Wait for main slider to initiate
						$thumbSlider.on('init', function(){
							$thumbSlider.css({ height: $mainSlider.outerHeight() });
						});
					}

					// Initialize the slick sliders
					$mainSlider.slick({
						prevArrow: '<button type="button" class="slick-prev"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></button>',
						nextArrow: '<button type="button" class="slick-next"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>'
					});

					$thumbSlider.slick({
						prevArrow: '<button type="button" class="slick-prev"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></button>',
						nextArrow: '<button type="button" class="slick-next"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>'
					}).css('opacity',1);

					// Ajax add to cart
					$form.on( 'submit', function(){
						var $container = $form.parent(),
							$selectBoxes = $container.find( 'table.variations select' ),
							productId = $container.find( 'input[name="add-to-cart"]' ).val(),
							variationId = $container.find( 'input[name="variation_id"]' ).val(),
							variation = {},
							qty = $container.find( 'input[name="quantity"]' ).val(),
							selected = false,
							productSku = '';

						if ($selectBoxes.length > 0){
							$selectBoxes.each( function(){
								var $selectbox = $( this ),
									key = $selectbox.attr( 'name' ).replace('attribute_pa_', '').replace('attribute_', ''),
									val = $selectbox.find('option:selected').val();

								if ( val === '' || val === undefined || val === null) {
									$selectbox.addClass( 'error' ).one( 'focusin touchstart', function(){
										$( this ).removeClass( 'error' );
									});
									selected = false;
								} else {
									variation[ key ] = val;
									selected = true;
								}
							});
						} else {
							selected = true;
						}

						if ( selected ){
							PP.method.cart.ajaxToCart($container, productId, productSku, variationId, variation, qty);
						}

						return false;
					});

					// Unbind any existing events
					//$form.off( 'change focusin', '.variations select' );

					// Reset first load from WC default func
					//$form.trigger( 'reset_data' );

					// On changing an attribute
					$form.on( 'change', '.variations select', function() {

						// added to get around variation image flicker issue
						$( '.product.has-default-attributes #main-slider' ).fadeTo( 200, 1 );

						// Custom event for when variation selection has been changed
						$form.trigger( 'woocommerce_variation_has_changed' );
					});

					// Trigger a change
					$form.find( '.variations select' ).trigger( 'change' );

					// Move the variation description in the tab
					$form.on('found_variation', function(event, variation){

						switchContent(variation);

					}).on( 'hide_variation', function() {
						if ( $( '.single_variation' ).css( 'display' ) === 'block' ){
							$( '.single_variation_wrap .regular_price' ).delay( 200 ).slideDown( 200 );
						}
					});

					function switchContent(variation){
						// Display the variation description if any
						var $variationPrice = $( '.single_variation .woocommerce-variation-price' ),
							$variationWrap = $( '.single_variation_wrap' ),
							$saleBadge = $('.product-type-variable .container .single-product-sale'),
							$selectVar = $mainSlider.closest('.product').find('.summary .variations select'),
							$slideVar = false,
							slideIndex;

						// Check if a variation is selected
						if (variation) {
							// Find the image with the same title as the variation selected
							if (variation.image_title !== ''){
								$slideVar = $mainSlider.find('img[data-image-title="'+ variation.image_title +'"]'),
								slideIndex = $slideVar.parents('.item').attr('data-slick-index');
							}

							// Get correct pricing
							if (variation.price_html) {
								// Hide global price
								$variationWrap.find( '.regular_price' ).hide();
								$variationPrice.html( variation.price_html );
								$variationWrap.removeClass('availability');
							} else if (variation.availability_html){
								$variationWrap.addClass('availability');
							}

							// Show sale badge if variation is on sale
							if (variation.price_html.includes('del')) {
								$saleBadge.show();
							} else {
								$saleBadge.hide();
							}

						} else {
							var triggerChange = false;

							// If the page loads with all selected variations, trigger a change
							$selectVar.each(function(){
								var $sel = $(this);

								if ($sel.val() !== '') {
									triggerChange = true;
								} else {
									triggerChange = false;
								}
							});

							if (triggerChange){
								$selectVar.change();
							}

						}

						// If image with title or alt exists - display it
						if ($slideVar && $slideVar.length > 0) {
							// Main slider moves to the slide
							$mainSlider.slick( 'slickGoTo', slideIndex );
						} else {
							// Set the first slider image to the chosen variation
							var $product = $mainSlider.closest('.product'),
								$product_img = $product.find( '#main-slider .item[data-slick-index="0"] img' ),
								$product_link = $product.find( '#main-slider .item[data-slick-index="0"] a.zoom' );

							if ( variation && variation.image_src && variation.image_src.length > 1 ) {
								$product_img.wc_set_variation_attr( 'src', variation.image_src );
								$product_img.wc_set_variation_attr( 'title', variation.image_title );
								$product_img.wc_set_variation_attr( 'alt', variation.image_alt );
								$product_img.wc_set_variation_attr( 'srcset', variation.image_srcset );
								$product_img.wc_set_variation_attr( 'sizes', variation.image_sizes );
								$product_link.wc_set_variation_attr( 'href', variation.image_link );
								$product_link.wc_set_variation_attr( 'title', variation.image_caption );

								// Change the first slider image
								$thumbSlider.find( '.thumb[data-slick-index="0"] img' ).attr({
									src: variation.image_src,
									srcset: variation.image_srcset
								});

								// Main slider moves to first slide
								$mainSlider.slick( 'slickGoTo', 0 );
							} else {
								$product_img.wc_reset_variation_attr( 'src' );
								$product_img.wc_reset_variation_attr( 'title' );
								$product_img.wc_reset_variation_attr( 'alt' );
								$product_img.wc_reset_variation_attr( 'srcset' );
								$product_img.wc_reset_variation_attr( 'sizes' );
								$product_link.wc_reset_variation_attr( 'href' );
								$product_link.wc_reset_variation_attr( 'title' );
							}

						}

					}

					switchContent();

				},

				// Change hashtag when clicking on description or review link
				singleProductDesc: function(){
					$( 'a.woocommerce-desc-link, a.woocommerce-review-link' ).click( function() {
						window.location.hash = '';
						window.location.hash = $(this).attr( 'href' );

						return false;
					});
				},

				// Interaction for the product review pro plugin
				productReviewAction: function(){
					// Close the flag form
					$( '.contribution-flag-form button.cancel' ).on( 'click', function(){
						$( this ).parents( '.contribution-flag-form' ).slideUp( 250 );
					});

					// Toggle the comments and form
					$( '.toggle-comment' ).on( 'click', function(){
						$( this ).parents( 'li.review' ).find( 'ul.children, .form-contribution_comment' ).slideToggle( 250 );
					});

					// Display the follow thread checkbox on textarea focus
					$( '#question_comment' ).on( 'focus', function(){
						$( this ).parents( '#question_form_wrapper' ).find( '.subscribe_to_replies' ).slideDown( 250 );
					});

					// Remove the unrelated comments
					$( '#tab-reviews li.question' ).remove();
					$( '#tab-questions li.review' ).remove();

					// Rename the form for the question tab
					$( '#tab-questions .form-contribution_comment #contribution_comment_comment' ).attr( 'placeholder', $( '.answer-placeholder' ).val() );
					$( '#tab-questions .form-contribution_comment button.button' ).text( $( '.answer-button' ).val() );

					// Answer question form
					$( 'a.open_answer_form' ).on( 'click', function(){
						var $container = $( this ).parents( '.comment_container' );

						$container.append( $( this ).parents( 'li.question' ).find( 'form.form-contribution_comment' ) );
					});
				},

				// On Ajax product filtering
				productsFiltered: function(){
					$('select.orderby, select.wppp-select').select2({
					  minimumResultsForSearch: Infinity
					});
				},

				// Call to reload functions needed for the products
				reloadProductJS: function(){
					this.productSlider();
					this.checkFilterColor();
					this.productsFiltered();
					this.selectVariations();
					this.singleVariationProduct();

					PP.method.cart.addToCart();

					$('li.product [data-toggle="tooltip"]').tooltip({ container: 'body' });

				},

				init: function(){

					this.regEventHandlers();
					this.productSlider();
					this.selectVariations();
					this.singleVariationProduct();
					this.checkFilterColor();
					this.singleProductDesc();
					this.productReviewAction();
					this.productsFiltered();
					this.selectProductVariation();

					$('#comments_filter').select2({
						minimumResultsForSearch: Infinity
					});

				},

			},

			// Functions related to the checkout process
			'checkout': {

				// Register event handler
				regEventHandlers: function(){

					// Checkout Steps
					PP.obj.$body.on( 'click', '.cart-nav a', function () {
						var $btn		= $( this ),
							$parentBtn 	= $btn.parent(),
							$prevBtn	= $parentBtn.prev(),
							view		= $btn.attr( 'href' );

						// If clicked in the cart state - Open checkout and exit this function
						if ( $btn.parents( '.expanded' ).length ===0 ){
							window.location.hash = '#checkout';

							return false;
						}

						// Check if we click few steps away
						if ( $prevBtn.length > 0 && ! $prevBtn.hasClass( 'selected' ) && ! $prevBtn.hasClass( 'visited' ) ){
							$prevBtn.find( 'a' ).click();
							return false;
						}

						// Change the checkout section
						PP.method.checkout.views( view );

						return false;
					});

					// Checkout button
					$( '.offcanvas-cart.quick-checkout' ).on( 'click', '.button.checkout', function(){
						$( this ).append( '<p class="loading" />' ).addClass( 'load' );

						window.location.hash = '#checkout';

						return false;
					});

					// Close checkout button
					$( '.offcanvas-cart' ).on( 'click', '.close-cart', function(){
						PP.method.checkout.closeQuickCheckout( false );
					});

					// Create account checkout
					$( '.offcanvas-cart' ).on( 'change', 'input#createaccount', function(){
						var $el  = $( this ),
							$box = $el.parent().next();

						if ( $el.is( ':checked' ) ){
							$box.slideDown( 300, function(){
								PP.method.checkout.viewHeight();
							});
						} else {
							$box.slideUp( 300, function(){
								PP.method.checkout.viewHeight();
							});
						}

					});

					// Re-shuffle the layout when address selected
					$( 'a.js-show-address-fields' ).on( 'click', function(){
						$( 'select#billing_country' ).select2();
						$( '#billing_phone_field' ).css( 'width', '49.5%' );
						$( '.paypal-express-provided' ).css( 'display', 'block' );
					});

					// Check the error input
					PP.obj.$body.on( 'change', '.error input, .error select', function (){
						var $input = $( this );

						if ( $input.val() !== '' ){
							$input.parent().removeClass( 'error' );
						}
					});

					// Clicking on "returning customer" change the view height
					$( '.offcanvas-cart' ).on( 'click', '#heading-login-customer a, .showcoupon', function(){

						setTimeout(function(){
							PP.method.checkout.viewHeight();
						}, 500);

					});

					// When submit the checkout form - Listen to the Ajax response once complete and reload or show message from the iframe
					$( 'form.checkout' ).on( 'submit', function(){
						if ( $( 'body' ).hasClass( 'offcanvas-cart' ) ){
							$( document ).one('ajaxComplete', function( event, xhr, settings ) {
								var response = $.parseJSON( xhr.responseText );

								if ( response.result === 'success' ){
									if ( -1 === response.redirect.indexOf( 'https://' ) || -1 === response.redirect.indexOf( 'http://' ) ) {
										parent.location.href = response.redirect;
									} else {
										parent.location.href = decodeURI( response.redirect );
									}
								} else {
									var $modal 	= $( '#message-modal', window.parent.document ),
										$cart	= $( '.offcanvas-cart', window.parent.document );

									// Display the error in modal
									$modal.find( '.content' ).html( '<h4>' + response.result + '</h4>' + response.messages );
									$modal.find( '.content ul.woocommerce-error' ).removeClass( 'woocommerce-error' );
									$modal.addClass( 'error' ).modal( 'show' );

									// Display the buttons and header
									$cart.removeClass( 'hide-actions' );

									// Scroll the checkout to the tops
									$cart.find( '.cart-container' ).scrollTo( 0, 400, {
										axis: 'y'
									} );
								}
							});
						}
					});

					// Quick checkout button
					$( '.offcanvas-cart' ).on( 'click', '.quick-btn a', function(){
						// If the button is place order, then submit form
						if ( $( this ).attr( 'id' ) === 'place_order' ){
							var $iframe	= $( '.offcanvas-cart #iframe-checkout' ).contents(),
								$terms 	= $iframe.find( '#checkout_review input#terms' ),
								$cart = $( '.offcanvas-cart' ),
								strpInt	= null;

							if ( $terms.length > 0 ){

								if ( $terms.is( ':checked' ) ){
									$iframe.find( '.place-order input#place_order' ).trigger( 'click' );

									// Hide the buttons and cart header
									$cart.addClass( 'hide-actions' );

									// If stripe is selected
									if ( $iframe.find( '#payment_method_stripe' ).is( ':checked' ) && ( ! $iframe.find( 'input[name="wc-stripe-payment-token"]:checked' ).length || 'new' === $iframe.find( 'input[name="wc-stripe-payment-token"]:checked' ).val() ) ) {

										// Hide the buttons and cart header
										$cart.addClass( 'stripe' );
										$iframe.find( 'body' ).addClass( 'stripe' );
										PP.method.cart.cartMaxHeight();

										strpInt = setInterval( checkStripe, 1000);

										// Check if the stripe checkout iframe exists - Wait for it to be closed before running this
										function checkStripe(){
											if ( $iframe.find( '.stripe_checkout_app' ).length > 0 ){
											    if( ! $iframe.find( '.stripe_checkout_app' ).is( ':visible' ) ){
											    	$cart.removeClass( 'stripe' );
													$iframe.find( 'body' ).removeClass( 'stripe' );
													PP.method.cart.cartMaxHeight();
													$iframe.find( '.stripe_checkout_app' ).remove();
													clearInterval( strpInt );
											    }
											}
										}
									}

								} else {
									$terms.parent().addClass( 'error' );
									$( '.offcanvas-cart .cart-container' ).scrollTo( $iframe.find( '.place-order' ), 400, {
										axis: 'y',
										offset: -30
									} );
								}

							}
						} else {
							PP.method.checkout.views( $( this ).attr( 'href' ) );
						}

						return false;
					});

					// Show CVC location when input is focused in
					$( 'body' ).on( 'focus', 'input.wc-credit-card-form-card-cvc', function(){
						$( this ).parents( '.wc-credit-card-form' ).addClass( 'cvc-focus' );
					}).on( 'blur', 'input.wc-credit-card-form-card-cvc', function(){
						$( this ).parents( '.wc-credit-card-form' ).removeClass( 'cvc-focus' );
					});

					// Re-run function on checkout update
					$( 'body' ).on( 'update_checkout', function(){
						// Save selected payment method
						var selectedPayment = $( '.payment_methods input[name="payment_method"]:checked' ).val(),
							cardChosen		= $( 'input[name="wc-stripe-payment-token"]:checked' ).val(),
							paymentForm		= $( '.wc-payment-form' ).clone();

						$( document ).one('ajaxComplete', function( event, xhr, settings ) {

							var payInt = setInterval( checkPayment, 200);

							function checkPayment(){
								if ( $('.woocommerce-checkout-payment').length > 0 && $('.woocommerce-checkout-payment .blockUI').length == 0 ){
									PP.method.checkout.paymentCardIcon();
									PP.method.checkout.updateSelectedPayment( selectedPayment, cardChosen, paymentForm );
									clearInterval(payInt);
								}
							}
						});
					});

				},

				// Validate the view
				validate: function( view ){
					var $cart 	= $( '.offcanvas-cart #iframe-checkout' ).contents(),
						passed	= true;

					switch( view ){
						case '#details':
							$cart.find( '.woocommerce-billing-fields .validate-required' ).each( function(){
								var $el = $( this ).find( '> input' );

								// Pass if "create account" checkbox is not set
								if ( $el.attr( 'id' ) === 'account_password' && ! $( '.woocommerce-billing-fields input#createaccount' ).is( ':checked' ) ){
									return true;
								}

								// If not input then it's a select box
								if ( $el.length === 0 ){ $el = $( this ).find( '> select' ); }

								// If empty make it obvious
								if ( $el.val() === '' ){
									$( this ).addClass( 'error' );
									passed = false;
								}
							});

							if ( $cart.find( '#ship-to-different-address-checkbox' ).is(':checked') ){
								$cart.find( '.woocommerce-shipping-fields .validate-required' ).each( function(){
									var $el = $( this ).find( '> input' );

									// If not input then it's a select box
									if ( $el.length === 0 ){ $el = $( this ).find( '> select' ); }

									// If empty make it obvious
									if ( $el.val() === '' ){
										$( this ).addClass( 'error' );
										passed = false;
									}
								});
							}

							if ( ! passed ){
								// Make sure you are on the details view
								if ( ! $cart.find( '#checkout_details' ).hasClass( 'in-view' ) ){
									PP.method.checkout.views( view );
								}
							}

						break;
						case '#shipping':
							if ( $cart.find( 'input#payment_method_stripe' ).is( ':checked' ) ){

								if ( $cart.find( '#wc-stripe-payment-token-new' ).length > 0 && $cart.find( '#wc-stripe-payment-token-new' ).is( ':checked' ) ){

									$cart.find( '.wc-credit-card-form input[type="text"]' ).each( function(){
										// If empty make it obvious
										if ( $( this ).val() === '' ){
											$( this ).parent().addClass( 'error' );
											passed = false;
										}
									});

								}
							}
						break;
						case '#review':

						break;
					}

					// If error scroll to it for the user to notice
					if ( ! passed ){
						$( '.offcanvas-cart .cart-container' ).scrollTo( $cart.find( '#checkout_' + view.replace( '#', '' ) + ' p.error:first' ).offset().top -30, 400, {
							axis: 'y'
						} );
					}

					return passed;

				},

				// Display the correct checkout sections
				views: function( view ){
					var $offcanvasCart	= $( '.offcanvas-cart' ),
						$cartNavBtn		= $offcanvasCart.find( '.cart-nav a[href="' + view + '"]' ),
						$cartNavParent	= $cartNavBtn.parent(),
						vwToMove		= 0,
						$cartHeader		= $offcanvasCart.find( '.cart-header' ),
						$cartTitle		= $cartHeader.find( 'h4' ),
						$cartSubtitle	= $cartHeader.find( 'h6' ),
						$quickBtnCont	= $offcanvasCart.find( '.quick-btn' ),
						$quickBtn 		= $quickBtnCont.find( 'a[href="' + view + '"]' ),
						passed 			= true,
						nextBtnAttr		= ( ( $quickBtn.data( 'next' ) ) ? $quickBtn.data( 'next' ).split( ',' ) : '' ),
						prevBtnAttr		= ( ( $quickBtn.data( 'prev' ) ) ? $quickBtn.data( 'prev' ).split( ',' ) : '' ),
						btnAttr			= nextBtnAttr,
						btnText			= $cartTitle.data( 'text' );

					// Remove the hash
					view = view.replace( '#', '' );

					var $checkoutIframe	= $offcanvasCart.find( '#iframe-checkout' ),
						$checkoutForm	= $checkoutIframe.contents().find( 'form.checkout' ),
						$viewToShow 	= $checkoutForm.find( '#checkout_' + view ),
						$viewHeader 	= $viewToShow.find( 'header' );

					// Exit if already in view
					if ( $viewToShow.hasClass( 'in-view' ) ){
						return false;
					}

					// Cart nav selected
					if ( ! $cartNavParent.hasClass( 'selected' ) ){

						// Validate the previous sections before continuing
						$cartNavParent.prevAll().find( 'a' ).each( function(){
							var $thisView = $( this ).attr( 'href' );

							passed = PP.method.checkout.validate( $thisView );

							$( this ).parent().addClass( 'selected visited' );

							if ( ! passed ){
								view = $thisView.replace( '#', '' );
								$viewToShow = $checkoutForm.find( '#checkout_' + view );
								$viewHeader = $viewToShow.find( 'header' );

								return false;
							}

						});
					} else if ( $cartNavParent.next().hasClass( 'selected' ) ) {
						$cartNavParent.nextAll().removeClass( 'selected' );
					}

					if ( passed ){
						$cartNavParent.addClass( 'selected visited' );
					}

					// When loading the view for the first time add the buttons text
					if ( ! $quickBtnCont.hasClass( 'loaded' ) ){
						$quickBtnCont.find( 'a' ).each( function(){
							var $btn	= $( this ),
								btnHref = $btn.attr( 'href' ).replace( '#', '' ),
								btnText = $checkoutForm.find( '#checkout_' + btnHref + ' header h4' ).text();

							// Cart has different DOM
							if ( btnHref === 'cart' ){
								btnText = $offcanvasCart.find( '.cart-header h4' ).text();
							}

							$btn.find( 'span' ).text( btnText );
						});

						$quickBtnCont.addClass( 'loaded' )
					}

					// Get the number to move the views
					switch( view ){
						case 'cart':
							// Move the buttons container
							$quickBtnCont.addClass( 'to-right' );
							btnText = $viewToShow.next().find( 'header h4' ).text();
						break;
						case 'details':
							// Get the correct title  and attributes
							if ( $quickBtnCont.hasClass( 'to-right' ) ){
								btnAttr = prevBtnAttr;
								// Move the buttons container
								$quickBtnCont.removeClass( 'to-right' );
							} else {
								btnText = $viewToShow.next().find( 'header h4' ).text();
								// Move the buttons container
								$quickBtnCont.removeClass( 'to-left far-left' );
							}

							vwToMove = -25;
						break;
						case 'shipping':
							// Move the buttons container
							if ( $quickBtnCont.hasClass( 'far-left' ) ){
								btnText = $viewToShow.next().find( 'header h4' ).text();
								$quickBtnCont.addClass( 'to-left' ).removeClass( 'far-left' );
							} else {
								btnAttr = prevBtnAttr;
								btnText = $viewToShow.prev().find( 'header h4' ).text();
								$quickBtnCont.addClass( 'to-left' );
							}


							vwToMove = -50;
						break;
						case 'review':
							// Move the buttons
							$quickBtnCont.removeClass( 'to-left' ).addClass( 'far-left' );
							btnAttr = prevBtnAttr;
							btnText = $viewToShow.prev().find( 'header h4' ).text();

							vwToMove = -75;

							// Change the place order button text
							var btnTxt	  = $checkoutIframe.contents().find( '#checkout_review input#place_order' ).val(),
								$orderBtn = $( '.quick-btn #place_order' );

							$orderBtn.text( btnTxt );

							// If paypal add a class to style it
							if ( btnTxt.indexOf( 'PayPal' ) > 0 ){
								$orderBtn.addClass( 'paypal' );
							} else {
								$orderBtn.removeClass( 'paypal' );
							}

						break;
					}

					if ( passed ){
						// Remove the button class starting with icon
						if ( $quickBtn.attr( 'class' ) ){
							$quickBtn.attr( 'class', function(i, c){ return c.replace(/(^|\s)icon-\S+/g, ''); } );
						}

						// Add new button class / href / text
						$quickBtn.addClass( btnAttr[1] ).attr( 'href', btnAttr[0] ).find( 'span' ).text( btnText );
					}

					// Animate titles out
					$cartHeader.addClass( 'hide-title' );

					// Wait for titles to be hidden
					$cartTitle.one( 'animationend', function(){

						//Change title
						if ( view === 'cart' ){
							$cartTitle.text( $cartTitle.data( 'text' ) );
							$cartSubtitle.text( $cartSubtitle.data( 'text' ) );
						} else {
							$cartTitle.text( $viewHeader.find( 'h4' ).text() );
							$cartSubtitle.text( $viewHeader.find( 'h6' ).text() );
						}

						// Animate titles in
						$cartHeader.removeClass( 'hide-title' );
					});

					// Move the correct section
					$checkoutIframe.css( 'transform', 'translate3d(' + vwToMove + '%,0,0)' )
					$checkoutForm.find( '> div' ).removeClass( 'in-view' );
					$viewToShow.addClass( 'in-view' );

					// Scroll to top
					setTimeout(function(){
						if ( passed ){
							$offcanvasCart.find( '.cart-container' ).scrollTo( 0, 0, {
								onAfter: function(){
									// Add the content height to the parent element
									setTimeout(function(){
										PP.method.checkout.viewHeight();
									}, 500);
								}
							});
						} else {
							// Add the content height to the parent element
							setTimeout(function(){
								PP.method.checkout.viewHeight();

								// Scroll to the error field
								if ( ! passed ){
									$( '.offcanvas-cart .cart-container' ).scrollTo( $viewToShow.find( 'p.error:first' ).offset().top -30, 400, {
										axis: 'y'
									} );
								}
							}, 500);
						}

					}, 400);

				},

				// Load the checkout form
				loadCheckoutDOM: function(){
					var $offcanvasCart	= $( '.offcanvas-cart' );

					if ( $offcanvasCart.hasClass( 'quick-checkout' ) ){
						// Expand the cart container
						if ( ! $offcanvasCart.hasClass( 'expanded' ) && ! $offcanvasCart.hasClass( 'empty' ) ){
							var newIframe = $( '<iframe id="iframe-checkout" name="iframe-checkout" src="' + wc_cart_params.checkout_page + '?ajax_request=true" scrolling="no">' );

							if ( $( '.offcanvas-cart #iframe-checkout' ).length > 0 ){
								$( '.offcanvas-cart #iframe-checkout' ).replaceWith( newIframe );
							} else {
								$( newIframe ).insertAfter( '.offcanvas-cart .cart-content' );
							}

							$( newIframe ).on('load', function(){
								var iframe   = $( '.offcanvas-cart #iframe-checkout' ).contents(),
								    $container = iframe.find( '#checkout-container' );

								// Keep only the checkout form
								iframe.find( 'body' ).addClass( 'woocommerce offcanvas-cart' ).html( $container );

								// Mark it when finished loaded
								$( '.offcanvas-cart #iframe-checkout' ).addClass( 'loaded' );

								// Move the cart in the form
								$offcanvasCart.find( '#checkout_cart' ).detach().insertBefore( $container.find( '#checkout_details' ) );

								// Cannot scroll page
								$( 'body' ).addClass( 'no-scroll' );

								setTimeout(function(){

									// Imitate the real cart
									iframe.find( 'body' ).addClass( 'open' );

							        // Expand the cart
									$offcanvasCart.addClass( 'expanded open' );

									// Call the correct view
									PP.method.checkout.views( '#details' );

									// Make sure the cart is not longer than the screen
									PP.method.cart.cartMaxHeight();

									// Functions for the checkout UI
									PP.method.checkout.radioCheckboxAction();
								}, 10);
						    });
						} else {
							window.location.hash = '#';
						}
					}

				},

				// Ajax call to reload the shipping methods
				calShipping: function( $container ){

					// wc_checkout_params is required to continue, ensure the object exists
					if ( typeof wc_checkout_params === 'undefined' ) {
						return false;
					}

					$form = $( '.shipping_select' );

					$form.addClass( 'processing' ).block({
						message: null,
						overlayCSS: {
							background: '#fff',
							opacity: 0.6
						}
					});

					$.ajax({
						type: 'POST',
						url: wc_checkout_params.ajax_url,
						data: $( 'form.woocommerce-shipping-calculator' ).serialize(),
						dataType: 'json',
						success: function( data ) {
							if (data.error === true){
								var $modal = $('#message-modal');

								$modal.find('.content').html('<h4>'+data.title+'</h4><p>'+data.message+'</p>');
								$modal.addClass('error').modal('show');
								$container.find('a.cart_button').removeClass('icon-cart').addClass('icon-cart-line');
							} else {
								// Replace the NEW CONTENT
								$.ajax({
									type: 'GET',
									url: wc_cart_params.checkout_page,
									data: {
										ajax_request: 'true'
									},
									success: function( data ) {
										$container.find( '#shipping_method_container' ).html( $( data ).find( 'ul#shipping_method' ) );
									},
									complete: function(){
										$form.removeClass( 'processing' ).unblock();
									}
								});
			                }
						}
					});
				},

				// Reload the shipping method section when choosing a country
				shippingCountry: function(){
					$( 'select#billing_country' ).off().on( 'change', function(){
						var $parentFields	= $( '.woocommerce-billing-fields' ),
							$billing 		= $parentFields.find( '#billing_state_field' ),
							$postcode		= $parentFields.find( '#billing_postcode_field' );

						// Change placeholder name
						setTimeout(function(){
							var $billingLabel = $billing.find( 'label' ).text();

							if ( $billingLabel.indexOf( '*' ) > -1 ){
								$billingLabel = $billingLabel.split( ' ', 1)[0] + '*';
							}

							$billing.find( '.select2-chosen' ).text( $billingLabel );
							$billing.find( 'input' ).attr( 'placeholder', $billingLabel );
							$postcode.find( 'input' ).attr( 'placeholder', $postcode.find( 'label' ).text() );
						}, 100);

						// Check if shipping to different address is not selected
						if ( ! $('input#ship-to-different-address-checkbox' ).is( ':checked' ) ){
							// Make the form that calculate the shipping selected witht the correct choice
							$( 'select#calc_shipping_country' ).val( $(this).find(":selected").val() ).prop( 'selected', true );
							// AJAX call to set it
							PP.method.checkout.calShipping( $( this ).parents( 'form.woocommerce-checkout' ) );
						}

					});

					$( 'select#shipping_country' ).off().on( 'change', function(){
						var $shipping = $( '.woocommerce-shipping-fields' );

						// Make sure shipping to different address is checked
						if ( $( 'input#ship-to-different-address-checkbox' ).is( ':checked' ) ){
							// Make the form that calculate the shipping selected witht hte correct choice
							$( 'select#calc_shipping_country' ).val( $(this).find(":selected").val() ).prop('selected', true);
							// AJAX call to set it
							PP.method.checkout.calShipping( $( this ).parents( 'form.woocommerce-checkout' ) );
						}

					});
				},

				// Reload the checkout on shipping method selection
				shippingMethod: function(){

					// Update checkout when shipping method selected
					$( 'body' ).on( 'change', '.offcanvas-cart input.shipping_method', function(){
						$( 'body' ).trigger( 'update_checkout' );
					});

				},

				// Slide the selected payment method and change the button text
				radioCheckboxAction: function() {
					var $iframe = $( '.offcanvas-cart #iframe-checkout' ).contents();

					$iframe.on( 'change', 'input[name="payment_method"], input[name="wc-stripe-payment-token"], input[name="ship_to_different_address"], input[name="createaccount"]', function(){
						setTimeout(function(){
							PP.method.checkout.viewHeight();
						}, 400);
					});
				},

				// Change the icon for the saved credit cards
				paymentCardIcon: function(){

					if ( $( '.payment_method_stripe' ).length > 0 ){
						$( '.woocommerce-SavedPaymentMethods-token label' ).each( function(){
							var $label 		= $( this );

							if ( ! $label.hasClass( 'credit-card' ) ){
								var labelC		= $label.text().split( String.fromCharCode(160) ),
									cardName	= labelC[0].toLowerCase().replace( ' ', '-' );

								// Remove the card type in the text
								$label.text( labelC[1] );

								// Add the card type as class
								$label.addClass( 'credit-card ' + cardName );
							}

						});
					}

				},

				// Update the previously selected payment method
				updateSelectedPayment: function( method, card, paymentForm ){
					// Select the payment
					$( 'input[name="payment_method"][value=' + method + ']' ).prop( 'checked', true );
					// Select the credit card if any
					if ( card ){
						$( 'input[name="wc-stripe-payment-token"][value=' + card + ']' ).prop( 'checked', true ).trigger( 'change' );
					}
					// Replace the credit card form
					if ( paymentForm ){
						// Loop through each input and match the ID
						paymentForm.find( 'input' ).each( function(){
							var $cloneItem 	= $( this ),
								cloneId  	= $cloneItem.attr( 'id' ),
								cloneVal 	= $cloneItem.val();

							$( '.wc-payment-form' ).find( 'input' ).each( function(){
								if ( $( this ).attr( 'id' ) == cloneId ){
									$( this ).val( cloneVal );

									return true
								}
							});
						});
					}
					// Open its content
					setTimeout( function(){
						$( 'input[name="payment_method"]:checked' ).trigger( 'click' );
					}, 100 );
				},

				// Change the view height
				viewHeight: function(){
					// Add the content height to the parent element
					var $iframe = $( '.offcanvas-cart #iframe-checkout' );
					$iframe.css( 'height', $iframe.contents().find( 'div.in-view' ).outerHeight( true ) + 50 );
				},

				// Submit the coupon input field or by clicking on it
				submitCoupon: function() {
					// Input field submit
					$( 'div.checkout_coupon' ).find( 'input[type=submit]' ).on( 'click', function(){
						PP.method.checkout.ajaxCoupon( $( this ).parents( 'div.checkout_coupon' ) );

						return false;
					});
					// Clicking on coupon
					$( 'div.apply_coupons_credits' ).off().on( 'click', function(){
						PP.method.checkout.ajaxCoupon( $( this ) );

						return false;
					});
				},

				// Ajax call to submit the coupon
				ajaxCoupon: function( $form ){
					var codeCoupon = '';

					if ( $form.parents( 'div#coupons_list' ).length > 0 ){
						codeCoupon = $form.attr( 'name' );
						$form = $form.parents( 'div#coupons_list' );
					} else {
						codeCoupon = $form.find( 'input[name="coupon_code"]' ).val();
					}

					if ( $form.is( '.processing' ) ) {
						return false;
					}

					$form.addClass( 'processing' ).block({
						message: null,
						overlayCSS: {
							background: '#fff',
							opacity: 0.6
						}
					});

					$.ajax({
						type: 'POST',
						url: wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'apply_coupon' ),
						dataType: 'html',
						data: {
							security: wc_checkout_params.apply_coupon_nonce,
							coupon_code: codeCoupon
						},
						success: function( code ) {
							$( '.woocommerce-error, .woocommerce-message' ).remove();
							$form.removeClass( 'processing' ).unblock();

							if ( code ) {
								$form.before( code );

								if ( code.indexOf( 'woocommerce-error' ) === -1 ){
									$form.parent().find( '.checkout_coupon, #coupons_list' ).slideUp();
								}

								$( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );
							}
						}
					});
				},

				// Remove coupon action to AJAX
				removeCoupon: function() {
					PP.obj.$body.on( 'click', 'a.tomo-remove-coupon', function(){
						var container = $( this ).parents( '.woocommerce-checkout-review-order' ),
							coupon = $( this ).data( 'coupon' );

						container.addClass( 'processing' ).block({
							message: null,
							overlayCSS: {
								background: '#fff',
								opacity: 0.6
							}
						});

						var data = {
							security: wc_checkout_params.remove_coupon_nonce,
							coupon: coupon
						};

						$.ajax({
							type: 'POST',
							url: wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'remove_coupon' ),
							data: data,
							success: function( code ) {
								$( '.woocommerce-error, .woocommerce-message' ).remove();
								container.removeClass( 'processing' ).unblock();

								if ( code ) {
									container.before( code );

									$( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );

									// remove coupon code from coupon field
									$( 'div.checkout_coupon' ).find( 'input[name="coupon_code"]' ).val( '' );
								}
							},
							error: function ( jqXHR ) {
								if ( wc_checkout_params.debug_mode ) {
									/*jshint devel: true */
									console.log( jqXHR.responseText );
								}
							},
							dataType: 'html'
						});

						return false;
					});
				},

				// Close the quick checkout
				closeQuickCheckout: function( cart ){
					var $cart 	= $( '.offcanvas-cart' ),
						$iframe	= $cart.find( '#iframe-checkout' ).contents();

					// Change the view back to cart
					this.views( '#cart' );

					// Remove the loader from the "Proceed Checkout" btn
					$( '.cart-btn-container .checkout' ).removeClass( 'load' ).find( '.loading' ).remove();

					// Can scroll the page now
					$( 'body' ).removeClass( 'no-scroll' );

					// Shrink it back to cart format
					$cart.removeClass( 'expanded ' )

					// Close it
					if ( ! cart ){
						PP.method.cart.popupCart( $cart, 'close' );
					}

					// Remove set height
					$cart.find( '.cart-container' ).removeAttr( 'style' );

					// Move the cart out the form
					$iframe.find( '#checkout_cart' ).detach().insertBefore( '.offcanvas-cart #iframe-checkout' );
					$cart.find( '#iframe-checkout' ).remove();
				},

				// Make an AJAX request when login on checkout page
				checkoutLogin: function(){
					$( 'body' ).on( 'click', '#loginform a.submit-login', function(){
						var $form = $( this ).parent(),
							error = false;

						$( $form ).find( '.email, .password' ).each( function(){
							var $input = $( this );

							if ( $input.val() === '' || $input.val() === null || $input.val() === undefined ){
								$input.parent().addClass( 'error' );
								$input.one( 'keyup', function( e ){
					                $(this).parent().removeClass('error');
				                });
								error = true;
							}
						});

						if ( ! error ){
							PP.method.login.ajaxLogin( $form, 'reloadForm' );
						}

				        return false;
					});

					$( 'body' ).on( 'keydown', '#loginform .email, #loginform .password', function( e ){
						if (e.which === 13) {
							$( '#loginform a.submit-login' ).click();

							e.preventDefault();
						}
					});

					$( 'body' ).on( 'click', '#loginform a.lost', function(){
						$( '#login-modal form#login a.lost' ).click();
						$( 'nav.navbar .account a[data-target="#login-modal"]' ).click();

						return false;
					});
				},

				init: function(){

					this.shippingCountry();
					this.shippingMethod();
					this.radioCheckboxAction();
					this.paymentCardIcon();
					this.removeCoupon();
					this.checkoutLogin();
					this.regEventHandlers();

				},

			},

			// Misc Functions
			'global': {

				// Well, it centers modal vertically
				centerModal: function(){
					$('div.modal').on('shown.bs.modal', function (e) {
						var $modal = $(this).find('.container'),
							modalH = $modal.outerHeight(),
							windowH = PP.obj.$window.outerHeight();

						if (modalH < windowH){
							$modal.css({
								marginTop: (windowH - modalH) / 2
							});
						}
					});
				},

				// Change some widgets UI
				widgetUIMod: function(){
					// Remove brackets around the count number in widgets
					$( '.widget').find( '.count, .wc-layered-nav-rating a' ).each( function(){
						var $item = $( this ),
							newText = removebrck( $item.text() );

						if ( $item.parent( '.wc-layered-nav-rating ' ).length > 0 ){
							var $stars = $item.find( '.star-rating' ).detach();

							$item.html( '<span class="count">' + newText + '</span>' ).prepend( $stars );
						} else {
							$item.text( newText );
						}
					});

					// Layered Nav widget - Adding class if query type is OR
					$( '.widget_layered_nav' ).each( function(){
						var $widget = $( this ),
							$firstItem = $widget.find( 'li:first a' );

						if ( $firstItem.attr( 'href' ).indexOf( '=or' ) > 0 ){
							$widget.addClass( 'query-or' );
						}
					});

					function removebrck( text ){
						var regExp = /\(([^)]+)\)/,
							matches = regExp.exec( text );

						return matches[1];
					}
				},

				// Get URL parameter
				getUrlParameter: function( sParam ) {
				    var sPageURL = decodeURIComponent( window.location.search.substring(1) ),
				        sURLVariables = sPageURL.split( '&' ),
				        sParameterName,
				        i;

				    for ( i = 0; i < sURLVariables.length; i++ ) {
				        sParameterName = sURLVariables[i].split( '=' );

				        if ( sParameterName[0] === sParam ) {
				            return sParameterName[1] === undefined ? true : sParameterName[1];
				        }
				    }
				},

				// Tab Bootstrap
				tabs: function(){
				    $('.vc_tta-tabs-container a').click(function (e) {
						e.preventDefault();
						$(this).tab('show');
					});
					$('.vc_tta-tabs-container').each(function(){
						$(this).find('a:first').tab('show');
					});
				},

				// Make the image retina using srcset with WP Retina plugin
				retinaImg: function( img, productImg ){
					var src	= img.attr( 'src' );

					if ( productImg &&  src !== PP.obj.last_src || !productImg ){
						$.post(
							woocommerce_params.ajax_url,
							{
								action: 'get_srcset',
								nonce: $('.navbar .widget_shopping_cart_content #_wpnonce').val(),
								src: src
							},
							function( srcset ) {
								if ( srcset !== '' ) {
									img.attr( 'srcset', srcset );
								}
							}
						);

						PP.obj.last_src = src;
					}
				},

				// Add scrolled class
				scrollClass: function(){

					if ( PP.obj.$window.scrollTop() > 0 ) {
						PP.obj.$html.addClass( 'scrolled' );
					} else if ( PP.obj.$html.hasClass( 'scrolled' ) ){
						PP.obj.$html.removeClass( 'scrolled' )
					}

				},

				init: function(){

					this.centerModal();
					this.tabs();
					this.widgetUIMod();

				},

			},

			// Functions to run only for mobile
			funcTouch: function(){

			},

			// Functions to run only for desktop
			funcNoTouch: function(){

				// Initiate functions
				PP.method.forms.init();

			},

			// Function to run on any device
			funcAll: function(){

				PP.method.navigation.init();
			    PP.method.slider.init();
				PP.method.cart.init();
				PP.method.login.init();
				PP.method.product.init();
				PP.method.checkout.init();
				PP.method.global.init();

				// Call the tooltip function and append them to the body tag
				$('[data-toggle="tooltip"]').tooltip({ container: 'body' });
				$( 'body' ).on( 'click', '[data-toggle="tooltip"]', function(){
					$( this ).tooltip( 'hide' );
				});

			},
		},

		// On body click
		'bodyClick': function( e ){
			PP.obj.$body.on( 'click', function ( e ) {
				// Close the mini cart
		    	if ( ! $( '.offcanvas-cart' ).is( e.target ) && $( '.offcanvas-cart' ).has( e.target ).length === 0 && ! $( '.modal' ).is( e.target ) && $( '.modal' ).has( e.target ).length === 0 ) {
					PP.method.cart.popupCart( $( '.offcanvas-cart' ), 'close' );
				}

				// Close the product overlay (variations/favorites)
		    	if ( ! $( '.product-overlay.open .content' ).is( e.target ) && ! $( '.loading-overlay.open' ).is( e.target ) && $( '.product-overlay.open .content' ).has( e.target ).length === 0 ) {
		    		var $popup = $( '.product-overlay.open' );

					if ( $popup.hasClass( 'wishlist-options' ) ){
						$popup.insertAfter( '#wl-list-pop-wrap' );
						$( '#wl-list-pop-wrap' ).hide();
					}
					$popup.removeClass( 'open' ).find( '.content' );
				}
			});
		},

		// On window scroll
		'scroll': function( func, funcname, args ){
			PP.obj.$window.scroll( function(){

				PP.method.global.scrollClass();

			});
		},

		// Looking for hashchange in the URL
		'hashChange': function(){
			// On page load
			var hashURL  = window.location.hash;

			conditions( hashURL );

			// When hash is being changed
			PP.obj.$window.hashchange( function(){
				var hashURL  = window.location.hash;

				conditions( hashURL );
			});

			function conditions( hash ){

				if ( hash === '#tab-description' || hash === '#tab-reviews' ) {

					var $target = $( hash ),
						offsetTop = ( $( 'nav.navbar-fixed-top' ).length > 0 ? $( 'nav.navbar-fixed-top' ).outerHeight() : 0 ) + $( 'header.banner' ).outerHeight() + 120;

					// Open the correct tab
					$( '.wc-tabs a[href="' + hash + '"]' ).click();

					// Scroll to it
					$.scrollTo( $target, 500, {
						offset: { top: -offsetTop }
					});

				} else if ( hash.indexOf( 'comment-' ) > -1 && $( 'body' ).hasClass( 'single-product' ) ){

					var $target = $( hash ),
						parentID = $target.parents( '.panel' ).attr( 'id' ),
						$container = $( '#contributions-list'),
						offsetTop = ( $( 'body' ).hasClass('nav-is-fixed') ? $( 'nav.navbar-top' ).outerHeight() : 0 ) + $( 'header.nav-header' ).outerHeight() + 30;

					// Open the correct tab
					$( '.wc-tabs a[href="#' + parentID + '"]' ).click();

					// Scroll to it
			        $container.scrollTo( $target, 10, {
						offset: { top: -30 },
						onAfter: function(){
							$.scrollTo( $target, 500, {
								offset: { top: -offsetTop }
							});
						}
					});

				} else if ( hash === '#checkout' ){

					// Load the checkout form in the offcanvas cart
					PP.method.checkout.loadCheckoutDOM();

				} else if ( hash === '#cart' ){

					// Open cart
					PP.method.cart.popupCart( $( '.offcanvas-cart .widget_shopping_cart' ), 'open' );
				}

			}
		},

		// On window resize
		'resize': function( func, funcname, args ){
			PP.obj.$window.bind('resize', function(){

				PP.method.cart.cartMaxHeight();
				PP.method.navigation.navHorizontalScroll();

			});
		},

		// All pages
		'common': {
		  	init: function(e) {
			    // Call method depending on device type
			    PP.method.checkMobile();

				// Method fired on resize
			    PP.resize();

				// Method fired on scroll
			    PP.scroll();

			    //  Method fired on hashchange
			    PP.hashChange();

			    //  Method fired when body is clicked
			    PP.bodyClick(e);

				// Make the recommended products a slider - Located on the thankyou page
				$( '#recommended-products .related > ul.products' ).flickity();
				// $( '#recommended-products .related > ul.products' ).owlCarousel({
				// 	items: 3,
				// 	margin: 1,
				// 	loop: ( ( $( '#recommended-products li.product' ).length > 3 ) ? true : false ),
				// 	nav: ( ( $( '#recommended-products li.product' ).length > 3 ) ? true : false ),
				// 	navText: [ '', '' ],
				// 	navClass: [ 'owl-prev icon-left-arrow', 'owl-next icon-right-arrow' ],
				// 	dots: true,
				// 	mouseDrag: false
				// });

				// Check for login redirect
				if ( PP.method.global.getUrlParameter('login') === 'true' ){
					$('#login-modal').modal( 'show' );
				}
			},

			finalize: function() {
		    	// JavaScript to be fired on all pages, after page specific JS is fired
			    PP.common.loaded();
			},

			loaded: function() {
				PP.obj.$window.load(function(){
					PP.method.forms.spinner();
					PP.method.checkout.submitCoupon();
				});
			}
		},
		// Home page - Body tag page class is home
		'home': {
			init: function() {
				// JavaScript to be fired on the home page
			},
			finalize: function() {
				// JavaScript to be fired on the home page, after the init JS
			}
		},
	};

	// The routing fires all common scripts, followed by the page specific scripts.
	// Add additional events for more control over timing e.g. a finalize event
	var UTIL = {
		fire: function(func, funcname, args) {
			var fire;
			var namespace = PP;
			funcname = (funcname === undefined) ? 'init' : funcname;
			fire = func !== '';
			fire = fire && namespace[func];
			fire = fire && typeof namespace[func][funcname] === 'function';

			if (fire) {
				namespace[func][funcname](args);
			}
		},
		loadEvents: function(e) {
			// Fire common init JS
			UTIL.fire('common', 'init', e);

			// Fire page-specific init JS, and then finalize JS
			$.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
				UTIL.fire(classnm);
				UTIL.fire(classnm, 'finalize');
			});

			// Fire common finalize JS
			UTIL.fire('common', 'finalize');
		}
	};

	// Load Events
	$(document).ready(UTIL.loadEvents);

})(jQuery);
