<?php
/**
 * Copyright (c) 2021-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_tir4u { private $m4is__3anb = []; private $m4is_bxv7u; static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_ap508(); } private 
function m4is_ap508() { add_action( 'gamipress_award_achievement', [$this, 'm4is_tws56b'], 10, 2 ); add_action( 'memberium/lms/completion', [$this, 'm4is_w1be'], 10, 2 ); add_filter( 'memberium/posts/unenhanced', [$this, 'm4is_mmtr07'], 10, 1 ); add_filter( 'memberium/session/updated', [$this, 'm4is_i5vt2'], 10, 2 ); if ( is_admin() ) { require_once __DIR__ . '/admin.php'; m4is_e5w6::m4is_a6x52r(); } } 
function m4is_tws56b( $m4is_q4c_xa, $m4is_xrwalt ) { $m4is_aicfp = (int) m4is_zbyh::m4is_fhxr6($m4is_q4c_xa); if ($m4is_aicfp) { $m4is_eny5fd = get_option('memberium/gamipress/tag_by_badge', [] ); if (! empty($m4is_eny5fd) ) { if (array_key_exists($m4is_xrwalt, $m4is_eny5fd) ) { $m4is_w9feq2 = $m4is_eny5fd[$m4is_xrwalt]; memberium_app()->m4is__mkz($m4is_w9feq2, $m4is_aicfp); } } } } 
function m4is_i5vt2( int $m4is_q4c_xa, array $m4is_sxfbjo ) { if ( ! function_exists( 'gamipress_award_achievement_to_user' ) ) { return; } if ( empty( $m4is_sxfbjo['keap']['contact']['groups'] ) || empty( $m4is_q4c_xa ) ) { return; } $m4is_znf9 = explode( ',', $m4is_sxfbjo['keap']['contact']['groups'] ); $m4is_eny5fd = get_option( 'memberium/gamipress/assign_by_tag', [] ); $m4is_ib_tl = $this->m4is_vtbkdi( $m4is_q4c_xa ); if ( is_array( $m4is_eny5fd ) ) { foreach( $m4is_eny5fd as $m4is_xrwalt => $m4is_qxtoe ) { if ( ! empty( $m4is_qxtoe ) ) { if ( ! in_array( $m4is_xrwalt, $m4is_ib_tl ) ) { if ( in_array( $m4is_qxtoe, $m4is_znf9 ) ) { gamipress_award_achievement_to_user( $m4is_xrwalt, $m4is_q4c_xa ); } } } } } } 
function m4is_w1be($m4is_q4c_xa, $m4is__xysg) { if (! function_exists('gamipress_maybe_award_achievement_to_user') ) { return; } $m4is__1z5fg = get_post_meta($m4is__xysg, '_is4wp_learndash_achievement', true); if ($m4is__1z5fg) { gamipress_award_achievement_to_user($m4is__1z5fg, $m4is_q4c_xa); } } private 
function m4is_vtbkdi( int $m4is_q4c_xa = 0 ) { $m4is_w5ky4q = [ 'user_id' => $m4is_q4c_xa, ]; $m4is_ib_tl = gamipress_get_user_achievements( $m4is_w5ky4q ); return array_map( function( $m4is_yonb ){ return $m4is_yonb->ID; }, $m4is_ib_tl); } 
function m4is_mmtr07(array $m4is_i8_ymd = [] ) : array { $m4is_i8_ymd[] = 'achievement-type'; $m4is_i8_ymd[] = 'nomination'; $m4is_i8_ymd[] = 'step'; $m4is_i8_ymd[] = 'submission'; $achievements = gamipress_get_achievement_types_slugs(); $m4is_i8_ymd = array_merge($m4is_i8_ymd, $achievements); return $m4is_i8_ymd; } }
