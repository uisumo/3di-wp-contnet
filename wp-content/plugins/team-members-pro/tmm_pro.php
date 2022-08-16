<?php
/**
 * Plugin Name: Team Members PRO
 * Plugin URI: https://wpdarko.com/items/team-members-pro/
 * Description: A responsive, simple and clean way to display your team. Create new members, add their positions, bios, social links (and much more) and copy-paste the shortcode into any post/page. Find help and information on our <a href="https://wpdarko.com/support">support site</a>. Make sure you check out all our useful plugins at <a href='https://wpdarko.com/'>WPDarko.com</a>.
 * Version: 5.1.0
 * Author: WP Darko
 * Author URI: https://wpdarko.com
 * Text Domain: team-members
 * Domain Path: /lang/
 * License: GPL2
 */

 /* Defines plugin's root folder. */
define( 'TMMP_PATH', plugin_dir_path( __FILE__ ) );

/* Defines plugin's text domain. */
define( 'TMMP_TXTDM', 'team-members' );

// Defines WP Darko's store URL
define( 'TMMP_STORE_URL', 'https://wpdarko.com' ); 

// Defines WP Darko's plugin ID
define( 'TMMP_ITEM_ID', 53 );

// Defines WP Darko's license page  name
define( 'TMMP_PLUGIN_LICENSE_PAGE', 'tmm-license' );


/* General. */
require_once('inc/tmm-text-domain.php');
require_once('inc/tmm-license-check.php');


/* Scripts. */
require_once('inc/tmm-front-scripts.php');
require_once('inc/tmm-admin-scripts.php');


/* Teams. */
require_once('inc/tmm-post-type.php');


/* Shortcode. */
require_once('inc/tmm-shortcode-column.php');
require_once('inc/tmm-shortcode.php');


/* Registers metaboxes. */
require_once('inc/tmm-metaboxes-members.php');
require_once('inc/tmm-metaboxes-settings.php');
require_once('inc/tmm-metaboxes-help.php');


/* Saves metaboxes. */
require_once('inc/tmm-save-metaboxes.php');


/* Checks for updates */
if( !class_exists( 'Darko_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/inc/darko_updater/Darko_Plugin_Updater.php' );
}

add_action( 'admin_init', 'tmmp_plugin_updater', 0 );
function tmmp_plugin_updater() {
	$license_key = trim( get_option( 'tmmp_license_key' ) );
	$tmmp_updater = new DARKO_Plugin_Updater( TMMP_STORE_URL, __FILE__,
		array(
			'version' => '5.1.0',
			'license' => $license_key, 
			'item_id' => TMMP_ITEM_ID,
			'author'  => 'WP Darko',
			'url'     => home_url(),
			'beta'    => false,
		)
	);
}

?>