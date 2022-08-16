<?php

/**
 * The plugin bootstrap file
 *
 * Plugin Name:       Tweet Dis
 * Plugin URI:        http://tweetdis.com
 * Description:       TweetDis a Wordpress plugin that creates "tweetable quotes" in your articles. These click to tweet links catch the attention of your readers and make them tweet your content.
 * Version:           3.5.4
 * Author:            Tim Soulo
 * Author URI:        http://tweetdis.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tweetdis
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'Hi there!  I\'m just a plugin, not much I can do when called directly.' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/tweetdis-activator.php
 */
function activate_tweetdis() {
            require_once plugin_dir_path( __FILE__ ) . 'includes/tweetdis-activator.php';
            Tweetdis_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_tweetdis' );

/**
 * Begins execution of the plugin.
 */
function run_tweetdis() {

        /**
        * The core plugin class that is used to define internationalization,
        * admin-specific hooks, and public-facing site hooks.
        */
        require_once plugin_dir_path( __FILE__ ) . 'includes/tweetdis.php';
	$plugin = new Tweetdis(plugin_basename(__FILE__), '3.5.4');
	$plugin->run();

}
run_tweetdis();
