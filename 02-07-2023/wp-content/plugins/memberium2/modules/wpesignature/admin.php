<?php
/**
 * Copyright (c) 2021-2022 David J Bullock
 * Web Power and Light
 */

 class_exists( 'm4is_emz57o' ) || die(); final 
class m4is_xu7t5o { static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_ap508(); } private 
function m4is_ap508() {  add_action( 'esig_display_right_sidebar', [$this, 'm4is_ha8e'], 10 ); add_action( 'esig_document_after_save', [$this, 'm4is_lo8q3c'] ); add_filter( 'memberium/modules/active/names', [$this, 'm4is_a5tu'], 10, 1 ); add_filter( 'memberium/enhanced_admin_scripts', [$this, 'm4is_c5py'] ); } 
function m4is_a5tu( $m4is_its6y = [] ) { return array_merge( $m4is_its6y, ['WP E-Signature for Memberium'] ); } 
function m4is_qgfr() { return [ 'esign', ]; } 
function m4is_ha8e( $m4is_j0n7 = '' ) { $m4is_liez4 = isset( $_GET['document_id'] ) ? $_GET['document_id'] : 0; $m4is_g_wa = "memberium_esignature_nonce_{$m4is_liez4}"; $m4is_o3mwus = WP_E_Sig()->meta->get( $m4is_liez4, '_is4wp_esignature_tags' ); $m4is_hwvlct = m4is_zvyj::m4is_a6x52r(); $m4is_qiwse4 = wp_nonce_field( __FILE__, $m4is_g_wa, true, false); $m4is_x5al = $m4is_o3mwus > '' ? $m4is_o3mwus : ''; $m4is_k2qb08 .= '<div class="postbox esign-form-panel">'; $m4is_k2qb08 .= '<h3 class="esig-section-title" style="padding-left:0">Memberium Integration</h3>'; $m4is_k2qb08 .= '<div class="esig-inside">'; $m4is_k2qb08 .= $m4is_qiwse4; $m4is_k2qb08 .= '<label for="_is4wp_esignature_tags">Add Tag when signed:</label>'; $m4is_k2qb08 .= '<input value="' . $m4is_x5al . '" name="_is4wp_esignature_tags" class="multitaglist" style="width:95%; max-width:95%"><br /><br />'; $m4is_k2qb08 .= '</div>'; $m4is_k2qb08 .= '</div>'; add_action( 'admin_footer', [$m4is_hwvlct, 'm4is_o8eji3'] ); echo $m4is_k2qb08; return $m4is_j0n7; } 
function m4is_lo8q3c( $m4is_v1ox5f ) {  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; } $m4is_liez4 = isset($m4is_v1ox5f['document']->document_id) ? $m4is_v1ox5f['document']->document_id : 0; $m4is_g_wa = "memberium_esignature_nonce_{$m4is_liez4}"; if ( empty( $_POST[$m4is_g_wa] ) || ! wp_verify_nonce( $_POST[$m4is_g_wa], __FILE__ ) ) { return; }  $m4is_ekvmr = [ '_is4wp_esignature_tags', ]; foreach( $m4is_ekvmr as $m4is_ap3_ ) { $_POST[$m4is_ap3_] = isset( $_POST[$m4is_ap3_] ) ? $_POST[$m4is_ap3_] : ''; if (empty($_POST[$m4is_ap3_])) { WP_E_Sig()->meta->delete($m4is_liez4,$m4is_ap3_); } else { WP_E_Sig()->meta->add($m4is_liez4, $m4is_ap3_, $_POST[$m4is_ap3_]) or WP_E_Sig()->meta->update($m4is_liez4, $m4is_ap3_, $_POST[$m4is_ap3_]); } } } 
function m4is_c5py($m4is_bnuai) { $m4is_bnuai[] = 'admin_page_esign-edit-document'; return $m4is_bnuai; } }
