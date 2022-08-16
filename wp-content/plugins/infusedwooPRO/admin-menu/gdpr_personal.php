<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(isset($_GET['form']) && $_GET['form'] == 'pfields') {
	$post = array();
	foreach($_POST as $k => $v) {
		if(is_array($v)) {
			$post[$v['label']] = $v['fields'];
		} else {
			$post[$k] = $v;
		}
	}


	update_option( 'infusedwoo_data_pfields', $post );
}

if(isset($_POST['iwdata-manage'])) {
	if(isset($_POST['gdpr_data_view'])) update_option( 'infusedwoo_gdpr_data_view', 1);
	else update_option( 'infusedwoo_gdpr_data_view', 0);

	if(isset($_POST['gdpr_data_edit'])) update_option( 'infusedwoo_gdpr_data_edit', 1);
	else update_option( 'infusedwoo_gdpr_data_edit', 0);

	if(isset($_POST['gdpr_data_nonempty'])) update_option( 'infusedwoo_gdpr_data_nonempty', 1);
	else update_option( 'infusedwoo_gdpr_data_nonempty', 0);

	if(isset($_POST['gdpr_data_dl'])) update_option( 'infusedwoo_gdpr_data_dl', 1);
	else update_option( 'infusedwoo_gdpr_data_dl', 0);

	if(isset($_POST['gdpr_data_euonly'])) update_option( 'infusedwoo_gdpr_data_euonly', 1);
	else update_option( 'infusedwoo_gdpr_data_euonly', 0);

}

$gdpr_data_view = get_option('infusedwoo_gdpr_data_view'); 
$gdpr_data_edit = get_option('infusedwoo_gdpr_data_edit');
$gdpr_data_nonempty = get_option('infusedwoo_gdpr_data_nonempty');
$gdpr_data_dl = get_option('infusedwoo_gdpr_data_dl');
$gdpr_data_euonly = get_option('infusedwoo_gdpr_data_euonly');


$pfields = get_option('infusedwoo_data_pfields', array());

wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));

$fields = array(
	'Account Information' => array(
		'WPUser:user_email' 	=> 'Email Address',
		'WPUser:user_login' 	=> 'User Login',
		'WPUser:first_name' 	=> 'First Name',
		'WPUser:last_name'		=> 'Last Name',
		'WPUser:display_name'  	=> 'Display Name'
	),
	'Address Information' => array(
		'WPUser:billing_email'			=> 'Billing Email Address',
		'WPUser:billing_first_name'		=> 'Billing First Name',
		'WPUser:billing_last_name'		=> 'Billing Last Name',
		'WPUser:billing_phone'			=> 'Billing Phone',
		'WPUser:billing_address_1'		=> 'Billing Street Address 1',
		'WPUser:billing_address_2'		=> 'Billing Street Address 2',
		'WPUser:billing_city'			=> 'Billing City',
		'WPUser:billing_state'			=> 'Billing State',
		'WPUser:billing_country'		=> 'Billing Country',
		'WPUser:billing_postcode'		=> 'Billing PostCode',
		'WPUser:billing_company'		=> 'Billing Company',
		'WPUser:shipping_address_1'		=> 'Shipping Address 1',
		'WPUser:shipping_address_2'		=> 'Shipping Address 2',
		'WPUser:shipping_city'			=> 'Shipping City',
		'WPUser:shipping_state'			=> 'Shipping State',
		'WPUser:shipping_country'		=> 'Shipping Country',
		'WPUser:shipping_postcode'		=> 'Shipping PostCode',		
	),
	'Other Infusionsoft Fields' => array(
		"InfContact:MiddleName" => "Middle Name",
		"InfContact:Nickname" => "Nickname",
		"InfContact:ZipFour1" => "ZipFour",
		"InfContact:ContactNotes" => "Contact Notes",
		"InfContact:Leadsource" => "Leadsource",
		"InfContact:ZipFour2" => "Shipping ZipFour",
		"InfContact:Address3Street1" => "Optional Street Address",
		"InfContact:Address3Street2" => "Optional Street Address 2",
		"InfContact:City3" => "Optional City",
		"InfContact:State3" => "Optional State",
		"InfContact:Country3" => "Optional Country",
		"InfContact:PostalCode3" => "Optional Postal Code",
		"InfContact:ZipFour3" => "Optional ZipFour",
		"InfContact:Anniversary" => "Anniversary",
		"InfContact:Birthday" => "Birthday",
		"InfContact:ContactType" => 'Contact Type',
		"InfContact:AssistantName" => "Assistant Name",
		"InfContact:AssistantPhone" => "Assistant Phone",
		"InfContact:EmailAddress2" => "Email Address 2",
		"InfContact:EmailAddress3" => "Email Address 3",
		"InfContact:Phone2" => "Phone 2",
		"InfContact:Phone3" => "Phone 3",
		"InfContact:Fax1" => "Fax",
		"InfContact:Fax2" => "Fax 2",
		"InfContact:JobTitle" => "Job Title",
		"InfContact:SpouseName" => "Spouse Name",
		"InfContact:Title" => "Title",
		"InfContact:Website" => "Website",
		"InfContact:Language" => 'Language',
		"InfContact:TimeZone" => 'TimeZone'
	)
);


