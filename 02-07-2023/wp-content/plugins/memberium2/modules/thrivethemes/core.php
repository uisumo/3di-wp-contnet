<?php
 class_exists( 'm4is_emz57o') || die(); final 
class m4is_axf1p7 { private $m4is_bxv7u, $m4is_q7m2; static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_q7m2 = $this->m4is_bxv7u->m4is_re5x('appname'); $this->m4is_efgr75(); } private 
function m4is_efgr75() { $m4is_n8zp05 = [ 'm4is_heztk' => __DIR__ . '/entities/memberium', 'm4is_bzal' => __DIR__ . '/fields/tags', 'm4is_y7j3' => __DIR__ . '/fields/memberships', ]; $this->m4is_bxv7u->m4is_fovlg( $m4is_n8zp05 ); add_action( 'init', [ $this, 'm4is_fovlg' ] ); add_filter( 'memberium/modules/active/names', [$this, 'm4is_hj92e'], 10, 1 ); $this->m4is_ki2zc(); } 
function m4is_hj92e( array $m4is_its6y ) : array { return array_merge( $m4is_its6y, [ 'ThriveThemes Integration' ] ); } 
function m4is_fovlg() { tve_register_condition_entity( 'm4is_heztk' ); tve_register_condition_field( 'm4is_bzal' ); tve_register_condition_field( 'm4is_y7j3' ); } 
function m4is_psb2( ?string $m4is_p41s = '') : array { global $wpdb; $m4is_guz_br = "%{$m4is_p41s}%" ; $m4is_womq = $m4is_p41s ? $wpdb->prepare( " AND ( `name` LIKE %s OR `id` LIKE %s ) ", $m4is_guz_br, $m4is_guz_br ) : ''; $m4is_ioxk = sprintf( "SELECT `id`, `name` FROM `%s` WHERE `appname` = '%s' %s ORDER BY `name` ASC ", MEMBERIUM_DB_TAGS, $this->m4is_q7m2, $m4is_womq ); $m4is_jpzyit = $wpdb->get_results( $m4is_ioxk, OBJECT_K ); return (array) $m4is_jpzyit; } 
function m4is_ki2zc( ?string $m4is_p41s = '') : array { $m4is_cesjr = (array) $this->m4is_bxv7u->m4is_mmdrl( 'memberships' ); $m4is_fdf0v = []; foreach ($m4is_cesjr as $m4is_ap3_ => $m4is_tyoak ) { if ( empty( $m4is_p41s ) || stripos( $m4is_tyoak['name'], $m4is_p41s ) !== false ) { $m4is_fdf0v[$m4is_ap3_] = $m4is_tyoak['name']; } } return $m4is_fdf0v; } }
