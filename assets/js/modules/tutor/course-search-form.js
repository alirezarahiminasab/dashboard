(
	function( $ ) {
		'use strict';

		$( document ).ready( function() {
			$( '.edumall-wp-widget-course-name-filter' ).on( 'submit', '.search-form', function() {
				var baseLink = $( this ).attr( 'action' );
				var filterByKey = 'filter_name';
				var currentValue = $( this ).find( 'input[name="filter_name"]' ).val();

				if ( '' !== currentValue ) {
					baseLink = addUrlParam( baseLink, filterByKey, currentValue );
					baseLink = addUrlParam( baseLink, 'filtering', '1' );
				}

				window.location.href = baseLink;

				return false;
			} );
		} );

		/**
		 * Add a URL parameter (or changing it if it already exists)
		 * @param {string} search - This is typically document.location.search
		 * @param {string} key - The key to set
		 * @param {string} val - Value
		 */
		var addUrlParam = function( search, key, val ) {
			var key = encodeURI( key ),
			    val = encodeURI( val );
			var newParam = key + '=' + val;
			var params = '&' + newParam;

			var hasQueryString = search.indexOf( '?' );
			if ( - 1 === hasQueryString ) {
				params = '?' + newParam;
			}

			search += params;

			return search;
		};

	}( jQuery )
);
