<?php
/**
 * Copyright (c) 2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if ( !defined( 'ABSPATH' ) ) { die(); } final class wplk0dtr { function wplmql_() { $vwplpil9 = $_SERVER['REQUEST_URI']; $vwploia7_d = ''; $vwplimo5 = get_site_url(); $vwplelob86 = $this->wplrw2ix9(); if (! empty($vwplelob86['rules']) && is_array($vwplelob86['rules'])) { foreach ( $vwplelob86['rules'] as $vwplumpq ) { $vwplumpq['urls'] = isset( $vwplumpq['urls'] ) ? $vwplumpq['urls'] : ''; $vwplu9a0sb = array_filter( array_map( 'trim', explode( "\n", $vwplumpq['urls'] ) ) ); if ( is_array($vwplu9a0sb) ) { foreach( $vwplu9a0sb as $vwplfkojlf ) { if ( strpos( $vwplpil9, $vwplfkojlf ) === 0 ) { $vwplrtc96l = true; if ( $vwplumpq['logged_in'] == 1 && ! is_user_logged_in() ) { $vwplrtc96l = false; } if ( $vwplumpq['anonymous_only'] == 1 && is_user_logged_in() ) { $vwplrtc96l = false; } if ( ! $vwplrtc96l ) { $vwploia7_d = $vwplumpq['prohibited_action']; $vwplimo5 = $vwplumpq['redirect_url']; break; } } } } } } if ( $vwploia7_d == 'hide' ) { include(get_query_template('404') ); exit; } elseif ( $vwploia7_d == 'redirect' ) { nocache_headers(); wp_redirect($vwplimo5); exit; } } private function wplrw2ix9() { $vwply17edn = 'WPAL/pathprotect/settings'; $vwpl_lz_n = 'MemberiumPathProtect'; $vwplelob86 = get_option($vwply17edn, false); if ($vwplelob86 === false) { $vwplelob86 = get_option($vwpl_lz_n, ''); if (is_array($vwplelob86) ) { update_option($vwply17edn, $vwplelob86); } } if (! is_array($vwplelob86) ) { $vwplelob86 = array(); } return $vwplelob86; } function __construct() { if ( in_array( $GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php') ) ) { return; } $this->wplmql_(); } }
