(
	function( $ ) {
		'use strict';

		elementor.channels.editor.on( 'section:activated', function( sectionName, editor ) {
			var editedElement = editor.getOption( 'editedElementView' );

			if ( sectionName == null ) {
				return;
			}

			var widgetType = editedElement.model.get( 'widgetType' );

			// Flipped true site on edit.
			if ( 'tm-flip-box' === widgetType ) {
				var isBackSection = false;

				if ( - 1 !== sectionName.indexOf( 'back_side_section' ) || - 1 !== sectionName.indexOf( 'button_style_section' ) ) {
					isBackSection = true;
				}

				editedElement.$el.toggleClass( 'edumall-flip-box--flipped', isBackSection );

				var $backLayer = editedElement.$el.find( '.back-side' );

				if ( isBackSection ) {
					$backLayer.css( 'transition', 'none' );
				}

				if ( ! isBackSection ) {
					setTimeout( function() {
						$backLayer.css( 'transition', '' );
					}, 10 );
				}
			}

			// Edit heading wrapper style.
			if ( 'tm-heading' === widgetType && 'wrapper_style_section' === sectionName ) {
				editedElement.$el.addClass( 'edumall-heading-wrapper-editing' );
			} else {
				editedElement.$el.removeClass( 'edumall-heading-wrapper-editing' );
			}

			// Force show arrows when editing arrows of any widgets has swiper.
			if ( 'swiper_arrows_style_section' === sectionName ) {
				editedElement.$el.addClass( 'edumall-swiper-arrows-editing' );
			} else {
				editedElement.$el.removeClass( 'edumall-swiper-arrows-editing' );
			}

			// Force show marker overlay when editing.
			if ( 'markers_popup_style_section' === sectionName ) {
				editedElement.$el.addClass( 'edumall-map-marker-overlay-editing' );
			} else {
				editedElement.$el.removeClass( 'edumall-map-marker-overlay-editing' );
			}
		} );

		var EdumallElementor = {
			helpers: {
				getRepeaterSelectOptionText: function( widgetName, repeaterControlName, repeaterSelectName, repeaterSelectValue ) {
					var elementorWidgets = elementor.documents.currentDocument.config.widgets;

					if ( typeof elementorWidgets[ widgetName ] === undefined ) {
						return '';
					}

					var widgetControls = elementorWidgets[ widgetName ].controls;

					if ( typeof widgetControls[ repeaterControlName ] === undefined ) {
						return '';
					}

					var repeaterControl = widgetControls[ repeaterControlName ];

					var repeaterSelectControl = repeaterControl.fields[ repeaterSelectName ];

					var text = _.unescape( repeaterSelectControl.options[ repeaterSelectValue ] );
					
					return text;
				}
			}
		};

		window.EdumallElementor = EdumallElementor;
	}
)( jQuery );
