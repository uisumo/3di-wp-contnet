<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); 
class m4is_bkxh { private $m4is_pa8wn4 = null; static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->memberium_umbrella_core_class = m4is_skoru::m4is_a6x52r(); if (! memberium_app()->m4is_fop0d()) { return; } add_action('admin_init', [$this, 'm4is_f2h7'], 9 ); add_action('memberium_admin_menu_addons', [$this, 'm4is_v43f_'] ); add_action('edit_user_profile', [$this, 'm4is_n4v3'], 2010 ); add_filter('memberium/modules/active/names', [$this, 'm4is_hj92e'], 10, 1); } 
function m4is_hj92e($m4is_its6y) { return array_merge($m4is_its6y, [ 'Umbrella Accounts for Memberium' ]); }    
function m4is_f2h7() { $this->m4is_pa8wn4 = m4is_zvyj::m4is_a6x52r(); } 
function m4is_v43f_($m4is_xhf4gm) { if ($m4is_xhf4gm) { add_submenu_page( $m4is_xhf4gm, 'Umbrella Accounts', 'Umbrella Accounts', 'manage_options', 'memberium-umbrella-accounts', [$this, 'm4is_n9im']); } } 
function m4is_n4v3($m4is_nzrv1) { if (! memberium_app()->m4is_fop0d()) { return; } $m4is_sxfbjo = memberium_app()->m4is_q4nu( $m4is_nzrv1->ID ); $m4is_aicfp = isset( $m4is_sxfbjo['keap']['contact']['id'] ) ? $m4is_sxfbjo['keap']['contact']['id'] : 0; if ( ! $m4is_aicfp ) { return; } $m4is_i81f = m4is_skoru::m4is_a6x52r(); $m4is_h028 = strtolower( $m4is_i81f->m4is_evz8xq() ); $m4is_ptl_ = strtolower( $m4is_i81f->m4is_vwpz() ); echo '<table class="form-table">'; echo '<tr>'; echo '<th valign="top"><label for="infusionsoft_umbrella">Umbrella</label></th>'; echo '<td>'; echo 'Parent Code:  ', empty( $m4is_sxfbjo['keap']['contact'][$m4is_h028] ) ? '<strong style="color:red;">None</strong>' : $m4is_sxfbjo['keap']['contact'][$m4is_h028], '<br>'; if ( $m4is_h028 <> $m4is_ptl_ ) { echo 'Child Code:  ', empty( $m4is_sxfbjo['keap']['contact'][$m4is_ptl_] ) ? '<strong style="color:red;">None</strong>' : $m4is_sxfbjo['keap']['contact'][$m4is_ptl_], '<br>'; } echo '</td>'; echo '</tr>'; echo '</table>'; } 
function m4is_n9im() { require_once __DIR__ . '/screen.php'; } }
