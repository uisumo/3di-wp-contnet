<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); new m4is_h7s3; final 
class m4is_h7s3 { private $m4is_bxv7u, $m4is_tct_hk; 
function __construct() { $this->m4is_gopgz(); $this->m4is_y3z1(); } private 
function m4is_gopgz() { $this->m4is_bxv7u = memberium_app(); $this->m4is_tct_hk = 'settings'; } private 
function m4is_y3z1() { echo '<form method="POST" action="">'; wp_nonce_field( $this->m4is_bxv7u->m4is_yl5j8(), 'memberium_options_nonce' ); echo '<ul>'; $this->m4is_aidp9(); echo '</ul>'; echo '<p><input type="submit" value="Update" class="button-primary"></p>'; echo '</form>'; } private 
function m4is_aidp9() { $m4is_zksg = [ 0 => 'No action', 1 => 'Disable Automatic Paragraphs', 2 => 'Delay Automatic Paragraphs', ]; $m4is_jln4g = (bool) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'dynamic_menus', 0 ); $m4is_n5mud = (bool) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'two_pass_shortcode_filter', 0 ); $m4is_imq43e = (bool) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'multi_language', 0 ); $m4is_yznt = (bool) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'cache_flush', 0 ); $m4is_krjo1 = (bool) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'cache_bust', 0 ); $m4is_z8qa = (int) $this->m4is_bxv7u->m4is_mmdrl( $this->m4is_tct_hk, 'wp_autop', 0 );  echo '<h3>Page Handling</h3>'; m4is__95_::m4is_i6c5( 'Personal Menus', 'dynamic_menus', 11934, $m4is_jln4g ); m4is__95_::m4is_ouv1( 'Automatic Paragraphs', 'wp_autop', $m4is_z8qa, $m4is_zksg, [ 'help_id' => 21886 ] ); m4is__95_::m4is_i6c5( 'Two Pass Shortcode Handling', 'two_pass_shortcode_filter', 8227, $m4is_n5mud ); m4is__95_::m4is_i6c5( 'Multi-Language Support', 'multi_language', 14684, $m4is_imq43e ); m4is__95_::m4is_i6c5( 'Force Rewrite Cache Flush', 'cache_flush', 9636, $m4is_yznt ); m4is__95_::m4is_i6c5( 'Discourage Browser Caching', 'cache_bust', 13292, $m4is_krjo1 );  } }
