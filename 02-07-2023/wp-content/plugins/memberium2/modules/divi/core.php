<?php
/**
* Copyright (c) 2018-2022 David J Bullock
* Web Power and Light
*/

 class_exists('m4is_emz57o') || die();  final 
class m4is_mqyuz9 { static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; }  private 
function __construct() {} 
function m4is_zbtp(){ add_action( 'wpal/block/access/init', [$this, 'm4is_gopgz'] ); } 
function m4is_gopgz(){ add_action( 'et_builder_modules_loaded', [$this, 'm4is_xjxrbk'], PHP_INT_MAX ); add_action( 'admin_enqueue_scripts', [$this, 'm4is_syvg'] ); } 
function m4is_xjxrbk() { if( is_admin() || isset( $_GET['et_fb'] ) ) { $m4is_tbyfh = isset( $_GET['page'] ) && $_GET['page'] == 'et_theme_builder'; $m4is_tbyfh = $m4is_tbyfh || isset( $_GET['et_tb'] ); if ( $m4is_jhd1 <> 'et_theme_builder' && $m4is_tbyfh == false ) { $this->m4is_q2amj()->m4is_gopgz(); } } else{ $this->m4is_dm0y8e()->m4is_gopgz(); } }  
function m4is_syvg( $m4is_uwsyca ) { $m4is_njbq = ['edit.php', 'post-new.php', 'post.php']; if ( in_array( $m4is_uwsyca, $m4is_njbq ) ) { wp_enqueue_style( 'select2css_divi', plugin_dir_url(__FILE__) . 'select2_divi.css', false, '1.0.5', 'all' ); } } 
function m4is_q2amj(){ static $m4is_mi8edr = null; if ( is_null( $m4is_mi8edr ) ) { include_once __DIR__ . '/' . 'editor.php'; $m4is_mi8edr = m4is_qcoj::m4is_a6x52r(); } return $m4is_mi8edr; } 
function m4is_dm0y8e(){ static $m4is_cpwjsn = null; if( is_null( $m4is_cpwjsn ) ) { include_once __DIR__ . '/' . 'frontend.php'; $m4is_cpwjsn = m4is_ay7n::m4is_a6x52r(); } return $m4is_cpwjsn; } }
