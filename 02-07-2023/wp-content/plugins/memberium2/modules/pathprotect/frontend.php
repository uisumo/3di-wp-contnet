<?php
/**
 * Copyright (c) 2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_ght0e6 { 
function process_path_protect_rules() { $m4is_pqr7 = $_SERVER['REQUEST_URI']; $m4is_edow = ''; $m4is_pizyx = get_site_url(); $m4is_tct_hk = $this->m4is_y843hl(); $m4is_vj4p = function_exists( 'is_user_logged_in' ) ? is_user_logged_in() : false; if (! empty($m4is_tct_hk['rules']) && is_array($m4is_tct_hk['rules'])) { foreach ( $m4is_tct_hk['rules'] as $m4is__5k0n ) { $m4is__5k0n['urls'] = isset( $m4is__5k0n['urls'] ) ? $m4is__5k0n['urls'] : ''; $m4is_yhyv7 = array_filter( array_map( 'trim', explode( "\n", $m4is__5k0n['urls'] ) ) ); if ( is_array($m4is_yhyv7) ) { foreach( $m4is_yhyv7 as $m4is__mto ) { if ( strpos( $m4is_pqr7, $m4is__mto ) === 0 ) { $m4is_yx4m = true; if ( $m4is__5k0n['logged_in'] == 1 && ! $m4is_vj4p ) { $m4is_yx4m = false; } if ( $m4is__5k0n['anonymous_only'] == 1 && $m4is_vj4p ) { $m4is_yx4m = false; } if ( ! $m4is_yx4m ) { $m4is_edow = $m4is__5k0n['prohibited_action']; $m4is_pizyx = $m4is__5k0n['redirect_url']; break; } } } } } } if ( $m4is_edow == 'hide' ) { include(get_query_template('404') ); exit; } elseif ( $m4is_edow == 'redirect' ) { m4is_d8yr0_::m4is_vsv0mr(); nocache_headers(); wp_redirect($m4is_pizyx); exit; } } private 
function m4is_y843hl() { $m4is_ap3_ = 'WPAL/pathprotect/settings'; $m4is_ghufz = 'MemberiumPathProtect'; $m4is_tct_hk = get_option($m4is_ap3_, false); if ($m4is_tct_hk === false) { $m4is_tct_hk = get_option($m4is_ghufz, ''); if (is_array($m4is_tct_hk) ) { update_option($m4is_ap3_, $m4is_tct_hk); } } if (! is_array($m4is_tct_hk) ) { $m4is_tct_hk = []; } return $m4is_tct_hk; } 
function __construct() { global $pagenow; if ( ! in_array($pagenow, ['wp-login.php', 'wp-register.php']) ) { add_action( 'init', [$this, 'process_path_protect_rules'] ); } } }
