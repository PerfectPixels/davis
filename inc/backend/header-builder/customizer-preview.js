(function($){
	var api = wp.customize;

	var HB = {

		syncDropAreas: function(){

			$( '.header-builder .sortable' ).each( function(){
				var setting = $( this ).data( 'setting' );

				if ( setting !== undefined && api.instance( setting ) !== undefined && api.instance( setting ).get() ){
					api.instance( setting ).get().forEach(function( type ) {
						var device = 'desktop';

						if ( setting.indexOf( 'tablet' ) > -1 ){ 
							device = 'tablet'; 
						} else if ( setting.indexOf( 'mobile' ) > -1 ){ 
							device = 'mobile'; 
						}

						$( '#header-' + device + ' .unused' ).find( '[data-type=' + type + ']' ).appendTo( '.header-builder [data-setting=' + setting +']' )
					});
				}
			});

		},

		makeSortable: function(){

			$( '.header-builder .sortable' ).sortable({
		    	connectWith: ".sortable",
		    	update: function( event, ui ) {
		    		HB.updateCustomizer( ui );
		    	}
		    }).disableSelection();

		},

		updateCustomizer: function( ui ){
			var $container = $( ui.item ).parent(),
				setting = $container.data( 'setting' ),
				val = [];
			
			if ( ui.sender !== null ) {
				$container = $( ui.sender );
				setting = $container.data( 'setting' );
			}
			
			if ( setting !== undefined ) {
				$container.find( 'span.button' ).each( function(){
					val.push( $( this ).data( 'type' ) );
				});
				
				$( '[data-customize-setting-link=' + setting + ']' ).selectize()[0].selectize.setValue( val, !0 );
				
				api.instance( setting ).set( val );
			}

			// Display/Hide Menu Positon option from customizer
			// if ( $( '.header-builder .main-header' ).find( '.button[data-type="main_menu"]' ).length == 0 ) {
			// 	$( '[data-customize-setting-link="content_pos"]' ).selectize()[0].selectize.setValue( 'left', !0 );
			// 	api.instance( 'content_pos' ).set( 'left' );
			// }
	
		},

		addTitlePanel: function(){
			var sections = ['accordion-section-top_bar', 'accordion-section-account_element'];

			sections.forEach( function( id ){
				var title = $( '#sub-' + id + ' .customize-section-description' );

				$( '<h3 class="section_title in-panel">' + title.text() + '</h3>' ).insertBefore( $( '#' + id ) );

				title.remove();
			});
		},

		goToSetting: function(){

			$( 'i[data-section]' ).on( 'click', function(){
				var section = $( this ).data( 'section' );

				if ( api.section( section ) ){
					api.section( section ).focus();
				}
			});

		},

		deviceViews: function(){

			$( '.header-builder .devices button' ).on( 'click', function(){
				var device = $( this ).data( 'device' );

				$( '#customize-controls button.preview-' + device ).click();
			});

		},

		displayHB: function(){

			api.panel( 'panel_header' ).expanded.bind( function( open ){
            	if ( open === true ){
            		$( '.header-builder' ).addClass( 'open' );
            	}
            });

			$( '.collapse-builder' ).on( 'click', function(){
				$( '.header-builder' ).toggleClass( 'open' );
			});

		},

		logoPos: function(){
			var devices = [ 'desktop', 'tablet', 'mobile' ];

			devices.forEach( function( device ){
				api( 'logo_position_' + device, function( value ){
		            value.bind( function( newval ) {
		            	var $headerSection = $( '#header-' + device );

		                if ( newval === 'center' ){ 
		                	$headerSection.addClass( 'center-logo' ); 
		                } else {
		                	$headerSection.removeClass( 'center-logo' ); 
		                }
		            });
		        });
		    });

		},

		init: function(){

			HB.syncDropAreas();
			HB.makeSortable();
			HB.addTitlePanel();
			HB.goToSetting();
			HB.deviceViews();
			HB.displayHB();
			HB.logoPos();

		}

	};

	// Load Events
	$( document ).ready( HB.init );

})(jQuery);