// Infusionsoft Custom Fields
if($iwpro->ia_app_connect()) {
	$custfields = $iwpro->app->dsFind("DataFormField", 200,0, "FormId", -1, array("Name","Label","DataType"));

	if(is_array($custfields) && count($custfields) > 0) {
		$fields['Infusionsoft Custom Fields'] = array();
		foreach($custfields as $custfield) {
			$fields['Infusionsoft Custom Fields']["InfContact:_" . $custfield["Name"]] = $custfield["Label"];
		}
	}
}

// Wordpress User Meta Fields
global $wpdb;
$meta_keys = $wpdb->get_results( "SELECT DISTINCT meta_key FROM {$wpdb->prefix}usermeta" );
$fields['Wordpress User Meta Fields'] = array();

foreach($meta_keys as $i => $m) {
	if($i > 42) {
		$forbid = array('capabilities','user_level','dashboard');
		$forbidden = false;
		foreach($forbid as $f) {
			if(strpos($m->meta_key, $f) !== false) {
				$forbidden = true;
				break;
			}
		}

		if($m->meta_key[0] == '_' || substr($m->meta_key, 0, 2) == 'wp') {
			$forbidden = true;
		}


		if($forbidden) continue;

		$fields['Wordpress User Meta Fields']['WPUserMeta:'.$m->meta_key] = $m->meta_key;
	}
}


$recommended_fields = array(
	'Personal Information' => array(
		'WPUser:user_email' 	=> 'Email Address',
		'WPUser:user_login'			=> 'User Login',
		'WPUser:first_name' 	=> 'First Name',
		"InfContact:MiddleName" 	=> "Middle Name",
		"InfContact:Nickname" 	=> "Nickname",
		'WPUser:last_name'		=> 'Last Name',
		'WPUser:display_name'  => 'Display Name',
		"InfContact:SpouseName" 	=> "Spouse Name",
		"InfContact:Website" 		=> "Website",
		"InfContact:Birthday" 		=> "Birthday",
		"InfContact:EmailAddress2" => "Email Address 2",
		"InfContact:EmailAddress3" => "Email Address 3",
		"InfContact:AssistantName" => "Assistant Name",
		"InfContact:AssistantPhone" => "Assistant Phone",
		
	),
	'Address Information' => array(
		'WPUser:billing_email'			=> 'Billing Email Address',
		'WPUser:billing_first_name'		=> 'Billing First Name',
		'WPUser:billing_last_name'		=> 'Billing Last Name',
		'WPUser:billing_phone'			=> 'Billing Phone',
		'WPUser:billing_address_1'		=> 'Billing Street Address 1',
		'WPUser:billing_address_2'		=> 'Billing Street Address 2',
		'WPUser:billing_city'			=> 'Billing City',
		'WPUser:billing_state'			=> 'Billing State',
		'WPUser:billing_country'		=> 'Billing Country',
		'WPUser:billing_postcode'		=> 'Billing PostCode',
		'WPUser:billing_company'		=> 'Billing Company',
		'WPUser:shipping_address_1'	=> 'Shipping Address 1',
		'WPUser:shipping_address_2'	=> 'Shipping Address 2',
		'WPUser:shipping_city'			=> 'Shipping City',
		'WPUser:shipping_state'		=> 'Shipping State',
		'WPUser:shipping_country'		=> 'Shipping Country',
		'WPUser:shipping_postcode'		=> 'Shipping PostCode',
		"WPUser:Phone2" => "Phone 2",	
		"InfContact:Address3Street1" => "Optional Street Address",
		"InfContact:Address3Street2" => "Optional Street Address 2",
		"InfContact:City3" => "Optional City",
		"InfContact:State3" => "Optional State",
		"InfContact:Country3" => "Optional Country",
		"InfContact:Phone3" => "Phone 3",
		"InfContact:Fax1" => "Fax",
		"InfContact:Fax2" => "Fax 2"
	),
);

