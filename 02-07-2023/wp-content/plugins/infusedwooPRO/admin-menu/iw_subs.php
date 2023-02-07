<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$iw_subs_settings = get_option( 'iw_sub_settings', array() );

$gateways = WC()->payment_gateways->get_available_payment_gateways();
$pgenabled = false;

if($gateways) foreach($gateways as $gateway) {
	if($gateway->id == 'infusionsoft_cc') {
		$pgenabled = $gateway->enabled == 'yes';
	}
}

?>

<h1>Setting up Subscriptions in InfusedWoo</h1>
<hr>
<div class="iw-admin-subs">
<?php if(!$pgenabled) { ?>
	<div style="color:red; margin: 20px 0; padding: 20px; border: 1px dashed #999;">Note: InfusedWoo subscriptions requires Infusionsoft Payment Gateway.
		Please enable Infusionsoft Payment Gateway first to use this feature of InfusedWoo. 

		<br><br><br>
		<center>
		<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=infusionsoft_cc');?>">
		<div class="big-button">Configure Infusionsoft Gateway
		</div>
		</a>
		</center>
		<br>
	</div>
<?php } ?>
	If you have enabled <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=infusionsoft_cc');?>">Infusionsoft Payment Gateway</a>,
	then you can set your woocommerce products as subscriptions and sell these subscriptions in your woocommerce shop.
	<br><br>

	<a href="#help1" class="modal-trigger">How do I link Infusionsoft Subscription to Woocommerce Products?</a>

	<h3>My Account Page</h3>
	<br>
	<div class="switch">
		<label style="width: 100%; font-size: 11pt; color: #222;">
		<input name="myacct_show" type="checkbox" 
			<?php echo isset($iw_subs_settings['myacct_show']) && $iw_subs_settings['myacct_show'] ? "checked" : ""; ?>>
		<span class="lever"></span>
			Allow users to see their subscriptions in the "My Account" Page.
		</label>
  	</div>
	  <br>
	<div class="iw-subs-ma-on" style="display: none;">
		<div class="switch">
			<label style="width: 100%; font-size: 11pt; color: #222;">
			<input name="cancel_show" type="checkbox"
				<?php echo isset($iw_subs_settings['cancel_show']) && $iw_subs_settings['cancel_show'] ? "checked" : ""; ?>>
			<span class="lever"></span>
				Show "Cancel Subscription" link in the "My Account Page".
			</label>
		</div>
		<br>
			<div class="switch">
				<label style="width: 100%; font-size: 11pt; color: #222;">
				<input name="prices_show" type="checkbox"
					<?php echo isset($iw_subs_settings['prices_show']) && $iw_subs_settings['prices_show'] ? "checked" : ""; ?>>
				<span class="lever"></span>
					Hide the subscription prices in the "My Account Page".
				</label>
			</div>
			<br>
			<div class="switch">
					<label style="width: 100%; font-size: 11pt; color: #222;">
					<input name="inactive_show" type="checkbox"
						<?php echo isset($iw_subs_settings['inactive_show']) && $iw_subs_settings['inactive_show'] ? "checked" : ""; ?>>
					<span class="lever"></span>
						Show Inactive Subscriptions
					</label>
			</div><br>

			<div class="switch-attach">
				<div class="switch">
					<label style="width: 100%; font-size: 11pt; color: #222;">
					<input name="show_to_some" type="checkbox"
						<?php echo isset($iw_subs_settings['show_to_some']) && $iw_subs_settings['show_to_some'] ? "checked" : ""; ?>>
					<span class="lever"></span>
						Only show certain subscription products
					</label>
				</div>
				<div style="padding-left: 20px;" class="switch-attach-content">
					<div class="iw4-subs" placeholder="Enter Subscription Product Names...">
						<input type="hidden" name="show_to" value="<?php echo isset($iw_subs_settings['show_to']) ? $iw_subs_settings['show_to'] : ""; ?>" />
					</div>
				</div>
			</div>

			<br><br>
				
				<i data-target="help2" class="material-icons show-help modal-trigger"  title="Click for more help">help_outline</i> <a href="#help2" class="modal-trigger"> &nbsp; &nbsp;Would you like to run actions when a subscription is cancelled?</a>
	</div>
	<div class="modal" id="help1">
		<div class="modal-content" style="width: 100%;">
		
			<h2>Setting Up Infusionsoft Subscriptions</h2>

			In InfusedWoo, you can set your woocommerce products as subscriptions. 
			When you do this, the woocommerce product will be tied up to an infusionsoft subscription and when purchased it will start a subscription in Infusionsoft. 
			<br><br>
				Follow the steps below to setup your subscriptions in woocommerce. 
			
				<br><br>
			<b>1. Add Subscription Plans to your Infusionsoft Products</b>
			<br><br>
			In infusionsoft, go to Ecommerce → Products. Then go to the "Subscription Plans" tab as shown above. Add a subscription here by entering the billing frequency, billing cycle and plan price. Once done, hit "Save".
			<br><br>
			<img src="https://cdn-std.droplr.net/files/acc_609773/P5rYbY" style="max-width: 100%;" />
			<br><br>

			<b>2. Add Subscription Plans to your Infusionsoft Products</b>
			<br><br>
			When editing or adding a new product, go to Product Data → Infusionsoft Tab. 
			In the "Product or Subscription?" dropdown, select "Subscription". 
			Then select the subscription you want to use for this product. If the subscription plan doesn't appear in the dropdown, simply click the refresh link at the bottom. 
			<br><br>
			You can also configure the subscription to have trial days.
			</b>
			<br><br>
			<img src="https://cdn-std.droplr.net/files/acc_609773/TWPJtB" style="max-width: 100%;" />
		</div>
	</div>
	<div class="modal" id="help2">
		<div class="modal-content" style="width: 100%;">
		
			<h2>Running actions when a subscription is cancelled</h2>

			You can run actions when a user cancelled their subscription. This is handy if you want to send out a notice to an admin that a subscription is cancelled, or if you would like to send an email 
			asking the user for a feedback.
			<br><br>
				To run actions upon subscription cancellation, you need to create a new Automation Recipe via InfusedWoo Menu > Automation > Automation Recipes.
			
				<br><br>
			<b>1. Set the Automation Trigger to "User Action Trigger"</b>
			<br><br>
			See the screenshot below, set the Automation Trigger to "User Action Trigger". Also, add a condition "If the user does this activity" > "User cancelled an Infusionsoft Subscription".
			<br><br>
			<img src="https://cdn-std.droplr.net/files/acc_609773/0ypbjL" style="max-width: 100%;" />
			<br><br>

			<b>2. Add Necessary Actions and Save the Recipe</b>
			<br><br>
			Under Actions, add the desired actions, such as tagging, triggering a campaign, etc. 
			Once done, save the recipe and everything is set!
			</b>
			<br><br>
			<img src="https://cdn-std.droplr.net/files/acc_609773/1BTSYU" style="max-width: 100%;" />
		</div>
	</div>
