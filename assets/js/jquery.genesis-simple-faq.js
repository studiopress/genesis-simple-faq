( function( $, animation ) {

	// Gather all the FAQ components on the page.
	var $faqs = $( '.genesis-simple-faq' );

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
	 * @param object $faq Object of the FAQ component to setup.
	 * @return undefined
	 *
	 * @since 0.9.0
	 */
	function setupFaq( $faq ) {

		var $question = $faq.children( '.genesis-simple-faq__question' ),
			$answer   = $faq.children( '.genesis-simple-faq__answer'   );

		$question.click( function() {
			handleClickEvent( $faq );
		});

	}

	/**
	 * Handle a click event on the FAQ question element.
	 *
	 * @param  object    $target Object the click was initiated on.
	 * @return undefined
	 *
	 * @since 0.9.0
	 */
	function handleClickEvent( $faq ) {

		if ( $faq.hasClass( 'genesis-simple-faq--expanded' ) ) {

			// Parent state class.
			$faq.removeClass( 'genesis-simple-faq--expanded' );

			// Question class and attributes.
			$faq.children( '.genesis-simple-faq__question' )
				.attr( 'aria-expanded', false )
				.removeClass( 'genesis-simple-faq__question--expanded' );

			// Answer class and attributes.
			$faq.children( '.genesis-simple-faq__answer' )
				.attr( 'aria-expanded', false )
				.removeClass( 'genesis-simple-faq__answer--expanded' )

			if ( animation ) {
				$faq.children( '.genesis-simple-faq__answer' ).slideToggle( 'fast' );
			}

		} else {

			// Parent state class.
			$faq.addClass( 'genesis-simple-faq--expanded' );

			// Question class and attributes.
			$faq.children( '.genesis-simple-faq__question' )
				.attr( 'aria-expanded', true )
				.addClass( 'genesis-simple-faq__question--expanded' );

			// Answer class and attributes.
			$faq.children( '.genesis-simple-faq__answer' )
				.attr( 'aria-expanded', true )
				.addClass( 'genesis-simple-faq__answer--expanded' );

			if ( animation ) {
				$faq.children( '.genesis-simple-faq__answer' ).slideToggle( 'fast' );
			}

		}

	}

})( jQuery, genesis_simple_faq_animation.js_animation );
