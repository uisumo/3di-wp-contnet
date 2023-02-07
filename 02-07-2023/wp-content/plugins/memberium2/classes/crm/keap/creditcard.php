<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_s3nu {  static 
function m4is_cd2zws( int $m4is_aicfp, string $m4is_q7m2 = '' ) { $m4is_q7m2 = empty( $m4is_q7m2 ) ? memberium_app()->m4is_re5x( 'appname' ) : $m4is_q7m2; return 'memberium/creditcards/' . $m4is_q7m2 . '/' . $m4is_aicfp; }  static 
function m4is_p1idj2( int $m4is_aicfp ) : bool { if ( $m4is_aicfp ) { $m4is_t7i0bz = self::m4is_cd2zws( $m4is_aicfp ); delete_transient( $m4is_t7i0bz ); return true; } return false; }  static 
function m4is_knd_c(array $m4is_xk0cg) { return end($m4is_xk0cg); }  static 
function m4is_n8hr4l(int $m4is_a0vjlg) { $m4is__ntc3 = [ 0 => 'Unknown', 1 => 'Error', 2 => 'Deleted', 3 => 'OK', 4 => 'Inactive', ]; return key_exists($m4is_a0vjlg, $m4is__ntc3) ? $m4is__ntc3[$m4is_a0vjlg] : 'Unknown'; }  static 
function m4is_or9mj( int $m4is_aicfp, int $m4is_rr90 = 3) { $m4is_xk0cg = []; if ($m4is_aicfp > 0) { $m4is_t7i0bz = self::m4is_cd2zws($m4is_aicfp); $m4is_xk0cg = get_transient($m4is_t7i0bz); $m4is_b9hmo = m4is_lpl4d::m4is_a_2z(); if ($m4is_xk0cg === false) { $m4is_xk0cg = self::m4is_vpfcvg($m4is_aicfp); } if ($m4is_rr90 >= 0) { foreach($m4is_xk0cg as $m4is_ap3_ => $m4is_o6h2) { $m4is_z60ohb = (int) $m4is_o6h2['Status']; if ($m4is_z60ohb <> $m4is_rr90) { unset($m4is_xk0cg[$m4is_ap3_]); } } } if ($m4is_aicfp === $m4is_b9hmo) { $_SESSION['memb_user']['has_credit_card'] = is_array($m4is_xk0cg) ? count($m4is_xk0cg) : 0; } } return $m4is_xk0cg; }  static 
function m4is_vpfcvg( int $m4is_aicfp ) {      if ( $m4is_aicfp ) { $m4is_t7i0bz = self::m4is_cd2zws( $m4is_aicfp ); $m4is_w6xi = 300; $m4is_xk0cg = get_transient( $m4is_t7i0bz ); if ($m4is_xk0cg === false) { $m4is_gwtb03 = memberium_app()->m4is_wnlbj_(); $m4is_xk0cg = []; $m4is_qqzo = 1000; $m4is_u13x = 'CreditCard'; $m4is_zvxijt = 0; $m4is__dxt_o = 'ContactId'; $m4is_v_fri = $m4is_aicfp; $m4is_hkp7s = m4is_f84s3h::m4is_cm6nr( $m4is_u13x, false ); $m4is_w6mt = MEMBERIUM_DB_AFFILIATES; $m4is_c_3n = 0; $m4is_q7m2 = memberium_app()->m4is_re5x( 'appname' ); $m4is_kc1q = [ 'ContactId' => $m4is_aicfp,  ]; do { $m4is_jpzyit = $m4is_gwtb03->dsQueryOrderBy( $m4is_u13x, $m4is_qqzo, $m4is_zvxijt, $m4is_kc1q, $m4is_hkp7s, 'Id', true ); if ( is_array( $m4is_jpzyit ) ) { foreach ( $m4is_jpzyit as $m4is_wo7c93 ) { $m4is_xk0cg[$m4is_wo7c93['Id']] = $m4is_wo7c93; } $m4is_zvxijt++; $m4is_c_3n = $m4is_c_3n + count( $m4is_jpzyit ); } } while ( count( $m4is_jpzyit ) == $m4is_qqzo ); if ( is_array( $m4is_xk0cg ) ) { set_transient( $m4is_t7i0bz, $m4is_xk0cg, $m4is_w6xi ); } } } if ( m4is_lpl4d::m4is_a_2z() === $m4is_aicfp ) { $_SESSION['memb_user']['has_credit_card'] = is_array( $m4is_xk0cg ) ? count( $m4is_xk0cg ) : 0; } return $m4is_xk0cg; } }
