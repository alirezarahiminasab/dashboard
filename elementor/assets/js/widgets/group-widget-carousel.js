(
	function( $ ) {
		'use strict';

		var SwiperHandler = function( $scope, $ ) {
			var $element = $scope.find( '.tm-slider-widget' );

			$element.EdumallSwiper();
		};

		var SwiperLinkedHandler = function( $scope, $ ) {
			var $element = $scope.find( '.tm-slider-widget' );

			if ( $scope.hasClass( 'edumall-swiper-linked-yes' ) ) {
				var thumbsSlider = $element.filter( '.edumall-thumbs-swiper' ).EdumallSwiper();
				var mainSlider = $element.filter( '.edumall-main-swiper' ).EdumallSwiper( {
					thumbs: {
						swiper: thumbsSlider
					}
				} );
			} else {
				$element.EdumallSwiper();
			}
		};

		$( window ).on( 'elementor/frontend/init', function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-image-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-rich-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-modern-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-modern-slider.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-team-member-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-portfolio-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-course-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-course-category-carousel.default', SwiperHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-event-carousel.default', SwiperHandler );

			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-testimonial.default', SwiperLinkedHandler );
		} );
	}
)( jQuery );
