/* global wpCookies */
( function( window, $, wpCookies ) {

	'use strict';

	var WP20LocaleSwitcher = window.WP20LocaleSwitcher || {},
		app;

	app = $.extend( WP20LocaleSwitcher, {
		$switcher: $(),

		$notice: $(),

		init: function() {
			app.$switcher = $( '#wp20-locale-switcher' );
			app.$notice   = $( '.wp20-locale-notice' );
			app.$container = $( '.navigation-top-menu-container' );

			app.$switcher.selectWoo( {
				language: app.locale,
				dir: app.dir,
				dropdownParent: app.$container,
				width: 'auto',
				dropdownAutoWidth : true
			} );

			app.$switcher.on( 'change', function() {
				$(this).parents( 'form' ).submit();
			} );

			// This has to stay `select2`; `selectWoo:open` will not work.
			app.$switcher.on( 'select2:open', function() {
				app.$container.find( 'input[type="search"]').attr('placeholder', app.$container.attr( 'data-placeholder' ) );

				// Turn off the menu if it's open.
				if( $( '#site-navigation' ).hasClass( 'toggled-on' ) ) {
					$( '.menu-toggle' ).trigger( 'click' );
				}
			} );

			app.$notice.on( 'click', '.wp20-locale-notice-dismiss', function( event ) {
				event.preventDefault();
				app.dismissNotice();
			} );
		},

		dismissNotice: function() {
			app.$notice.fadeTo( 100, 0, function() {
				app.$notice.slideUp( 100, function() {
					app.$notice.remove();
				});
			});

			wpCookies.set(
				'wp20-locale-notice-dismissed',
				true,
				app.cookie.expires,
				app.cookie.cpath,
				app.cookie.domain,
				app.cookie.secure
			);
		}
	} );

	$( document ).ready( function() {
		app.init();
	} );

} )( window, jQuery, wpCookies );