?>

<h1>GDPR Personal Data Management</h1>
<hr>

<h3>Personal Data Fields</h3>

<p>In the left box, select the fields you consider as personal data fields and move them the right box by clicking the ">" button. If it was a mistake, click the item in the right box and click the "<" button. You can group fields by clicking "Group Fields" and this will put fields into one category.</p>
<form method="POST" class="pfield-save">
	<input type="hidden" name="compiled" />
<table width="100%">
	<tr>
		<td>
			Available Fields
		</td>
		<td></td>
		<td>Personal Data Fields
		</td>
	</tr>
	<tr>
		<td width="200">
			<select multiple name="allfields" style="width: 100%; height: 300px; " class="allfields browser-default">
				<?php 
					foreach($fields as $group => $s) {
						echo '<optgroup label="'.$group.'">';
						foreach($s as $k => $v) {
							echo '<option value="'.$k.'" iwlabel="'.$v.'">'.$v.'</option>';
						}
						echo '</optgroup>';
					}
				?>
			</select>
		</td>
		<td><center>
			<input type="button" class="button control-left" value="<"  /><br><br>
			<input type="button" class="button control-right" value=">" /><br>
			
			</center>
		</td>
		<td>
			<select multiple name="pfields" style="min-width: 100px; width: 100%; height: 300px;" class="pfields browser-default">
				
			</select>

		</td>
	</tr>
	<tr>
		<td>
			<input type="button" class="button control-rec" value="Transfer Recommended Fields >" title="Move up a field item"  />
		</td>
		<td></td>
		<td><br><input type="button" class="button control-group" value="Group Fields" title="Group your Fields using Field Groups" />
				<input type="button" class="button control-up" value="↑" title="Move up a field item"  />
				<input type="button" class="button control-down" value="↓" title="Move down a field item" /><br><br>
				<input type="button" class="button control-rename" value="Rename Field" title="Rename Field Name" />
		</td>

</table>

<input type="submit" class="next-button iw-ov-save" value="Save Settings" style="width: 100px"></input>
</form>
<br>
<hr>
<form method="POST" class="pdata-save">
<h3>Allow Data Management</h3>

<p>Allow users to view and update their data. Users will then be able to access and edit their data in the Woocommerce My Account Page > Data Tab.</p>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_data_view" <?php echo $gdpr_data_view ? 'checked' : ''; ?>>
		  <span class="control-indicator"></span>
		  Allow users to view their personal data.
		</label>
	</div>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_data_edit" <?php echo $gdpr_data_edit ? 'checked' : ''; ?>>
		  <span class="control-indicator"></span>
		  Allow users to edit their personal data.
		</label>
	</div>

	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_data_nonempty" <?php echo $gdpr_data_nonempty ? 'checked' : ''; ?>>
		  <span class="control-indicator"></span>
		  Only show fields if it is not empty
		</label>
	</div>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_data_dl" <?php echo $gdpr_data_dl ? 'checked' : ''; ?>>
		  <span class="control-indicator"></span>
		  Allow Users to download their Personal Data (JSON Format)
		</label>
	</div>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_data_euonly" <?php echo $gdpr_data_euonly ? 'checked' : ''; ?>>
		  <span class="control-indicator"></span>
		  Enable Data Management only in EU
		</label>
	</div>

	
	<br><br>
	<input type="submit" class="next-button iw-ov-save" value="Save Settings" style="width: 100px"></input>
	<input type="hidden" name="iwdata-manage" value="1" />
