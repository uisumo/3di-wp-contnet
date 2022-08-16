<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<h1>Guided Setup</h1>
<hr>
<div class="step-by-step guided-setup">
<div class="steps-wrap">

	<div class="step-block">

		<span class="circle-step">1</span> <span class="step-head">Connect to your Infusionsoft App</span><br>
		
		
		<div class="big-row">
		Enter your App Id and API key to connect.<br><br>
		Your App Id is the {name} of part of your app subdomain {name}.infusionsoft.com. 
		E.g. w209 is the app id of w209.infusionsoft.com. 
		For Keap, you can <a href="#help1" target="_blank" class="modal-trigger">find your app id here</a>. 
		<br><br>
		Don't know where to find you're API Key?  Click these links to locate your API Key 
			<a href="#help2" target="_blank" class="modal-trigger">in Infusionsoft</a> and 
			<a href="#help3" target="_blank" class="modal-trigger">in Keap</a>.
		</a><br>
		</div><br>
		<div class="big-row">
			<label>App Id</label>
			<input type="text" placeholder="App Id" name="iw-app-name" value="<?php echo isset($iwpro->machine_name)  ? $iwpro->machine_name  : ""; ?>" />
			<i data-target="help1" class="material-icons show-help modal-trigger" title="Click for more help">help_outline</i>
		</div>
		<div class="big-row">
			<label>API Key</label>
			<input type="password" name="iw-api-key" placeholder="Enter API Key" value="<?php echo isset($iwpro->apikey) ? $iwpro->apikey : ""; ?>" />
			<i data-target="help2" class="material-icons show-help modal-trigger"  title="Click for more help">help_outline</i>
		</div>

		<div id="help1" class="modal">
			<div class="modal-content" style="width: 100%;">
			<iframe src="https://help.keap.com/help/how-do-i-locate-my-application-id" style="width: 100%; height: 500px;"></iframe>
			</div>
		</div>
		<div id="help2" class="modal">
			<div class="modal-content" style="width: 100%;">
			<iframe src="https://help.infusionsoft.com/help/api-key" style="width: 100%; height: 500px;"></iframe>
			</div>
		</div>
		<div id="help3" class="modal">
			<div class="modal-content" style="width: 100%;">
			<iframe src="https://help.keap.com/help/api-key" style="width: 100%; height: 500px;"></iframe>
			</div>
		</div>

		

		<div class="big-row">
			<br>
			<div class="next-button apicreds" style="margin-left: 95px;">Next</div>
			
		</div>	
	</div>

	<div class="step-block"><span class="circle-step">2</span> <span class="step-head">Add / Import Products</span><br>
		<div class="big-row">
		 At this point, woocommerce is now connected to your infusionsoft application. Next, we add products to your woocommerce site.
		 
		 <br><br>If you have already added products to your woocommerce store, then you may proceed to the next step of this guided setup.
		 Otherwise, you can add new product by either (or both) manually creating a new product or by importing products from infusionsoft:<br>
		</div>
		<div class="big-row">
		<h3>Creating New Products</h3>
		To create new product, you can access this via Woocommerce Product Menu:
		<br><br>
		<img src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/images/add_prod.gif" ?>" />
		</div>
		<div class="big-row">
		<h3>Import Products from Infusionsoft</h3>
		To import products, you can access this via InfusedWoo Import/Export Menu:
		<br><br>
		<img src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/images/import_prod.gif" ?>" />
		</div>

		<div class="big-row">
			<br>
			<div class="back-button just-back" style="">Back</div>
			<div class="next-button just-next" style="">Next</div>
			
		</div>	
	</div>

	<div class="step-block"><span class="circle-step">3</span> <span class="step-head">Setup Payment Gateway</span>
		<div class="big-row">
		Next, we make sure that you are able to receive payments and integrate woocommerce orders to Infusionsoft.<br><br>

		InfusedWoo comes with its own Infusionsoft Payment Gateway where you can take payments using your Infusionsoft set up merchant
		account.<br><br>

		You can as well use other wooocommerce payment gateway and still integrate with infusionsoft.<br><br>

		To set-up Infusionsoft Payment gateway and/or integrate other payment gateways with Infusionsoft, you may proceed to the 
		"Receiving Payments" Menu. <br><br>
		
		<br><br>
		<img src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/images/receive_payments.gif" ?>" />
		
		<br><br>
		Once done, you may proceed to the next step of this guided setup.
		</div>
		<div class="big-row">
			<br>
			<div class="back-button just-back" style="">Back</div>
			<div class="next-button just-next" style="">Next</div>
			
		</div>	
	</div>

	<div class="step-block">
		<span class="circle-step">4</span> <span class="step-head">Automate!</span>

		<div class="big-row">
		Last but most importantly, let's start automating using the power of Infusionsoft.<br><br>

		Setting up automation is all up to you and InfusedWoo provides you the tools you need to set this up.<br><br>

		You can use Infusionsoft's action sets or much better use the campaign builder to automate processes.
		<br><br>

		You may proceed to the "Automation" Menu to know more how to set up Infusionsoft automation with woocommerce. <br><br>
		
		<br><br>
		<img src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/images/automation.gif" ?>" />
		
		</div>

		<div class="big-row">
			<br>
			<div class="back-button just-back" style="">Back</div>
		</div>	
	</div>

</div>
</div>