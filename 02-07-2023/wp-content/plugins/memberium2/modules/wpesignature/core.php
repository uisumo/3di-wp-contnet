<?php
/**
 * Copyright (c) 2021-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_e_69 { static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_ap508(); if ( is_admin() && include_once( __DIR__ . '/admin.php' ) ) { m4is_xu7t5o::m4is_a6x52r(); } } private 
function m4is_ap508() { add_action( 'esig_document_basic_closing', [$this, 'm4is_bjmr6'], 10, 1 ); add_action( 'esig_signature_saved', [$this, 'm4is_bjmr6'], 10, 1 ); } 
function m4is_bjmr6( $m4is_k_fdu ) { $m4is_liez4 = isset( $m4is_k_fdu['sad_doc_id'] ) ? $m4is_k_fdu['sad_doc_id'] : 0; if ( ! $m4is_liez4 ) { return;  } $m4is_o3mwus = WP_E_Sig()->meta->get( $m4is_liez4, '_is4wp_esignature_tags' ); if ( empty( $m4is_o3mwus ) ) { return; } $m4is_aicfp = 0; $m4is_q4c_xa = isset($m4is_k_fdu['recipient']->wp_user_id) ? $m4is_k_fdu['recipient']->wp_user_id : 0; if (empty($m4is_q4c_xa)) { $m4is_ijvi = isset($m4is_k_fdu['recipient']->user_email) ? $m4is_k_fdu['recipient']->user_email : ''; $m4is_aicfp = memberium_app()->m4is__yge($m4is_ijvi); } else { $m4is_aicfp = memberium_app()->m4is_r231y($m4is_q4c_xa); } memberium_app()->m4is__mkz( $m4is_o3mwus, $m4is_aicfp ); } }
