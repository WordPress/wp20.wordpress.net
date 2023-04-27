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
			app.$outerContainer = $( '.wp20-locale-switcher-container' );
			app.$switcherForm = $( '#wp20-locale-switcher-form' );

			const localeSelect = document.querySelector( '#wp20-locale-switcher' );



			// todo enable a11yautocom here
			accessibleAutocomplete.enhanceSelectElement( {
				selectElement: localeSelect,
				showAllValues: true,
				// displayMenu: 'overlay' might be useful
				// autoselect: false

				// Submit the form.
				onConfirm: function( localeName ) {
					// Find the selected locale code.
					// This is necessary because of https://github.com/alphagov/accessible-autocomplete/issues/387.
					const selectedOption = Array.from( localeSelect.querySelectorAll( 'option' ) ).find( function( option ) {
						return option.innerText === localeName;
					} );

					if ( selectedOption ) {
						if ( app.locale !== selectedOption.value ) {
							$( '#wp20-locale-switcher-select' ).val( selectedOption.value );
							app.$switcherForm.submit();
						}
					}
				},

				dropdownArrow: function() {
					// Intentionally empty because we'll create the arrow in CSS.
					return '';
				},

				// defaultValue: function( value ) {
				// 	console.log( 'defaultvalue', value );
				// 	return 'hi';
				// }

				// . If your use case doesn't fit the above defaults, try reading the source and seeing if you can write your own.

				// souce - use locale code too

				// inputValue: 		function( value ) {
				// 	console.log( 'inputValue', value );
				// return value;
				// },
				// doesn't give locale code

				// dropdownArrow: () => '' requires showallvalues true

				// transleat "no results found" etc
				/*
				do this just like you've done other i18n strings
				tStatusQueryTooShort: (minQueryLength) => '',
				tStatusNoResults: () => '',
				tStatusSelectedOption: (selectedOption, length) => '',
				tStatusResults: () => ''

				make sure escaped
				*/

				// { templates: { inputValue, suggestion } } to let search by endonym and english name
					// make sure escaped


				placeholder: 'Search languages...',

				// supply our dropdown arrow
			} );


			document.addEventListener("DOMContentLoaded", function(event) {
				app.$switcher.on( 'focus', function() {
					console.log('focus');
				});

				app.$switcher.on( 'blur', function() {
					console.log('blur');
				});
				document.querySelector( '.autocomplete__wrapper' ).addEventListener( 'keydown', function(event) {
					console.log(event);
				} );
			});

			// This has to stay `select2`; `selectWoo:open` will not work.
			app.$switcher.on( 'select2:open', function() {
				// move to other events? there aren't any i don't think
				// but maybe there are some native ones, or you can use a mutation observer

				// change from ? to "search languages"
				// app.$container.find( 'input' ).attr( 'placeholder', app.$container.attr( 'data-placeholder' ) );
				// maybe don't need this b/c they don't recommend using placeholders, and can set via api if need to?


				// Turn off the menu if it's open.
				if( $( '#site-navigation' ).hasClass( 'toggled-on' ) ) {
					$( '.menu-toggle' ).trigger( 'click' );
					// should probably port to new lib
				}

				app.$outerContainer.addClass( 'is-toggled' );
			} );

			app.$switcher.on( 'select2:close', function() {
				app.$outerContainer.removeClass( 'is-toggled' );
			} )

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
