/**
 * Part of GravityView_Maps plugin. This script is enqueued from the backend settings page.
 *
 * globals ajaxurl, jQuery, GV_MAPS_SETTINGS
 */

// make sure GV_MAPS_SETTINGS exists
window.GV_MAPS_SETTINGS = window.GV_MAPS_SETTINGS || {};

( function( $ ) {
	var $verify_key = $( 'button.gv-map-api-verify' );
	var $api_key_input_field = $( '#googlemaps-api-key' );
	var $verification = $( '#api_key_verification' );
	var $verification_error = $( '#api_key_verification_error' );
	var $required_error = $( '#api_key_required_error' );
	var $verification_response = $( '#api_key_verification_response' );
	var current_api_key = $api_key_input_field.val();

	var verify_key = function( force_verification ) {
		var updated_api_key = $api_key_input_field.val();

		$verify_key.insertAfter( $api_key_input_field );

		// API key is empty; don't process check
		if ( !updated_api_key || '' === String( updated_api_key ) ) {
			$verify_key.hide();
			$verification_response.hide();
			return;
		}

		$required_error.hide();
		$verification_response.show();
		$verify_key.show();

		if ( true !== force_verification && current_api_key === updated_api_key ) {
			return;
		}

		// Clean up before starting verification
		$verification.show();
		$verification_error.hide();
		$verify_key.prop( 'disabled', 'disabled');
		$verification_response.hide();
		$verification_response.find( 'span.dashicons' ).removeClass( 'dashicons-yes dashicons-no' );

		$.ajax( {
			type: 'POST',
			url: ajaxurl,
			data: {
				nonce: GV_MAPS_SETTINGS.nonce,
				action: GV_MAPS_SETTINGS.action_verify_api_key,
				api_key: updated_api_key,
			},
		} )
			.done( function( response ) {
				if ( ! response.success ) {
					return $verification_error.show();
				}

				$.map( response.data, function( data, capability ) {
					var $cap = $verification_response.find( '.gv-maps-api-cap-' + capability );
					$( '.dashicons', $cap ).addClass( 'dashicons-' + ( data.enabled ? 'yes' : 'no' ) );
					$( '.description', $cap ).html( data.message );
				} );

				$verification_response.show();
			} )
			.fail( function() {
				$verification_error.show();
			} )
			.always( function() {
				$verification.hide();
				$verify_key.prop( 'disabled', null );
			} );

		current_api_key = updated_api_key;
	};

	$api_key_input_field.on( 'blur', verify_key );

	$verify_key.on( 'click', function() {
		verify_key( true );
	} );

	$( document ).on( 'ready', function() {
		verify_key( true );
	} );

}( jQuery ) );
