<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$gateways = WC()->payment_gateways->get_available_payment_gateways();
$pgenabled = false;

if($gateways) foreach($gateways as $gateway) {
	if($gateway->id == 'infusionsoft_cc') {
		$pgenabled = $gateway->enabled == 'yes';
	}
}

?>

<h1>Infusionsoft Payment Gateway</h1>
<hr>

If you have a merchant account already set up and working in Infusionsoft, 
then you can use Infusionsoft as payment gateway in Woocommerce.
<br><br>
As of now, your Infusionsoft Payment Gateway is currently 
<?php if($pgenabled) { ?>
<b style="color: green;">enabled.</b>
<?php } else { ?>
<b style="color: red;">disabled.</b>
<?php } ?>
<br><br>
To disable / enable Infusionsoft Payment Gateway or change settings to the gateway, 
please click the button below.
<br><br>
<center>
<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=infusionsoft_cc');?>">
<div class="big-button">Configure Infusionsoft Gateway
</div>
</center>