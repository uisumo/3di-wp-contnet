<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


include_once INFUSEDWOO_PRO_DIR . "admin-menu/admin_ajax.php";

add_action('admin_menu', 'infusedwoo_add_menu2');
add_action('current_screen', 'iw_plugin_deactivation_monitor_enqueue');
add_action('admin_footer', 'iw_plugin_deactivation_monitor');

// Update Checker
add_action('admin_init', 'iw_admin_checks_update'); 
add_action( 'admin_notices', 'iwpro_update_notices' );




function iw_admin_checks_update() {
	global $iwpro,$iwpro_updater;
	delete_transient('infusedwoo_remote_ver');
	$iwpro_updater->init();

	if(isset($_GET['page']) && $_GET['page'] == 'infusedwoo-menu-2' && isset($_GET['submenu']) && $_GET['submenu'] == 'update') {

		if($_POST) {
			if(isset($_POST['upd-lic-key'])) {
				if($_POST['upd-lic-key'] != '****************') {
					if(isset($iwpro->settings)) {
						$settings = $iwpro->settings;
					} else {
						$settings = array();
					}

					$settings['lic'] = $_POST['upd-lic-key'];


					update_option( $iwpro->plugin_id . $iwpro->id . '_settings', $settings );
					$iwpro->settings = $settings;
					$iwpro->lic_key = $_POST['upd-lic-key'];
					$iwpro_updater->lic_key = $_POST['upd-lic-key'];
				}
			}
		}

		
		iwpro_auto_activate();	
	}
}


function infusedwoo_add_menu2() {
	add_menu_page('InfusedWoo', __('InfusedWoo','woocommerce'), 'manage_woocommerce', 'infusedwoo-menu-2', 'infusedwoo_menu2', INFUSEDWOO_PRO_URL . "images/infusedwoo_menu_icon.png", '2.17');
}

function iw_plugin_deactivation_monitor_enqueue() {
	$screen = get_current_screen();

	if($screen->id == 'plugins') {
		wp_enqueue_script( 'jquery-ui-dialog' ); 
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script('iw-deactivation', INFUSEDWOO_PRO_URL . 'admin-menu/assets/deactivation.js', array('jquery-ui-dialog'), filemtime(INFUSEDWOO_PRO_DIR . 'admin-menu/assets/deactivation.js'), true);
	}
}

function iw_plugin_deactivation_monitor() {
	$screen = get_current_screen();

	if($screen->id == 'plugins') {
	?>
	<style type="text/css">
		#iw-deactivation input {
			margin-right: 10px;
			display: inline-block;
			margin-bottom: 20px;
			margin-top: 2px;
			float:left;
		}

		#iw-deactivation label {
			
		}
	</style>
	<div id="iw-deactivation" style="font-size: 11pt; display:none;">
		<div class="iw-deactivation-1">
			<input type="hidden" name="iw-deactivation-url" />
			Please let us know why you are deactivating InfusedWoo.

			<br><br>
			<ul>
			<div>
				<label><input type="radio" name="iwdeactivate" value="temporary" checked />This is a temporary deactivation, I will re-activate InfusedWoo later. (All data and settings will be kept)</label>
			</div>
			<br>
			<div>
				<label><input type="radio" name="iwdeactivate" value="fulldeactivate" />I will not use InfusedWoo for this site anymore. (<font color="red">Settings and data will be deleted</font>)</label>
			</div>
			<br><br>
			<button class="button button-primary button-large iw-deactivate">Deactivate InfusedWoo</button> 
		</div>
		<div class="iw-deactivation-2">
			InfusedWoo settings and data will be deleted. Please enter "DELETE" in the input box below to confirm and click "Deactivate InfusedWoo" to proceed.
			<br><br>
			<div style="width: 100%; text-align: center;">
			<input type="text" name="iw-confirm-delete" placeholder="Enter 'DELETE' to confirm" class="input" style="text-transform: uppercase; font-size:13pt; width:300px; padding: 5px; display: inline; margin:auto; text-align: center;"  />
			</div>

			<br><br><br>
			<button class="button button-primary button-large iw-delete">Deactivate InfusedWoo</button> 
			<div color="red" class="iw-deacerror" style="display: none; margin-top: 10px; font-weight: bold; font-size: 10pt; color:red">Please enter the word DELETE to confirm InfusedWoo deactivation with deletion.</div>
		</div>
		
	</div>

	<?php
	}
}

