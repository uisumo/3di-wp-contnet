<?php
/**
 * Copyright (c) 2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die();  
class m4is_jagukq { private $api_key; private $api_secret; private $api_base = 'https://api.zoom.us/v2/'; private $api_count = 0; 
function __construct( $m4is_ap3_, $m4is_invg7 ){ $this->api_key = $m4is_ap3_; $this->api_secret = $m4is_invg7; }  
function m4is_re0t5($m4is_ut6vn, $m4is_w5ky4q = false) { $m4is_rxc9n1 = ['headers' => $this->m4is_wke8()]; if( is_array($m4is_w5ky4q) ){ $m4is_rxc9n1 = wp_parse_args($m4is_w5ky4q, $m4is_rxc9n1); } $m4is_zv59 = wp_remote_get($this->api_base.$m4is_ut6vn, $m4is_rxc9n1); $this->api_count++; return $this->m4is_t6htp8($m4is_zv59); }  
function m4is_us4ahz($m4is_ut6vn, $m4is_j16p = false){ return $this->m4is_ck9_x( $this->api_base.$m4is_ut6vn, 'POST', $m4is_j16p ); }  
function m4is_orvamd( $m4is_ut6vn, $m4is_j16p = false ){ return $this->m4is_ck9_x( $this->api_base.$m4is_ut6vn, 'PATCH', $m4is_j16p ); }  
function m4is_ttjbre( $m4is_ut6vn, $m4is_j16p = false ){ return $this->m4is_ck9_x( $this->api_base.$m4is_ut6vn, 'PUT', $m4is_j16p ); }  
function m4is_q7d3s( $m4is_ut6vn, $m4is_j16p = false ){ return $this->m4is_ck9_x( $this->api_base.$m4is_ut6vn, 'DELETE', $m4is_j16p ); }  
function m4is_ck9_x( $m4is__mto, $m4is_ut6vn, $m4is_j16p = false ){ $m4is_rxc9n1 = [ 'method' => $m4is_ut6vn, 'headers' => $this->m4is_wke8() ]; if($m4is_j16p){ $m4is_rxc9n1['body'] = ( is_array($m4is_j16p) ) ? json_encode($m4is_j16p) : $m4is_j16p; } $m4is_zv59 = wp_remote_request($m4is__mto, $m4is_rxc9n1); $this->api_count++; return $this->m4is_t6htp8($m4is_zv59); }  
function m4is_wke8() { return [ 'Authorization' => 'Bearer ' . $this->m4is_s0vq(), 'Content-Type' => 'application/json', 'Accept' => 'application/json', ]; }  
function m4is_s0vq(){ $m4is_il8u4 = time() * 1000 - 30000; $m4is_afrae = json_encode(['typ' => 'JWT','alg' => 'HS256']); $m4is_nmxdh = $this->m4is_iy16($m4is_afrae); $m4is_wg_j = json_encode(['iss' => $this->api_key, 'exp' => $m4is_il8u4]); $m4is__ucw = $this->m4is_iy16($m4is_wg_j); $m4is_k_fdu = hash_hmac('sha256', $m4is_nmxdh . "." . $m4is__ucw, $this->api_secret, true); $m4is_ngqv = $this->m4is_iy16($m4is_k_fdu); $m4is_fy3zf = $m4is_nmxdh . "." . $m4is__ucw . "." . $m4is_ngqv; return $m4is_fy3zf; } 
function m4is_iy16($m4is_j0n7){ $m4is_due1 = base64_encode($m4is_j0n7); if ($m4is_due1 === false) { return false; } $m4is__mto = strtr($m4is_due1, '+/', '-_'); return rtrim($m4is__mto, '='); }  
function m4is_myic5( $m4is_b40e_m, $m4is_hqmdn ){ $m4is_il8u4 = time() * 1000 - 30000; $m4is_j0n7 = base64_encode($this->api_key.$m4is_b40e_m.$m4is_il8u4.$m4is_hqmdn); $m4is_jdl7 = hash_hmac('sha256', $m4is_j0n7, $this->api_secret, true); $m4is_jdl7 = base64_encode($m4is_jdl7); $m4is_k_fdu = "{$this->api_key}.{$m4is_b40e_m}.{$m4is_il8u4}.{$m4is_hqmdn}.{$m4is_jdl7}"; return rtrim(strtr(base64_encode($m4is_k_fdu), '+/', '-_'), '='); }  
function m4is_t6htp8( $m4is_zv59 ){ if ( is_wp_error($m4is_zv59) ){ return $m4is_zv59; } else { return json_decode(wp_remote_retrieve_body($m4is_zv59)); } } }
