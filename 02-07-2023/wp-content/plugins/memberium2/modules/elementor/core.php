<?php
/**
* Copyright (c) 2018-2022 David J Bullock
* Web Power and Light
*/

 class_exists('m4is_emz57o') || die();  final 
class m4is_y9rpad { static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; }  private 
function __construct() {} 
function m4is_zbtp() { add_action( 'wpal/block/access/init', [$this, 'm4is_gopgz'] ); } 
function m4is_gopgz(){ add_action( 'elementor/element/after_section_end', [$this, 'm4is_d5okl'], 10, 2 );  add_action( 'elementor/editor/before_enqueue_scripts', [$this, 'm4is_mazw_h'] );   if ( is_admin() && ! wp_doing_ajax() ) { return; } add_action( 'template_redirect', [ $this, 'm4is_gxjf1' ], PHP_INT_MAX ); }    
function m4is_dm0y8e(){ static $m4is_cpwjsn; if( ! isset( $m4is_cpwjsn ) ) { include_once __DIR__ . '/frontend.php'; $m4is_cpwjsn = m4is_pljk::m4is_a6x52r(); } return $m4is_cpwjsn; } 
function m4is_gxjf1(){ $m4is_vw2go = \Elementor\Plugin::instance(); if ( $m4is_vw2go->editor->is_edit_mode() ) { return; } if ( $m4is_vw2go->preview->is_preview_mode() ) { return; } if( !empty($_GET['action']) && $_GET['action'] === 'elementor' ){ return; }  remove_action( 'elementor/element/after_section_end', [$this, 'm4is_d5okl'], 10 );  $this->m4is_dm0y8e(); }    
function m4is_q2amj(){ static $m4is_mi8edr; if( ! isset( $m4is_mi8edr ) ) { include_once __DIR__ . '/editor.php'; $m4is_mi8edr = m4is_t1sb23::m4is_a6x52r(); } return $m4is_mi8edr; } 
function m4is_d5okl( $m4is_ifbz, $m4is_oto2jv ){ if ( 'section_advanced' === $m4is_oto2jv || '_section_style' === $m4is_oto2jv ) { $this->m4is_q2amj()->m4is_lvycqu( $m4is_ifbz, $m4is_oto2jv ); } } 
function m4is_mazw_h(){ $this->m4is_q2amj()->m4is_j0l4(); } }
