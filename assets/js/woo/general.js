(
	function( $ ) {
		'use strict';

		var $body = $( 'body' );

		$( document ).ready( function() {
			initQuickViewPopup();
			addToCartNotification();
			singleProductAddToCart();
		} );

		function initQuickViewPopup() {
			$( '.edumall-product' ).on( 'click', '.quick-view-btn', function( e ) {
				e.preventDefault();
				e.stopPropagation();

				var $button = $( this );

				var $actions = $button.parents( '.product-actions' ).first();
				$actions.addClass( 'refresh' );

				$button.addClass( 'loading' );
				var productID = $button.data( 'pid' );

				/**
				 * Avoid duplicate ajax request.
				 */
				var $popup = $body.children( '#' + 'popup-product-quick-view-content-' + productID );
				if ( $popup.length > 0 ) {
					openQuickViewPopup( $popup, $button );
				} else {
					var data = {
						action: 'product_quick_view',
						pid: productID
					};

					$.ajax( {
						url: $edumall.ajaxurl,
						type: 'POST',
						data: $.param( data ),
						dataType: 'json',
						success: function( results ) {
							$popup = $( results.template );
							$body.append( $popup );
							openQuickViewPopup( $popup, $button );
						},
					} );
				}
			} );
		}

		function openQuickViewPopup( $popup, $button ) {
			$button.removeClass( 'loading' );

			$.magnificPopup.open( {
				mainClass: 'mfp-fade popup-product-quick-view',
				items: {
					src: $popup.html(),
					type: 'inline'
				},
				callbacks: {
					open: function() {
						var $contentWrap = this.content.find( '.product-container' );

						// Max height of popup = Window height - top bottom spacing.
						var popupHeight = window.innerHeight - 60;

						// If window height large then used fixed height.
						// Popup max height = 760.
						popupHeight = Math.min( popupHeight, 760 );

						$contentWrap.outerHeight( popupHeight );

						$contentWrap.perfectScrollbar( {
							suppressScrollX: true
						} );

						var $sliderWrap = this.content.find( '.woo-single-gallery' );
						var thumbsSlider = $sliderWrap.children( '.edumall-thumbs-swiper' ).EdumallSwiper();
						var mainSlider = $sliderWrap.children( '.edumall-main-swiper' ).EdumallSwiper( {
							thumbs: {
								swiper: thumbsSlider
							}
						} );

						if ( typeof isw != 'undefined' && typeof isw.Swatches !== 'undefined' ) {
							isw.Swatches.init();
						}

						// Re init add to cart form variation.
						if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
							this.content.find( '.variations_form' ).each( function() {
								$( this ).wc_variation_form();
							} );
						}

						var $form = this.content.find( '.variations_form' );
						var variations = $form.data( 'product_variations' );

						$form.find( 'select' ).on( 'change', function() {
							var isFieldSelected = true;
							var needReset = false;
							var globalAttrs = {};

							var formValues = $form.serializeArray();

							// Check all attributes selected.
							for ( var i = 0; i < formValues.length; i ++ ) {

								var _name = formValues[ i ].name;

								if ( _name.substring( 0, 10 ) === 'attribute_' ) {

									globalAttrs[ _name ] = formValues[ i ].value;

									if ( formValues[ i ].value === '' ) {
										isFieldSelected = false;

										break;
									}
								}
							}

							if ( isFieldSelected === true ) {
								// Convert to array.
								var selectedAttributes = Object.entries( globalAttrs );

								var variationImageID = 0;
								var minMatch = 0;

								for ( var i = variations.length - 1; i >= 0; i -- ) {
									var currentVariation = variations[ i ];
									var currentAttributes = Object.entries( currentVariation.attributes ); // Convert to array.
									var loopMatch = 0;

									// Compare selected variation with all variations to find best matches.
									currentAttributes.forEach( ( [ key, value ] ) => {
										selectedAttributes.forEach( ( [ selectedKey, selectedValue ] ) => {

											if ( selectedKey === key ) {
												if ( selectedValue === value
												     || '' === value // Any Terms.
												) {
													loopMatch ++;
												}
											}
										} );
									} );

									if ( minMatch < loopMatch ) {
										minMatch = loopMatch;
										variationImageID = currentVariation.image_id;
									}
								}

								if ( variationImageID ) {
									mainSlider.$wrapperEl.find( '.swiper-slide' ).each( function( index ) {
										var slideImageID = $( this ).attr( 'data-image-id' );
										slideImageID = parseInt( slideImageID );

										if ( slideImageID === variationImageID ) {
											mainSlider.slideTo( index );

											return false;
										}
									} );
								} else {
									needReset = true;
								}
							} else {
								needReset = true;
							}

							// Reset to main image.
							if ( needReset ) {
								var $mainImage = mainSlider.$wrapperEl.find( '.product-main-image' );
								var index = $mainImage.index();
								mainSlider.slideTo( index );
							}
						} );
					},
				}
			} );
		}

		function addToCartNotification() {
			var edumallNotices = [];

			$body.on( 'click', '.ajax_add_to_cart:not(.disabled)', function() {
				var $addedProduct = $( this ).parents( '.cart-notification' ).first();
				var settings = $addedProduct.data( 'notification' );

				var addedText = '<span class="added-text">' + $edumall.noticeAddedCartText + '</span>';
				var messages = addedText;

				if ( settings !== undefined ) {
					messages = '<div class="product-added-cart">';
					if ( '' !== settings.image ) {
						messages += '<div class="product-thumbnail"><img src="' + settings.image + '" alt="' + settings.title + '"/></div>'
					}
					messages += '<div class="product-caption"><h3 class="product-title">' + settings.title + ' </h3>' + addedText + '</div>';
					messages += '</div>'
				}

				messages += '<div class="tm-button-wrapper btn-view-cart"><a href="' + $edumall.noticeCartUrl + '" class="tm-button button-grey style-flat tm-button-xs tm-button-full-wide">' + $edumall.noticeCartText + '</a></div>';

				edumallNotices.push( messages );
			} );

			$body.on( 'added_to_cart', function() {
				for ( var i = 0; i < edumallNotices.length; i ++ ) {
					var messages = edumallNotices[ i ];

					$.growl( {
						location: 'br',
						duration: 5000,
						title: '',
						message: messages,
					} );

					edumallNotices.splice( i, 1 );
				}
			} );
		}

		function singleProductAddToCart() {
			// wc_add_to_cart_params is required to continue, ensure the object exists.
			if ( typeof wc_add_to_cart_params === 'undefined' ) {
				return false;
			}

			// Ajax add to cart.
			$( document ).on( 'click', '.single_add_to_cart_button', function( evt ) {
				var $thisButton = $( this );

				// Do nothing if this is external product.
				if ( ! $thisButton.hasClass( 'external-add-to-cart-button' ) ) {
					evt.preventDefault();

					if ( $thisButton.hasClass( 'disabled' ) ) { // Variation select required.
						return false;
					}

					if ( $thisButton.hasClass( 'woosb-disabled' ) ) { // Smart Bundle select required.
						return false;
					}

					var $variation_form = $( this ).closest( 'form.cart' );
					var var_id = $variation_form.find( 'input[name=variation_id]' ).val();
					var product_id = $variation_form.find( 'input[name=product_id]' ).val();
					var quantity = $variation_form.find( 'input[name=quantity]' ).val();

					if ( 'add-to-cart' === $thisButton.attr( 'name' ) ) {
						product_id = $thisButton.val();
					}

					$thisButton.removeClass( 'added' ).addClass( 'loading updating-icon' );

					var data = {
						action: 'edumall_woocommerce_add_to_cart',
						'product_id': product_id
					};

					$variation_form.serializeArray().map( function( attr ) {
						if ( attr.name !== 'add-to-cart' ) {
							if ( attr.name.endsWith( '[]' ) ) {
								let name = attr.name.substring( 0, attr.name.length - 2 );
								if ( ! (
									name in data
								) ) {
									data[ name ] = [];
								}
								data[ name ].push( attr.value );
							} else {
								data[ attr.name ] = attr.value;
							}
						}
					} );

					// Trigger event.
					$( 'body' ).trigger( 'adding_to_cart', [ $thisButton, data ] );

					// Ajax action.
					$.post( wc_add_to_cart_params.ajax_url, data, function( response ) {

						if ( ! response ) {
							return;
						}

						if ( response.error && response.product_url ) {
							window.location = response.product_url;
							return;
						}

						// Redirect to cart option
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}

						// Trigger event so themes can refresh other areas.
						$( document.body ).trigger( 'added_to_cart', [
							response.fragments,
							response.cart_hash,
							$thisButton
						] );

					} ).always( function() {
						$thisButton.addClass( 'added' ).removeClass( 'loading updating-icon' );
					} );

					return false;
				}
			} );
		}
	}( jQuery )
);
