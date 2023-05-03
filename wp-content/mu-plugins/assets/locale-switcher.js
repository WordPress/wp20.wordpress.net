/* global wpCookies */
( function( window, $, wpCookies ) {

	'use strict';

	var WP20LocaleSwitcher = window.WP20LocaleSwitcher || {},
		app;

	app = $.extend( WP20LocaleSwitcher, {
		$switcher: $(),

		$notice: $(),

		init: function() {
			// todo doesn't show up on desktop when view clicking on it, but it does when tabbing to it

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
					return app.i18n.noResults;
				},

				// Internationalize the text used in the accessibility hint to indicate that the query is too short.
				tStatusQueryTooShort: function( minQueryLength ) {
					console.log( wp.i18n.sprintf(
						app.i18n.statusQueryTooShort,
						minQueryLength
					) );


					return minQueryLength;//todo

					//test
				},

				// Internationalize the text that is used in the accessibility hint to indicate that there are no results.
				tStatusNoResults: function() {
					return app.i18n.statusNoResults;
					//test

				},

				// Internationalize the text used in the accessibility hint to indicate which option is selected.
				tStatusSelectedOption: function( selectedOption, length, index ) {
					return app.i18n.statusSelectedOption;
						// @todo replace all the placeholdrs in string
						// `${selectedOption} ${index + 1} of ${length} is highlighted`

						//test
				},

				// Internationalize the text used in the accessibility hint to indicate which options are available and which is selected.
				tStatusResults: function( length, contentSelectedOption ) {
					let text = '';

					if ( 1 === length ) {
						text = app.i18n.statusOneResult;
					} else {
						text = app.i18n.statusManyResults;
					}

					// @todo replace %s w/ contentSelectedOption

					return '<span>' + text + '</span>';

					//test
				},

				// Internationalize the text to be assigned as the aria description of the html `input` element, via the `aria-describedby` attribute.
				tAssistiveHint: function() {
					return app.i18n.assistiveHint;

					//test
				},


				// @todo make sure all i18n strings escaped

				// @todo  { templates: { inputValue, suggestion } } to let search by endonym and english name
					// make sure escaped
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
