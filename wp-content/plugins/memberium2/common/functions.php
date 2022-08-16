<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } function wplcqoi() { $vwplz97jd = array( ); foreach($vwplz97jd as $vwplu2t0ah) { $vwplf_3k79 = MEMBERIUM_HOME_DIR . "/vendor/{$vwplu2t0ah}/init.php"; if (file_exists($vwplf_3k79) ) { include_once $vwplf_3k79; } } } function wplb_vo() { return array( 'affiliate-leaderboards' => '/ext/affiliate-leaderboards/init.php', 'facebook' => '/vendor/wpal/facebook/init.php',  'pathprotect' => '/vendor/wpal/pathprotect/init.php', 'spiffy' => '/vendor/wpal/spiffy/init.php', 'umbrella-accounts' => '/ext/umbrella-accounts/init.php', ); } function wplu_9s() { $vwplz97jd = wplb_vo(); $vwplrd4c = get_option('memberium_extensions', array() ); foreach($vwplz97jd as $vwplu2t0ah => $vwplg38x51) { if (! empty($vwplrd4c[$vwplu2t0ah]) ) { $vwplf_3k79 = MEMBERIUM_LIB_DIR . $vwplg38x51; include_once $vwplf_3k79; } } } function wplaah_w() {  if (session_status() !== 1) { return; }  $vwplax4s9 = false; $vwplax4s9 = $vwplax4s9 || (defined('MEMBERIUM_NATIVE_SESSIONS') && MEMBERIUM_NATIVE_SESSIONS); $vwplax4s9 = isset($_SERVER['WPENGINE_PHPSESSIONS']) ? true : $vwplax4s9; $vwplax4s9 = isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE'] == 'LiteSpeed' ? true : $vwplax4s9; if (! $vwplax4s9) { global $session_driver; $session_driver = new wplmu94w; session_set_save_handler( array(&$session_driver, 'wplier5'), array(&$session_driver, 'wplmq90m7'), array(&$session_driver, 'wplqsa2u'), array(&$session_driver, 'wpleom2uw'), array(&$session_driver, 'wply4tx'), array(&$session_driver, 'wpl_yq_2') ); } if (! headers_sent() ) { $vwplqkus9i = wplz8bid::wplvf1d('settings', 'microcache_compat_session'); if (empty($vwplqkus9i) ) { session_start(); } } } if (! function_exists('wplm5vkd') ) { function wplm5vkd($vwpllzly5b, $vwpldwc9tz = '') { global $i2sdk, $memberium_registry_class; $vwplnkj9d_ = wplz8bid::wplvf1d(); $vwplgogvie = get_userdata($vwpllzly5b); $vwpl_vsi = wplz8bid::wplvf1d('settings', 'sync_new_wp_users'); $vwplup7mi = wplz8bid::wplvf1d('settings', 'password_field'); $vwplh1d50 = wplz8bid::wplvf1d('settings', 'local_auth_only', false); $vwplu08ru9 = (int) wplz8bid::wplvf1d('settings', 'new_user_registration_tag', 0); $vwplk94s = (int) wplz8bid::wplvf1d('settings', 'password_reset_tag', 0); $vwplnwot = 0; $vwplvtmqd = 0; $vwplrp9u24 = array( 'Email' => $vwplgogvie->user_email, $vwplup7mi => $vwpldwc9tz, ); if ($vwplh1d50) { unset($vwplrp9u24[$vwplup7mi]); } if (! empty($vwpl_vsi) ) { $vwplvtmqd = (int) $i2sdk->isdk->addWithDupCheck($vwplrp9u24, 'Email'); if ($vwplu08ru9) { $i2sdk->isdk->grpAssign($vwplvtmqd, $vwplu08ru9); } }   $vwplfbtq0 = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES); $vwplygr2 = sprintf(__('New user registration on your site %s:'), $vwplfbtq0) . "\r\n\r\n"; $vwplygr2 .= sprintf(__('Username: %s'), $vwplgogvie->user_login) . "\r\n\r\n"; $vwplygr2 .= sprintf(__('E-mail: %s'), $vwplgogvie->user_email) . "\r\n"; @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $vwplfbtq0), $vwplygr2); if (empty($vwpldwc9tz) ) { return; } $vwplygr2 = sprintf(__('Username: %s'), $vwplgogvie->user_login) . "\r\n"; $vwplygr2 .= sprintf(__('Password: %s'), $vwpldwc9tz) . "\r\n"; $vwplygr2 .= wp_login_url() . "\r\n"; wp_mail($vwplgogvie->user_email, sprintf(__('[%s] Your username and password'), $vwplfbtq0), $vwplygr2); } }
