<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if($_POST) {
	update_option( 'infusedwoo_tc_date', $_POST['gdpr_tc_date']);
	update_option( 'infusedwoo_tc_msg', stripslashes($_POST['gdpr_tc_intro']));
	update_option( 'infusedwoo_tc_link', stripslashes($_POST['gdpr_tc']));
	update_option( 'infusedwoo_utc_title', stripslashes($_POST['gdpr_utc_title']));
	update_option( 'infusedwoo_utc_msg', stripslashes($_POST['gdpr_utc_intro']));


	if(isset($_POST['gdpr_tc_checkout'])) update_option( 'infusedwoo_tc_checkout', 1);
	else update_option( 'infusedwoo_tc_checkout', 0);

	if(isset($_POST['gdpr_tc_reg'])) update_option( 'infusedwoo_tc_reg', 1);
	else update_option( 'infusedwoo_tc_reg', 0);

	if(isset($_POST['gdpr_tc_my_account'])) update_option( 'infusedwoo_tc_my_acct', 1);
	else update_option( 'infusedwoo_tc_my_acct', 0);

	if(isset($_POST['gdpr_utc_req'])) update_option( 'infusedwoo_utc_req', 1);
	else update_option( 'infusedwoo_utc_req', 0);

	if(isset($_POST['gdpr_tc_euonly'])) update_option( 'infusedwoo_tc_euonly', 1);
	else update_option( 'infusedwoo_tc_euonly', 0);
}

// Get Values:
$tc_date = get_option('infusedwoo_tc_date', date('Y-m-d'));
$intro = get_option('infusedwoo_tc_msg', 'I have read and agree to the [link]Terms of Service[/link]');
$link = get_option('infusedwoo_tc_link','');

$utc_title = get_option('infusedwoo_utc_title','Updates to our Terms and Conditions');
$utc_intro = get_option('infusedwoo_utc_msg','There were updates to our [link]Terms and Conditions[/link]. Please read and agree to our new terms and conditions.');

$enabled_checkout = get_option('infusedwoo_tc_checkout', 1);
$enabled_reg = get_option('infusedwoo_tc_reg', 1);
$enabled_my_account= get_option('infusedwoo_tc_my_acct', 1);
$require_utc = get_option('infusedwoo_utc_req', 1);
$enabled_eu_only = get_option('infusedwoo_tc_euonly', 0);


?>

<h1>Terms and Conditions Link</h1>
<hr>

<p>
Enter your updated, GDPR-Compliant Terms and Conditions Link below.
See more information <a href="https://termsfeed.com/blog/how-to-update-privacy-policy-gdpr-compliance/" target="_blank">here</a> on how to write an GDPR-Compliant Terms and Condition page.

</p>

<?php if($_POST) { ?>
	<div class="iwar-success-notice">Successfully Saved Settings</div>
<?php } ?>

<form method="POST">
<div class="ia-new-form">
	<hr>
	<h3>Terms and Conditions Checkbox</h3>

	<div class="form-field">
		<label>Your GDPR Compliant Terms and Conditions Link</label>
		<input type="text" class="medium-text" name="gdpr_tc" placeholder="https://" value="<?php echo $link ?>" required />
	</div>

	<div class="form-field">
		<label>Terms Last Update Date</label><br>
		<span style="font-size: 9pt;">By entering the last update date, the Terms checkbox will re-appear if the customer's last agreement date is before the Terms last update date.</span>
		<input type="text" class="medium-text" name="gdpr_tc_date" placeholder="<?php echo $tc_date ?>" value="<?php echo $tc_date ?>" required />
	</div>

	<div class="form-field">
		<label>Checkbox Label</label>
		<br><span style="font-size: 9pt;">(wrap with [link][/link], the text that will link to T&C Page)</span>
		<textarea class="medium-text" name="gdpr_tc_intro" value="" placeholder="" required><?php echo $intro ?></textarea>
	</div>

	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_tc_checkout" <?php echo $enabled_checkout ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable in Woocommerce Checkout Page
		</label>
	</div>

	<div class="form-field">
		<label class="control checkbox" >
		  <input type="checkbox" name="gdpr_tc_my_account" <?php echo $enabled_my_account ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable in Woocommerce My Account Registration Page
		</label>
	</div>

	<div class="form-field">
		<label class="control checkbox"  >
		  <input type="checkbox" name="gdpr_tc_reg" <?php echo $enabled_reg ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable in Wordpress Registration Page
		</label>
	</div>
	<div class="form-field">
		<label class="control checkbox"  >
		  <input type="checkbox" name="gdpr_tc_euonly" <?php echo $enabled_eu_only ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable only in EU Region
		</label>
	</div>

	<br>
	<hr>
	<h3>Updates to Terms and Conditions Box</h3>
	<p>Updates to Terms and Conditions Box will be available to users if their last agreement date is before the terms last update date (as set above)</p>

	<p style="text-align: center;"><a href="<?php echo site_url() . '/iw-data/terms_updates'; ?>" target="_blank">Preview the "Updates to Terms and Conditions" Box here </a></p>

	<div class="form-field">
		<label>Updates to Terms and Conditions Box Title</label><br>

		<input type="text" class="medium-text" name="gdpr_utc_title" placeholder="<?php echo $utc_title ?>" value="<?php echo $utc_title ?>" required />
	</div>

	<div class="form-field">
		<label>Updates to Terms and Conditions Box Message</label>
		<br><span style="font-size: 9pt;">(wrap with [link][/link], the text that will link to T&C Page)</span>
		<textarea class="medium-text" name="gdpr_utc_intro" value="" placeholder="<?php echo $utc_intro ?>" required><?php echo $utc_intro ?></textarea>
	</div>

	<div class="form-field">
		<label class="control checkbox"  >
		  <input type="checkbox" name="gdpr_utc_req" <?php echo $require_utc ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Require users to agree to the updated terms right after log-in (if the user hasn't agreed yet)
		</label>
	</div>

	<div class="form-field">
		<br>
		<input type="submit" class="next-button iw-ov-save" style="" value="Save"></input>
	</div>

	<br><br><br><br><br>
	<hr>
	<b>Advanced Notes:</b>
	<ul>
		<li>- When a user agrees to the terms, InfusedWoo stores the agreement date in the <b>infusedwoo_tc_agree_date</b> user meta of the wordpress user. (You can use this with other plugins for different purposes e.g. for creating a written contract of Terms with date of consent.)</li>

		<li>- You can save the contract agreement date to Infusionsoft by creating an automation recipe. Use the trigger "User Action Trigger", add Condition "If the user does this Activity > User agrees to the terms" and under Action, add "Update/Add Contact Record Field in Infusionsoft", select the Infusionsoft field and then set value to the merge string {{WPUserMeta:infusedwoo_tc_agree_date}}</li>
	</ul>
</div>
</form>
