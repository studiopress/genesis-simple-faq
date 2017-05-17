jQuery(document).ready(function($) {

	// Link click action
	$(".plugin-boilerplate-ajax-link").on( "click", function() {

		var data = {
			'action': 'plugin_boilerplate_ajax', // located in includes/class-plugin-boilerplate-ajax.php
			'nonce':  plugin_boilerplate_ajax.nonce
		};

		var button = $(this);
		var button_text = $(this).text();

		// Only run the click if the button is enabled
		if ( $(this).hasClass('disabled') ) {
			return false;
		}

		// Disable the button, show spinner.
		$(this).removeClass('enabled');
		$(this).addClass('disabled');
		$('.plugin-boilerpate-ajax-spinner').show();

		//* Main POST
		$.post( ajaxurl, data, function( response ) {

			$(button).addClass('enabled');
			$(button).removeClass('disabled');
			$('.plugin-boilerpate-ajax-spinner').hide();
			$('.plugin-boilerplate-ajax-results').html( response );
		//	$('.plugin-boilerplate-ajax-results').append( response ); // Use this to append the response to any previous.

			return false;

		});

		return false;

	});

	// Form submit action
	$( '.plugin-boilerplate-ajax-form' ).submit(function() {

		var data = {
			'action': 'plugin_boilerplate_ajax', // located in includes/class-plugin-boilerplate-ajax.php
			'nonce':  plugin_boilerplate_ajax.nonce
		};

		$('.plugin-boilerpate-ajax-spinner').show();
		$('.plugin-boilerplate-ajax-submit').prop( "disabled", true );

		//* Main POST
		$.post( ajaxurl, data, function( response ) {

			$('.plugin-boilerplate-ajax-submit').prop( "disabled", false );
			$('.plugin-boilerpate-ajax-spinner').hide();
			$('.plugin-boilerplate-ajax-results').html( response );
		//	$('.plugin-boilerplate-ajax-results').append( response ); // Use this to append the response to any previous.

			return false;

		});

		return false;

	});

});
