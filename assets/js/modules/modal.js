(
	function( $ ) {
		'use strict';

		var EdumallModal = function( $el, options ) {
			this.$el = $el;
			this.ACTIVE_CLASS = 'open';
			this.initialized = false;
			this.defaults = {
				perfectScrollbar: true
			};
			this.settings = $.extend( {}, this.defaults, options );

			// jQuery methods.
			this.triggerMethod = ( method, options ) => {
				if ( typeof this[ method ] === 'function' ) {
					this[ method ]( options );
				}
			};

			this.setOptions = function( options ) {
				options = options || {};

				this.settings = $.extend( {}, this.settings, options );
			};

			this.getOptions = function() {
				return this.settings;
			};

			this.update = function( options ) {
				this.setOptions( options );
			};

			this.setHeight = function( newHeight ) {
				this.$el.find( '.modal-content-wrap' ).height( newHeight );
			};

			this.init = function() {
				var plugin = this;

				if ( false === plugin.initialized ) {
					$el.on( 'click', '.modal-overlay, .button-close-modal', function( e ) {
						e.preventDefault();
						e.stopPropagation();

						plugin.close();
					} );

					plugin.initialized = true;
					$( document.body ).trigger( 'EdumallModalInit', [ $el ] );

					plugin.open();
				}
			};

			this.open = function() {
				var plugin = this;

				$( '.edumall-modal' ).removeClass( plugin.ACTIVE_CLASS );

				plugin.init();

				$el.addClass( plugin.ACTIVE_CLASS );

				window.edumall.Helpers.setBodyOverflow();

				if ( this.settings.perfectScrollbar && $.fn.perfectScrollbar && ! window.edumall.Helpers.isHandheld() ) {
					$el.find( '.modal-content-wrap' ).perfectScrollbar();
				}

				$( document.body ).trigger( 'EdumallModalOpen', [ $el ] );
				$el.trigger( 'EdumallModalOpen' );
			};

			this.close = function() {
				var plugin = this;

				$el.removeClass( plugin.ACTIVE_CLASS );

				window.edumall.Helpers.unsetBodyOverflow();

				$( document.body ).trigger( 'EdumallModalClose', [ $el ] );
				$el.trigger( 'EdumallModalClose' );
			};

			this.init();
		};

		const namespace = 'edumallModal';

		$.fn.extend( {
			EdumallModal: function( args, update ) {
				// Check if selected element exist.
				if ( ! this.length ) {
					return this;
				}

				// We need to return options.
				if ( args === 'options' ) {
					return $.data( this.get( 0 ), namespace ).getOptions();
				}

				return this.each( function() {
					var $el = $( this );

					let instance = $.data( this, namespace );

					if ( instance ) { // Already created then trigger method.
						instance.triggerMethod( args, update );
					} else { // Create new instance.
						instance = new EdumallModal( $el, args );
						$.data( this, namespace, instance );
					}
				} );
			}
		} );
	}( jQuery )
);
