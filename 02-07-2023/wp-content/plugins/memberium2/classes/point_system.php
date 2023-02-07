<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_lvqbx1 {  static 
function m4is_yysd9e( int $m4is_q4c_xa = 0, int $m4is_j1vz = 0 ) : int { $m4is_q4c_xa = $m4is_q4c_xa == 0 ? get_current_user_id() : (int) $m4is_q4c_xa; $m4is_j1vz = (int) $m4is_j1vz; if ( function_exists( 'badgeos_get_users_points' ) ) { $m4is_lx0o = badgeos_get_users_points( $m4is_q4c_xa ); } elseif (function_exists( 'gamipress_get_user_points' ) ) { $m4is_lx0o = gamipress_get_user_points( $m4is_q4c_xa ); } else { $m4is_ap3_ = empty( $m4is_j1vz ) ? '_memberium_points' : "_memberium_{$m4is_j1vz}_points"; $m4is_lx0o = get_user_meta( $m4is_q4c_xa, $m4is_ap3_, true ); } return (int) $m4is_lx0o; }  static 
function m4is_pf0z(int $m4is_q4c_xa = 0, int $m4is_qcdy8h = 0, int $m4is_j1vz = 0) : int { $m4is_q4c_xa = $m4is_q4c_xa == 0 ? get_current_user_id() : $m4is_q4c_xa; $m4is_qcdy8h = $m4is_qcdy8h; $m4is_j1vz = $m4is_j1vz; if ($m4is_q4c_xa == 0) { return false; } $m4is_j1vz = self::m4is_akutc($m4is_j1vz); if (function_exists('badgeos_update_users_points') ) { $m4is_relb8 = badgeos_update_users_points($m4is_q4c_xa, $m4is_qcdy8h); badgeos_log_users_points($m4is_q4c_xa, $m4is_qcdy8h, $m4is_relb8, 0, 0); } elseif (function_exists('gamipress_update_user_points') ) { $m4is_relb8 = gamipress_update_user_points($m4is_q4c_xa, $m4is_qcdy8h); gamipress_log_user_points($m4is_q4c_xa, $m4is_qcdy8h, $m4is_relb8, 0, 0); } else { $m4is_ap3_ = empty($m4is_j1vz) ? '_memberium_points' : "_memberium_{$m4is_j1vz}_points"; $m4is_relb8 = $m4is_qcdy8h + self::m4is_yysd9e($m4is_q4c_xa); update_user_meta($m4is_q4c_xa, $m4is_ap3_, $m4is_relb8); } return $m4is_relb8; }  static 
function m4is_dc4ul7($m4is_qvehs, string $m4is_amunwi = '', string $m4is_rz70ok = '') : string { $m4is_q4c_xa = isset($m4is_qvehs['user_id']) ? (int) $m4is_qvehs['user_id'] : get_current_user_id(); $m4is_j1vz = isset($m4is_qvehs['type']) ? (int) $m4is_qvehs['type'] : ''; $m4is_lx0o = self::m4is_yysd9e($m4is_q4c_xa, $m4is_j1vz); return (string) $m4is_lx0o; }     private static 
function m4is_akutc($m4is_rgue2 = null) : string { if (empty($m4is_rgue2) ) { return ''; } if (function_exists('gamipress_update_user_points') ) { $m4is_j1vz = gamipress_get_points_type($m4is_j1vz); } else { $m4is_j1vz = (string) $m4is_rgue2; } return $m4is_j1vz; } }
