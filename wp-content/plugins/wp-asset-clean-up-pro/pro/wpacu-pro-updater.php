<?php
// Exit if accessed directly
if (! defined('WPACU_PRO_DIR')) {
	exit;
}

// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define('WPACU_PRO_PLUGIN_STORE_URL', 'https://gabelivan.com');

// The name of your product. This should match the download name in EDD exactly
define('WPACU_PRO_PLUGIN_STORE_ITEM_NAME', 'Asset CleanUp Pro: Performance WordPress Plugin');

// The ID of the product from the store
define('WPACU_PRO_PLUGIN_STORE_ITEM_ID', 17193);

/**
 * Initialize the updater. Hooked into `init` to work with the
 * wp_version_check cron job, which allows auto-updates.
 */
function wpassetcleanup_pro_plugin_updater()
{
	// retrieve the license key from the DB
	$license_key = trim(get_option( WPACU_PLUGIN_ID . '_pro_license_key'));

	if ( ! $license_key ) {
		// Without a license, no notice of a possible new version will be shown
		return;
	}

	// setup the updater
	new \WpAssetCleanUpPro\PluginUpdater(WPACU_PRO_PLUGIN_STORE_URL, WPACU_PLUGIN_FILE, array(
			'version' 	=> WPACU_PRO_PLUGIN_VERSION,         // current version number
			'license' 	=> $license_key, 		             // license key
			'item_id'   => WPACU_PRO_PLUGIN_STORE_ITEM_ID,   // item ID from the store
			'author' 	=> 'Gabriel Livan',                  // author of this plugin
			'url'       => home_url(),
			'beta'		=> false
		)
	);
}

add_action('init', 'wpassetcleanup_pro_plugin_updater', 0);
