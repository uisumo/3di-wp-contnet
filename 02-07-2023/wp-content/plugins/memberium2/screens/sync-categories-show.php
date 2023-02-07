<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); ?>
<style>
	p.checkbox { margin-bottom: 6px; display: inline-block; width: 250px; white-space: nowrap; overflow:hidden; }
	div.indented {margin-left: 15px;}
	label.field_selected { font-weight:bold; color:red; }
</style>
<?php
 m4is_pexbc::m4is_burleh(); final 
class m4is_pexbc {  static 
function m4is_burleh() : self { static $m4is_jprj8; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->process_updates(); $this->m4is_zzf9v(); }  private 
function process_updates() { if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) { return; } if ( ! isset( $_POST['is4wp_ignore_tag_categories'] ) || ! is_array( $_POST['is4wp_ignore_tag_categories'] ) ) { return; } $m4is_ad0jf = $_POST['is4wp_ignore_tag_categories']; $m4is_u4ctm = $this->m4is_c6klo(); $m4is_gw_ls = implode( ',', array_diff( $m4is_u4ctm, $m4is_ad0jf ) ); $this->m4is_bxv7u->m4is_oqwxk( $m4is_gw_ls, 'settings', 'ignore_tag_categories' ); m4is_f84s3h::m4is_omi1x4(); m4is__95_::m4is_hbfrj( 'Tag Categories Ignore List Updated.' ); }  
function m4is_zzf9v() { echo '<p>Select which tag categories <strong>are</strong> synchronized.</p>'; echo '<p><strong>For best performance, sync either ALL categories, or only ONE category.</strong></p>'; echo '<p>Tags in the <strong style="color:red;">BOLD RED</strong> categories are not synced.</p>';  $this->m4is_r73pu(); echo '<p><input type="submit" name="save" value="Save Category Sync" class="button-primary" /></p>'; }  private 
function m4is_qnaco() { $m4is_gw_ls = explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'ignore_tag_categories' ) ); $m4is_gw_ls = array_filter( $m4is_gw_ls, function( $v ) { return $v <> ''; } ); return $m4is_gw_ls; }  private 
function m4is_c6klo() { $m4is_hmeo = m4is_f84s3h::m4is_sicx(); $m4is_ihds = array_map( function( $m4is_wo7c93 ) { return $m4is_wo7c93['id']; }, $m4is_hmeo ); return $m4is_ihds; }  private 
function m4is_id5b() { $m4is_gw_ls = $this->m4is_qnaco(); $m4is_rz1a6 = m4is_f84s3h::m4is_sicx(); $m4is_es_ut = ''; echo '<select multiple="multiple" id="is4wp_ignore_tag_categories" name="is4wp_ignore_tag_categories[]" size="25" style="width:600px;">'; foreach ($m4is_rz1a6 as $m4is_a90h ) { $m4is_bp1zf3 = ! in_array( $m4is_a90h['id'], $m4is_gw_ls ) ? ' selected="selected" ' : ''; printf( '<option value="%s" %s >%s</option>', $m4is_a90h['id'], $m4is_bp1zf3, $m4is_a90h['name'] ); } echo '</select>'; }  private 
function m4is_r73pu() { $m4is_gw_ls = $this->m4is_qnaco(); $m4is_rz1a6 = m4is_f84s3h::m4is_sicx(); echo '<div class="indented">'; foreach( $m4is_rz1a6 as $m4is_a90h ) { $m4is_zk_wne = ''; $m4is_nwmitn = ' field_selected '; if ( ! in_array( $m4is_a90h['id'], $m4is_gw_ls ) ) { $m4is_zk_wne = ' checked="checked" '; $m4is_nwmitn = ''; } $m4is_zk_wne = ! in_array( $m4is_a90h['id'], $m4is_gw_ls ) ? ' checked="checked" ' : ''; $m4is_hw9v8b = 'is4wp_category_' . $m4is_a90h['id']; printf( '<p class="checkbox"><input value=%s %s type="checkbox" id="%s" name="is4wp_ignore_tag_categories[]">', $m4is_a90h['id'], $m4is_zk_wne, $m4is_hw9v8b ); printf( '<label class="%s" for="%s" >%s</label></p>', $m4is_nwmitn, $m4is_hw9v8b, $m4is_a90h['name'] ); } echo '</div>'; } }
