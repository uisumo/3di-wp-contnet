<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_xdqx {  static 
function m4is_aq4vwi() { $m4is_hxrbd = time() + 180; if (! wp_next_scheduled('memberium_scanmakepass') ) { wp_schedule_event($m4is_hxrbd, '3min', 'memberium_scanmakepass'); } if (! wp_next_scheduled('memberium_maintenance') ) { wp_schedule_event($m4is_hxrbd + 15, 'hourly', 'memberium_maintenance'); } if (! wp_next_scheduled('memberium_maintenance12') ) { wp_schedule_event($m4is_hxrbd + 30, 'twicedaily', 'memberium_maintenance12'); } if (! wp_next_scheduled('memberium_license_check') ) { wp_schedule_event($m4is_hxrbd + 45, 'daily', 'memberium_license_check'); } update_option('memberium_cron', $m4is_hxrbd); }  static 
function m4is_r3st1k() { $m4is_oy9c = [ 'memberium_license_check', 'memberium_maintenance', 'memberium_maintenance12', 'memberium_scanmakepass', ]; foreach( $m4is_oy9c as $m4is_mhrv6_ ) { wp_clear_scheduled_hook( $m4is_mhrv6_ ); } delete_option( 'memberium_cron' ); } static 
function m4is_gmjr57() { } }
