(
	function( $ ) {
		'use strict';

		var EdumallGridHandler = function( $scope, $ ) {
			var $element = $scope.find( '.edumall-grid-wrapper' );

			$element.EdumallGridLayout();
		};

		$( window ).on( 'elementor/frontend/init', function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-image-gallery.default', EdumallGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-testimonial-grid.default', EdumallGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-product-categories.default', EdumallGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-course-category-cards.default', EdumallGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-course-languages.default', EdumallGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-faq-cards.default', EdumallGridHandler );
		} );
	}
)( jQuery );
