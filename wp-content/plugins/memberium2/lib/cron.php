<?php
/**
 * Copyright (c) 2018-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wplneci { static function wplx4fq0i() { $vwpljvhj = time() + 180; if (! wp_next_scheduled('memberium_scanmakepass') ) { wp_schedule_event($vwpljvhj, '3min', 'memberium_scanmakepass'); } if (! wp_next_scheduled('memberium_maintenance') ) { wp_schedule_event($vwpljvhj + 15, 'hourly', 'memberium_maintenance'); } if (! wp_next_scheduled('memberium_maintenance12') ) { wp_schedule_event($vwpljvhj + 30, 'twicedaily', 'memberium_maintenance12'); } if (! wp_next_scheduled('memberium_license_check') ) { wp_schedule_event($vwpljvhj + 45, 'daily', 'memberium_license_check'); } update_option('memberium_cron', $vwpljvhj); } static function wplwvk1() { $vwpld78sfj = array( 'memberium_license_check', 'memberium_maintenance', 'memberium_maintenance12', 'memberium_scanmakepass', ); foreach($vwpld78sfj as $vwplvp7j) { wp_clear_scheduled_hook($vwplvp7j); } delete_option('memberium_cron'); } static function wplf7oqyj() { } }
