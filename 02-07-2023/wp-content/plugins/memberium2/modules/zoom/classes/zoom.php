<?php
/**
 * Copyright (c) 2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die();  
class m4is_dn1_a { const VERSION = '1.0.0'; const OPTION_SLUG = 'wpal/zoom/settings'; private $config = []; private $options = null; private $connected = false;  
function init($m4is_iikfu) {  define('WPAL_ZOOM_HOME_DIR', dirname(__DIR__) . '/'); $m4is__mto = trailingslashit(plugins_url('', dirname(__FILE__) ) ); define('WPAL_ZOOM_URL', $m4is__mto); $m4is_p78sgz = [ 'parent_slug' => 'options-general.php', 'menu_slug' => 'wpal-zoom', 'shortcode_prefix' => 'wpal', 'I18n' => [ 'page_title' => __('Zoom Settings', 'wpal_ecomm'), 'menu_title' => __('Zoom', 'wpal_ecomm'), ] ]; $this->config = wp_parse_args($m4is_iikfu, $m4is_p78sgz); $this->register_wp_hooks(); }  
function register_wp_hooks(){ if( is_admin() ) {  add_action("admin_menu", function(){ $m4is_iikfu = $this->get_config(); $m4is_swhd5 = $m4is_iikfu['I18n']; add_submenu_page( $m4is_iikfu['parent_slug'], $m4is_swhd5['page_title'], $m4is_swhd5['menu_title'], 'manage_options', $m4is_iikfu['menu_slug'], [$this, 'zoom_settings_page'] ); }, PHP_INT_MAX ); } else {  $m4is_eg2e = $this->config['shortcode_prefix']; add_shortcode("{$m4is_eg2e}_zoom_event", function( $m4is_qvehs, $m4is_amunwi, $m4is_w9feq2 ) { $m4is_cpwjsn = $this->frontend(); $m4is_cpwjsn->frontend_scripts(); return $m4is_cpwjsn->zoom_event_func( $m4is_qvehs, $m4is_amunwi, $m4is_w9feq2 ); } ); } }  
function zoom_settings_page(){ $this->admin()->m4is_ggtrov( $this->m4is_mmdrl(), $this->get_config() ); }  
function frontend() { static $m4is_cpwjsn; if( is_null($m4is_cpwjsn) ){ require_once __DIR__ . '/frontend.php'; $m4is_cpwjsn = new m4is_rav1( self::VERSION ); } return $m4is_cpwjsn; }  
function admin(){ static $m4is_hwvlct; if( is_null($m4is_hwvlct) ){ require_once __DIR__ . '/admin.php'; $m4is_hwvlct = new m4is_wtvkh2( self::OPTION_SLUG, self::VERSION ); } return $m4is_hwvlct; }  
function api(){ static $m4is_dg4i = false; if(! $m4is_dg4i){ require_once __DIR__ . '/api.php'; $m4is_ap3_ = $this->m4is_mmdrl('api_key'); $m4is_invg7 = $this->m4is_mmdrl('api_secret'); $m4is_dg4i = new m4is_jagukq($m4is_ap3_, $m4is_invg7); } return $m4is_dg4i; }  
function get_config( $m4is_ap3_ = false ){ if( $m4is_ap3_ ){ if( isset( $this->config[$m4is_ap3_] ) ){ return $this->config[$m4is_ap3_]; } else { return false; } } else { return $this->config; } }  
function m4is_mmdrl( $m4is_ap3_ = false ){ if( is_null( $this->options ) ){ $this->options = get_option( self::OPTION_SLUG, [ 'default_email' => get_bloginfo('admin_email'), 'api_key' => '', 'api_secret' => '', 'connected' => false ] ); } if( $m4is_ap3_ ){ if( isset( $this->options[$m4is_ap3_] ) ){ return $this->options[$m4is_ap3_]; } else { return false; } } else { return $this->options; } }  private 
function __construct() { } static 
function get_wpal_zoom_instance() { static $m4is_c8ove = false; if (! $m4is_c8ove ) { $m4is_c8ove = new self; } return $m4is_c8ove; } }  
function m4is_dn1_a(){ return m4is_dn1_a::get_wpal_zoom_instance(); }
