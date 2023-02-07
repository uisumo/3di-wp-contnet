<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @package    Tweetdis
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$activation_data = json_decode(get_option('tweetdis_rinfo'), true);
if (!isset($activation_data['domain'])) {
    $activation_data['domain'] = get_site_url();
}
$url = "http://tweetdis.com/activate.php?act=deactivate&domain=" . $activation_data['domain'] . "&key=" . $activation_data['code'];
wp_remote_get($url);

remove_shortcode('tweet_dis');
remove_shortcode('tweet_box');
remove_shortcode('tweet_dis_img');

delete_option('tweetdis_hint');
delete_option('tweetdis_box');
delete_option('tweetdis_image');
delete_option('tweetdis_tweet_author');
delete_option('tweetdis_tweet_settings');
delete_option('tweetdis_rinfo');

global $wpdb;
$table_list_images = $wpdb->prefix . "tweetdis_list_img";
$wpdb->query( "DROP TABLE IF EXISTS `" . $table_list_images ."`" );