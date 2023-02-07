<?php
/**
 * Copyright (C) 2022 David Bullock
 * Web Power and Light, LLC
 */

 class_exists('m4is_emz57o') || die(); 
class m4is_xgkt { 
function m4is_a5tu($m4is_its6y = []) { return array_merge($m4is_its6y, ['Peepso Groups for Memberium']); } 
function m4is_ql81n($m4is_q4c_xa, $m4is_sxfbjo) { global $wpdb; if (! $m4is_q4c_xa ) { return; } $m4is_znf9 = isset($m4is_sxfbjo['memb_user']['tags']) ? explode(',', $m4is_sxfbjo['memb_user']['tags']) : []; if (empty($m4is_znf9) ) { return; }  $m4is_ioxk = "SELECT `gm_group_id` FROM `{$wpdb->prefix}peepso_group_members` WHERE `gm_user_id` = {$m4is_q4c_xa}"; $m4is_ixyb = implode(',', array_keys($wpdb->get_results($m4is_ioxk, OBJECT_K) ) ); if (! empty($m4is_ixyb) ) { $m4is_ioxk = "SELECT `post_id`, `meta_value` FROM `{$wpdb->postmeta}` WHERE `post_id` IN ( {$m4is_ixyb} ) AND `meta_key` = 'autojoin' AND `meta_value` > ''"; $m4is_wsf8 = $wpdb->get_results($m4is_ioxk, OBJECT_K); if (! empty($m4is_wsf8) ) { foreach($m4is_wsf8 as $m4is_tm_b) { if (! in_array($m4is_tm_b->meta_value, $m4is_znf9) ) { $peepso = new PeepSoGroupUser($m4is_tm_b->post_id, $m4is_q4c_xa); $peepso->member_leave(); } } } }  $m4is_ioxk = "SELECT distinct(`gm_group_id`) FROM `{$wpdb->prefix}peepso_group_members` WHERE `gm_user_id` <> {$m4is_q4c_xa}"; $m4is_ixyb = implode(',', array_keys($wpdb->get_results($m4is_ioxk, OBJECT_K) ) ); if (! empty($m4is_ixyb) ) { $m4is_ioxk = "SELECT `post_id`, `meta_value` FROM `{$wpdb->postmeta}` WHERE `post_id` IN ( {$m4is_ixyb} ) AND `meta_key` = 'autojoin' AND `meta_value` > ''"; $m4is_wsf8 = $wpdb->get_results($m4is_ioxk, OBJECT_K); if (! empty($m4is_wsf8) ) { foreach($m4is_wsf8 as $m4is_tm_b) { if (in_array($m4is_tm_b->meta_value, $m4is_znf9) ) { $peepso = new PeepSoGroupUser($m4is_tm_b->post_id, $m4is_q4c_xa); $peepso->member_join(); } } } } } private 
function m4is_ap508() { add_action('memberium/session/updated', [$this, 'm4is_ql81n'], 10, 2); if (is_admin() ) { add_filter('memberium/modules/active/names', [$this, 'm4is_a5tu'], 10, 1); } } private 
function __construct() { $this->m4is_ap508(); } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
