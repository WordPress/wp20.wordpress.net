/**
 * WP20MeetupEvents
 *
 * Displays a Google Map with the provided markers.
 *
 * This is mostly copied from the `wordcamp-central-2012` theme.
 */
var WP20MeetupEvents = app = ( function( $ ) {
	/**
	 * @param {google.maps.Map} map
	 * @param {object}          markers
	 * @param {MarkerClusterer} markerCluster
	 * @param {object}          templateOptions
	 *                              copied from Core in order to avoid an extra HTTP request just
	 *                              to get `wp.template`.
	 */
	var events,
	    options,
	    strings,
	    map,
	    markers,
	    markerCluster,
	    templateOptions = {
			evaluate:    /<#([\s\S]+?)#>/g,
			interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
			escape:      /\{\{([^\}]+?)\}\}(?!\})/g
		};

	/**
	 * Initialization that runs when the document has fully loaded.
	 */
	function init( data ) {
		events  = data.events;
		options = data.map_options;
		strings = data.strings;

		try {
			$( '#wp20-events-query-mobile' ).keyup( handleFilterInput );
			$( '#wp20-events-query-desktop' ).keyup( handleFilterInput );
			$( '#wp20-events-filter' ).submit( handleFilterInput );

			if ( options.hasOwnProperty( 'mapContainer' ) ) {
				loadMap( options.mapContainer, events );
			}
		} catch ( exception ) {
			log( exception );
		}
	}

	/**
	 * Build a Google Map in the given container with the given marker data.
	 *
	 * @param {string} container
	 * @param {object} events
	 */
	function loadMap( container, events ) {
		if ( ! $( '#' + container ).length ) {
			throw "Map container element isn't present in the DOM.";
		}

		if ( 'undefined' === typeof( google ) || ! google.hasOwnProperty( 'maps' ) ) {
			throw 'Google Maps library is not loaded.';
		}

		var mapOptions = {
			center            : new google.maps.LatLng( 15.000, 7.000 ),
			zoom              : 2,
			zoomControl       : true,
			mapTypeControl    : false,
			streetViewControl : false,
			styles            : getMapStyles()
		};

		app.map           = new google.maps.Map( document.getElementById( container ), mapOptions );
		app.markers       = createMarkers( events );
		app.markerCluster = clusterMarkers();
	}

	/**
	 * Get the styles for the map.
	 *
	 * These were generated from https://mapstyle.withgoogle.com/ with these settings:
	 * Theme Silver, Roads 2, Landmarks 2, Labels 3, Water color #c7d1ff.
	 */
	function getMapStyles() {
		var styles = [
			{
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#f5f5f5"
					}
				]
			},
			{
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
					}
				]
			},
			{
				"elementType": "labels.text.stroke",
				"stylers": [
					{
						"color": "#f5f5f5"
					}
				]
			},
			{
				"featureType": "administrative.land_parcel",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#c7d1ff"
					}
				]
			},
			{
				"featureType": "administrative.land_parcel",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "administrative.land_parcel",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#bdbdbd"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "labels.text",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
					}
				]
			},
			{
				"featureType": "poi.business",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
					}
				]
			},
			{
				"featureType": "poi.park",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			},
			{
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#ffffff"
					}
				]
			},
			{
				"featureType": "road",
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road.arterial",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road.arterial",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
					}
				]
			},
			{
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#dadada"
					}
				]
			},
			{
				"featureType": "road.highway",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road.highway",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
					}
				]
			},
			{
				"featureType": "road.local",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road.local",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road.local",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			},
			{
				"featureType": "transit",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "transit.line",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
					}
				]
			},
			{
				"featureType": "transit.station",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#C9D1FB"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
					}
				]
			}
		];

		return styles;
	}

	/**
	 * Create markers on a map with the given marker data.
	 *
	 * Normally the markers would be assigned to the map at this point, but we'll run them through MarkerClusterer
	 * later on, so adding them to the map now is unnecessary and negatively affects performance.
	 *
	 * @param {object}          events
	 *
	 * @return {object}
	 */
	function createMarkers( events ) {
		var markerID,
			markers            = {},
			infoWindowTemplate = _.template( $( '#tmpl-wp20-map-marker' ).html(), null, templateOptions ),
			infoWindow         = new google.maps.InfoWindow( {
				pixelOffset: new google.maps.Size( -options.markerIconAnchorXOffset, 0 )
			} );

		for ( markerID in events ) {
			if ( ! events.hasOwnProperty( markerID ) ) {
				continue;
			}

			markers[ markerID ] = new google.maps.Marker( {
				id        : markerID,
				group     : events[ markerID ].group,
				name      : events[ markerID ].name,
				time      : events[ markerID ].time,
				url       : events[ markerID ].eventUrl,

				icon : {
					url        : options.markerIconBaseURL + options.markerIcon,
					size       : new google.maps.Size(  options.markerIconHeight,        options.markerIconWidth ),
					anchor     : new google.maps.Point( options.markerIconAnchorXOffset, options.markerIconWidth / 2 ),
					scaledSize : new google.maps.Size(  options.markerIconHeight / 2,    options.markerIconWidth / 2 )
				},

				position : new google.maps.LatLng(
					events[ markerID ].latitude,
					events[ markerID ].longitude
				)
			} );

			google.maps.event.addListener( markers[ markerID ], 'click', function() {
				try {
					infoWindow.setContent( infoWindowTemplate( { 'event': markers[ this.id ] } ) );
					infoWindow.open( app.map, markers[ this.id ] );
				} catch ( exception ) {
					log( exception );
				}
			} );
		}

		return markers;
	}

	/**
	 * Cluster the markers into groups for improved performance and UX.
	 *
	 * options.clusterIcon is just 1x size, because MarkerClusterer doesn't support retina images.
	 * MarkerClusterer Plus does, but it doesn't seem as official, so I'm not as confident that it's secure,
	 * stable, etc.
	 *
	 * @return MarkerClusterer
	 */
	function clusterMarkers() {
		var clusterOptions,
			markersArray = [];

		/*
		 * We're storing markers in an object so that they can be accessed directly by ID, rather than having to
		 * loop through them to find one. MarkerClusterer requires them to be passed in as an object, though, so
		 * we need to convert them here.
		 */
		for ( var m in app.markers ) {
			markersArray.push( app.markers[ m ] );
		}

		clusterOptions = {
			maxZoom:  11,
			gridSize: 20,
			styles: [
				{
					url:       options.markerIconBaseURL + options.clusterIcon,
					height:    options.clusterIconHeight,
					width:     options.clusterIconWidth,
					anchor:    [ 0, -0 ],
					textColor: '#ffffff',
					textSize:  18
				}
			]
		};

		return new MarkerClusterer( app.map, markersArray, clusterOptions );
	}

	/**
	 * Handle user input in the filter form.
	 *
	 * @param {object} event
	 */
	function handleFilterInput( event ) {
		event.preventDefault();

		filterEventList( this.value );

		/*
		 * Sometimes the map may be taking up most of the viewport, so the user won't see the list changing as
		 * they type their query. This helps direct them to the results.
		 */
		event.target.scrollIntoView( {
			inline: 'start',
			behavior: 'smooth',
		} );
	}

	/**
	 * Filter the list of events based on a user's search query.
	 */
	function filterEventList( query ) {
		var events = $( '.wp20-events-list' ).children( 'li' );
		    speak  = _.debounce( wp.a11y.speak, 1000 );
		var noMatches = $( '.wp20-events-list-no-results' );
		var countHidden = 0;

		if ( '' === query ) {
			events.attr( 'aria-hidden', false );
			noMatches.css( 'display', 'none' );
			speak( strings.search_cleared );
			return;
		}

		events.each( function( index, event ) {
			var groupName = $( event ).children( '.wp20-event-group' ).text().trim(),
			    location  = $( event ).data( 'location' );

			if ( -1 === groupName.search( new RegExp( query, 'i' ) ) && -1 === location.search( new RegExp( query, 'i' ) ) ) {
				$( event ).attr( 'aria-hidden', true );
				countHidden++;
			} else {
				$( event ).attr( 'aria-hidden', false );
			}
		} );

		if ( events.length === countHidden ) {
			noMatches.css( 'display', 'block' );
			speak( strings.search_no_matches );
		} else {
			noMatches.css( 'display', 'none' );
			speak( strings.search_match.replace( '%s', query ) );
		}
	}

	/**
	 * Log a message to the console.
	 *
	 * @param {*} message
	 */
	function log( message ) {
		if ( ! window.console ) {
			return;
		}

		if ( 'string' === typeof( message ) ) {
			console.log( 'WP20MeetupEvents: ' + message );
		} else {
			console.log( 'WP20MeetupEvents: ', message );
		}
	}

	return {
		init: init
	};
} )( jQuery );

jQuery( document ).ready( WP20MeetupEvents.init( wp20MeetupEventsData ) );
