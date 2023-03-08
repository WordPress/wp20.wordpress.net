
( function( $ ) {

	'use strict';

	var app = {
		$body: $( 'body' ),

		classValue: 'site-navigation-fixed',

		init: function() {
			var observer;

			app.$nav          = app.$body.find( '.navigation-top' );
			app.$navContainer = app.$body.find( '.navigation-top-container' );
			app.$siteContent  = app.$body.find( '.site-content-contain' );

			observer = new MutationObserver( app.observerCallback );

			if ( app.$navContainer.length ) {
				observer.observe( app.$nav.get(0), {
					attributes: true,
					attributeFilter: [ 'class' ]
				} );
			}
		},

		observerCallback: function( events ) {
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
