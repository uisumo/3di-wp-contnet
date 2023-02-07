<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); m4is_km30y::m4is_burleh(); final 
class m4is_km30y { private $m4is_aicfp = 0, $m4is_qqzo = 10, $m4is_f9vi2l = '', $m4is_yu8j1 = 0; static 
function m4is_burleh() : self { static $m4is_jprj8; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_tpgkj(); $this->m4is_qhl2y1(); $this->m4is_a4ox0(); } private 
function m4is_tpgkj() { $this->m4is_qqzo = empty($_GET['limit']) ? 10 : (int) $_GET['limit']; $this->m4is_yu8j1 = empty($_GET['start']) ? 0 : (int) $_GET['start']; $this->m4is_f9vi2l = empty($_GET['search']) ? '' : trim($_GET['search']); $this->m4is_aicfp = empty($_GET['contact_id']) ? 0 : (int) $_GET['contact_id']; } private 
function m4is_j_z15s() { global $wpdb; $m4is_u13x = MEMBERIUM_DB_HTTPPOST; $m4is_q7m2 = memberium_app()->m4is_re5x('appname'); $m4is_mx1n8 = empty($this->m4is_f9vi2l) ? '' : " AND `log` LIKE '%" . $wpdb->esc_like($this->m4is_f9vi2l) . "%' "; $m4is_ioxk = "SELECT `id`, UNIX_TIMESTAMP(`time`) as `time`, `log` FROM `{$m4is_u13x}` WHERE `type` = 'cron' AND `appname` = '{$m4is_q7m2}' {$m4is_mx1n8} ORDER BY `id` DESC LIMIT {$this->m4is_qqzo} ;"; $m4is_jpzyit = $wpdb->get_results($m4is_ioxk, ARRAY_A); return $m4is_jpzyit; } private 
function m4is_qhl2y1() { $m4is_jpzyit = $this->m4is_j_z15s(); if (! is_array($m4is_jpzyit) || empty($m4is_jpzyit) ) { echo '<p>The Cron log is empty.</p>'; } else { $m4is_mysbf = get_option('timezone_string'); $m4is_piycrd = date_default_timezone_get(); date_default_timezone_set($m4is_mysbf); echo '<table class="widefat">'; echo '<tr><td width="150">Time</td><td>Results</td></tr>'; foreach($m4is_jpzyit as $m4is_wo7c93) { echo '<tr>'; echo '<td>', date('Y-m-d H:i:s', $m4is_wo7c93['time']), '</td>'; echo '<td>', $m4is_wo7c93['log'], '</td>'; echo '</tr>'; } echo '</table>'; date_default_timezone_set($m4is_piycrd); } } private 
function m4is_a4ox0() { echo '<form method="get" style="margin-top:12px;">'; echo '<input type="hidden" name="page" value="memberium-logs">'; echo '<input type="hidden" name="tab" value="cron">'; echo "Search: <input type='text' name='search' value='{$this->m4is_f9vi2l}' placeholder='Search Results'>"; echo "Limit: <input type='text' name='limit' value='{$this->m4is_qqzo}' placeholder='# Results'>"; echo '<input type="submit" value="Search" class="button-primary" style="margin-left:15px;">'; echo '</form>'; } }
