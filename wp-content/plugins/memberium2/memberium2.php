<?php
/*
Plugin Name: Memberium
Plugin URI: http://www.memberium.com
Description: Provide membership site functions for WordPress.
Version: 2.160
Author: David Bullock
Author URI: http://www.webpowerandlight.com/
License: Copyright (c) 2012-2020 David Bullock, Web Power and Light
Text Domain: memberium
*/



if (!defined('ABSPATH') ) {
	die();
}

define('MEMBERIUM_VERSION', '2.160');
define('MEMBERIUM_HOME', __FILE__);
define('MEMBERIUM_HOME_DIR', __DIR__);
define('MEMBERIUM_CLASS_DIR', MEMBERIUM_HOME_DIR . '/classes/');
define('MEMBERIUM_SCREEN_DIR', MEMBERIUM_HOME_DIR . '/screens/');
define('MEMBERIUM_SKU', 'm4is');

require_once __DIR__ . '/lib/bootstrap.php';
