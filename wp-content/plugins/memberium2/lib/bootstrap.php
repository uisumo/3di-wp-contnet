<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } if (defined('MEMBERIUM_INSTALLED') ) { return; } memberium_app(); function memberium_app() { static $vwploeilq = false; if (! $vwploeilq) { global $i2sdk; wplxmjt(); if (! defined('WP_DEBUG') || (! WP_DEBUG) ) { if (! MEMBERIUM_DEBUG) { @ini_set('display_errors', 0); error_reporting(error_reporting() & ~E_NOTICE & ~E_WARNING); } } require_once MEMBERIUM_CLASS_DIR . '/autoloader.php'; require_once MEMBERIUM_COMMON . '/functions.php'; require_once MEMBERIUM_COMMON . '/interface.php';  wplaah_w(); if (is_admin() ) { wplz7axr(); include_once MEMBERIUM_LIB . '/admin.php'; } if (! method_exists($i2sdk, 'isVerified') || ! $i2sdk->isVerified() ) { return; } $vwploeilq = new wplj_l2t; } return $vwploeilq; } function wplxmjt() { global $wpdb; $vwpla_f3 = array( 'MEMBERIUM' => true, 'MEMBERIUM_BETA' => 0, 'MEMBERIUM_COMMON' => MEMBERIUM_HOME_DIR . '/common/', 'MEMBERIUM_LIB_DIR' => __DIR__, 'MEMBERIUM_SCREEN_DIR' => __DIR__ . '/screens/', 'MEMBERIUM_DB_ACTIONSETS' => 'memberium_actionsets', 'MEMBERIUM_DB_AFFILIATES' => 'memberium_affiliates', 'MEMBERIUM_DB_CONTACTGROUPCATEGORIES' => 'memberium_contactgroupcategories', 'MEMBERIUM_DB_CONTACTS' => 'memberium_contacts', 'MEMBERIUM_DB_CONTACTTAGS' => 'memberium_contacttags', 'MEMBERIUM_DB_DATAFORMFIELDS' => 'i2sdk_dataformfields', 'MEMBERIUM_DB_EVENTS' => "{$wpdb->prefix}memberium_events", 'MEMBERIUM_DB_HTTPPOST' => 'memberium_httppost', 'MEMBERIUM_DB_INVOICES' => 'memberium_invoices', 'MEMBERIUM_DB_JOBS' => 'memberium_jobs', 'MEMBERIUM_DB_LANG' => "{$wpdb->prefix}memberium_lang", 'MEMBERIUM_DB_LOGINLOG' => 'memberium_loginlog', 'MEMBERIUM_DB_PAGETRACKING' => "{$wpdb->prefix}memberium_pagetracking", 'MEMBERIUM_DB_PRODUCTS' => 'memberium_products', 'MEMBERIUM_DB_QUEUE' => 'memberium_queue', 'MEMBERIUM_DB_SESSIONS' => "{$wpdb->prefix}memberium_sessions", 'MEMBERIUM_DB_TAGS' => 'memberium_tags', 'MEMBERIUM_DEBUG' => 0, 'MEMBERIUM_DEBUGLOG' => "{$_SERVER['DOCUMENT_ROOT']}/debuglog.txt", 'MEMBERIUM_DELIMITER' => '|', 'MEMBERIUM_ERRORLOG' => 0, 'MEMBERIUM_LIB' => __DIR__, 'MEMBERIUM_NESTING_LEVELS' => 10, 'MEMBERIUM_INSTALLED' => 1, 'MEMBERIUM_NOWYSIWYG' => 0, ); foreach($vwpla_f3 as $vwplyq9i7o => $vwplcjpa) { defined($vwplyq9i7o) ? '' : define($vwplyq9i7o, $vwplcjpa); } } function wplz7axr() { register_activation_hook(MEMBERIUM_HOME, array('wple8cx', 'wplldr75') ); register_uninstall_hook(MEMBERIUM_HOME, array('wple8cx', 'wpln2ae') ); register_deactivation_hook(MEMBERIUM_HOME, array('wple8cx', 'wplod95ok') ); }
