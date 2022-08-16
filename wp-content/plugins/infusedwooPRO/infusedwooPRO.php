<?php
/*
Plugin Name: InfusedWoo Pro
Plugin URI: https://woo.infusedaddons.com
Description: Integrates WooCommerce with Infusionsoft/Keap. You need an Infusionsoft or Keap account to make this plugin work.
Version: 3.19.2
Requires at least: 4.3
Tested up to: 6.0
WC requires at least: 3.0
WC tested up to: 6.6.0
Author: Mark Joseph
Author URI: https://www.infusedaddons.com
*/
define('INFUSEDWOO_PRO_VER', '3.19.2');
define('INFUSEDWOO_PRO_DIR', WP_PLUGIN_DIR . "/" . plugin_basename( dirname(__FILE__) ) . '/');
define('INFUSEDWOO_PRO_URL', plugins_url() . "/" . plugin_basename( dirname(__FILE__) ) . '/');
define('INFUSEDWOO_PRO_BASE', plugin_basename( __FILE__));
define('INFUSEDWOO_PRO_UPDATER', 'http://downloads.infusedaddons.com/updater/iwpro-new.php');

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $iwpro, $iw_cache, $iwpro_updater;

$iwpro = 0;
$iw_cache = array();

// Composer Libraries
include(INFUSEDWOO_PRO_DIR . 'vendor/autoload.php');

// INCLUDE CORE FILES

include(INFUSEDWOO_PRO_DIR . 'core/integration.php');
include(INFUSEDWOO_PRO_DIR . 'core/autoupdate.php');
include(INFUSEDWOO_PRO_DIR . 'core/gateway.php');

// InfusedWoo 2.0 = New Admin Menu
include(INFUSEDWOO_PRO_DIR . 'admin-menu/admin.php');

// INCLUDE MODULES :: Note that modules below will only be loaded if Infusionsoft Integration is Enabled
register_activation_hook( __FILE__, 'iwpro_activation' );
add_action('iwpro_ready', 'iwpro_modules', 9, 1);

$iwpro_updater = new ia_auto_update;

function iwpro_modules($int) {
	global $iwpro, $iwpro_updater;

	$iwpro = $int;

	if(!defined('INFUSEDWOO_DISABLE_AUTOUPDATE') || INFUSEDWOO_DISABLE_AUTOUPDATE != true) {
		$iwpro_updater->init();
	}
	

	if($iwpro->enabled) {
		// ADD MODULES BELOW
		include(INFUSEDWOO_PRO_DIR . 'modules/login.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/paneledits.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/orderprocess.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/ordercomplete.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/referral.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/registration.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/postfcn.php');

		if(version_compare( WOOCOMMERCE_VERSION, '2.1.0', '>=' )) {
			include(INFUSEDWOO_PRO_DIR . 'modules/subscriptions2.php');
		} else {
			include(INFUSEDWOO_PRO_DIR . 'modules/subscriptions.php');
		}

		include(INFUSEDWOO_PRO_DIR . 'modules/woo-subscriptions-actions.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/wooevents.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/checkoutfields.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/typagecontrol.php');
		include(INFUSEDWOO_PRO_DIR . 'modules/save_address.php');

		// New 3.0:
		include(INFUSEDWOO_PRO_DIR . '3.0/init.php');
	}
}

// CDN Scripts
$infusedwoo_cdn_url = "https://d1h725wnqhabh5.cloudfront.net/" . INFUSEDWOO_PRO_VER . "/build/";
$infusedwoo_cdn_ver = INFUSEDWOO_PRO_VER; 
if(is_dir(INFUSEDWOO_PRO_DIR . 'cdnjs')) {
	$infusedwoo_cdn_url = INFUSEDWOO_PRO_URL . 'cdnjs/build/';
	$infusedwoo_cdn_ver = time();
}

define('INFUSEDWOO_CDN_URL', $infusedwoo_cdn_url);
define('INFUSEDWOO_CDN_VER', $infusedwoo_cdn_ver);

// Dev Testing

if(file_exists(INFUSEDWOO_PRO_DIR . '.dev/tests.php')) {
	include INFUSEDWOO_PRO_DIR . '.dev/tests.php';
}

function iwpro_activation() {
	update_option( 'infusedwoo_activate', 1, false);
	include(INFUSEDWOO_PRO_DIR . 'core/db.php');

	update_option( 'infusedwoo_check_migrations', 1, false);
	flush_rewrite_rules();
}

?>
