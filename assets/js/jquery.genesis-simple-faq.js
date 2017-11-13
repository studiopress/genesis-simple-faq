/**
 * Plugin to control FAQ showing/hiding and accessibility attributes.
 * Accessible markup initiated by 10up Components - thanks!
 *
 * @author Calvin Koepke
 *
 * @since 0.9.1
 */
( function( $, animation ) {
	'use strict';

	// Determine if JS is on.
	$( 'body' ).addClass( 'js' );

	// Gather all the FAQ components on the page.
	var $faqs = $( '.gs-faq__question' );
	var index = 0;

	// Event handler for toggling.
	$( '.gs-faq' ).on( 'click', '.gs-faq__question', function() {
		handleClickEvent( $(this) );
	});

	/**
	 * Method to add event handlers and actions to each FAQ component.
	 *
	 * @param  int       index Index of the current array item.
	 * @param  object    faq   DOM node of the current component in the loop.
	 * @return undefined
	 *
	 * @since 0.9.0
	 */
	$faqs.each( function( index, item ) {

		var $faq = $(item);
		setupFaq( $faq );

	});

	/**
	 * Function to initialize each FAQ component.
	 *
	 * @param {Object} $faq Object of the FAQ component to setup.
	 *
	 * @since 0.9.0
	 */
	function setupFaq( $faq ) {

		var id     = index++,
			$panel = $faq.next();

		// Add animation class.
		if ( animation ) {
			$panel.removeClass( 'no-animation' );
		}

		$faq
			.attr( 'id', 'tab' + index + '-' + id )
			.attr( 'aria-selected', 'false' )
			.attr( 'aria-expanded', 'false' )
			.attr( 'aria-controls', 'panel' + index + '-' + id )
			.attr( 'role', 'tab' );

		$panel
			.attr( 'id', 'panel' + index + '-' + id )
			.attr( 'aria-hidden', 'true' )
			.attr( 'aria-labelledby', 'tab' + index + '-' + id )
			.attr( 'role', 'tabpanel' );

	}

	/**
	 * Handle a click event on the FAQ question element.
	 *
	 * @param {Object} $faq Object the click was initiated on.
	 *
	 * @since 0.9.0
	 */
	function handleClickEvent( $faq ) {

		var $nextPanel      = $faq.next();
		var $nextPanelLabel = $nextPanel.find( '.gs-faq__answer__heading' );

		$faq.toggleClass( 'gs-faq--expanded' );

		$nextPanel.toggleClass( 'gs-faq--expanded' );
		$nextPanelLabel
			.attr( 'tabindex', '-1' )
			.focus();

		if ( animation ) {
			$nextPanel.slideToggle( 200, function() {
				$nextPanelLabel.focus();
			});
		}

		if ( $nextPanel.hasClass( 'gs-faq--expanded' ) ) {

			$faq
				.attr( 'aria-selected', 'true' )
				.attr( 'aria-expanded', 'true' );
			$nextPanel
				.attr( 'aria-hidden', 'false' );

		} else {

			$faq
				.attr( 'aria-selected', 'false' )
				.attr( 'aria-expanded', 'false' );
			$nextPanel
				.attr( 'aria-hidden', 'true' );

		}

	}

})( jQuery, gs_faq_animation.js_animation );