function infusedwoo_sub_menu_link($submenu,$label) {
	$uri = admin_url("admin.php?page=infusedwoo-menu-2&submenu=$submenu");

	if(isset($_GET['submenu']) && $submenu == $_GET['submenu']) $class = "iw-submenu active";
	else $class = "iw-submenu";

	echo '<a href="'.$uri.'" class="'.$class.'">'.$label.'</a>';
}

function infusedwoo_menu2() {
	global $iwpro;
	global $woocommerce;
	if(version_compare( WOOCOMMERCE_VERSION, '2.1.0', '>=' )) 
		$wcs = 'wc-settings';
	else
		$wcs = 'woocommerce_settings';

	// add css / js
	wp_enqueue_style( "infusedwoo-admin-matl", "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css", array());
	wp_enqueue_script( 'ia_searchable', (INFUSEDWOO_PRO_URL . 'assets/chosen/chosen.jquery.min.js'), array('jquery') ); 
	wp_enqueue_script( "infusedwoo-admin-matl-js", "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js", array(), true);
	wp_enqueue_script( "infusedwoo-admin-jqueryui", "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", array('infusedwoo-admin-matl-js'), true);
	wp_enqueue_style( 'ia_searchable_css', (INFUSEDWOO_PRO_URL . 'assets/chosen/chosen.min.css') ); 
	wp_enqueue_style( "infusedwoo-admin-css", INFUSEDWOO_PRO_URL . "admin-menu/assets/admin.css", array(),filemtime(INFUSEDWOO_PRO_DIR . "admin-menu/assets/admin.css"));
	wp_enqueue_script( "infusedwoo-admin-js", INFUSEDWOO_PRO_URL . "admin-menu/assets/admin.js", array('jquery','infusedwoo-admin-jqueryui','ia_searchable','infusedwoo-admin-matl-js'), filemtime(INFUSEDWOO_PRO_DIR . "admin-menu/assets/admin.js"), true);
	
	wp_enqueue_style( "infusedwoo-admin-fonts", "//fonts.googleapis.com/css?family=Lato|Arvo", array());
	wp_enqueue_style( "infusedwoo-admin-icons", "https://fonts.googleapis.com/icon?family=Material+Icons", array());
	

	wp_enqueue_style( 'iwpro-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
	wp_register_style( 'jquery-ui-styles','//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css' );
	?>
		<div class="infusedwoo-admin-wrapper">
			<div class="infusedwoo-admin-top-bar">
				<a href="<?php echo admin_url("admin.php?page=infusedwoo-menu-2"); ?>" class="iw-submenu"><img class="infusedwoo-logo" src="<?php echo INFUSEDWOO_PRO_URL . "images/infusedwoo.png" ?>" /></a>

				<span style="float: right; margin-right: 20px; margin-top: 10px; font-size: 12pt; color:white;">Version: <?php echo INFUSEDWOO_PRO_VER; ?>
					<?php 
						$plugin_current_version = INFUSEDWOO_PRO_VER;  
						$remote_ver = get_transient('infusedwoo_remote_ver');
						$lic_validate = get_transient('infusedwoo_lic_validate');

						if(isset($remote_ver) && version_compare( $remote_ver, INFUSEDWOO_PRO_VER, '>=' ) && !empty($lic_validate)) {
							$new_upd = true;
							 	if($lic_validate == "invalid") {
						            infusedwoo_sub_menu_link("update",'<span class="alert">Invalid License Key! Click to Update.</span>');
						        } else if($lic_validate == "exceed") {
						        	infusedwoo_sub_menu_link("update",'<span class="alert">License Key Limit Reached!</span>');    
						        }  else if($lic_validate == "empty") {
						            infusedwoo_sub_menu_link("update",'<span class="alert">No License Key! Click to Update</span>');
						        }  else if($lic_validate == "valid") {
						            infusedwoo_sub_menu_link("update",'<span class="alert">New Update is Available!</span>');
						        }  else if($lic_validate == "expired") {
						            infusedwoo_sub_menu_link("update",'<span class="alert">License has Expired.</span>');
						        } 
						} else {
							$new_upd = false;
						}
					?>
					<span class="loader"><img src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/images/ajax-loader.gif" ?>" /></span>
				</span>
			</div>

			<div class="infusedwoo-admin-left-menu">
				<div class="infusedwoo-admin-menu">
					<ul><li><a href="#" class="menu-list-head">Getting Started</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("quick_install","Guided Setup") ?></li>
								<li><?php infusedwoo_sub_menu_link("update","Updating InfusedWoo") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">Import / Export</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("product_import","Products") ?></li>
								<li><?php infusedwoo_sub_menu_link("order_import","Orders") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">Receiving Payments</a> <span class='menu-new'>New</span>
							<ul>
								<li><?php infusedwoo_sub_menu_link("is_gateway","Infusionsoft Payment Gateway") ?></li>
								<li><?php infusedwoo_sub_menu_link("other_gateways","Integrating Other Payment Gateways") ?></li>
								<li><?php infusedwoo_sub_menu_link("payplans","Payplans") ?> <span class='menu-new'>New</span></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">Automation</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("automation_recipes","Automation Recipes") ?> <span class='menu-new'>New</span></li>
								<li><?php infusedwoo_sub_menu_link("action_sets","Using Action Sets") ?></li>
								<li><?php infusedwoo_sub_menu_link("campaign_builder","Using Campaign Builder") ?></li>
								<li><?php infusedwoo_sub_menu_link("campaign_goals","Available Campaign API Goals") ?></li>
								<li><?php infusedwoo_sub_menu_link("cart_abandon","Cart Abandon Campaign") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">Subscriptions</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("iw_subs","Via InfusedWoo Subscription Module") ?></li>
								<li><?php infusedwoo_sub_menu_link("woo_subs","Via Woocommerce Subscriptions") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">More Integration Options</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("ty_page_control","Thank You Page Control") ?></li>
								<li><?php infusedwoo_sub_menu_link("custom_fields","Checkout Custom Fields") ?></li>
								<li><?php infusedwoo_sub_menu_link("leadsources","Leadsources") ?></li>
								<li><?php infusedwoo_sub_menu_link("ref_partners","Referral Partners") ?></li>
								<li><?php infusedwoo_sub_menu_link("auto_order_import","Order Auto Import") ?></li>
								<li><?php infusedwoo_sub_menu_link("user_reg","User Registration") ?></li>
								<li><?php infusedwoo_sub_menu_link("one-click","One-Click Upsells") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">GDPR Toolkit</a>
							<ul>
								<li><?php infusedwoo_sub_menu_link("gdpr_overview","GDPR Checklist") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_terms","Terms and Conditions Link") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_cookie","Cookie Consent") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_personal","Personal Data Management") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_consent","Consent Manager") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_links","Tokenized GDPR Links") ?></li>
								<li><?php infusedwoo_sub_menu_link("gdpr_clean_data","Analytic Data Cleanup") ?></li>
							</ul>
						</li></ul>

					<ul><li><a href="#" class="menu-list-head">Others</a>
							<ul>
								<?php
									if(version_compare( WOOCOMMERCE_VERSION, '2.1.0', '>=' )) 
										$wcs = 'wc-settings';
									else
										$wcs = 'woocommerce_settings';
								?>
								<li><a href="<?php echo admin_url('admin.php?page='.$wcs.'&tab=integration&section=iw_infusionsoft'); ?>" class="" target="_blank">Integration Settings</a></li>
								<li><a href="http://infusedaddons.com/support" class="" target="_blank">Support</a></li>
							</ul>
						</li></ul>
				</div>
			</div>

			<div class="infusedwoo-admin-content">
				<?php if(isset($_GET['submenu'])) {
						if((isset($iwpro->enabled) && $iwpro->enabled == "yes" && $iwpro->ia_app_connect()) || in_array($_GET['submenu'], array('quick_install','gen_settings','support','update','gdpr_terms','gdpr_overview')))
							include INFUSEDWOO_PRO_DIR . "admin-menu/{$_GET['submenu']}.php";
						else {
							?>
							<br><br><br>
							<center>
							<img src="<?php echo INFUSEDWOO_PRO_URL . "images/broken_link.jpg" ?>" style="opacity: 0.7; width: 80%;"/>
							<br><br>
							<p style="font-size: 14pt; line-height: 16pt">
								Connection to Infusionsoft is currently disabled.<br><br>
								To access this feature, please <a href="<?php echo admin_url("admin.php?page=infusedwoo-menu-2&submenu=quick_install"); ?>">
								enable Infusionsoft<br> Integration first.
								</a>

							</p>
							
							<?php
						} 

					} else {
					?>
						<center style="font-size: 13pt; line-height: 18pt;">
							<br><br>
							<div style="display: inline-block; ">
							<img src="<?php echo INFUSEDWOO_PRO_URL . "images/infusedwoo.png" ?>" />
							</div>
							<br><br><br>
							You are currently using InfusedWoo <?php echo INFUSEDWOO_PRO_VER; ?>
							<br><br>
							Welcome to the InfusedWoo admin panel. <br>Please use the menu on the left side to access all the features of InfusedWoo. 

						</center>

					<?php } ?>
			</div>
		</div>
		<?php 
			 $iw_current_user = wp_get_current_user();
		?>
		<script>
		var beamer_config = {
			product_id : 'ITeqgSIi6355', //DO NOT CHANGE: This is your product code on Beamer
			//selector : 'selector', /*Optional: Id, class (or list of both) of the HTML element to use as a button*/
			//display : 'right', /*Optional: Choose how to display the Beamer panel in your site*/
			//top: 0, /*Optional: Top position offset for the notification bubble*/
			//right: 0, /*Optional: Right position offset for the notification bubble*/
			//bottom: 0, /*Optional: Bottom position offset for the notification bubble*/
			//left: 0, /*Optional: Left position offset for the notification bubble*/
			//button_position: 'bottom-right', /*Optional: Position for the notification button that shows up when the selector parameter is not set*/
			//icon: 'bell_lines', /*Optional: Alternative icon to display in the notification button*/
			//language: 'EN', /*Optional: Bring news in the language of choice*/
			//filter: 'admin', /*Optional : Bring the news for a certain role as well as all the public news*/
			//lazy: false, /*Optional : true if you want to manually start the script by calling Beamer.init()*/
			//alert : true, /*Optional : false if you don't want to initialize the selector*/
			//delay : 0, /*Optional : Delay (in milliseconds) before initializing Beamer*/
			//embed : false, /*Optional : true if you want to embed and display the feed inside the element selected by the 'selector' parameter*/
			//mobile : true, /*Optional : false if you don't want to initialize Beamer on mobile devices*/
			//notification_prompt : 'sidebar', /*Optional : override the method selected to prompt users for permission to receive web push notifications*/
			//callback : your_callback_function, /*Optional : Beamer will call this function, with the number of new features as a parameter, after the initialization*/
			//onclick : your_onclick_function(url, openInNewWindow), /*Optional : Beamer will call this function when a user clicks on a link in one of your posts*/
			//onopen : your_onopen_function, /*Optional : Beamer will call this function when opening the panel*/
			//onclose : your_onclose_function, /*Optional : Beamer will call this function when closing the panel*/
			//---------------Visitor Information---------------
			//user_firstname : "firstname", /*Optional : Input your user firstname for better statistics*/
			//user_lastname : "lastname", /*Optional : Input your user lastname for better statistics*/
			user_email : "<?php echo $iw_current_user->user_email; ?>", /*Optional : Input your user email for better statistics*/
			//user_id : "user_id" /*Optional : Input your user ID for better statistics*/
		};
	</script>
	<script type="text/javascript" src="https://app.getbeamer.com/js/beamer-embed.js" defer="defer"></script>
	<?php
}