</form>
<br>
<hr></hr>
<form method="POST" class="pdata-save">
<h3>Data Erasure</h3>

	<p>Currently InfusedWoo doesn't provide a feature where users can erase their own personal data. And there is a reason for this:</p>

	 <p>While the right of a user to remove completely all their personal data is a requirement of EU's GDPR, it is not good to have a button where users can delete their data automatically. At the minimum, GDPR requires that there is a system where you receive requests and take note of these requests, and then process the request within 1 month. <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-to-erasure/" target="_blank">See GDPR Guidelines here.</a> To be compliant with regards to GDPR's Data Erasure policy, we advise following the steps below:

	 <ol>
	 	 <li><b>Update to version 4.9.6</b> (or above) of Wordpress as this version provides a system to track Data Erasure requests.</li>
	 	 <li><b>Data Erasure Form</b>: Create a form for accepting data erasure requests using Infusionsoft or other Web Form applications. Make sure you have a link in your support page or knowledgebase pointing to data erasure request form.</li>
	 	 <li>
	 	 	<b>Handling Request Step 1</b>: When you receive a data erasure request, first double check if they have withdrawn their consent already from the data processing they have initially requested. If they have not yet withdrawn, first ask them if their data processing requests are not anymore relevant before you proceed to data erasure.
	 	 </li>
	 	 <li>
	 	 	<b>Handling Request Step 2</b>: Go to Wordpress Admin > Tools > Erase Personal Data, and then add a new erasure request. This will send an email to the user requesting for final confirmation and also serves as a record of the request.
	 	 </li>
	 	 <li>
	 	 	<b>Handling Request Step 3</b>: Once they have confirmed the request, then you may delete the user data (and orders) in Wordpress, as well as the contact data in Infusionsoft. Send an email to the user afterwards to give a confirmation that their information has already been completely removed.
	 	 </li>
	 </ol>
	 </p>


</form>

