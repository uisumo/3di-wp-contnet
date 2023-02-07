<?php
 class_exists('m4is_emz57o') || die(); 
class m4is_b_28a { static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { add_filter( 'memberium/modules/active/names', [$this, 'm4is_hj92e'], 10, 1 ); add_action( 'memberium_admin_menu_addons', [$this, 'm4is_v43f_'] ); } 
function m4is_hj92e( $m4is_its6y ) { return array_merge( $m4is_its6y, [ 'Affiliate Leaderboards for Keap' ] ); } 
function m4is_v43f_( $m4is_xhf4gm ) { add_submenu_page( $m4is_xhf4gm, 'Affiliates', 'Affiliates', 'manage_options', 'memberium-affiliate-leaderboards', [$this, 'm4is_n9im'] ); } 
function m4is_n9im() { require_once __DIR__ . '/screen.php'; } }
