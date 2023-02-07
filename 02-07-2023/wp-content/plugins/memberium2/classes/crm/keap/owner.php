<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light
 */

 class_exists( 'm4is_emz57o' ) || die(); m4is_y96l1::m4is_gopgz(); final 
class m4is_y96l1 { private static $m4is_bxv7u, $m4is_q7m2; static 
function m4is_gopgz() { self::$m4is_bxv7u = memberium_app(); self::$m4is_q7m2 = self::$m4is_bxv7u->m4is_re5x( 'appname' ); }  static 
function m4is_u5u90o( string $m4is_q7m2 = '' ) { $m4is_q7m2 = empty( $m4is_q7m2) ? self::$m4is_q7m2 : $m4is_q7m2; return sprintf( 'memberium/owners/%s', $m4is_q7m2 ); }  static 
function m4is_ck_5( int $m4is_zi7wa, bool $m4is_qcu7zp = false ) : array { $m4is_pzy13 = self::m4is_xidq(); $m4is_k_z0vk = isset( $m4is_pzy13[$m4is_zi7wa] ) ? $m4is_pzy13[$m4is_zi7wa] : []; if ( $m4is_qcu7zp ) { $m4is_k_z0vk = array_change_key_case( $m4is_k_z0vk, CASE_LOWER ); } return apply_filters( 'memberium/owner/load', $m4is_k_z0vk ); }  static 
function m4is_xidq() : array { $m4is_t7i0bz = self::m4is_u5u90o(); $m4is_pzy13 = get_transient( $m4is_t7i0bz ); if ( $m4is_pzy13 === false ) { $m4is_gwtb03 = self::$m4is_bxv7u->m4is_wnlbj_(); $m4is_u13x = 'User'; $m4is_pzy13 = []; $m4is_hkp7s = m4is_f84s3h::m4is_cm6nr( 'User', false ); $m4is_kc1q = [ 'Id' => '%' ]; $m4is_jpzyit = $m4is_gwtb03->dsQuery( 'User', 1000, 0, $m4is_kc1q, $m4is_hkp7s ); if ( is_array( $m4is_jpzyit ) ) { foreach( $m4is_jpzyit as $m4is_k_z0vk ) { $m4is_pzy13[$m4is_k_z0vk['Id']] = $m4is_k_z0vk; } set_transient( $m4is_t7i0bz, $m4is_pzy13, DAY_IN_SECONDS ); } } return $m4is_pzy13; } }
