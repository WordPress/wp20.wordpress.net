/* global wpCookies */
( function( window, $, wpCookies ) {

	'use strict';

	const __ = wp.i18n.__;
	const sprintf = wp.i18n.sprintf;

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

			accessibleAutocomplete.enhanceSelectElement( {
				selectElement: localeSelect,
				showAllValues: true,

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

				placeholder: wp.i18n.__( 'Search languages...', 'wp20' ),

				dropdownArrow: function() {
					// Intentionally empty because we'll create the arrow in CSS.
					return '';
				},

				// Internationalize the text used in the dropdown to indicate that there are no results.
				tNoResults: function() {
					return wp.i18n.__( 'No results found', 'wp20' );
				},

				// Internationalize the text used in the accessibility hint to indicate that the query is too short.
				tStatusQueryTooShort: function( minQueryLength ) {
					console.log( wp.i18n.sprintf(
						__( 'TOOSHORTTEST Type in %d or more characters for results', 'wp20' ),
						minQueryLength
						) );


						return minQueryLength;//todo

						//test
					},

				// Internationalize the text that is used in the accessibility hint to indicate that there are no results.
				tStatusNoResults: function() {
					return __( 'No search results', 'wp20' );
				},

				// Internationalize the text used in the accessibility hint to indicate which option is selected.
				tStatusSelectedOption: function( selectedOption, length, index ) {
					return sprintf(
						// Translators: 1: Name of language that is highlighted in a list; 2: Position of the highlighted language; 3: Total number of languages. Example: "Afrikaans 2 of 272 is highlighted"
						__( '%1$s %2$d of %3$d is highlighted', 'wp20' ),
						selectedOption,
						index + 1,
						length
					);
				},

				// Internationalize the text used in the accessibility hint to indicate which options are available and which is selected.
				tStatusResults: function( length, contentSelectedOption ) {
					let text = '';

					if ( 1 === length ) {
						text = sprintf(
							__( '1 result is available. %s', 'wp20' ),
							contentSelectedOption
						);
					} else {
						text = sprintf(
							__( '%d results are available. %s', 'wp20' ),
							length,
							contentSelectedOption
						);
						//test
					}
					console.log(text);

					return '<span>' + text + '</span>';
				},

				// Internationalize the text to be assigned as the aria description of the html `input` element, via the `aria-describedby` attribute.
				tAssistiveHint: function() {
					return __( 'When autocomplete results are available use up and down arrows to review, and enter to select. Touch device users, explore by touch or with swipe gestures.', 'wp20' );
				},
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
