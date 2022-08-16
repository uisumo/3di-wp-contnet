/**
 * Part of GravityView_Maps plugin. This script is enqueued from
 * front-end view that has Maps setting enabled.
 *
 * globals jQuery, GV_MAPS, google
 */

// make sure GV_MAPS exists
window.GV_MAPS = window.GV_MAPS || {};

function gm_authFailure() {
	gvMapsDisplayErrorNotice( window.GV_MAPS.google_maps_api_error );
}

/**
 * Inserts an error message before each map
 *
 * @param {string} error_text The API error message to display.
 *
 * @since 1.7
 *
 * @return {void}
 */
function gvMapsDisplayErrorNotice( error_text ) {
	var notice;

	if ( window.GV_MAPS.display_errors ) {
		notice = jQuery( '<div/>', {
			text: error_text,
			'class': 'gv-notice gv-error error'
		} );
	} else {
		notice = jQuery( document.createComment( error_text ) );
	}

	jQuery( '.gv-map-canvas' ).hide().each( function () {
		notice.insertBefore( jQuery( this ) );
	} );
}

( function ( $ ) {

	'use strict';

	/**
	 * Passed by wp_localize_script() with some settings
	 * @type {object}
	 */
	var self = $.extend( {
		'did_scroll': false,
		'map_offset': 0,
		'map_sticky_container': null,
		'map_entries_container_selector': '.gv-map-entries',
		'markers': [],
		'maps': [], // Google Map object, set up in `self.setup_maps`
		'is_single_entry': false,
		'infowindow': {
			'no_empty': true,
			'max_width': 300,
		},
		'mobile_breakpoint': 600, // # of pixels to be considered mobile
	}, window.GV_MAPS );

	/**
	 * Set up the map functionality
	 * @return {[type]} [description]
	 */
	self.init = function () {
		var maps = document.querySelectorAll( '[id^="' + self.map_id_prefix + '-"]' );

		// Do we really need to process maps?
		if ( !maps ) {
			return;
		}

		//check if it is a single entry view
		if ( $( '.gv-map-single-container' ).length > 0 ) {
			self.is_single_entry = true;
		}

		// make sure map canvas is less than 50% of the window height (default 400px)
		self.sticky_canvas_prepare();

		self.setup_map_options();
		self.setup_maps();
		self.markers_process();

		// mobile behaviour
		self.mobile_init();

		self.start_scroll_check();

		// bind markers animations
		self.markers_animate_init();
	};

	/**
	 *
	 */
	self.setup_map_options = function () {

		self.MapOptions.zoom = parseInt( self.MapOptions.zoom, 10 );
		self.MapOptions.mapTypeId = google.maps.MapTypeId[ self.MapOptions.mapTypeId ];

		if ( self.MapOptions.hasOwnProperty( 'zoomControl' ) && true === self.MapOptions.zoomControl && self.MapOptions.zoomControlOptions && self.MapOptions.zoomControlOptions.hasOwnProperty( 'position' ) ) {

			/**
			 * Convert map type setting into google.maps object
			 *
			 * With style and position keys.
			 *
			 * For the position value, see [Google V3 API grid of positions](https://developers.google.com/maps/documentation/javascript/reference#ControlPosition)
			 * Options include: BOTTOM_CENTER, BOTTOM_LEFT, BOTTOM_RIGHT, LEFT_BOTTOM, LEFT_CENTER, LEFT_TOP, RIGHT_BOTTOM, RIGHT_CENTER, RIGHT_TOP, TOP_CENTER, TOP_LEFT, TOP_RIGHT
			 */
			self.MapOptions.zoomControlOptions = {
				'position': google.maps.ControlPosition[ self.MapOptions.zoomControlOptions.position ],
			};
		}
	};

	/**
	 * Initiate the map object, stored in map
	 * @return {void}
	 */
	self.setup_maps = function () {
		var m;
		var map_element;
		var maps = document.querySelectorAll( '[id^="' + self.map_id_prefix + '-"]' );

		for ( var i = 0; i < maps.length; i++ ) {
			map_element = maps[ i ];

			if ( !map_element ) {
				if ( console ) {
					console.error( 'GravityView map DOM element not found at #' + self.map_id_prefix + '-' + i.toString() + '; map not created.' );
				}
				continue;
			}

			var trafficLayer = new google.maps.TrafficLayer();
			var transitLayer = new google.maps.TransitLayer();
			var bicyclingLayer = new google.maps.BicyclingLayer();

			m = new google.maps.Map( map_element, $.extend( {}, self.MapOptions, {
				_index: i,
				_entryId: parseInt( map_element.getAttribute( 'data-entryid' ), 10 ),
				_bounds: new google.maps.LatLngBounds()
			} ) );

			if ( 1 === self.layers.bicycling ) {
				bicyclingLayer.setMap( m );
			}
			if ( 1 === self.layers.transit ) {
				transitLayer.setMap( m );
			}
			if ( 1 === self.layers.traffic ) {
				trafficLayer.setMap( m );
			}

			self.maps.push( m );

			self.set_zoom_and_center( m );
		}

	};

	/**
	 * Fixes issue where fitBounds() zooms in too far after adding markers
	 *
	 * @see http://stackoverflow.com/a/4065006/480856
	 * @since 1.3
	 * @since 1.7 added centering
	 * @param map Google map object
	 */
	self.set_zoom_and_center = function ( map ) {
		google.maps.event.addListenerOnce( map, 'idle', function () {
			if ( map.getZoom() > self.MapOptions.zoom ) {
				map.setZoom( self.MapOptions.zoom );
			}

			if ( 'undefined' !== typeof self.MapOptions.center && self.MapOptions.center.lat && self.MapOptions.center.lng ) {
				map.setCenter( self.MapOptions.center );
			}
		} );
	};

	/**
	 * Add markers to the maps.
	 *
	 * Each marker gets added to each map.
	 *
	 * @return {void}
	 */
	self.markers_process = function () {

		self.maps.forEach( function ( map ) {
			// add marker
			self.markers_info.forEach( function ( marker ) {
				self.marker_add( map, marker );
			} );

			// enable clustering and spiderfy markers
			self.setup_cluster( map );
			self.setup_spider( map );
		} );
	};

	self.setup_cluster = function ( map ) {

		// Cluster markers if option is set and map contains markers
		if ( !self.MapOptions.markerClustering || !self.markers[ map._index ] ) {
			return;
		}

		google.maps.event.addListenerOnce( map, 'idle', function () {
			new MarkerClusterer( map, self.markers[ map._index ], {
				imagePath: self.markerClusterIconPath,
				maxZoom: self.MapOptions.markerClusteringMaxZoom || self.MapOptions.zoom,
			} );
		} );
	};

	/**
	 * Add OverlappingMarkerSpiderfier to the markers
	 *
	 * @since 1.6
	 *
	 * @param map
	 */
	self.setup_spider = function ( map ) {

		// Spiderfy markers if they exist and can be found on a map
		if ( 0 === self.markers.length || !self.markers[ map._index ] ) {
			return;
		}

		google.maps.event.addListener( map, 'idle', function () {
			// Spiderfy markers
			var oms = new OverlappingMarkerSpiderfier( map, {
				markersWontMove: true,
				markersWontHide: true,
				keepSpiderfied: true,
			} );

			self.markers[ map._index ].forEach( function ( marker ) {
				oms.addMarker( marker );
			} );
		} );
	};

	/**
	 * Add marker to a map
	 *
	 * @param map google.maps.Map object
	 * @param markerData array Data passed as `markers_info` from the localized data {@see GravityView_Maps_Render_Map::localize_javascript() }
	 *
	 */
	self.marker_add = function ( map, markerData ) {
		// For single Entry Maps, filter the markers to match the entry ID
		// If entry ID is set and is different than the current marker (entry ID) do not add it to the map
		if ( map._entryId && map._entryId != markerData.entry_id ) {
			return;
		}

		var geo = new google.maps.LatLng( markerData.lat, markerData.long ),
			icon = markerData.icon_url || self.icon;

		var marker = new google.maps.Marker( {
			map: map,
			icon: icon,
			url: markerData.url,
			position: geo,
			entryId: markerData.entry_id,
			content: markerData.content,
		} );

		// Extend map bounds using marker position
		self.maps[ map._index ]._bounds.extend( marker.position );
		self.maps[ map._index ].fitBounds( self.maps[ map._index ]._bounds );

		if ( self.markers[ map._index ] === undefined ) {
			self.markers[ map._index ] = [];
		}

		self.marker_add_events( marker, map );
		self.markers[ map._index ].push( marker );
	};

	/**
	 * Add event listeners to Markers
	 *
	 * @param {object} marker google.maps.Marker
	 * @param {object} map google.maps.Map
	 */
	self.marker_add_events = function ( marker, map ) {

		if ( self.is_single_entry ) {
			return;
		}

		// The marker has been clicked.
		google.maps.event.addListener( marker, 'spider_click', function () {
			self.marker_on_click( marker );
		} );

		// on Mouse over
		google.maps.event.addListener( marker, 'mouseover', self.marker_on_over( marker ) );

		// on mouseout
		google.maps.event.addListener( marker, 'mouseout', self.marker_on_mouseout( marker ) );

		// Close infowindow when clicking the map
		google.maps.event.addListener( map, 'click', function () {
			infowindow.close();
		} );

	};

	/**
	 * Open infowindow or go to entry link when marker has been clicked
	 *
	 * @param {object} marker google.maps.Marker Google maps marker object
	 * @param {string} marker.content Infowindow markup string
	 * @param {object} marker.map A google.maps.Map object
	 * @param {string} marker.url Full URL to the marker's single entry page
	 * @param {object} marker.position A google.maps.LatLng object
	 * @param {int|string} marker.entryId Entry ID # or slug
	 */
	self.marker_on_click = function ( marker ) {
		var content = self.infowindow_get_content( marker.content );

		// Open infowindow if content is set
		if ( content ) {
			infowindow.setContent( content );
			infowindow.open( marker.map, marker );

			return;
		}

		// Go to entry link
		infowindow.close();
		window.open( marker.url, self.marker_link_target );
	};

	/**
	 * Check if the infowindow content is empty and if so add a link to the single entry (by default)
	 * @param {string} content Infowindow markup string
	 * @returns {string} Prepared Infowindow HTML, with empty image tags removed and default text added to empty links
	 */
	self.infowindow_get_content = function ( content ) {

		/**
		 * Do we accept empty infowindows?
		 * @see \GravityView_Maps_Render_Map::parse_map_options
		 */
		if ( !self.infowindow.no_empty ) {
			return content;
		}

		var $content = $( content );

		$content
		.find( 'img[src=""]' ).remove() // Remove empty images
		.end()
		.addClass( function () {
			if ( 0 === $content.find( 'img' ).length ) {
				return 'gv-infowindow-no-image';
			}
		} )
		.find( 'a.gv-infowindow-entry-link:not([allow-empty]):empty' ).text( self.infowindow.empty_text ); // Empty links get some text, unless "allow-empty" attribute is set

		return $content.prop( 'outerHTML' );
	};

	/**
	 * Highlights the assigned entry on mouse over a Marker
	 *
	 * @param marker google.maps.Marker Google maps marker object
	 * @returns {Function}
	 */
	self.marker_on_over = function ( marker ) {
		return function () {
			$( '#gv_map_' + marker.entryId ).addClass( 'gv-highlight-entry' );
		};
	};

	/**
	 * Remove the highlight of the assigned entry on mouse out a Marker
	 *
	 * @param marker google.maps.Marker Google maps marker object
	 * @returns {Function}
	 */
	self.marker_on_mouseout = function ( marker ) {
		return function () {
			$( '#gv_map_' + marker.entryId ).removeClass( 'gv-highlight-entry' );
		};
	};

	// Animate markers when mouse is over an entry

	/**
	 *  Bind events when mouse is over an entry
	 */
	self.markers_animate_init = function () {
		if ( self.is_single_entry || '' === self.icon_bounce ) {
			return;
		}
		$( '.gv-map-view' ).on( 'mouseenter', self.marker_animate );
	};

	/**
	 * Starts and Stops the marker animation
	 * @param e object Event
	 */
	self.marker_animate = function ( e ) {

		var id = this.id.replace( 'gv_map_', '' );

		self.markers.forEach( self.marker_animation_start, id );
	};

	/**
	 * Starts Bounce marker animation for the marker associated with the Entry
	 *
	 * @param marker google.maps.Marker Google maps marker object
	 * @param i
	 * @param array
	 */
	self.marker_animation_start = function ( marker, i, array ) {
		if ( marker.entryId === this ) {

			// Don't interrupt something beautiful
			if ( marker.animating ) {
				return;
			}

			marker.setAnimation( google.maps.Animation.BOUNCE );

			// stop the animation after one bounce
			setTimeout( self.marker_animation_stop, 750, marker );
		}
	};

	/**
	 * Stops all the marker animations
	 *
	 * @param marker google.maps.Marker Google maps marker object
	 * @param i
	 */
	self.marker_animation_stop = function ( marker, i ) {
		marker.setAnimation( null );
	};

	// sticky maps functions
	/**
	 * Set properties for sticky map and make sure Map Canvas height is less than 50% of window height viewport
	 * Default Canvas height = 400 px (@see assets/css/gv-maps.css )
	 */
	self.sticky_canvas_prepare = function () {
		// set map container (just for sticky purposes)
		self.map_sticky_container = $( '.gv-map-sticky-container' );

		var windowHeight = $( window ).height(),
			doubleCanvasHeight = self.map_sticky_container.height() * 2;

		// if viewport height is less than 2x 400 px
		if ( windowHeight < doubleCanvasHeight ) {
			$( '.gv-map-canvas' ).height( windowHeight / 2 );
		}

	};

	self.window_scroll_init_offset = function () {
		self.map_offset = self.map_sticky_container.offset().top;
	};

	self.scroll_set = function () {
		self.did_scroll = true;
	};

	self.start_scroll_check = function () {
		if ( self.map_sticky_container.length > 0 ) {
			$( window ).one( 'scroll', self.window_scroll_init_offset );
			setInterval( self.window_on_scroll, 250 );
		}
	};

	self.window_on_scroll = function () {
		if ( self.did_scroll ) {
			self.did_scroll = false;
			var scroll = $( window ).scrollTop();
			var canvasObj = self.map_sticky_container.find( '.' + self.map_id_prefix );
			var listObj = $( self.map_entries_container_selector );
			var canvasWidth = canvasObj.width(),
				canvasHeight = canvasObj.height();
			if ( scroll >= self.map_offset ) {
				canvasObj.width( canvasWidth );
				self.map_sticky_container.addClass( 'gv-sticky' );
				if ( self.template_layout === 'top' ) {
					listObj.css( 'margin-top', canvasHeight + 'px' );
				}

			} else {
				canvasObj.width( '100%' );
				self.map_sticky_container.removeClass( 'gv-sticky' );
				if ( self.template_layout === 'top' ) {
					listObj.css( 'margin-top', '' );
				}
			}

		}
	};

	// Mobile

	/**
	 * Check if the page is being loaded in a tablet/mobile environment,
	 *  and if yes, run special functions
	 * $mobile-portrait: 320px;
	 * $mobile-landscape: 480px;
	 * $small-tablet: 600px;
	 */
	self.mobile_init = function () {
		// only apply this logic for the map template containing the sticky map (even if it is not pinned)
		if ( self.map_sticky_container.length <= 0 ) {
			return;
		}

		if ( $( window ).width() <= parseInt( self.mobile_breakpoint, 10 ) ) {
			self.mobile_map_to_top();
		}

	};

	/**
	 * Move the sticky map to the top, when aligned to the right.
	 */
	self.mobile_map_to_top = function () {
		var parent = self.map_sticky_container.parent(),
			grandpa = $( '.gv-map-container' );

		if ( parent.hasClass( 'gv-grid-col-1-3' ) && 1 === parent.index() ) {
			parent.detach().prependTo( grandpa );
		}

	};

	// Initialize maps
	if ( !self.api_key ) {
		gvMapsDisplayErrorNotice( self.google_maps_api_key_not_found );
	} else if ( 'undefined' === typeof window.google ) {
		gvMapsDisplayErrorNotice( self.google_maps_script_not_loaded );
	} else if ( !self.markers_info.length ) {
		gvMapsDisplayErrorNotice( self.entries_missing_coordinates );
	} else {

		var infowindow = new google.maps.InfoWindow( {
			content: '',
			maxWidth: parseInt( self.infowindow.max_width, 10 ),
		} );

		self.init();
	}

	// Window scroll
	$( window ).scroll( self.scroll_set );

	// Update global variable reference
	window.GV_MAPS = self;

}( jQuery ) );
