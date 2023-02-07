<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(isset($_POST['token-expiration'])) {
	update_option( 'iw_gdpr_link_expires', $_POST['token-expiration'] );
} 

$token_expire = get_option('iw_gdpr_link_expires', '72' );

wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));

$http_post_uri = site_url() . '/iw-data/gen_token/' . infusedwoo_get_admin_token();

$cfield = get_option( 'infusedwoo_gdpr_links_iwcfield', '' );

?>
<style type="text/css">
	.link_box input {
		font-size: 13pt;
		width: 90%;
		padding: 5px;
	}
</style>

<h1>GDPR Tokenized Links</h1>

<p>Below are links you can include in your email communications with your contacts to confirm or refresh their data preferences. GDPR requires that user's data and preferences should be easily accessible. For example, you can put a link to update their email preferences just above Infusionsoft's unsubscribe link. This will also reduce the unsubscribe rates as users have an option to reduce the emails by choosing ones that they really need instead of fully opting out from your emailing service.</p>


<hr>

<h3>Tokenized Links</h3>

<p>The use of tokenized links is a secure way of sending links as they do not contain delicate information such as email address. The links also auto-expire after few days to prevent possible unauthorized access in the event that emails were unintentionally shared by the account owner.</p>

<p><b>Updates to our Terms and Conditions Link</b>
	<br>

	<div class="link_box">
	<input type="text" value="<?php echo site_url() ?>/iw-data/terms_updates/[token]" readonly class="tclink">
	</div>
</p>

<p><b>My Contact Preferences Link</b>
	<br>

	<div class="link_box">
	<input type="text" value="<?php echo site_url() ?>/iw-data/consent/[token]" readonly class="datalink">
	</div>
</p>

<p><b>Cart Retrieval Link (For Cart Abandonment)</b>
	<br>

	<div class="link_box">
	<input type="text" value="<?php echo site_url() ?>/iw-data/saved_cart/[token]" readonly class="datalink">
	</div>
</p>

<br>
<input type="button" class="button gen-tokens" value="Generate a Token" />
<br><br>
<hr>
<h3>Auto-generate Tokens</h3>

<p>
	By posting to this HTTP POST URL, tokens will be automatically generated and can be saved to an Infusionsoft contact custom field.

	<div class="big-row">
		 Select Infusionsoft Custom Field &nbsp;&nbsp;<select style="width: 200px;" class="iw-cfield">
		 	<option value="">Select Custom Field ...</option>
		 <?php 
		 	if($iwpro->ia_app_connect()) {
				$custfields = $iwpro->app->dsFind("DataFormField", 200,0, "FormId", -1, array("Name","Label","DataType"));

				if(is_array($custfields) && count($custfields) > 0) {
					$fields['Infusionsoft Custom Fields'] = array();

					foreach($custfields as $custfield) {
						echo '<option value="'."_" . $custfield["Name"].'"'. ($cfield == $custfield["Name"] ? 'selected' : '' ) .'>'.$custfield["Label"].'</option>';
					}
				}
			}
		 ?>

		 </select><br><br>
	</div>
	<b>HTTP POST URL</b><br>
		<div class="link_box">
			<input type="text" value="<?php echo $http_post_uri ?>" readonly class="httppostlink">
		</div>

	<br><b>Learn More</b><br><br>
		Please see <a href="https://infusedaddons.com/guides/infusedwoo/sending-emails-with-gdpr-tokenized-links/" target="_blank">this guide</a> to learn more how to effectively used the tokenized links.
		
</p>

<hr>
		<h3>Token Lifetime</h3>
		Set the number of hours tokens will remain active.
		<br><br>
		<form method="POST">
		<div class="big-row">
			<label>Lifetime </label> <input type="text" style="width: 60px;" name="token-expiration" 
			value="<?php echo $token_expire; ?>"/> &nbsp;&nbsp;(hrs)
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" class="button" value="Save" />
		</div>
		</form>

		<br><br>
		* In case that the user tries to access a link with an expired token, they can request to have a new token sent to them via email

<script type="text/javascript">
	var iw_http_post_uri = <?php echo json_encode($http_post_uri); ?>;
	var cfield = <?php echo json_encode($cfield); ?>;



	jQuery(".gen-tokens").click(function() {
		swal({   
			title: "Enter Contact Email",   
			text: "A token will be generated for this contact.\nThe token will be only valid to this user.",   
			type: "input",   
			showCancelButton: true,   
			closeOnConfirm: false,   
   			inputPlaceholder: "user@domain.com",
   			showLoaderOnConfirm: true,
   		}, function(inputValue) {   
   				if (inputValue === false) return false;      
   				if (inputValue === "") {     
   					swal.showInputError("Please enter contact's email address.");     
   					return false;
   				}

   				jQuery.post(ajaxurl + '?action=iw_gdpr_gen_token', {
   					email: inputValue
				}, function(data){
					if(data.token) {
						
						iw_set_token(data.token);
						swal.close();
					}					
					
				},'json');
   			});
		});

	jQuery('.iw-cfield').change(function() {
		var cfield = jQuery(this).val();

		if(cfield) {
			jQuery('.httppostlink').val(iw_http_post_uri  + '/' + cfield);
			iw_set_token('~Contact.' + cfield + '~');
		} else {
			iw_set_token('[token]');
			jQuery('.httppostlink').val(iw_http_post_uri);
		}
		

		jQuery.post(ajaxurl + '?action=iw_gdpr_links_iwcfield', {
				cfield: cfield
		}, function(data){
			// just silence
		},'json');
	});

	jQuery('.iw-cfield').val(cfield);
	jQuery('.iw-cfield').trigger('change');

	function iw_set_token(token) {
		jQuery(".link_box > input").each(function() {
			var href = jQuery(this).val();
			var to_replace = jQuery(this).attr('token') ? jQuery(this).attr('token') : '[token]';
			jQuery(this).attr('token', token);
			jQuery(this).val(href.replace(to_replace,token));
		});
	}
</script>
