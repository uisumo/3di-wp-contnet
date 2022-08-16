<?php
/**
 * Plugin Name: LearnDash Customization
 * Plugin URI: https://wisdmlabs.com/
 * Description: Provides support for learndash uncandy
 * Version: 1.0
 * Author: WisdmLabs
 * Author URI: https://wisdmlabs.com/
 * Text Domain: wdm-ld-custom
 * Doman Path: /languages/
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('admin_init', 'wdmCheckPluginActivation', 10, 0);

function wdmCheckPluginActivation()
{
    if (! class_exists('SFWD_LMS')) {
        deactivate_plugins(plugin_basename(__FILE__));
        unset($_GET[ 'activate' ]);
        add_action('admin_notices', 'wdmPLuginActivationNotices');
    }
}

function wdmPLuginActivationNotices()
{
	if (! class_exists('SFWD_LMS')) {
        ?>
        <div class='error'><p>
                <?php echo __("LearnDash LMS plugin is not active. In order to make the 'LearnDash Topic Tags' plugin work, you need to install and activate LearnDash LMS first.", "wdm-ld-custom");
        ?>
            </p></div>

        <?php

    }
}

// Include required files
require_once plugin_dir_path(__FILE__).'/includes/wdm-ld-custom.php';
require_once plugin_dir_path(__FILE__).'/includes/wdm-ld-user-profile.php';