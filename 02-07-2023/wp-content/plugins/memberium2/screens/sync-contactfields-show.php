<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); ?>
<style>
	p.checkbox { margin-bottom: 6px; display: inline-block; width: 200px; white-space: nowrap; overflow:hidden; }
	div.indented {margin-left: 15px;}
	label.field_selected { font-weight:bold; color:red; }
</style>
<?php
 m4is_rsao::m4is_burleh(); final 
class m4is_rsao { private $m4is_bxv7u; static 
function m4is_burleh() : self { static $m4is_jprj8; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_s_9s8(); $this->m4is_zzf9v(); } private 
function m4is_s_9s8() { if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) { return; } if ( ! isset( $_POST['formtype'] ) || $_POST['formtype'] !== 'contactfields' ) { return; } $m4is_ay7a = isset( $_POST['is4wp_ignore_contact_fields'] ) ? array_filter( $_POST['is4wp_ignore_contact_fields'] ) : []; $m4is_mjdo7q = is_array( $m4is_ay7a ) ? implode( ',', $m4is_ay7a ) : ''; $this->m4is_bxv7u->m4is_oqwxk( $m4is_mjdo7q, 'settings', 'ignore_contact_fields' ); m4is_f84s3h::m4is_br8l(); m4is_zbyh::m4is_tm75y(); m4is__95_::m4is_hbfrj( 'Contact Fields Ignore List Updated.' ); } 
function m4is_zzf9v() { echo '<p>Please read our online help BEFORE changing these options.</p>';  echo '<p>Contact fields marked in <strong style="color:red;">BOLD RED</strong> are not synced. '; echo 'We recommend blocking as many fields as possible to speed up performance, and reduce database usage. '; echo 'Be careful not to block fields you use.</p>'; echo '<p>Please contact support@memberium.com if you have questions about this function.</p>';  $this->m4is_l3ush(); echo '<p><input type="submit" name="save" value="Save Contact Field Sync" class="button-primary" /></p>'; } private 
function m4is_l3ush() { $m4is_tvcm = m4is_f84s3h::m4is_cm6nr('Contact', false ); $m4is_b9nqt = array_filter( explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'sync', 'required_fields')['Contact'] ) ); $m4is_uo1_su = array_filter( explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'ignore_contact_fields' ) ) ); $m4is_b9nqt[] = $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'username_field'); $m4is_b9nqt[] = $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'password_field'); array_flip( $m4is_b9nqt ); sort($m4is_tvcm); echo '<div class="indented">'; foreach ( $m4is_tvcm as $m4is_dc39 ) { $m4is_zk_wne = ''; $m4is_mn_xj = ''; $m4is_nwmitn = ''; $m4is_hw9v8b = 'is4wp_ignore_contact_fields_' . $m4is_dc39; if ( in_array( $m4is_dc39, $m4is_uo1_su ) ) { $m4is_zk_wne = ' checked="checked" '; $m4is_nwmitn = ' field_selected '; } if ( ! in_array($m4is_dc39, $m4is_b9nqt ) ) { printf( '<p class="checkbox"><input value="%s" %s type="checkbox" id="%s" name="is4wp_ignore_contact_fields[]">', $m4is_dc39, $m4is_zk_wne, $m4is_hw9v8b ); printf( '<label for="%s" class="%s">%s</label></p>', $m4is_hw9v8b, $m4is_nwmitn, $m4is_dc39 ); } } echo '</div>'; } private 
function m4is_t96of() { $m4is_haju = ''; $m4is_tvcm = m4is_f84s3h::m4is_cm6nr( 'Contact', false ); $m4is_b9nqt = array_filter( explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'sync', 'required_fields')['Contact'] ) ); $m4is_wd8t = array_filter( explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'ignore_contact_fields' ) ) ); $m4is_b9nqt[] = $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'username_field' ); $m4is_b9nqt[] = $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'password_field' ); array_flip( (array) $m4is_b9nqt ); echo '<select multiple="multiple" id="is4wp_ignore_contact_fields" name="is4wp_ignore_contact_fields[]" size="20" style="width:200px;">>'; foreach ( $m4is_tvcm as $m4is_dc39 ) { $m4is_bp1zf3 = in_array( $m4is_dc39, $m4is_wd8t ) ? ' selected="selected" ' : '' ; if ( ! in_array($m4is_dc39, $m4is_b9nqt ) ) { printf( '<option value="%s" %s>%s</option>', $m4is_dc39, $m4is_bp1zf3, $m4is_dc39 ); } } echo '</select>'; } }
