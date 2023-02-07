<?php
/*
Plugin Name: i2SDK
Plugin URI: http://www.webpowerandlight.com
Description: Provides enhanced SDK Library functions for Memberium and 3rd party plugins with Infusionsoft.  Required by Memberium.
Version: 3.99
Author: David Bullock
Author URI: http://www.webpowerandlight.com/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define('I2SDK_HOME', __FILE__);
define('I2SDK_VERSION', '3.99');
define('I2SDK_DIR', __DIR__ . '/');

require_once I2SDK_DIR . 'lib/i2sdk_class.php';

$i2sdk = new i2sdk_class;

if ( is_admin() ) {
	require_once I2SDK_DIR . 'admin/admin.php';
	require_once I2SDK_DIR . 'admin/activate.php';
	require_once I2SDK_DIR . 'admin/deactivate.php';
	require_once I2SDK_DIR . 'admin/uninstall.php';
	require_once I2SDK_DIR . 'lib/plugin-php-tester.php';

	register_activation_hook( __FILE__, 'wpal_i2sdk_activate' );
	register_deactivation_hook( __FILE__, 'wpal_i2sdk_deactivate' );
	register_uninstall_hook( __FILE__, 'wpal_i2sdk_uninstall' );

}
else {
	if ( $i2sdk->getConfigurationOption( 'tracking_code' ) > '' && $i2sdk->getConfigurationOption( 'infusionsoft_analytics' ) == 1 ) {
		add_action( 'wp_footer', array( $i2sdk, 'showInfusionsoftWebAnalytics' ) );
	}
}

do_action( 'i2sdk_init' );
