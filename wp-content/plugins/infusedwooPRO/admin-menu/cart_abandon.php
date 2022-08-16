<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<h1>Cart Abandon Campaign</h1>
<hr>

This is a free campaign blueprint that comes with InfusedWoo Plugin. 
<br><br>

According to a <a href="http://baymard.com/lists/cart-abandonment-rate" target="_blank">research</a> from Baymard Institute, an average of 67.9% of your site visitor abandon their shopping cart. 
As an example on how to effectively use 
the <?php echo infusedwoo_sub_menu_link('campaign_goals', 'available campaign API goals'); ?> that is built-in inside InfusedWoo, we will be building a Cart Abandon Campaign in Infusionsoft.
<br><br>

<h2>Campaign Blueprint</h2>

<img src="https://cdn-std.droplr.net/files/acc_609773/RL6VAh" style="width:100%;" />
<br><br>
This campaign blueprint is based from a very good blog post:
<a href="http://blog.marketo.com/2013/12/how-to-send-perfectly-time-abandoned-cart-emails.html" target="_blank">
<i>How to Send Perfectly Timed “Abandoned Cart” Emails</i>
</a><br><br>
We will be building a campaign that sends three emails when they abandon their cart.
First email will be sent 1 hour after purchase, Second Email 24 hours thereafter. And third email after 48 hours.
<br><br>

<b>1. Add an API Goal: </b> From the Campaign tools, drag the API Campaign Goal tool to the campaign area. This API Goal will serve as the entry point of the campaign
and will trigger when customers reaches the checkout page.<br><br>
<br>
<center>
<img src="https://cdn-std.droplr.net/files/acc_609773/RQ4iEK" />
</center>
<br><br>
<b>2. Enter API Settings to the Goal</b>: Double click on the newly created API goal to enter the settings.
Then set the integration name to "wooevent" and call name "reachedcheckout" then hit "save".
<br><br>
<center>
<img src="https://cdn-std.droplr.net/files/acc_609773/B8Nsj8" style="width: 100%"  />
</center>

<br><br>
<b>3. Cart Abandon Sequence</b>
<br><br>
<center>
<img src="https://cdn-std.droplr.net/files/acc_609773/e7Ye3M" style="width: 100%;" /><br>
</center>
<br>Next we add a new sequence and connect the "reached checkout" goal to this sequence. In this example, we sent out three emails.<br>
<br>
First email is more focused on helping the customer, e.g. asking them if they have some technical difficulties or issues with payments.
This is sent 1 hour after they have reached the checkout page.<br><br>

Second email is sent 24 hours after the first email and this is a more urgent email, e.g. telling them that their cart will expire or 
some of their cart items will soon get out of stock.<br><br>

Last email is sent 48 hours after the last email. In this email you may give a discount or a coupon code.
<br><br>
<b>TIP:</b> If you have enabled Advanced Cart Tracking in <?php echo infusedwoo_sub_menu_link('campaign_goals', 'Available campaign API goals section'); ?>,
You can embed this link on your emails so your customers can restore their cart automatically when they click the link:<br><br>

<b>GDPR Compliant Link (<a target="_blank" href="admin.php?page=infusedwoo-menu-2&submenu=gdpr_links">More Info</a>): </b><br>
<?php echo site_url() ?>/iw-data/saved_cart/[token]

<br><br>
<b>Legacy (non-GDPR Compliant)</b>:<br> <?php 
	$iw_cart_uri = wc_get_cart_url(); 
	if(strpos($iw_cart_uri, '?') !== false) {
		$iw_cart_uri .= "&ia_saved_cart=~Contact.Email~";
	} else {
		$iw_cart_uri .= "?ia_saved_cart=~Contact.Email~";
	}

	echo $iw_cart_uri;
?>
<img src="https://cdn-std.droplr.net/files/acc_609773/eDnRks" style="width: 100%;" /><br>



<br><br>
<b>4. Exit Goals: </b> Last but not the least, we add exit goals that will stop the campaign when two events happen: when the customer purchases and when the 
customer empties their cart.<br><br><center>
<img src="https://cdn-std.droplr.net/files/acc_609773/YOcrIM" style=""/>
</center>
<br><br>
This is a very important step. Without this goal, all customers going to your checkout page will receive all cart abandon emails even if they have successfully purchased. 
<br><br>
To do this, create two API goals (like you did in step 1) and place the goals next to the sequence you created from #3. This time set the API goal values to the following:<br>
Purchase Goal = Integration: <b>woopurchase</b>, Call Name: <b>any</b><br>
Emptied Cart Goal = Integration: <b>wooevent</b>, Call Name: <b>emptiedcart</b><br>
<br>
<br>
That's it! Now, you have an automated system checking with customers if their abandon their cart.
<hr>

