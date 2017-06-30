(function() {

	document.addEventListener( 'DOMContentLoaded', function() {

		// Gather all the FAQ components on the page.
		var faqs = document.querySelectorAll( '.gs-faq' );

		/**
		 * Method to add event handlers and actions to each FAQ component.
		 *
		 * @param  int       index Index of the current array item.
		 * @param  node      item  DOM node of the current component in the loop.
		 * @return undefined
		 *
		 * @since 0.9.0
		 */
		faqs.forEach( function( item, index ) {
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

		var question = faq.querySelector( '.gs-faq__question' ),
			answer   = faq.querySelector( '.gs-faq__answer'   );

		question.addEventListener( 'mousedown', function() {
			handleClickEvent( faq );
		});

		question.addEventListener( 'keydown', function( event ) {
			handleKeydownEvent( event, faq );
		});

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

		if ( faq.classList.contains( 'gs-faq--expanded' ) ) {

			// Parent state class.
			faq.classList.remove( 'gs-faq--expanded' );

			// Accessible attributes.
			faq.querySelector( '.gs-faq__question' )
				.setAttribute( 'aria-expanded', "false" );
			faq.querySelector( '.gs-faq__answer' )
				.setAttribute( 'aria-expanded', "false" );

			// Remove expanded classes.
			faq.querySelector( '.gs-faq__question' )
				.classList.remove( 'gs-faq__question--expanded' );
			faq.querySelector( '.gs-faq__answer' )
				.classList.remove( 'gs-faq__answer--expanded' );

			// Hide answer.
			faq.querySelector( '.gs-faq__answer' ).style.display = 'none';

		} else {

			// Parent state class.
			faq.classList.add( 'gs-faq--expanded' );

			// Accessible attributes.
			faq.querySelector( '.gs-faq__question' )
				.setAttribute( 'aria-expanded', "true" );
			faq.querySelector( '.gs-faq__answer' )
				.setAttribute( 'aria-expanded', "true" );

			// Add expanded classes.
			faq.querySelector( '.gs-faq__question' )
				.classList.add( 'gs-faq__question--expanded' );
			faq.querySelector( '.gs-faq__answer' )
				.classList.add( 'gs-faq__answer--expanded' );

			// Show answer.
			faq.querySelector( '.gs-faq__answer' ).style.display = 'block';

		}

	}

	/**
	 * Function to handle a keydown event on FAQ buttons.
	 *
	 * @param  {object}    event Event details object.
	 * @param  {node}      faq   The target FAQ component.
	 * @return {undefined}
	 *
	 * @since 0.9.0
	 */
	function handleKeydownEvent( event, faq ) {

		// If not Enter or Spacebar, do nothing.
		if ( event.keyCode !== 13 && event.keyCode !== 32 ) {
			return;
		}

		handleClickEvent( faq );

	}

})();
