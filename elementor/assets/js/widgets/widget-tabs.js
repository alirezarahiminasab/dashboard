(
	function( $ ) {
		'use strict';

		var EdumallTabsHandler = function( $scope, $ ) {
			var $tabs = $scope.find( '.edumall-tabs' );

			$tabs.EdumallTabPanel();
		};

		$( window ).on( 'elementor/frontend/init', function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-tabs.default', EdumallTabsHandler );
		} );
	}
)( jQuery );
