<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_bw7_y {  static 
function m4is_chuq( int $m4is_aicfp ) { $m4is_u13x = 'SocialAccount'; $m4is_ltqb = 1000; $m4is_kc1q = [ 'ContactId' => $m4is_aicfp ]; $m4is_zvxijt = 0; $m4is_j0n7 = m4is_f84s3h::m4is_yt5p0l( $m4is_u13x, $m4is_ltqb, $m4is_zvxijt, $m4is_kc1q ); return $m4is_j0n7; }  static 
function m4is_pp_x( int $m4is_aicfp ) { $m4is_x3kod_ = self::m4is_chuq( $m4is_aicfp ); if (! empty( $m4is_x3kod_ ) ) { self::m4is_ey1c( $m4is_x3kod_ ); } }  static 
function m4is_y1t357( int $m4is_b40e_m ) { global $wpdb; $m4is_q7m2 = memberium_app()->m4is_re5x( 'appname' ); $m4is_w6mt = MEMBERIUM_DB_SOCIAL; $m4is_ioxk = "SELECT * FROM `{$m4is_w6mt}` WHERE `id` = %d AND appname = %s"; $m4is_ioxk = $wpdb->prepare( $m4is_ioxk, $m4is_b40e_m, $m4is_q7m2 ); $m4is_i2t3ps = $wpdb->get_results( $m4is_ioxk, ARRAY_A ); $m4is_i2t3ps = empty( $m4is_i2t3ps[0] ) ? $m4is_i2t3ps : $m4is_i2t3ps[0]; return $m4is_i2t3ps; } static 
function m4is_ey1c( array $m4is_x3kod_ ) { global $wpdb; $m4is_u13x = 'SocialAccount'; $m4is_h9ti6y = []; foreach ( $m4is_x3kod_ as $m4is_ap3_ => $m4is_aia3k ) { $m4is_h9ti6y[] = $m4is_aia3k['Id']; } foreach ( $m4is_x3kod_ as $m4is_ap3_ => $m4is_aia3k ) { $m4is_z4yq79 = self::m4is_y1t357( $m4is_aia3k['Id'] ); if ( empty( $m4is_z4yq79 ) ) { $m4is_ioxk = ""; } else { $m4is_ioxk = ""; } $wpdb->query( $m4is_ioxk );  } } }
