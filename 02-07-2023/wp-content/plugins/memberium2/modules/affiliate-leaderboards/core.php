<?php
 class_exists('m4is_emz57o') || die(); final 
class m4is_mifz { const VERSION = '1.0'; private $m4is_bxv7u, $m4is_hwvlct = false, $m4is_mhrv6_ = false, $m4is_cpwjsn = false, $m4is_g8qm = []; static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8) ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { if ( ! m4is_o5aoir::m4is__qlbej() ) { return; } $this->m4is_bxv7u = memberium_app(); $this->m4is_gopgz(); } private 
function m4is_gopgz() { $this->m4is_bxv7u->m4is_fovlg( [ 'm4is_i6vs' => __DIR__ . '/cron', 'm4is_bmod' => __DIR__ . '/shortcodes', ] ); add_action( 'memberium_maintenance12', ['m4is_i6vs', 'm4is_wj1xmr'] ); if ( is_admin() ) { require_once __DIR__ . '/admin.php'; m4is_b_28a::m4is_a6x52r(); } else { $this->m4is_gg_4(); } } 
function m4is_gu3m() { return self::VERSION; } 
function m4is_owh5() { return (array) get_option( 'memberium_leaderboard_profiles', [] ); } 
function m4is_co90ks( $m4is_g8qm ) { update_option( 'memberium_leaderboard_profiles', $m4is_g8qm ); $this->m4is_g8qm = $m4is_g8qm; } 
function m4is_l54tf( $m4is_b40e_m ) { $this->m4is_g8qm = $this->m4is_owh5(); foreach( $this->m4is_g8qm as $m4is_ap3_ => $m4is_g4ulmz ) { if ( $m4is_b40e_m === $m4is_ap3_ || 0 === strcasecmp( $m4is_b40e_m, $m4is_g4ulmz['name'] ) ) { return $m4is_g4ulmz; } } return false; } 
function m4is_gg_4() { add_action( 'memberium/shortcodes/add', [$this, 'm4is_gg_4'] ); add_shortcode( 'memb_show_leaderboard', ['m4is_bmod', 'm4is_zkq_01'] ); } }
