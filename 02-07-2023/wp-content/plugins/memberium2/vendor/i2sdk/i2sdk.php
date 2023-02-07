<?php
/**
 * Copyright (c) 2011-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */



if ( ! class_exists('m4is_emz57o') || defined('I2SDK_HOME') ) {
	return;
}

global $i2sdk;

i2sdk_define_constants();

require_once __DIR__ . '/lib/i2sdk_class.php';

$i2sdk = new i2sdk_class;

if (is_admin() ) {
	require_once I2SDK_DIR . 'admin/admin.php';
	require_once I2SDK_DIR . 'admin/activate.php';
	require_once I2SDK_DIR . 'admin/deactivate.php';
	require_once I2SDK_DIR . 'admin/uninstall.php';

	register_activation_hook( __FILE__, 'wpal_i2sdk_activate' );
	register_deactivation_hook( __FILE__, 'wpal_i2sdk_deactivate' );
	register_uninstall_hook( __FILE__, 'wpal_i2sdk_uninstall' );
}
else {
	if ($i2sdk->getConfigurationOption('tracking_code') > '' && $i2sdk->getConfigurationOption('infusionsoft_analytics') == 1) {
		add_action('wp_footer', [$i2sdk, 'show_infusionsoft_web_analytics']);
	}
}

do_action('i2sdk_init');


function i2sdk_define_constants() {
	define('I2SDK_HOME', __FILE__);
	define('I2SDK_VERSION', '4.0');
	define('I2SDK_DIR', __DIR__ . '/');
}
