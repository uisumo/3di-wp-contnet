jQuery( document ).ready( function() {

	if ( typeof memb_select2 !== 'undefined') {
		memberium_meta_update();

		jQuery(".tag-selector").memb_select2({
			tags: taglist
		});

		jQuery(".actionset-selector").memb_select2({});
	 }

});

function memberium_meta_update() {

	var prohibited_action = jQuery( '#is4wp_prohibited_action option:selected' ).text();
	if ( prohibited_action !== 'Redirect' && prohibited_action !== 'Site Default (Redirect)' ) {
		jQuery( '#is4wp_redirect_url' ).prop( 'disabled', true );
	}

	if ( jQuery( "#is4wp_force_public" ).is(":checked") ) {
		jQuery( '.memberium_membership_checkbox' ).prop( 'checked', false );
		jQuery( '#is4wp_anymembership' ).prop( 'checked', false );
		jQuery( '#is4wp_anonymous_only' ).prop( 'checked', false );
		jQuery( '#is4wp_loggedin' ).prop( 'checked', false );
		jQuery( '.memb_redirect_options' ).hide();
		jQuery( '.memb_access_options' ).hide();
		jQuery( '#is4wp_redirect_url' ).prop( 'disabled', true );
	}

	if ( jQuery( "#is4wp_loggedin" ).is(":checked") ) {
		jQuery(".memberium_membership_checkbox").prop( "checked", false );
		jQuery("#is4wp_force_public").prop( "checked", false );
		jQuery("#is4wp_anymembership").prop( "checked", false );
		jQuery("#is4wp_anonymous_only").prop("checked", false );
	}

	if ( jQuery( "#is4wp_anonymous_only" ).is(":checked") ) {
		jQuery(".memberium_membership_checkbox").prop( "checked", false);
		jQuery("#is4wp_force_public").prop( "checked", false );
		jQuery("#is4wp_anymembership").prop("checked", false);
		jQuery("#is4wp_loggedin").prop("checked", false);
	}

	if ( jQuery( "#is4wp_anymembership" ).is(":checked") ) {
		jQuery(".memberium_membership_checkbox").prop( "checked", true);
		jQuery("#is4wp_anonymous_only").prop( "checked", false );
		jQuery("#is4wp_loggedin").prop( "checked", false );
	}

	if ( ! jQuery( ".memberium_membership_checkbox" ).is(":checked") ) {
		jQuery( '#is4wp_anymembership' ).prop( 'checked', false );
	}

	jQuery("#is4wp_prohibited_action").change( function() {
		var prohibited_action = jQuery("#is4wp_prohibited_action option:selected").text();
		if ( prohibited_action !== "Redirect" && prohibited_action !== "Site Default (Redirect)" ) {
			jQuery("#is4wp_redirect_url").prop( "disabled", true );
			jQuery("#is4wp_redirect_url").hide();
		}
		else {
			jQuery("#is4wp_redirect_url").prop( "disabled", false );
			jQuery("#is4wp_redirect_url").show();
		}
	});

	jQuery("#is4wp_force_public").change( function() {
		if ( jQuery( "#is4wp_force_public" ).is(":checked") ) {
			jQuery( '.memberium_membership_checkbox' ).prop( 'checked', false );
			jQuery( '#is4wp_anymembership' ).prop( 'checked', false );
			jQuery( '#is4wp_anonymous_only' ).prop( 'checked', false );
			jQuery( '#is4wp_loggedin' ).prop( 'checked', false );
			jQuery( '.memb_redirect_options' ).hide();
			jQuery( '.memb_access_options' ).hide();
			jQuery( '#is4wp_redirect_url' ).prop( 'disabled', true );
		}
		else {
			jQuery( '.memb_redirect_options' ).show();
			jQuery( '.memb_access_options' ).show();
			jQuery( '#is4wp_redirect_url' ).prop( 'disabled', false );
		}
	});

	jQuery("#is4wp_loggedin").change( function() {
		if ( jQuery( "#is4wp_loggedin" ).is(":checked") ) {
			jQuery( '#is4wp_force_public' ).prop( 'checked', false );
			jQuery(".memberium_membership_checkbox").prop( "checked", false );
			jQuery("#is4wp_anymembership").prop( "checked", false );
			jQuery("#is4wp_anonymous_only").prop("checked", false );
		}
	});

	jQuery("#is4wp_anonymous_only").change( function() {
		if ( jQuery( "#is4wp_anonymous_only" ).is(":checked") ) {
			jQuery(".memberium_membership_checkbox").prop( "checked", false);
			jQuery("#is4wp_anymembership").prop("checked", false);
			jQuery( '#is4wp_force_public' ).prop( 'checked', false );
			jQuery("#is4wp_loggedin").prop("checked", false);
		}
		else {
		}
	});

	jQuery(".memberium_membership_checkbox").change( function() {
		if ( jQuery( ".memberium_membership_checkbox" ).is(":checked") ) {
			jQuery( '#is4wp_force_public' ).prop( 'checked', false );
			jQuery("#is4wp_anonymous_only").prop("checked", false );
			jQuery("#is4wp_anymembership").prop( "checked", false );
			jQuery("#is4wp_loggedin").prop( "checked", false );
		}
		else {
		}
	});

	jQuery("#is4wp_anymembership").change( function() {
		if ( jQuery( "#is4wp_anymembership" ).is(":checked") ) {
			jQuery(".memberium_membership_checkbox").prop( "checked", true);
			jQuery( '#is4wp_force_public' ).prop( 'checked', false );
			jQuery("#is4wp_anonymous_only").prop( "checked", false );
			jQuery("#is4wp_loggedin").prop( "checked", false );
		}
		else {
			jQuery("#is4wp_anymembership").prop( "disabled", false );
			jQuery("#is4wp_loggedin").prop( "disabled", false );
		}
	});
}
