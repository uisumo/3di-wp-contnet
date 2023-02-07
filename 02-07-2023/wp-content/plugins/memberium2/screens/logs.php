<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); new m4is_rao8d; 
class m4is_rao8d { private $m4is_bxv7u, $m4is_bs50tf = 'login', $m4is_m_fnw0; 
function __construct() { $this->m4is_gopgz(); $this->m4is_exp59d(); m4is__95_::m4is_r6_jy(); $this->m4is_by18n(); $this->m4is_pa9udt(); $this->m4is_h5yot(); } private 
function m4is_gopgz() { $this->m4is_bs50tf = 'login'; $this->m4is_m_fnw0 = [ 'login' => '<i class="fa fa-history"></i> Logins', 'loginfail' => '<i class="fa fa-ban"></i> Login Error', 'httppost' => '<i class="fa fa-paper-plane"></i> HTTP POST', 'autologin' => '<i class="fa fa-magic"></i> Autologin', 'cron' => '<i class="fa fa-clock"></i> Cron', 'phperror' => '<i class="fa fa-bug"></i> PHP Errors',  ]; $this->m4is_bxv7u = memberium_app(); $this->m4is_shny = $this->m4is_j_qc4(); } private 
function m4is_j_qc4() { $m4is_obgvz = isset( $_GET['tab'] ) ? strtolower( $_GET['tab'] ) : ''; $m4is_obgvz = array_key_exists( $m4is_obgvz, $this->m4is_m_fnw0 ) ? $m4is_obgvz : $this->m4is_bs50tf; return $m4is_obgvz; } private 
function m4is_exp59d() { if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) { return; } if ( $this->m4is_shny == 'login' &&! empty( $_POST['delete_login_log'] ) ) { $m4is_kc1q = sprintf( "TRUNCATE TABLE `%s`", MEMBERIUM_DB_LOGINLOG ); } elseif ( $this->m4is_shny == 'httppost' && ! empty( $_POST['delete_httppost'] ) ) { $m4is_kc1q = sprintf( "DELETE FROM `%s` WHERE `type` = 'httppost'", MEMBERIUM_DB_HTTPPOST ); } elseif ( $this->m4is_shny == 'autologin' && ! empty($_POST['delete_autologin'] ) ) { $m4is_kc1q = sprintf( "DELETE FROM `%s` WHERE `type` = 'autologin'", MEMBERIUM_DB_HTTPPOST ); } else { $m4is_kc1q = false; } if ( $m4is_kc1q ) { global $wpdb; $wpdb->query( "DELETE FROM `{$m4is_u13x}` WHERE `type` = 'autologin'" ); } } private 
function m4is_by18n() { echo '<div class="wrap">'; echo '<h1>', _('Memberium Logs' ), '</h1>'; echo '<h2 class="nav-tab-wrapper">'; foreach ( $this->m4is_m_fnw0 as $m4is_obgvz => $m4is_ho0w2 ) { $m4is_mn_xj = ( $m4is_obgvz == $this->m4is_shny ) ? ' nav-tab-active' : ''; if ( $m4is_obgvz == $this->m4is_shny ) { echo "<span class='nav-tab{$m4is_mn_xj}'>{$m4is_ho0w2}</span>"; } else { echo "<a class='nav-tab{$m4is_mn_xj}' href='?page=", $_GET['page'], "&tab={$m4is_obgvz}'>{$m4is_ho0w2}</a>"; } } echo '</h2>'; } private 
function m4is_pa9udt() { $m4is_s3dnu = $this->m4is_bxv7u->m4is_n367bl( "logs-{$this->m4is_shny}-show.php" ); echo '<div class="memberium_tabcontent" style="margin-top:10px;">'; if ( file_exists( $m4is_s3dnu ) ) { require_once $m4is_s3dnu; } else { echo '<p>Screen Missing</p>'; } echo '</div>'; } private 
function m4is_h5yot() { echo '</div>'; } }
