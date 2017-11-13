/**
 * Plugin to control FAQ showing/hiding and accessibility attributes.
 * Accessible markup initiated by 10up Components - thanks!
 *
 * @author Calvin Koepke
 *
 * @since 0.9.1
 */
(function() {
	'use strict';

	// Determine if JS is on.
	var body = document.body;
	if ( ! body.classList.contains( 'js' ) ) {
		body.classList.add( 'js' );
	}

	var index = 0;

	document.addEventListener( 'DOMContentLoaded', function() {

		// Gather all the FAQ components on the page.
		var faqs  = document.querySelectorAll( '.gs-faq__question' );

		var groups = document.querySelectorAll('.gs-faq');

		groups.forEach(function( faq ) {

			faq.addEventListener(
				'click',
				function(e) {
					if ( e.target.classList.contains( 'gs-faq__question' ) ) {
						handleClickEvent( e.target );
					}
				}
			);

		});

		/**
		 * Method to add event handlers and actions to each FAQ component.
		 *
		 * @param  int       index Index of the current array item.
		 * @param  node      item  DOM node of the current component in the loop.
		 * @return undefined
		 *
		 * @since 0.9.0
		 */
		faqs.forEach( function( item ) {
			setupFaq( item );
		});

	});

	/**
	 * Function to initialize each FAQ component.
	 *
	 * @param  node faq DOM node of the FAQ component to setup.
	 * @return undefined
	 *
	 * @since 0.9.0
	 */
	function setupFaq( faq ) {

		var id    = index++;
		var panel = faq.nextElementSibling;

		faq.setAttribute( 'id', 'tab' + index + '-' + id );
		faq.setAttribute( 'aria-selected', 'false' );
		faq.setAttribute( 'aria-expanded', 'false' );
		faq.setAttribute( 'aria-controls', 'panel' + index + '-' + id );
		faq.setAttribute( 'role', 'tab' );

	}

	/**
	 * Handle a click event on the FAQ question element.
	 *
	 * @param  node      faq DOM node the click was initiated on.
	 * @return undefined
	 *
	 * @since 0.9.0
	 */
	function handleClickEvent( faq ) {

		var nextPanel = faq.nextElementSibling;
		var nextPanelLabel = nextPanel.getElementsByClassName( 'gs-faq__answer__heading' )[0];

		faq.classList.toggle( 'gs-faq--expanded' );

		nextPanel.classList.toggle( 'gs-faq--expanded' );
		nextPanelLabel.setAttribute( 'tabindex', '-1' );
		nextPanelLabel.focus();

		if ( nextPanel.classList.contains( 'gs-faq--expanded' ) ) {

			faq.setAttribute( 'aria-selected', 'true' )
			faq.setAttribute( 'aria-expanded', 'true' );

			nextPanel.setAttribute( 'aria-hidden', 'false' );

		} else {

			faq.setAttribute( 'aria-selected', 'false' )
			faq.setAttribute( 'aria-expanded', 'false' );

			nextPanel.setAttribute( 'aria-hidden', 'true' );

		}

	}

})();
