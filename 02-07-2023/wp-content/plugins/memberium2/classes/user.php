<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_lpl4d { const USER_FIELD = 'memberium::field::'; const SESSION_KEY = 'memberium/session'; static private $users = []; private $session = []; private $dirty = false; private $contact_id = 0; private $user_id = 0; private $defer_save = false;     static 
function m4is_a6x52r(int $m4is_q4c_xa, bool $regen = false) { if (! array_key_exists($m4is_q4c_xa, self::$users) ) { self::$users[$m4is_q4c_xa] = new m4is_lpl4d($m4is_q4c_xa, $regen); } return self::$users[$m4is_q4c_xa]; }  static 
function m4is_rs2o_() { return array_keys(self::$users); } static 
function m4is_e3r17($m4is_q4c_xa) { unset(self::$users[$m4is_q4c_xa]); }  private 
function __construct($m4is_q4c_xa = 0, $m4is_w_pnf = false) { $this->user_id = $m4is_q4c_xa; if ($m4is_w_pnf) { $this->m4is_q4nu(); } $this->session = $this->m4is_ze6uf(); } 
function __destruct() { if ($this->dirty) { $this->m4is_dzve(); } unset(self::$users[$this->user_id]); } 
function m4is_j7sv0k( bool $m4is_ms3pm = true ) { $this->defer_save = (bool) $m4is_ms3pm; if (! $m4is_ms3pm) { if ($this->dirty) { $this->m4is_dzve(); } } } 
function m4is_dzve( array $m4is_j0n7 ) { update_user_meta( $this->user_id, self::SESSION_KEY, $m4is_j0n7 ); $this->dirty = false; } 
function m4is_ze6uf() { $m4is_j0n7 = get_user_meta($this->user_id, self::SESSION_KEY, true); if (! empty($m4is_j0n7) ) { $this->session = $m4is_j0n7; } else { $this->session = $this->m4is_q4nu(); } return $this->session; } 
function m4is_ej5_0() { $this->session = []; delete_user_meta($this->user_id, self::SESSION_KEY); }    
function m4is_hxmi3a( $m4is_ap3_, $m4is_lphf = '' ) { $m4is_ap3_ = strtolower( trim( $m4is_ap3_ ) ); return isset( $this->session['keap']['affiliate'][$m4is_ap3_] ) ? $this->session['keap']['affiliate'][$m4is_ap3_] : $m4is_lphf; } 
function m4is_s2xd8( string $m4is_ap3_, $m4is_rhfd ) { $m4is_ap3_ = strtolower( trim( $m4is_ap3_ ) ); $this->session['keap']['affiliate'][$m4is_ap3_] = $m4is_rhfd; if (! $this->defer_save) { $this->m4is_dzve(); } return $m4is_rhfd; } 
function m4is_z8e9($m4is_ap3_, $m4is_rhfd ) { $m4is_ap3_ = strtolower(trim($m4is_ap3_) ); $this->session['keap']['contact'][$m4is_ap3_] = $m4is_rhfd; if (! $this->defer_save) { $this->m4is_dzve(); } return $m4is_rhfd; } 
function m4is__u7z($m4is_ap3_ = '', $m4is_lphf = '') { $m4is_ap3_ = strtolower(trim($m4is_ap3_) ); return isset($this->session['keap']['contact'][$m4is_ap3_]) ? $this->session['keap']['contact'][$m4is_ap3_] : $m4is_lphf; }    
function m4is_o4t3($m4is_ifbz = '', $m4is_ap3_ = '', $m4is_lphf = '') { if (empty($m4is_ifbz) ) { return $this->session; } if (empty($m4is_ap3_) ) { return $this->session[$m4is_ifbz]; } return isset($this->session[$m4is_ifbz][$m4is_ap3_]) ? $this->session[$m4is_ifbz][$m4is_ap3_] : $m4is_lphf; } 
function m4is_vh2zp($m4is_ifbz = '', $m4is_ap3_ = '', $m4is_rhfd = '') { if (empty ($m4is_ifbz) || empty ($m4is_ap3_) ) { return $this->session[$m4is_ifbz]; } $m4is_rhfd = isset($this->session[$m4is_ifbz][$m4is_ap3_]) ? $this->session[$m4is_ifbz][$m4is_ap3_] : $m4is_lphf; $this->dirty = true; if (! $this->defer_save) { $this->m4is_dzve(); } return $m4is_rhfd; } 
function m4is_u90u($m4is_ifbz = '', $m4is_ap3_ = '') { if (empty($m4is_ifbz) || empty($m4is_ap3_) ) { return false; } unset($this->session[$m4is_ifbz][$m4is_ap3_]); $this->m4is_dzve(); return true; }    static 
function m4is_nzco4j($m4is_enmq = '', $m4is_rhfd = '', $m4is_q4c_xa = 0) { $m4is_enmq = strtolower(trim($m4is_enmq) ); $m4is_q4c_xa = empty($m4is_q4c_xa) ? get_current_user_id() : $m4is_q4c_xa; if ( (! $m4is_q4c_xa) || empty($m4is_enmq) ) { return false; } update_user_meta($m4is_q4c_xa, self::USER_FIELD . $m4is_enmq, $m4is_rhfd); } static 
function m4is_seig6($m4is_enmq = '', $m4is_q4c_xa = false) { $m4is_enmq = strtolower(trim($m4is_enmq) ); $m4is_q4c_xa = empty($m4is_q4c_xa) ? get_current_user_id() : $m4is_q4c_xa; if ( (! $m4is_q4c_xa) || empty($m4is_enmq) ) { return false; }  return get_user_meta($m4is_q4c_xa, self::USER_FIELD . $m4is_enmq, true); } static 
function m4is_a_2z() : int { $m4is_aicfp = 0; if (isset($_SESSION['memb_user']['crm_id']) ) { $m4is_aicfp = (int) $_SESSION['memb_user']['crm_id']; } elseif( is_user_logged_in() ) { $m4is_q4c_xa = get_current_user_id(); $m4is_aicfp = (int) get_user_meta( $m4is_q4c_xa, 'infusionsoft_user_id', true ); } return $m4is_aicfp ; } static 
function m4is_rbd4( string $m4is_ap3_, $m4is_rhfd = '' ) { $m4is_ap3_ = strtolower( trim( $m4is_ap3_ ) ); if ( empty( $m4is_ap3_ ) ) { return; } $_SESSION['keap']['contact'][$m4is_ap3_] = $m4is_rhfd; }  static 
function m4is_iwkz( string $m4is_ap3_, string $m4is_lphf = '' ) : string { return isset( $_SESSION['keap']['affiliate'][$m4is_ap3_] ) ? $_SESSION['keap']['affiliate'][$m4is_ap3_] : $m4is_lphf; }  static 
function m4is_bfi49( string $m4is_ap3_, string $m4is_lphf = '' ) : string { $m4is_ap3_ = strtolower( $m4is_ap3_ ); return isset( $_SESSION['keap']['contact'][$m4is_ap3_] ) ? $_SESSION['keap']['contact'][$m4is_ap3_] : $m4is_lphf; } static 
function m4is_h_nl($m4is_kbu63_ = [], $m4is_w9feq2 = 0) { if (empty($m4is_kbu63_['FirstName']) || empty($m4is_kbu63_['Email']) ) { return false; } if ( get_user_by('email', $m4is_kbu63_['Email']) || get_user_by('login', $m4is_kbu63_['Email'] ) ) { return false; } $m4is_aicfp = 0; $m4is_jyx_t = memberium_app()->m4is_mmdrl('settings', 'password_field', 'Password');  if (empty($m4is_kbu63_[$m4is_jyx_t]) ) { $m4is_kbu63_[$m4is_jyx_t] = memberium_app()->m4is_v8mw2u(); }   if (! $m4is_aicfp) { }  if ($m4is_w9feq2) { }  } }
