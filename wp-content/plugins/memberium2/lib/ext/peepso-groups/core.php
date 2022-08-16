<?php
/**
 * Copyright (C) 2020 David Bullock
 * Web Power and Light, LLC
 */

 if (! defined('ABSPATH') ) { header('HTTP/1.0 403 Forbidden'); die(); } class wplsqns7 { static $instance = false; private function __construct() { add_action('memberium_session_regenerated', array($this, 'wplel7e3f'), 10, 2); } static function wplwsvahj() { if (! self::$instance) { self::$instance = new wplsqns7; } } function wplel7e3f($vwpllzly5b, $vwplc0nobe) { global $wpdb; if (! $vwpllzly5b ) { return; } $vwpls0hwb5 = isset($vwplc0nobe['memb_user']['Groups']) ? explode(',', $vwplc0nobe['memb_user']['Groups']) : array(); if (empty($vwpls0hwb5) ) { return; }  $vwplx1ap5_ = "SELECT `gm_group_id` FROM `{$wpdb->prefix}peepso_group_members` WHERE `gm_user_id` = {$vwpllzly5b}"; $vwplrudn1 = implode(',', array_keys($wpdb->get_results($vwplx1ap5_, OBJECT_K) ) ); if (! empty($vwplrudn1) ) { $vwplx1ap5_ = "SELECT `post_id`, `meta_value` FROM `{$wpdb->postmeta}` WHERE `post_id` IN ( {$vwplrudn1} ) AND `meta_key` = 'autojoin' AND `meta_value` > ''"; $vwpljpl2 = $wpdb->get_results($vwplx1ap5_, OBJECT_K); if (! empty($vwpljpl2) ) { foreach($vwpljpl2 as $vwplq2oa1l) { if (! in_array($vwplq2oa1l->meta_value, $vwpls0hwb5) ) { $peepso = new PeepSoGroupUser($vwplq2oa1l->post_id, $vwpllzly5b); $peepso->member_leave(); } } } }  $vwplx1ap5_ = "SELECT distinct(`gm_group_id`) FROM `{$wpdb->prefix}peepso_group_members` WHERE `gm_user_id` <> {$vwpllzly5b}"; $vwplrudn1 = implode(',', array_keys($wpdb->get_results($vwplx1ap5_, OBJECT_K) ) ); if (! empty($vwplrudn1) ) { $vwplx1ap5_ = "SELECT `post_id`, `meta_value` FROM `{$wpdb->postmeta}` WHERE `post_id` IN ( {$vwplrudn1} ) AND `meta_key` = 'autojoin' AND `meta_value` > ''"; $vwpljpl2 = $wpdb->get_results($vwplx1ap5_, OBJECT_K); if (! empty($vwpljpl2) ) { foreach($vwpljpl2 as $vwplq2oa1l) { if (in_array($vwplq2oa1l->meta_value, $vwpls0hwb5) ) { $peepso = new PeepSoGroupUser($vwplq2oa1l->post_id, $vwpllzly5b); $peepso->member_join(); } } } } } } wplsqns7::wplwsvahj();
