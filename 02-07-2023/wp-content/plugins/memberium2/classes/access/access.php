<?php
/**
 * Copyright (c) 2015-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_l0uwos { const NS = 'memberium', PREFIX = 'is4wp'; static 
function m4is_a6x52r(){ static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : new self; } private 
function __construct() {} 
function m4is_zbtp() {  add_filter( 'rest_pre_dispatch', [$this, 'm4is_j1ri'], 10, 3 ); add_action( 'wpal/block/access/init', [$this, 'm4is_p1g4t'], 1 ); do_action( 'wpal/block/access/init' );   if ( version_compare( get_bloginfo( 'version' ), '5.4', '>=' ) ) { $this->m4is_ax1wh(); } $this->m4is_c9fkcp();  $this->m4is_e07z();  }    
function m4is_p1g4t() { if ( is_admin() ) { add_action( 'enqueue_block_editor_assets', [ $this->m4is_lvmd(), 'm4is_katqdw' ], 1 );  } else{  add_filter( 'render_block', [ $this->m4is_dm0y8e(), 'm4is_hilnt' ], PHP_INT_MAX, 2 ); } }  
function m4is_j1ri( $m4is_n_bp6, $m4is_ef19, $m4is_eewg ) { if ( strpos( $m4is_eewg->get_route(), '/wp/v2/block-renderer' ) !== false) { if ( isset( $m4is_eewg['attributes'] ) ){ $m4is_xte4uv = $m4is_eewg['attributes']; if( is_array( $m4is_xte4uv ) && ! empty( $m4is_xte4uv ) ) { foreach ($m4is_xte4uv as $m4is_e3k_mi => $m4is_waxrhu) { if ( strpos( $m4is_e3k_mi, self::PREFIX ) === 0 ) { unset( $m4is_xte4uv[$m4is_e3k_mi] ); } } $m4is_eewg['attributes'] = $m4is_xte4uv; } } } return $m4is_n_bp6; }    
function m4is_ax1wh(){ $m4is_edow = false; if ( wp_doing_ajax() ) { $m4is_edow = isset($_POST['action']) ? $_POST['action'] : false; } if ( is_admin() || $m4is_edow === 'add-menu-item' ) { add_action('load-nav-menus.php', ['m4is_c6uv4', 'm4is_ap508'], 1);   if ($m4is_edow === 'add-menu-item' ) { m4is_c6uv4::m4is_ap508(); } } else if ( ! is_admin() || $m4is_edow ) { add_filter('wp_get_nav_menu_items', [$this->m4is_dm0y8e(), 'm4is_zgzj'], 1, 3); } } 
function m4is_nlm5( $m4is_pga7md ) { $m4is_ti8od = get_post_meta( $m4is_pga7md, '_wpal/menu/access', true ); return ( ! $m4is_ti8od || ! is_array($m4is_ti8od) || empty($m4is_ti8od) ) ? [] : $m4is_ti8od; }    
function m4is_c9fkcp() { $m4is_pmcgy = 'm4is__d4kf'; add_action( 'in_widget_form', [ $m4is_pmcgy, 'm4is_li9sf'], 10, 3 );  add_filter( 'widget_update_callback', [ $m4is_pmcgy, 'm4is_mip3ym'], 10, 2 );  if( is_admin() ){ add_action('load-widgets.php', [ $m4is_pmcgy, 'm4is_wzan4'], 1 );  } else { add_filter('sidebars_widgets', [ $this->m4is_dm0y8e(), 'm4is_irc0'], 10 );  add_filter('widget_display_callback', [ $this->m4is_dm0y8e(), 'm4is__ovuy3'], 10, 3 );  } }    
function m4is_e07z(){ if ( is_admin() && ! wp_doing_ajax() ) { add_action( 'load-term.php', ['m4is_qd7az', 'm4is_zf3i'], 1);   $m4is_qiwse4 = 'memberium/taxonomy/access'; $m4is_iue7mi = isset($_POST["_{$m4is_qiwse4}_name"]) ? $_POST["_{$m4is_qiwse4}_name"] : false; if ( $m4is_iue7mi && wp_verify_nonce($_POST["_{$m4is_qiwse4}_name"], $m4is_qiwse4) ){ m4is_qd7az::m4is_zf3i(); } } else { if (! memberium_app()->m4is_fop0d() ) { add_action('pre_get_posts', [$this->m4is_dm0y8e(), 'm4is_rz0q2']); add_filter('get_terms', [$this->m4is_dm0y8e(), 'm4is_lf6x'], -1, 4); } } }  
function m4is_ereom(){ static $m4is_hb7p6; if ( is_null($m4is_hb7p6) ) { $m4is_w5ky4q = [ 'public' => true, 'show_ui' => true, ]; $m4is_d9jfhg = get_taxonomies($m4is_w5ky4q, 'names'); foreach($m4is_d9jfhg as $m4is_ap3_ => $m4is_rhfd) { if (substr($m4is_ap3_, -4, 4) == '_tag') { unset($m4is_d9jfhg[$m4is_ap3_]); } } $m4is_d9jfhg = apply_filters('memberium/controlled/access/taxonomies', $m4is_d9jfhg);  $m4is_hb7p6 = is_array($m4is_d9jfhg) ? $m4is_d9jfhg : []; } return $m4is_hb7p6; } 
function m4is_tlkqoy( $m4is_xf4s ){ $m4is_ti8od = get_term_meta($m4is_xf4s, '_wpal/taxonomy/access', true); return ( ! $m4is_ti8od || ! is_array($m4is_ti8od) || empty($m4is_ti8od) ) ? [] : $m4is_ti8od; }    
function m4is_lvmd() : m4is_v98gbn { static $m4is_hwvlct; return isset( $m4is_hwvlct ) ? $m4is_hwvlct : $m4is_hwvlct = m4is_v98gbn::m4is_a6x52r(); } 
function m4is_dm0y8e() : m4is_bqb1 { static $m4is_cpwjsn; return isset( $m4is_cpwjsn ) ? $m4is_cpwjsn : $m4is_cpwjsn = m4is_bqb1::m4is_a6x52r(); } }
