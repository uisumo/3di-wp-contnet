<?php
/**
 * Plugin Name: Popup Builder Exit Intent
 * Plugin URI: https://popup-builder.com/
 * Description: Integrate Exit Intent extension into Popup Builder.
 * Version:	2.7
 * Author: Sygnoos
 * Author URI: https://popup-builder.com/
 * License:
 */

/*If this file is called directly, abort.*/
if (!defined('WPINC')) {
	wp_die();
}

if (defined('SGPB_EXIT_INTENT_CLASSES_PATH')) {
	_e('You already have Exit Intent extension. Please, remove this one.', SGPB_EXIT_INTENT_TEXT_DOMAIN);
	wp_die();
}

if (!defined('SGPB_EXIT_INTENT_FILE_NAME')) {
	define('SGPB_EXIT_INTENT_FILE_NAME', plugin_basename(__FILE__));
}

if (!defined('SGPB_EXIT_INTENT_FOLDER_NAME')) {
	define('SGPB_EXIT_INTENT_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'com/boot.php');
require_once(SGPB_EXIT_INTENT_CLASSES_PATH.'ExitIntent.php');