</div>

<script>
	window.settings_changed = false;
	window.settings_saving = false;
	window.iw_sub_setting = {};

	function ia_auto_save_settings() {
		if(window.settings_changed && !window.settings_saving) {
			window.settings_saving = true;

			setTimeout(function() {
				window.settings_changed = false;
				jQuery.post("<?php echo admin_url( 'admin-ajax.php?action=iw_subs_settings_save' )?>", window.iw_sub_setting, function(data){
					window.settings_saving = false;
					M.toast({html: 'Settings Saved'});
					if(window.settings_changed) ia_auto_save_settings();
				},'json');
			}, 2000);
		}
	}

	jQuery("[name=myacct_show]").is(":checked") ? jQuery(".iw-subs-ma-on").show() : jQuery(".iw-subs-ma-on").hide();
	jQuery('.iw-admin-subs').on('change', 'input', function() {
		jQuery("[name=myacct_show]").is(":checked") ? jQuery(".iw-subs-ma-on").show() : jQuery(".iw-subs-ma-on").hide();
		window.settings_changed = true;
		window.iw_sub_setting = {
			myacct_show: jQuery('[name=myacct_show]').is(':checked') ? 1 : 0,
			cancel_show: jQuery('[name=cancel_show]').is(':checked')  ? 1 : 0,
			prices_show: jQuery('[name=prices_show]').is(':checked')  ? 1 : 0,
			inactive_show: jQuery('[name=inactive_show]').is(':checked')  ? 1 : 0,
			show_to_some: jQuery('[name=show_to_some]').is(':checked') ? 1 : 0,
			show_to: jQuery('[name=show_to]').val(),
			show_to_some: jQuery('[name=show_to_some]').is(':checked') ? 1 : 0
		};

		ia_auto_save_settings();
	});	

	function unloadPage(){ 
		if(window.settings_changed){
			return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		}
	}

	window.onbeforeunload = unloadPage;

	
</script>