<script>
	var recommended_fields = <?php echo json_encode($recommended_fields); ?>;
	var saved_fields =  <?php echo json_encode($pfields); ?>;
	set_pfields(saved_fields);

	jQuery('.pfield-save').submit(function() {
		// Compile First

		jQuery('.pfield-save input[type=submit]').val('Saving...');


		var compile = {};
		var grp = 0;
		jQuery('.pfields').children().each(function() {
			if(jQuery(this).prop('tagName') == 'OPTGROUP') {
				grp++;
				compile['__'+grp] = {'label': jQuery(this).attr('label'), 'fields': {}};
				items = jQuery(this).children();

				for(var c=0; c < items.length; c++ ) {
					compile['__'+grp]['fields'][jQuery(items[c]).val()] = jQuery(items[c]).attr('iwlabel');
				}
			} else {
				compile[jQuery(this).val()] = jQuery(this).attr('iwlabel');
			}
		});

		jQuery.post(window.location + '&form=pfields', compile, function(data) {
			console.log('saved');
			jQuery('.pfield-save').after('<div class="iwar-success-notice iwsv" style="margin-top: 15px;">Successfully Saved Settings</div>');

			jQuery('.pfield-save input[type=submit]').val('Save Settings');

			setTimeout(function() {
				jQuery('.iwsv').remove();
			}, 7000);
		});
		return false;
	});

	jQuery('.control-rec').click(function() {
		set_pfields(recommended_fields);
	});

	function set_pfields(recommended_fields) {
		for (var k in recommended_fields) {
			if(typeof recommended_fields[k] == 'object') {
				var fields = recommended_fields[k];
				
				if(jQuery('.pfields optgroup[label="'+k+'"]').length == 0) {
					jQuery('.pfields').append('<optgroup label="'+k+'"></optgroup>');
				}

				for(var j in fields) {
					trans_field(j, fields[j] , k);
				}
			} else {
				trans_field(k, recommended_fields[k]);
			}
		}
	}

	function trans_field(k,label, grp = "") {
		if(grp) $el = jQuery('.pfields optgroup[label="'+grp+'"]');
		else $el = jQuery('.pfields');

		if(jQuery('.pfields option[value="'+k+'"]').length == 0) {
			$trans = jQuery('.allfields option[value="'+k+'"]');
			$cl = $trans.clone();

			if($cl.attr('iwlabel') != label) {
				var new_label = label + ' (' + $cl.attr('iwlabel') + ')';
				$cl.attr('iwlabel', new_label);
				$cl.text(new_label);
			}

			$cl.appendTo($el);
			$trans.hide();
		}
	}

	jQuery('.control-right').click(function() {
		jQuery('.allfields option:selected').each(function() {
			jQuery(this).clone().appendTo('.pfields');
			
			jQuery(this).prop('selected',false);
			jQuery(this).hide();
		});
	});

	jQuery('.control-left').click(function() {
		jQuery('.pfields option:selected').each(function() {
			jQuery('.allfields option[value="' + jQuery(this).val() + '"]').prop('selected',true).show();
			
			$inv_group = false;

			if(jQuery(this).parent().prop('tagName') == 'OPTGROUP') {
				$inv_group = jQuery(this).parent();
			}

			jQuery(this).remove();
			parent_opt_if_valid($inv_group);
		});
	});

	jQuery('.control-group').click(function() {
		var selection = jQuery('.pfields option:selected');

		if(!selection.length) {
			swal({
			  title: "Invalid Selection",
			  text: 'Please select one or more fields to group.'
			});

			return false;
		}

		for(var i = 0; i < selection.length; i++) {
			if(jQuery(selection[i]).parent().prop("tagName") == 'OPTGROUP') {
				swal({
				  title: "Invalid Selection",
				  text: 'One or more items are already in a group.'
				});

				return false;
			}
		}
			

		swal({
		  title: "Group Fields",
		  text: 'Please enter a group name',
		  type: 'input',
		  showCancelButton: true,
		  closeOnConfirm: false,
		  animation: "slide-from-top"
		}, function(inputValue){
			jQuery(selection[0]).before('<optgroup label="'+inputValue+'"></optgroup>');
			
			selection.each(function() {
				jQuery(this).prop('selected',false);
				jQuery('.pfields optgroup[label="'+inputValue+'"]').append(jQuery(this));
			});

		  swal.close();
		});
	});

	jQuery('.control-up').click(function() {
		var selection = jQuery('.pfields option:selected');

		if(selection.length !== 1) {
			swal({
			  title: "Invalid Selection",
			  text: 'Please select one field item only'
			});

			return false;
		}

		if(selection.prev().length > 0) {
			if(selection.prev().prop('tagName') == 'OPTGROUP') {
				selection.prev().append(selection);
			} else {
				selection.prev().before(selection);
			}
		} else if(selection.parent().prop('tagName') == 'OPTGROUP') {
			$inv_group = selection.parent();
			selection.parent().before(selection);
			parent_opt_if_valid($inv_group);
		}
	});

	jQuery('.control-down').click(function() {
		var selection = jQuery('.pfields option:selected');

		if(selection.length !== 1) {
			swal({
			  title: "Invalid Selection",
			  text: 'Please select one field item only'
			});

			return false;
		}

		if(selection.next().length > 0) {
			if(selection.next().prop('tagName') == 'OPTGROUP') {
				selection.next().prepend(selection);
			} else {
				selection.next().after(selection);
			}
		} else if(selection.parent().prop('tagName') == 'OPTGROUP') {
			$inv_group = selection.parent();
			selection.parent().after(selection);
			parent_opt_if_valid($inv_group);
		}
	});

	jQuery('.control-rename').click(function() {
		var selection = jQuery('.pfields option:selected');

		if(selection.length !== 1) {
			swal({
			  title: "Invalid Selection",
			  text: 'Please select one field item only'
			});

			return false;
		}

		var real_label = jQuery('.allfields option[value="'+selection.val()+'"]').attr('iwlabel');

		swal({
		  title: "Rename Field",
		  text: 'Please enter the new name of the Field (Original: '+ real_label +')',
		  type: 'input',
		  showCancelButton: true,
		  closeOnConfirm: false,
		  animation: "slide-from-top"
		}, function(inputValue){
		   if(inputValue) {
			   if(inputValue != real_label) {
			   		var inside_text = inputValue + ' ('+real_label+')';
			   } else {
			   		var inside_text = real_label;
			   }

			   selection.attr('iwlabel',inputValue);
			   selection.text(inside_text);

			  swal.close();
		   }
		});
	});

	function parent_opt_if_valid($optgroup=false) {
		if($optgroup !== false) {
			if(!$optgroup.children('option').length) {
				$optgroup.remove();
			}

			return false;
		}
	}
</script>