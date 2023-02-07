<?php
 class_exists('m4is_emz57o') || die(); final 
class m4is_ane1gj { 
function m4is_w5b6($m4is_j0n7 = []) { $m4is_q4c_xa = isset($m4is_j0n7['user_id']) ? $m4is_j0n7['user_id'] : get_current_user_id(); $m4is__xysg = isset($m4is_j0n7['post_id']) ? $m4is_j0n7['post_id'] : 0; $m4is__64n27 = isset($m4is_j0n7['button_id']) ? $m4is_j0n7['button_id'] : 0; $m4is_u6ixo = isset($m4is_j0n7['course']) ? $m4is_j0n7['course'] : 0; $m4is_aicfp = (int) m4is_zbyh::m4is_fhxr6($m4is_q4c_xa); if ($m4is_aicfp) { $m4is_znf9 = get_post_meta($m4is__xysg, '_is4wp_wpcomplete_tags', true); memberium_app()->m4is__mkz($m4is_znf9, $m4is_aicfp ); } } 
function m4is_notgb8($m4is_j0n7 = []) { $m4is_q4c_xa = isset($m4is_j0n7['user_id']) ? $m4is_j0n7['user_id'] : get_current_user_id(); $m4is__xysg = isset($m4is_j0n7['post_id']) ? $m4is_j0n7['post_id'] : 0; $m4is__64n27 = isset($m4is_j0n7['button_id']) ? $m4is_j0n7['button_id'] : 0; $m4is_u6ixo = isset($m4is_j0n7['course']) ? $m4is_j0n7['course'] : 0; $m4is_aicfp = (int) m4is_zbyh::m4is_fhxr6($m4is_q4c_xa); if ($m4is_aicfp) { $m4is_znf9 = get_post_meta($m4is__xysg, '_is4wp_wpcomplete_tags', true); memberium_app()->m4is__mkz($m4is_znf9, $m4is_aicfp ); } } private 
function m4is_ap508() { add_action('wpcomplete_page_completed', [$this, 'm4is_w5b6']); add_action('wpcomplete_course_completed', [$this, 'm4is_notgb8']); } private 
function m4is_k1r9t() { if ( is_admin() ) { if (include_once(__DIR__ . '/admin.php') ) { m4is_f9baf1::m4is_a6x52r(); } }  } private 
function __construct() { $this->m4is_ap508(); $this->m4is_k1r9t(); } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
