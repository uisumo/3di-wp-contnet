<?php
/**
 * Copyright (c) 2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die();  
class m4is_wtvkh2 { private $key; private $version;  
function __construct( $m4is_ap3_, $m4is_hsyp0 ) { $this->key = $m4is_ap3_; $this->version = $m4is_hsyp0; add_filter('memberium/modules/active/names', [$this, 'm4is_hj92e'], 10, 1); } 
function m4is_hj92e($m4is_its6y) { return array_merge($m4is_its6y, [ 'Zoom for Memberium Support' ]); }  
function m4is_c5py() { $m4is_waxrhu = $this->version; $m4is_bq_zw = WPAL_ZOOM_URL . 'assets/'; wp_enqueue_style("wpal-zoom-admin-css", "{$m4is_bq_zw}wpal-zoom-admin.css", [], $m4is_waxrhu, 'all'); }  
function m4is_ggtrov($m4is_wmzqp, $m4is_iikfu) { $m4is_qiwse4 = $this->key; $m4is_zvxijt = $m4is_iikfu['menu_slug']; if ($_SERVER['REQUEST_METHOD'] == 'POST') { if( isset($_POST["{$m4is_zvxijt}-submit"]) ){  if ( isset($_POST["_{$m4is_qiwse4}_name"]) ){ if( wp_verify_nonce($_POST["_{$m4is_qiwse4}_name"], $m4is_qiwse4) ){ $m4is_wmzqp = $this->m4is_zlqu( $_POST, $m4is_wmzqp ); } } } } $this->m4is_c5py(); $m4is_swhd5 = $m4is_iikfu['I18n']; $m4is_ap3_ = $m4is_wmzqp['api_key']; $m4is_invg7 = $m4is_wmzqp['api_secret']; require_once WPAL_ZOOM_HOME_DIR . 'templates/auth-screen.php'; } 
function m4is_zlqu($m4is_j0n7, $m4is_wmzqp){ $m4is_tct_hk = ['api_key', 'api_secret']; $m4is__l2nv = false; foreach ($m4is_tct_hk as $m4is_ho0w2) { $m4is_r9pul = $m4is_wmzqp[$m4is_ho0w2]; $m4is_bm417 = isset($m4is_j0n7[$m4is_ho0w2]) ? esc_attr($m4is_j0n7[$m4is_ho0w2]) : ''; if( $m4is_bm417 != $m4is_r9pul ){ $m4is_wmzqp[$m4is_ho0w2] = $m4is_bm417; $m4is__l2nv = true; } } if($m4is__l2nv){ update_option($this->key, $m4is_wmzqp); } return $m4is_wmzqp; } }
