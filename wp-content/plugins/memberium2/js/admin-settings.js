
jQuery( document ).ready( function() {

	// Simple Dropdown
	jQuery( '.basic-single' ).memb_select2();
	jQuery( '.roles-selector' ).memb_select2();

	if ( typeof actionsetlist !== 'undefined' ) {
		jQuery( '.actionsetdropdown' ).memb_select2({
			data: actionsetlist
		});
	}

	if ( typeof pagelist !== 'undefined' ) {
		jQuery( '.pagelistdropdown' ).memb_select2({
			data: pagelist
		});
	}

	if ( typeof taglist !== 'undefined' ) {
		jQuery( '.taglistdropdown' ).memb_select2({
			data: taglist
		});
		jQuery('.multitaglist,.tag-selector').memb_select2({
			data: taglist,
			tags: taglist
		});
	}

	if ( typeof requiredtaglist !== 'undefined' ) {
		jQuery( '.requiredtaglistdropdown' ).memb_select2({
			data: requiredtaglist
		});
	}

	if ( typeof membershiptaglist !== 'undefined' ) {
		jQuery( '.membershiptaglistdropdown' ).memb_select2({
			data: membershiptaglist
		});
	}

	if ( typeof themelist !== 'undefined' ) {
		jQuery( '.themelistdropdown' ).memb_select2({
			data: themelist
		});
	}

	if ( typeof productlist !== 'undefined' ) {
		jQuery( '.multiproductlistdropdown' ).memb_select2({
			tags: productlist
		});
		jQuery( '.productlistdropdown' ).memb_select2({
			data: productlist
		});
	}

	if ( typeof capabilitylist !== 'undefined' ) {
		jQuery( '.capabilitylistdropdown' ).memb_select2({
			data: capabilitylist
		});
		jQuery( '.capabilitylistdropdown' ).memb_select2({
			tags: capabilitylist
		});
	}


});
