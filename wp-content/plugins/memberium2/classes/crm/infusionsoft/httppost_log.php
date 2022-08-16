<?php
/**
 * Copyright (c) 2018-2020 David J Bullock
 * Web Power and Light
 */

 if ( !defined( 'ABSPATH' ) ) { die(); } final class wplycjh { static function wplwlamwg( $contact_id, $type = 'event', $text = '', $ipaddress = '', $override = false ) { $log_switch = wplz8bid::wplvf1d( 'settings', 'httppost_log' ); if ( $override === false && empty( $log_switch ) ) { return false; } global $wpdb; $table = MEMBERIUM_DB_HTTPPOST; $data = array( 'contactid' => (int) $contact_id, 'type' => trim( $type ), 'appname' => wplz8bid::wplm3z9k( 'appname' ), 'ipaddress' => $ipaddress, 'log' => trim( $text ) . "\n", ); $format = array( '%d', '%s', '%s', '%s', '%s', ); $wpdb->insert( $table, $data, $format ); $row_id = (int) $wpdb->insert_id; return $row_id; } static function wplxc5ht_( $row_id, $text ) { $log_switch = wplz8bid::wplvf1d( 'settings', 'httppost_log' ); if ( empty( $log_switch ) ) { return false; } global $wpdb; $row_id = (int) $row_id; $text = trim( $text ); if ( empty( $text ) || empty( $row_id ) ) { return false; } $table = MEMBERIUM_DB_HTTPPOST; $sql = "UPDATE `{$table}` SET `log` = CONCAT( IFNULL( `log`, '' ), %s ) WHERE `id` = %d;"; $sql = $wpdb->prepare( $sql, $text . "\n", $row_id ); $wpdb->query( $sql ); return true; } static function wplt_pchy() { global $wpdb; $days = defined('HTTPPOST_LOG_DAYS') ? constant('HTTPPOST_LOG_DAYS') : 7; $table = MEMBERIUM_DB_HTTPPOST; $sql = "DELETE FROM `{$table}` WHERE `time` < NOW() - INTERVAL {$days} DAY "; $wpdb->query( $sql ); } }
