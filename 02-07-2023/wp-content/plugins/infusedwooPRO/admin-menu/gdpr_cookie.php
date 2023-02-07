<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if($_POST) {
	update_option( 'infusedwoo_cookiealert_msg', stripslashes($_POST['gdpr_cookie_intro']));
	update_option( 'infusedwoo_cookiealert_style', stripslashes($_POST['gdpr_cookie_style']));
	update_option( 'infusedwoo_cookie_essential', stripslashes($_POST['gdpr_cookie_essential']));
	update_option( 'infusedwoo_cookie_functional', stripslashes($_POST['gdpr_cookie_functional']));
	update_option( 'infusedwoo_cookie_marketing', stripslashes($_POST['gdpr_cookie_marketing']));

	if(isset($_POST['gdpr_cookie'])) update_option( 'infusedwoo_cookie_alert', 1);
	else update_option( 'infusedwoo_cookie_alert', 0);

	if(isset($_POST['gdpr_cookie_euonly'])) update_option( 'infusedwoo_cookie_euonly', 1);
	else update_option( 'infusedwoo_cookie_euonly', 0);

	if(isset($_POST['gdpr_cookie_functional_enabled'])) update_option( 'infusedwoo_cookie_functional_enabled', 1);
	else update_option( 'infusedwoo_cookie_functional_enabled', 0);

	if(isset($_POST['gdpr_cookie_marketing_enabled'])) update_option( 'infusedwoo_cookie_marketing_enabled', 1);
	else update_option( 'infusedwoo_cookie_marketing_enabled', 0);
}

$enabled_cookie_alert = get_option('infusedwoo_cookie_alert', 0);
$enabled_eu_only = get_option('infusedwoo_cookie_euonly', 0);
$cookie_intro = get_option('infusedwoo_cookiealert_msg', 'We use cookies to enable the site\'s core functionalities. Please review our cookie policies. [link]My Preferences[/link]');
$cookie_title = get_option( 'infusedwoo_cookiealert_title', 'Cookie Policy' );
$cookie_style = get_option( 'infusedwoo_cookiealert_style', 'dark' );

$cookie_essential = get_option('infusedwoo_cookie_essential', 'These cookies are required for the site to perform its core functionalities. This includes cookies allowing you to securely log-in and log-out and make an order through our online shop.');

$cookie_functional = get_option('infusedwoo_cookie_functional', 'These are cookies needed to optimize your experience on our website. This includes analytics cookies, cookies to run 3rd party services like google maps, videos, etc.');

$cookie_functional_enabled = get_option('infusedwoo_cookie_functional_enabled', 0);

$cookie_marketing = get_option('infusedwoo_cookie_marketing', 'These are optional cookies to gather survey data and track affiliate links. We will use this data to improve our products and services.');

$cookie_marketing_enabled = get_option('infusedwoo_cookie_marketing_enabled', 0);

?>

<h1>Cookie Consent</h1>
<hr>

<form method="POST">
<div class="ia-new-form">
	<h3>Cookie Policy Alert Bar</h3>
	<p>
		Show a cookie info bar in your site so that users are aware that you use cookies in order for the site to perform its core functionalities.

	</p>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_cookie" <?php echo $enabled_cookie_alert ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable Cookie Alert Bar
		</label>
	</div>
	<div class="form-field">
		<label class="control checkbox">
		  <input type="checkbox" name="gdpr_cookie_euonly" <?php echo $enabled_eu_only  ? 'checked' : '' ?>>
		  <span class="control-indicator"></span>
		  Enable only in EU Region
		</label>
	</div>

	<!--<div class="form-field">
		<label>Cookie Consent Alert Title</label>
		<input type="text" class="medium-text" name="gdpr_cookie_title" placeholder="https://" value="<?php echo $cookie_title; ?>" required />
	</div>-->

	<div class="form-field">
		<label>Cookie Alert Bar Message</label>
		<br><span style="font-size: 9pt;">(wrap with [link][/link], the text that will link to Cookie Preferences Page - see below)</span>
		<textarea class="medium-text" name="gdpr_cookie_intro" value="" placeholder="<?php echo $cookie_intro ?>" required><?php echo $cookie_intro ?></textarea>
	</div>

	<div class="form-field">
		<label>Cookie Consent Alert Style</label>
		<select name="gdpr_cookie_style">
			<option value="dark" <?php echo $cookie_style == 'dark' ? 'selected' : '' ?>>Dark</option>
			<option value="light" <?php echo $cookie_style == 'light' ? 'selected' : '' ?>>Light</option>
			<option value="orange" <?php echo $cookie_style == 'orange' ? 'selected' : '' ?>>Orange</option>
		</select>
	</div>

	<p style="text-align: center;"><a href="<?php echo site_url() . '?iw-cookie-alert=show'; ?>" target="_blank">Preview the Cookie Alert Bar here </a></p>
	
	<hr>

	<h3>Cookie Preferences Page</h3>
	<p>
		When customer clicks the "My Preferences" link above, the customer will be sent to the cookie preferences page where they can choose what type of cookies to allow.
	</p>

	<p>
		GDPR requires that, for example, if you use google analytics on your site, then you would need to enable functional cookies below and get a permission from your user to allow functional cookies before you can embed a google analytics script.
	</p>
	<p>
		InfusedWoo saves the user's cookie preference in the "iw_cookie_consent" cookie and can have a value of "essential","functional" or "marketing". And plugins and developers can use this to enable/disable functionalities based on the user's cookie preferences.
	</p>

	<div class="form-field">
		<label>Essential Cookie Policy</label>
		<textarea class="medium-text" name="gdpr_cookie_essential" value="" placeholder="Enter your Essential Cookie Policy" required><?php echo $cookie_essential ?></textarea>
	</div>

	<div class="form-field">
		<label>Functional Cookie Policy</label>
		<br><span style="font-size: 9pt;">(Leave blank if you don't use Functional Cookies)</span>
		<textarea class="medium-text" name="gdpr_cookie_functional" value="" placeholder="Enter your Functional Cookie policy" ><?php echo $cookie_functional ?></textarea>
	</div>

	<div class="form-field">
		<label>Marketing Cookie Policy</label>
		<br><span style="font-size: 9pt;">(Leave blank if you don't use Marketing Cookies)</span>
		<textarea class="medium-text" name="gdpr_cookie_marketing" value="" placeholder="Enter your Marketing Cookie policy" ><?php echo $cookie_marketing ?></textarea>
	</div>

	<p style="text-align: center;"><a href="<?php echo site_url() . '/iw-data/cookie-policy'; ?>" target="_blank">Preview the Cookie Preferences Page Here </a></p>

	<div class="form-field">
		<br>
		<input type="submit" class="next-button iw-ov-save" style="" value="Save"></input>
	</div>
</div>
</form>