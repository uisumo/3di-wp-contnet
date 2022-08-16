<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<h1>GDPR Overview and Checklist</h1>
<hr>
<p>In preparation for the May 25th enforcement date of <a href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation">General Data Protection Regulation</a> (GDPR) for companies conducting business in EU Region, InfusedWoo provides special tools for you to become GDPR Compliant.</p>

<p>InfusedWoo is GDPR-compliant from version 3.9 of the plugin. This means that InfusedWoo, by default, does not collect and process personal data from you and your customers without consent. InfusedWoo being GDPR-compliant doesn't mean that your E-commerce site is also GDPR-compliant as you can still set up InfusedWoo to collect and process customer's personal data that doesn't follow the standards outlined in <a href="https://www.eugdpr.org/">EU's new GDPR Law</a>.</p>

<p>To ensure that you are using InfusedWoo based on GDPR Standards, make sure the following points below are all in good status.</p>

<table class="bluetable gdpr-checklist" cellspacing=0>
	<thead>
		<tr>
			<th>Status</th>
			<th>Policy</th>
			<th style="min-width: 80px;">Link to Fix</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
				$link = get_option('infusedwoo_tc_link','');
			?>

			<?php if($link) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>GDPR Compliant T&Cs</h3>
				<p>Make sure you have updated your terms and conditions <a href="https://termsfeed.com/blog/how-to-update-privacy-policy-gdpr-compliance/" target="_blank">to be GDPR Compliant</a></p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_terms') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php 
				$enabled_cookie_alert = get_option('infusedwoo_cookie_alert', 0);
			?>

			<?php if($enabled_cookie_alert) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Cookie Consent</h3>
				<p>GDPR requires that your users are informed of your cookie policy and that you are only collecting data that necessary for the site to function properly. If you are collecting non-essential data, users must first give their consent before you can use non-essential cookies. <a href="https://eugdprcompliant.com/cookies-consent-gdpr/" target="_blank">See guidelines.</a></p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_cookie') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php 
				$enabled_checkout = get_option('infusedwoo_tc_checkout', 1);
			?>

			<?php if($enabled_checkout) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Explicit Contract Terms Checkbox</h3>
				<p>Non-implied Contract Terms checkbox should be present on all forms and pages where you collect personal data. This includes sign-up form and checkout form.</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_terms') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php 
				$pfields = get_option('infusedwoo_data_pfields', array());
			?>

			<?php if(count($pfields) > 0 && get_option('infusedwoo_gdpr_data_view')) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Define Personal Data Fields</h3>
				<p>Let InfusedWoo know what data you are collecting that can be considered as Personal/Identifiable Data.
					This data will then be available to your customers for viewing (<a href="https://www.gdpreu.org/the-regulation/list-of-data-rights/right-of-access/" target="_blank">Right of Access</a>) and updating (<a href="https://www.gdpreu.org/the-regulation/list-of-data-rights/right-to-rectification/" target="_blank">Right to Data Rectification</a>).
				</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_personal') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php if(get_option('infusedwoo_gdpr_data_view') && get_option('infusedwoo_gdpr_data_dl')) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Right to Data Portability and Erasure</h3>
				<p>Allow your customers to be able to download (<a href="https://www.gdpreu.org/the-regulation/list-of-data-rights/right-to-data-portability/" target="_blank">Right to Data Portability</a>) and delete their own personal data (<a href="https://www.gdpreu.org/the-regulation/list-of-data-rights/right-to-erasure/" target="_blank">Right to Data Erasure</a>).
				</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_personal') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php 
				$automation_recipes =  iw_get_recipes('IW_UserConsent_Trigger');
			?>

			<?php if(count($automation_recipes) > 0) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Explicit Consent Checkboxes</h3>
				<p>Create consent checkboxes and show this in your checkout form, sign up form and customer's my account page. 
					And then configure your marketing (and other data processing campaigns) to only process data when consent is given and that the customer can anytime withdraw his consent any time.
				</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_consent') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php if(get_option('infusedwoo_postapi_token')) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Use Tokenized GDPR Links</h3>
				<p>Use tokenized links so that customers can quickly and securely access their data, manage their consent at any time without logging-in to your site. You can easily put these tokenized links in your email templates so that customers can opt-out from certain data processing subjects without fully unsubscribing.
				</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_links') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>
		<tr>
			<?php if(iw_count_old_identifiable_records() == 0) { ?>
				<td class="gdpr-status gdpr-status-good">
					<i class="fa fa-check-circle"></i><br>
					Good
				</td>
			<?php } else { ?>
				<td class="gdpr-status gdpr-status-bad">
					<i class="fa fa-times-circle"></i><br>
					Needs Fix
				</td>
			<?php } ?>
			<td>
				<h3>Clear Analytics Data with Personal Info</h3>
				<p>
					Previous version of InfusedWoo may have recorded personal data to your database. Run the clean up wizard to clear analytics data containing personal information.
				</p>
			</td>
			<td class="gdpr-status">
				<a href="<?php echo admin_url('admin.php?page=infusedwoo-menu-2&submenu=gdpr_clean_data') ?>" target="_blank">
				<i class="fa fa-external-link"></i><br>
					Fix Here
				</a>
			</td>
		</tr>


	</tbody>
</table>