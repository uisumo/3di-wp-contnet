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
 m4is_zcl9p::m4is_burleh(); 
class m4is_zcl9p { private $m4is_bxv7u, $m4is_kbu63_ = [], $m4is_m_9gr = [], $m4is_b9nqt = []; static 
function m4is_burleh() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; } 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_s_9s8(); $this->m4is_gopgz(); $this->m4is_qhl2y1(); } private 
function m4is_gopgz() { $this->m4is_kbu63_ = m4is_f84s3h::m4is_cm6nr( 'Affiliate', false );  $this->m4is_m_9gr = $this->m4is_c1j6b9(); $this->m4is_b9nqt = $this->m4is_m0dra(); } private 
function m4is_ujae() { global $wpdb; if ( ! empty( $m4is_h87p32 ) ) { $m4is_q7m2 = $this->m4is_bxv7u->m4is_re5x('appname'); $m4is_ioxk = 'DELETE FROM `' . MEMBERIUM_DB_AFFILIATES . '` WHERE fieldname in (\'' . $m4is_h87p32 . '\') AND `appname` = "' . $m4is_q7m2 . '" '; $wpdb->query( $m4is_ioxk ); } } private 
function m4is_s_9s8() { if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) { return; } $m4is_m_9gr = isset( $_POST['ignore_affiliate_fields'] ) && is_array( $_POST['ignore_affiliate_fields'] ) ? implode( ',', $_POST['ignore_affiliate_fields'] ) : ''; $this->m4is_bxv7u->m4is_oqwxk($m4is_m_9gr, 'settings', 'ignore_affiliate_fields'); m4is_f84s3h::m4is_br8l(); m4is__95_::m4is_hbfrj('Affiliate Fields Ignore List Updated.'); } private 
function m4is_qhl2y1() { echo '<p>Please read our online help BEFORE changing these options.</p>';  echo '<p>Affiliate fields marked in <strong style="color:red;">BOLD RED</strong> are not synced. '; echo 'We recommend blocking as many fields as possible to speed up performance, and reduce database usage. '; echo 'Be careful not to block fields you use.</p>'; echo '<p>Please contact support@memberium.com if you have questions about this function.</p>';  $this->m4is_gbvqrh(); echo '<p><input type="submit" name="save" value="Save Affiliate Field Sync" class="button-primary" /></p>'; } private 
function m4is_gbvqrh() { $m4is_m2u7m = m4is_f84s3h::m4is_cm6nr( 'Affiliate', false ); $m4is_m_9gr = $this->m4is_c1j6b9(); $m4is_b9nqt = $this->m4is_m0dra(); $m4is_b9nqt = array_flip( $m4is_b9nqt ); sort( $m4is_m2u7m ); echo '<div class="indented">'; foreach ( $m4is_m2u7m as $m4is_sv3h ) { $m4is_zk_wne = ''; $m4is_mn_xj = ''; $m4is_nwmitn = ''; $m4is_hw9v8b = 'ignore_affiliate_fields_' . $m4is_sv3h; if ( in_array( $m4is_sv3h, $m4is_m_9gr ) ) { $m4is_zk_wne = ' checked="checked" '; $m4is_nwmitn = ' field_selected '; } if ( ! in_array($m4is_sv3h, $m4is_b9nqt ) ) { printf( '<p class="checkbox"><input value="%s" %s type="checkbox" id="%s" name="ignore_affiliate_fields[]">', $m4is_sv3h, $m4is_zk_wne, $m4is_hw9v8b ); printf( '<label for="%s" class="%s">%s</label></p>', $m4is_hw9v8b, $m4is_nwmitn, $m4is_sv3h ); } } echo '</div>'; } private 
function m4is_vls8r2() { echo '<select multiple="multiple" id="ignore_affiliate_fields" name="ignore_affiliate_fields[]" size="20" style="width:200px;">'; foreach ($this->m4is_kbu63_ as $m4is_tenvhx) { if ( ! array_key_exists( $m4is_tenvhx, $this->m4is_b9nqt ) ) { $m4is_bp1zf3 = in_array( $m4is_tenvhx, $this->m4is_m_9gr ) ? ' selected="selected" ' : ''; printf( '<option value="%s" %s>%s</option>', $m4is_tenvhx, $m4is_bp1zf3, $m4is_tenvhx ); } } echo '</select>'; } private 
function m4is_c1j6b9() : array { return array_filter( explode( ',', $this->m4is_bxv7u->m4is_mmdrl( 'settings', 'ignore_affiliate_fields', '' ) ) ); } private 
function m4is_m0dra() : array { $m4is_b9nqt = []; $m4is_b9nqt[] = 'AffCode'; $m4is_b9nqt[] = 'AffName'; $m4is_b9nqt[] = 'ContactId'; $m4is_b9nqt[] = 'Id'; $m4is_b9nqt[] = 'ParentId'; $m4is_b9nqt[] = 'Password'; $m4is_b9nqt[] = 'Status'; return array_flip( $m4is_b9nqt ); } }
