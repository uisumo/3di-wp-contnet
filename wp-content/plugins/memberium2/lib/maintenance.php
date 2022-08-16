<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wpldk1bw { static function wplan6_u() { global $i2sdk; $vwplinyk0 = wplz8bid::wplvf1d('settings', 'sync_ecommerce', false); $vwplktq3k = get_option('memberium_tables_updated', array() ); $vwpli31x0l = isset($vwplktq3k['i2sdk_customfields']) ? $vwplktq3k['i2sdk_customfields'] : 0; $i2sdk->synccustomFields(); $vwplktq3k['i2sdk_customfields'] = time(); update_option('memberium_tables_updated', $vwplktq3k, false); memberium_app()->wplgtes(); if ($vwplinyk0) { memberium_app()->wplblz7(); } } static function wpli8x_6() { wpln9_s::wplzjhtq(); wpllbej::wplwwbm9(); memberium_app()->wplgfugwo(); wpllbej::wplctzj(); memberium_app()->wplrtxvdy(); memberium_app()->wplaw3p(); memberium_app()->wplf_82is(); } static function wplpen2() { global $wpdb; $vwplx1ap5_ = "SELECT `option_name` AS `key` FROM {$wpdb->options} WHERE `option_name` LIKE '_transient_timeout_%' AND `option_value` < " . time() . " ; "; $vwply4j8x = $wpdb->get_col($vwplx1ap5_); if (! empty($vwply4j8x) ) { $vwplx1ap5_ = ''; foreach($vwply4j8x as $vwplheakg) { $vwply17edn = explode('_transient_timeout_', $vwplheakg); $vwply17edn = $vwply17edn[1]; if (substr($vwplheakg, 0, 6) == '_site_') { $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE '_site_transient_%{$vwply17edn}'; "); } else { $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE '_transient_%{$vwply17edn}'; "); } } } }  static function wplme0cfq() { global $i2sdk; $vwplw5rgd3 = wplz8bid::wplm3z9k('appname'); $vwplkjx4fs = wplycjh::wplwlamwg(0, 'cron', 'Expire Subscriptions'); date_default_timezone_set('America/New_York'); $vwpluaj7 = date('Y-m-d'); $vwplc0g3p = array( 'Id', ); $vwplv80sz = array( 'Status' => 'Active', 'EndDate' => '~<=~' . $vwpluaj7, ); $vwplm2n3w = $i2sdk->isdk->dsQuery('RecurringOrder', 1000, 0, $vwplv80sz, $vwplc0g3p); if (is_array($vwplm2n3w) ){ $vwplgvh0x = array('Status' => 'Inactive'); foreach($vwplm2n3w as $vwplpwet1) { set_time_limit(30); $i2sdk->isdk->dsUpdate('RecurringOrder', (int) $vwplpwet1['Id'], $vwplgvh0x); wplycjh::wplxc5ht_($vwplkjx4fs, "Deactivating Recurring Order #{$vwplpwet1['Id']}\n"); usleep(250000); } } } static function wplgg2tyv() { global $i2sdk; $vwplkjx4fs = wplycjh::wplwlamwg(0, 'cron', 'scanMakePass Started'); $vwpln_lstx = (int) wplz8bid::wplvf1d('settings', 'makepass_scan_tag', 0); $vwplf748qb = (int) wplz8bid::wplvf1d('settings', 'makepass_success_tag', 0); $vwplih1ow = (int) wplz8bid::wplvf1d('settings', 'makepass_success_actionset', 0); $vwplz81x75 = (int) wplz8bid::wplvf1d('settings', 'makepass_scan_size', 0); $vwpl_2cd9 = wplz8bid::wplvf1d('settings', 'username_field', 'Email'); $vwplup7mi = wplz8bid::wplvf1d('settings', 'password_field', 'Password'); if ( (! $vwpln_lstx) || (! $vwplf748qb && ! $vwplih1ow) ) { return; }  $vwplc0g3p = wpllbej::wplntnyv('Contact', true); $vwplv80sz = array( 'Groups' => $vwpln_lstx, ); $vwpl_w3hc2 = $i2sdk->isdk->dsQueryOrderBy('Contact', $vwplz81x75, 0, $vwplv80sz, $vwplc0g3p, 'LastUpdated', false); if (is_array($vwpl_w3hc2) ) { foreach($vwpl_w3hc2 as $vwplrp9u24) { $vwplvtmqd = isset($vwplrp9u24['Id']) ? (int) $vwplrp9u24['Id'] : 0; $vwplp25z = isset($vwplrp9u24[$vwpl_2cd9]) ? strtolower(trim($vwplrp9u24[$vwpl_2cd9]) ) : ''; $vwpltfnm7 = isset($vwplrp9u24['Email']) ? strtolower(trim($vwplrp9u24['Email']) ) : ''; $vwpljfjl = isset($vwplrp9u24[$vwplup7mi]) ? $vwplrp9u24[$vwplup7mi] : ''; $vwpllpv3k = $vwplrp9u24['Groups']; $vwpll5uo = false; $vwplbk4y2 = false; $vwplv09c = array(); wplycjh::wplxc5ht_($vwplkjx4fs, "Contact ID = {$vwplvtmqd}, Username = {$vwplp25z}"); if (empty($vwplvtmqd) ) { break; } if (empty($vwplp25z) ) { $vwplv09c[$vwpl_2cd9] = $vwpltfnm7; $vwplrp9u24[$vwpl_2cd9] = $vwpltfnm7; $vwplc_uoh4 = $vwpltfnm7; }  if (username_exists($vwplc_uoh4) || email_exists($vwplc_uoh4) ) { $vwplyio4f = $i2sdk->isdk->updateCon($vwplvtmqd, $vwplv09c);  usleep(250000); memberium_app()->wplt263_("-{$vwpln_lstx}", $vwplvtmqd); usleep(250000); memberium_app()->wplt263_("{$vwplf748qb}", $vwplvtmqd); break; } if (empty($vwplrp9u24[$vwplup7mi]) ) { $vwplrp9u24[$vwplup7mi] = memberium_app()->wpleh1zcw(); $vwplv09c[$vwplup7mi] = $vwplrp9u24[$vwplup7mi]; $vwplyio4f = $i2sdk->isdk->updateCon($vwplvtmqd, $vwplv09c);  } memberium_app()->wplto2h4($vwplrp9u24);  $vwpldj4of = array(); $vwpldj4of['user_login'] = $vwplrp9u24[$vwpl_2cd9]; $vwpldj4of['user_pass'] = $vwplrp9u24[$vwplup7mi]; $vwpldj4of['first_name'] = isset($vwplrp9u24['FirstName']) ? trim($vwplrp9u24['FirstName']) : ''; $vwpldj4of['last_name'] = isset($vwplrp9u24['LastName']) ? trim($vwplrp9u24['LastName']) : ''; $vwpldj4of['user_url'] = isset($vwplrp9u24['Website']) ? trim($vwplrp9u24['Website']) : ''; $vwpldj4of['user_email'] = isset($vwplrp9u24['Email']) ? strtolower(trim($vwplrp9u24['Email']) ) : ''; $vwplgitq = array('contact' => $vwplrp9u24); $_POST['pass1'] = $vwplrp9u24[$vwplup7mi]; $vwpldj4of['display_name'] = apply_filters('memberium/wpuser/display_name', memberium_app()->wplc4zac($vwplgitq), $vwplrp9u24); $vwpldj4of['nickname'] = apply_filters('memberium/wpuser/nickname', $vwpldj4of['display_name'], $vwplrp9u24); $vwpldj4of['user_nicename'] = apply_filters('memberium/wpuser/nicename', sanitize_title($vwpldj4of['nickname'], $vwpldj4of['display_name']), $vwplrp9u24); $vwpl_ma6z = memberium_app()->wplqd_lae($vwplvtmqd); if (is_int($vwpl_ma6z) && $vwpl_ma6z > 0) { memberium_app()->wplaig81($vwplvtmqd, $vwpl_ma6z); do_action('user_register', $vwpl_ma6z); if (is_multisite() && ! is_user_member_of_blog($vwpl_ma6z) ) { $vwpltycqk9 = get_current_blog_id(); $vwplwpqkj8 = get_blog_option($vwpltycqk9, 'default_role', 'subscriber'); add_user_to_blog($vwpltycqk9, $vwpl_ma6z, $vwplwpqkj8); } if (function_exists('WPCW_actions_users_newUserCreated') ) { WPCW_actions_users_newUserCreated($vwpl_ma6z); } } if (empty($vwplih1ow) ) { memberium_app()->wplt263_("-{$vwpln_lstx}", $vwplvtmqd); usleep(250000); } if (! empty($vwplf748qb) ) { memberium_app()->wplt263_($vwplf748qb, $vwplvtmqd); usleep(250000); } if (! empty($vwplih1ow) ) { memberium_app()->wplmupt($vwplih1ow, $vwplvtmqd); usleep(250000); } if (MEMBERIUM_ERRORLOG) error_log('scanMakePass Contact Id: ' . $vwplrp9u24['Id'], 0);  } } } }
