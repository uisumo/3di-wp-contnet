<?php
/**
* Copyright (c) 2018-2022 David J Bullock
* Web Power and Light
*/

  class_exists('m4is_emz57o') || die(); final 
class m4is__pn2 { private $m4is_bxv7u; static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_bxv7u->m4is_wdf4zp( 'm4is_uyod9', __DIR__ . '/shortcodes' ); add_action('memberium/shortcodes/add', [$this, 'm4is_gg_4']); $this->m4is_gg_4(); $this->m4is_ap508(); } private 
function m4is_ap508() { add_action( 'template_redirect', [$this, 'm4is_bvem7w'], 11 ); } 
function m4is_bvem7w() { if ( ! is_buddypress() ) { return; } $m4is_nrgvs = bp_current_component(); if ( ! $m4is_nrgvs ) { return; } $m4is_nrgvs = $m4is_nrgvs == 'profile' ? 'members' : $m4is_nrgvs; $m4is__xysg = bp_core_get_directory_page_id( $m4is_nrgvs ); if ( ! $m4is__xysg ) { return; } $m4is_cpwjsn = m4is_pcys::m4is_a6x52r(); $m4is_b9ew1 = $m4is_cpwjsn->m4is_whka( $m4is__xysg ); if ( $m4is_b9ew1 ) { return; } $m4is_edow = $m4is_cpwjsn->m4is_phwd( $m4is__xysg ); if ( $m4is_edow == 'hide' ) { global $wp_query; $wp_query->set_404(); status_header( 404 ); return; } elseif ( $m4is_edow == 'redirect' ) { $m4is_cpwjsn->m4is_xgc1i( $m4is__xysg ); } } 
function m4is_gg_4() { $m4is_mn_xj = 'm4is_uyod9'; add_shortcode( 'memb_buddypressgroup_grid', [$m4is_mn_xj, 'm4is_lr3cp'] ); add_shortcode( 'memb_has_profile_type', [$m4is_mn_xj, 'm4is_rrbq'] ); } }
