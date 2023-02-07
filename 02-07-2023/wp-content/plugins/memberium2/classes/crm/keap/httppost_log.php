<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_q1amx {  static 
function m4is_u4dk( int $m4is_aicfp, string $m4is_j1vz = 'event', string $m4is_yeag = '', string $m4is_nwsv = '', bool $m4is_pxn7 = false ) : int { if ( $m4is_j1vz == 'httppost' ) { $m4is_iuf52 = memberium_app()->m4is_mmdrl( 'settings', 'httppost_log' ); if ( $m4is_pxn7 === false && empty($m4is_iuf52) ) { return false; } } global $wpdb; $m4is_u13x = MEMBERIUM_DB_HTTPPOST; $m4is_j0n7 = [ 'contactid' => (int) $m4is_aicfp, 'type' => trim( $m4is_j1vz ), 'appname' => memberium_app()->m4is_re5x( 'appname' ), 'ipaddress' => $m4is_nwsv, 'log' => trim($m4is_yeag) . "\n", ]; $m4is_mr7hxo = [ '%d', '%s', '%s', '%s', '%s', ]; $wpdb->insert($m4is_u13x, $m4is_j0n7, $m4is_mr7hxo); $m4is_mh5n09 = (int) $wpdb->insert_id; return $m4is_mh5n09; }  static 
function m4is_rf68r( int $m4is_mh5n09, string $m4is_yeag ) : bool { if ( $m4is_mh5n09 ) { global $wpdb; $m4is_mh5n09 = (int) $m4is_mh5n09; $m4is_yeag = trim($m4is_yeag); if (! empty($m4is_yeag) && ! empty($m4is_mh5n09) ) { $m4is_u13x = MEMBERIUM_DB_HTTPPOST; $m4is_ioxk = "UPDATE `{$m4is_u13x}` SET `log` = CONCAT( IFNULL( `log`, '' ), %s ) WHERE `id` = %d;"; $m4is_ioxk = $wpdb->prepare($m4is_ioxk, $m4is_yeag . "\n", $m4is_mh5n09); $wpdb->query($m4is_ioxk); return true; } } return false; }  static 
function m4is_dd80rf() { $m4is_u13x = MEMBERIUM_DB_HTTPPOST; $m4is_smzkru = defined('HTTPPOST_LOG_DAYS') ? (int) constant('HTTPPOST_LOG_DAYS') : 7; $m4is_ioxk = "DELETE FROM `{$m4is_u13x}` WHERE `time` < NOW() - INTERVAL {$m4is_smzkru} DAY "; $GLOBALS['wpdb']->query($m4is_ioxk); } }
