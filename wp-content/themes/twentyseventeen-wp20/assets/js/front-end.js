
( function( $ ) {

	'use strict';

	var app = {
		$body: $( 'body' ),

		classValue: 'site-navigation-fixed',

		init: function() {
			var observer, menuTitle;

			app.$nav          = app.$body.find( '.navigation-top' );
			app.$navContainer = app.$body.find( '.navigation-top-container' );
			app.$siteContent  = app.$body.find( '.site-content-contain' );
			app.$menuToggle   = $( '.menu-toggle' );
			app.$menuDropdown = $( '.main-navigation' );

			observer = new MutationObserver( app.observerCallback );

			if ( app.$navContainer.length ) {
				observer.observe( app.$nav.get(0), {
					attributes: true,
					attributeFilter: [ 'class' ]
				} );
			}

			// Change button text when menu toggle is clicked
			app.$menuToggle.on( 'click', function() {
				if ( $( this ).hasClass( 'toggled-on' ) ) {
					$( this ).removeClass( 'toggled-on' ).children( 'span' ).text( menuTitle );
				} else {
					menuTitle = $( this ).text();
					$( this ).addClass( 'toggled-on' ).children( 'span' ).text( 'Menu' );
				}
			});

			// When clicking outside of the dropdown menu, close the dropdown menu
			$( document ).click( function( event ) {
				var $target = $( event.target );

				if ( ! $target.closest( app.$menuToggle ).length && 
					! $target.closest( app.$menuDropdown ).length && 
					app.$menuDropdown.hasClass( 'toggled-on' )
				) {
					app.$menuDropdown.removeClass( 'toggled-on' );
				}
			});
		},

		observerCallback: function ( events ) {
			$.each( events, function ( i, event ) {
				var $target = $( event.target );

				if ( $target.hasClass( app.classValue ) ) {
					app.$navContainer.addClass( app.classValue );
					app.$siteContent.css( 'margin-top', app.$navContainer.height() + 'px' );
				} else {
					app.$navContainer.removeClass( app.classValue );
					app.$siteContent.css( 'margin-top', 0 );
				}
			} );
		}
	};

	$( document ).ready( function() {
		app.init();
	} );

} )( jQuery );
